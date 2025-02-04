<?php

namespace app\classes;

class Insert
{
  const SYNTAX = "INSERT INTO table (filds) VALUES (values)";
  const RESQUEST = ['table', 'filds', 'values'];
}

class Select
{
  const SYNTAX = "SELECT filds FROM table WHERE condition";
  const REQUEST = ['table', 'filds', 'condtion'];
}
