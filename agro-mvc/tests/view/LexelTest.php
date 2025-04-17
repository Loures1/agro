<?php

namespace tests\view;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use core\view\Lexer;

class LexelTest extends TestCase
{
  private Lexer $lexer1;
  private Lexer $lexer2;
  private Lexer $lexer3;
  private Lexer $lexer4;

  public function setUp(): void
  {
    $this->lexer1 = new Lexer('./tests/view/files/test1.html');
    $this->lexer2 = new Lexer('./tests/view/files/test2.html');
    $this->lexer3 = new Lexer('./tests/view/files/test3.html');
    $this->lexer4 = new Lexer('./tests/view/files/test4.html');
  }

  #[TestDox('Testing Lexem Reserved and Blank')]
  public function test_reserved_token_and_blank(): void
  {
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

    $token_list = array_map(
      fn($token) => [$token->lexem, $token->type],
      $this->lexer1->tokens
    );

    foreach ($tokens as $key => $token) {
      $this->assertEquals($token, $token_list[$key]);
    }
  }

  #[TestDox('Testing Lexem Identifier and Blank')]
  public function test_identifier_token_and_blank(): void
  {
    $tokens = [
      ['teste',     'Identifier'],
      ['\s',             'Blank'],
      ['question',  'Identifier'],
      ['\s',             'Blank'],
      ['teste2',    'Identifier'],
      ['\s',             'Blank'],
      ['numbers',   'Identifier'],
      ['\s',             'Blank'],
      ['numbers_1', 'Identifier'],
      ['\s',             'Blank']
    ];

    $token_list = array_map(
      fn($token) => [$token->lexem, $token->type],
      $this->lexer2->tokens
    );

    foreach ($tokens as $key => $token) {
      $this->assertEquals($token, $token_list[$key]);
    }
  }

  #[TestDox('Testing Lexem Tokens Expression: {% for questions in question %}')]
  public function test_expression_1(): void
  {
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

    $token_list = array_map(
      fn($token) => [$token->lexem, $token->type],
      $this->lexer3->tokens
    );

    foreach ($tokens as $key => $token) {
      $this->assertEquals($token, $token_list[$key]);
    }
  }

  #[TestDox('Testing Lexem Tokens Expression: <li><a href="/polls/{{ question.id }}/">{{ question.question_text }}</a></li>')]
  public function test_expression_2(): void
  {
    $tokens = [
      ['<li>', 'TagHtmlStarting'],
      ['<a', 'TagHtmlStarting'],
      ['href',]
    ];

    $token_list = array_map(
      fn($token) => [$token->lexem, $token->type],
      $this->lexer4->tokens
    );

    $this->assertEquals($tokens[0], $token_list[0]);
  }
}
