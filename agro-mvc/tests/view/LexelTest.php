<?php

namespace tests\view;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use core\view\Parser;

class LexelTest extends TestCase
{
  private function createTempFile(string $content): string
  {
    $tempFile = tempnam(sys_get_temp_dir(), 'tpl');
    file_put_contents($tempFile, $content);
    return $tempFile;
  }

  private function assertTokens(Parser $lexer, ?array $tokens): void
  {
    $token_list = array_map(
      fn($token) => [$token->lexem, $token->type],
      $lexer->tokens
    );

    foreach ($tokens as $key => $token) {
      $this->assertEquals($token, $token_list[$key]);
    }
  }

  #[TestDox('Expression: {% header %}')]
  public function test_expression_0(): void
  {
    $content = <<<TPL
    {% header %}
    TPL;

    $file = $this->createTempFile($content);
    $this->assertTokens(new Parser($file), [['{% header %}', 'Header']]);
  }

  #[TestDox('Expression: {% for question in questions %}')]
  public function test_expression_1(): void
  {
    $content = <<<TPL
    {% for question in questions %}
    TPL;

    $file = $this->createTempFile($content);
    $this->assertTokens(new Parser($file), [['{% for question in questions %}', 'StructFor']]);
  }

  #[TestDox('Expression: {% for questions %}')]
  public function test_expression_2(): void
  {
    $content = <<<TPL
    {% if questions %}
    TPL;

    $file = $this->createTempFile($content);
    $this->assertTokens(new Parser($file), [['{% if questions %}', 'StructIf']]);
  }
}
