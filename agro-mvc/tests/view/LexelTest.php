<?php

namespace tests\view;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use core\view\Lexer;

class LexelTest extends TestCase
{
  private function createTempFile(string $content): string
  {
    $tempFile = tempnam(sys_get_temp_dir(), 'tpl');
    file_put_contents($tempFile, $content);
    return $tempFile;
  }

  private function assertTokens(Lexer $lexer, ?array $tokens): void
  {
    $token_list = array_map(
      fn($token) => [$token->lexem, $token->type],
      $lexer->tokens
    );

    foreach ($tokens as $key => $token) {
      $this->assertEquals($token, $token_list[$key]);
    }
  }

  #[TestDox('Testing Lexem Tokens Expression: header if endif for endfor in else')]
  public function test_reserved_token_and_blank(): void
  {
    $content = <<<TPL
    header if endif for endfor in else
    TPL;

    $file = self::createTempFile($content);

    $tokens = [
      ['header', 'Reserved'],
      ['\s',        'Blank'],
      ['if',     'Reserved'],
      ['\s',        'Blank'],
      ['endif',  'Reserved'],
      ['\s',        'Blank'],
      ['for',    'Reserved'],
      ['\s',        'Blank'],
      ['endfor', 'Reserved'],
      ['\s',        'Blank'],
      ['in',     'Reserved'],
      ['\s',        'Blank'],
      ['else',   'Reserved']
    ];

    $lexer = new Lexer($file);
    self::assertTokens($lexer, $tokens);
  }

  #[TestDox('Testing Lexem Tokens Expression: {% for questions in question %}')]
  public function test_expression_1(): void
  {
    $content = <<<TPL
    {% for questions in question %}
    TPL;

    $file = self::createTempFile($content);

    $tokens = [
      ['{',       'OpeningBrace'],
      ['%',        'PercentSign'],
      ['\s',             'Blank'],
      ['for',         'Reserved'],
      ['\s',             'Blank'],
      ['questions', 'Identifier'],
      ['\s',             'Blank'],
      ['in',          'Reserved'],
      ['\s',             'Blank'],
      ['question',  'Identifier'],
      ['\s',             'Blank'],
      ['%',        'PercentSign'],
      ['}',       'ClosingBrace']
    ];

    $lexer = new Lexer($file);
    self::assertTokens($lexer, $tokens);
  }

  #[TestDox('Testing Lexem Tokens Expression: <li><a href="/polls/{{ question.id }}/">{{ question.question_text }}</a></li>')]
  public function test_expression_2(): void
  {
    $content = <<<TPL
    <li><a href="/polls/{{ question.id }}/">{{ question.question_text }}</a></li> 
    TPL;

    $file = self::createTempFile($content);

    $tokens = [
      ['<',                        'LessThan'],
      ['li',                     'Identifier'],
      ['>',                     'GreaterThan'],
      ['<',                        'LessThan'],
      ['a',                      'Identifier'],
      ['\s',                          'Blank'],
      ['href',                   'Identifier'],
      ['=',                           'Equal'],
      ['"/polls/',                   'String'],
      ['{',                    'OpeningBrace'],
      ['{',                    'OpeningBrace'],
      ['\s',                          'Blank'],
      ['question.id',            'Identifier'],
      ['\s',                          'Blank'],
      ['}',                    'ClosingBrace'],
      ['}',                    'ClosingBrace'],
      ['/"',                         'String'],
      ['>',                     'GreaterThan'],
      ['{',                    'OpeningBrace'],
      ['{',                    'OpeningBrace'],
      ['\s',                          'Blank'],
      ['question.question_text', 'Identifier'],
      ['\s',                          'Blank'],
      ['}',                    'ClosingBrace'],
      ['}',                    'ClosingBrace'],
      ['<',                        'LessThan'],
      ['/',                    'ForwardSlash'],
      ['a',                      'Identifier'],
      ['>',                     'GreaterThan'],
      ['<',                        'LessThan'],
      ['/',                    'ForwardSlash'],
      ['li',                     'Identifier'],
      ['>',                     'GreaterThan']
    ];

    $lexer = new Lexer($file);
    self::assertTokens($lexer, $tokens);
  }
}
