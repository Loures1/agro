<?php

function dd($dump)
{
  var_dump($dump);
  die();
}

function pdd($dump)
{
  print_r($dump);
  die();
}

function assertControllerHome($uri): bool
{
  if ($uri === '/') {
    return TRUE;
  }
  return FALSE;
}
