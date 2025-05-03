<?php

namespace app\classes\xls_file;

use DateTime;
use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use app\classes\xls_file\FormHeader;
use app\classes\xls_file\TypeFile;
use app\models\SqlCode;
use core\model\Model;
use core\model\Register;

class FileXls
{
  public static function validadeFileType(?array $file): string
  {
    $extesion_file = pathinfo($file['name'], PATHINFO_EXTENSION);
    $types_file = array_map(fn($type) => $type->value, TypeFile::cases());
    return (in_array($extesion_file, $types_file))
      ? $file['tmp_name']
      : throw new InvalidArgumentException(
        "Arquivo nao e xlsx: {$file['name']}"
      );
  }

  public static function prospector(string $file): array
  {
    $spreedSheet = [];
    $reader = new Xlsx();
    $reader->setReadDataOnly(TRUE);
    $spreedsheet = $reader->load($file);
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
    return $spreedSheet;
  }

  public static function prepe(?array $file): ?array
  {
    array_map(
      fn($key, $header) => ($key->value == $header)
        ? $header
        : throw new InvalidArgumentException(
          "Cabecalho Error: '{$key->name}' e '{$key->value}' nao '{$header}'"
        ),
      FormHeader::cases(),
      [count($file[0]), ...$file[0]]
    );

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

        $status = ($status == 'Completo') ? 'TRUE' : 'FALSE';
        $date = ($date != false)
          ?  '\'' . $date->format('Y-m-d')  . '\''
          : 'NULL';
        return [$name, $job, $training, $status, $date];
      },
      array_keys(array_slice($file, 1)),
      array_slice($file, 1)
    );

    $ids = Model::multiQuery(
      SqlCode::SelectExistRegisterXls,
      array_map(fn($cell) => array_slice($cell, 0, 3), $cells)
    );

    array_map(
      fn($line, $cell) => ($cell != null) ?: throw new InvalidArgumentException(
        "A relacao na  Linha '{$line}' nao existe no banco"
      ),
      range(2, count($cells) + 1),
      $cells
    );

    $cells = array_map(
      fn(Register $id, $cell) => [
        $cell[3],
        $cell[4],
        $id->employed_id,
        $id->job_id,
        $id->training_id,
      ],
      $ids,
      $cells
    );

    return $cells;
  }
}
