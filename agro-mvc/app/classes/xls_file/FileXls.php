<?php

namespace app\classes\xls_file;

use DateTime;
use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use app\classes\xls_file\FormHeader;
use core\model\Model;

class FileXls
{
  private ?array $file;
  private ?array $spreed_sheet;

  public function __construct(?array $file)
  {
    $this->file = $file;
  }

  public function validade(): self
  {
    $extesion = pathinfo(
      $this->file['name'],
      PATHINFO_EXTENSION
    );

    if ($extesion != 'xls' && $extesion != 'xlsx') {
      throw new InvalidArgumentException(
        "Arquivo nao e xls ou xlsx: {$this->file['name']}"
      );
    }

    return $this;
  }

  public function prospector(): self
  {
    $spreedSheet = [];
    $reader = new Xlsx();
    $reader->setReadDataOnly(TRUE);
    $spreedsheet = $reader->load($this->file['tmp_name']);
    $worksheet = $spreedsheet->getActiveSheet();
    foreach ($worksheet->getRowIterator() as $row) {
      $cellIterator = $row->getCellIterator();
      $columns = [];
      foreach ($cellIterator as $cell) {
        $value = $cell->getValue();
        $value = ($value == null) ? b'' : $value;
        array_push($columns, $value);
      }
      array_push($spreedSheet, $columns);
    }

    $spreedSheet = array_filter($spreedSheet, function (?array $row) {
      $row_size = count($row);
      foreach ($row as $cell) {
        if ($cell == b"") {
          --$row_size;
        }
      }
      return ($row_size != 0);
    });

    $this->spreed_sheet = $spreedSheet;

    return $this;
  }

  public function prepe(): ?array
  {
    //Checkout of the file's header.
    array_map(
      fn($key, $header) => ($key->value == $header)
        ? $header
        : throw new InvalidArgumentException(
          "Cabecalho Error: '{$key->name}' e '{$key->value}' nao '{$header}'"
        ),
      FormHeader::cases(),
      [count($this->spreed_sheet[0]), ...$this->spreed_sheet[0]]
    );

    //Checkout of the file's cells.
    $cells = array_map(
      function ($line, $row) {
        $line += 2;
        [$name, $job, $training, $status, $date] = $row;

        if ($status != 'Completo' && $status != 'Pendente') {
          throw new InvalidArgumentException(
            "Valor na Coluna 'Status' na Linha '{$line}' 
            e {$status} deve ser 'Completo' ou 'Pendente'"
          );
        }

        if ($status == 'Pendente' && $date != null) {
          throw new InvalidArgumentException(
            "Campo 'Data de Vencimento' deve estar vazia, 
            quando 'Situacao de Treinamento' esta marcado 'Pendente'. 
            Coluna 'Data de Vencimento' e Linha {$line}"
          );
        }

        $date = DateTime::createFromFormat('d/m/Y', $date);

        if ($status == 'Completo' && $date == false) {
          throw new InvalidArgumentException(
            "Data esta no formato errado. 
            Coluna 'Data de Vencimento' e Linha {$line}"
          );
        }

        $status = ($status == 'Completo') ? 1 : 0;
        $date = ($date != false)
          ? $date->format('Y-m-d')
          : 'NULL';

        return (object) [
          'name' => $name,
          'job' => $job,
          'training' => $training,
          'status' => $status,
          'date' => $date
        ];
      },
      array_keys(array_slice($this->spreed_sheet, 1)),
      array_slice($this->spreed_sheet, 1)
    );

    //Save relation's ids.
    $ids = [];
    $line = 2;
    foreach ($cells as $cell) {
      $id = Model::table('tbl_funcionario_treinamento as ft')
        ->join('tbl_funcionario as f', 'ft.id_funcionario', '=', 'f.id')
        ->join('tbl_profissao as p', 'ft.id_profissao', '=', 'p.id')
        ->join('tbl_treinamento as t', 'ft.id_treinamento', '=', 't.id')
        ->where(
          'f.nome=:employed and p.nome=:job and t.nome=:training',
          [
            'employed' => $cell->name,
            'job' => $cell->job,
            'training' => $cell->training
          ]
        )
        ->select('f.id as employed_id', 'p.id as job_id', 't.id as training_id')
        ->get();

      if ($id == null) {
        throw new InvalidArgumentException(
          "A relacao ({$cell->name}, {$cell->job}, {$cell->training})
          na linha {$line} nao existe no banco."
        );
      }

      array_push($ids, ...$id);
      ++$line;
    }

    $cells = array_map(
      fn($id, $cell) => (object) [
        'employed_id' => $id->employed_id,
        'job_id' => $id->job_id,
        'training_id' => $id->training_id,
        'status' => $cell->status,
        'date' => $cell->date,
      ],
      $ids,
      $cells
    );

    return $cells;
  }
}
