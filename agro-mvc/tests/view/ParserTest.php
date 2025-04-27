<?php

namespace tests\view;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use core\view\Parser;
use core\view\exceptions\ErrorSyntax;

class ParserTest extends TestCase
{
  #[TestDox("Exception: ErrorSyntax -> header 123")]
  public function test_expextion_ErrorSyntal_0(): void
  {
    $this->expectException(ErrorSyntax::class);
    $this->expectExceptionMessage("Error Syntax line: 1");
    $content = <<<TPL
    header 123
    TPL;
    Parser::generateCode($content);
  }

  #[TestDox("Exception: ErrorSyntax -> {%if latest_question_list %}")]
  public function test_expextion_ErrorSyntal_1(): void
  {
    $this->expectException(ErrorSyntax::class);
    $this->expectExceptionMessage("Error Syntax line: 1");
    $content = <<<TPL
    {% iflatest_question_list %}
    TPL;
    Parser::generateCode($content);
  }

  #[TestDox("Exception: ErrorSyntax -> {%for question in latest_question_list %}")]
  public function test_expextion_ErrorSyntal_2(): void
  {
    $this->expectException(ErrorSyntax::class);
    $this->expectExceptionMessage("Error Syntax line: 1");
    $content = <<<TPL
    {%for question in latest_question_list %}
    TPL;
    Parser::generateCode($content);
  }
}
