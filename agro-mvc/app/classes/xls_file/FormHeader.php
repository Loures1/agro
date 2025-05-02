<?php

namespace app\classes\xls_file;

enum FormHeader: string
{
  case SizeHeader = '5';
  case NameHeader = 'Nome';
  case JobHeader = 'Profissão';
  case TrainingHeader = 'Treinamento Obrigatório';
  case StatusHeader = 'Situação de Treinamento';
  case DateHeader = 'Data de Vencimento';
}
