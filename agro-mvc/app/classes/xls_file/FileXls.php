<?php

namespace app\classes\xls_file;

use DateTime;
use InvalidArgumentException;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use app\classes\xls_file\FormHeader;
use app\classes\xls_file\TypeFile;
use app\models\SqlCode;
use core\model\Model;

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
        array_push($columns, $cell->getValue());
      }
      array_push($spreedSheet, $columns);
    }
    return $spreedSheet;
  }

  public static function validadeInputs(?array $file): ?array
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
        $line += 1;
        [$name, $job, $training, $status, $date] = $row;
        if ($status != 'Completo' && $status != 'Pendente') {
          throw new InvalidArgumentException(
            "Valor na Coluna 'Status' na Linha '{$line}' 
            e {$status} deve ser 'Completo' ou 'Pendente'"
          );
        }
        if ($date != null && DateTime::createFromFormat('d/m/Y', $date) == false) {
          throw new InvalidArgumentException(
            "Formato invalido na Coluna 'Data de Vencimento' na Linha '{$line}'"
          );
        }
        return [$name, $job, $training];
      },
      array_keys(array_slice($file, 1)),
      array_slice($file, 1)
    );

    $cells = Model::multiQuery(SqlCode::SelectExistRegisterXls, $cells);
    dd($cells);
    array_map(
      fn($line, $cell) => ($cell != null) ?: throw new InvalidArgumentException(
        "A relacao na  Linha '{$line}' nao existe no banco"
      ),
      range(2, count($cells) + 1),
      $cells
    );

    return $cells;
  }
}
