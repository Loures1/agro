<?php

function dumpDie($dump)
{
  var_dump($dump);
  die();
}

function assertControllerHome($uri): bool
{
  if ($uri === '/') {
    return TRUE;
  }
  return FALSE;
}
