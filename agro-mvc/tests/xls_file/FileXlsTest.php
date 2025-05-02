<?php

namespace tests\xls_file;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use app\classes\xls_file\FileXls;

class FileXlsTest extends TestCase
{
  #[TestDox('Column \'Nome\' wrong')]
  public function test_expection_InvalidArgumentException_0(): void
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("Cabecalho Error: 'NameHeader' e 'Nome' nao 'Name'");
    $array = [
      0 => [
        'Name',
        'Profissao',
        'Treimento',
        'Status',
        'Date'
      ]
    ];
    FileXls::validadeInputs($array);
  }

  #[TestDox('Column \'Profissão\' wrong')]
  public function test_expection_InvalidArgumentException_1(): void
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("Cabecalho Error: 'JobHeader' e 'Profissão' nao 'Profissao'");
    $array = [
      0 => [
        'Nome',
        'Profissao',
        'Treimento',
        'Status',
        'Date'
      ]
    ];
    FileXls::validadeInputs($array);
  }

  #[TestDox('Column \'SizeHeader\' wrong')]
  public function test_expection_InvalidArgumentException_2(): void
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("Cabecalho Error: 'SizeHeader' e '5' nao '4'");
    $array = [
      0 => [
        'Nome',
        'Profissao',
        'Treimento',
        'Status'
      ]
    ];
    FileXls::validadeInputs($array);
  }
}
