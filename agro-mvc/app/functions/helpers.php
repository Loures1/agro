<?php

function dd($dump)
{
  var_dump($dump);
  die();
}

function pd($dump)
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
