<?php
include_once('./src/Tokyo1.php');
$tokyo = new Tokyo1();
$tokyo->uri = $_SERVER['REQUEST_URI'];
$tokyo->router = [
  '/'        => './static/html/index.html',
  '/sign_up' => './static/html/sign_up.html',
  '/sign_in' => './static/html/sign_in.html'
];
echo $tokyo();
