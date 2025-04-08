<?php

namespace tests\extractor_controller;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use core\controller\ExtractorControllers;
use core\controller\exceptions\ControllerDirEmpty;

class ExtractorControllersTest extends TestCase
{
  private string $path_true_controllers_test;
  private string $path_empty_controllers_test;

  public function setUp(): void
  {
    $this->path_true_controllers_test =
      'tests/extractor_controller/true_controllers_test/*.php';
    $this->path_empty_controllers_test =
      'tests/exxtractor_controller/empty_controllers_test/*.php';
  }

  #[TestDox('When the dir is true')]
  public function test_assert_controllers(): void
  {
    $expect = [
      'extractor_controller\true_controllers_test\Admin',
      'extractor_controller\true_controllers_test\Delete',
      'extractor_controller\true_controllers_test\Home',
      'extractor_controller\true_controllers_test\Login',
      'extractor_controller\true_controllers_test\Training',
    ];
    $this->assertEquals(
      $expect,
      ExtractorControllers::get($this->path_true_controllers_test)
    );
  }

  #[TestDox('When not have files .php inside dir')]
  public function test_expection_ControllerDirEmpty(): void
  {
    $this->expectException(ControllerDirEmpty::class);
    $this->expectExceptionMessage(
      "Pasta '{$this->path_empty_controllers_test}' nao a arquivos .php"
    );
    ExtractorControllers::get($this->path_empty_controllers_test);
  }
}
