<?php
require '../vendor/autoload.php';

session_start();

$app = new \Slim\App([
  'settings' => [
    'displayErrorDetails' => true,
    "db" => [
      "host" => "localhost",
      "dbname" => "cis_kku",
      "user" => "root",
      "pass" => ""
    ]
  ]
]);

require '../src/Container.php';

$app->get('/', \App\Controllers\PagesController::class . ':home')->setName('home');
$app->get('/news', \App\Controllers\PagesController::class . ':news')->setName('news');
$app->get('/event', \App\Controllers\PagesController::class . ':event')->setName('event');

$app->run();