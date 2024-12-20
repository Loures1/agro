<?php
include_once('./src/Tokyo1.php');
include_once('./src/Tokyo3.php');
$tokyo1 = new Tokyo1();
function index()
{
  return file_get_contents(
    "./static/html/index.html"
  );
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  function sign_up()
  {
    return file_get_contents(
      "./static/html/sign_up.html"
    );
  }

  function sign_in()
  {
    return file_get_contents(
      "./static/html/sign_in.html"
    );
  }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
  function sign_up()
  {
    $tokyo3 = new Tokyo3();
    $tokyo3->target = 'tbl_supervisor';
    $tokyo3->params = $_POST;
    $tokyo3->operation = 'INSERT';
    $tokyo3();
  }
}

$tokyo1->router = [
  '/'        => 'index',
  '/sign_up' => 'sign_up',
  '/sign_in' => 'sign_in'
];

echo $tokyo1();
