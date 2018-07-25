<?php
require '../vendor/autoload.php';

session_start();

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

$app = new \Slim\App([
  'settings' => [
    'displayErrorDetails' => true,
    'db' => [
      'driver' => 'mysql',
      'host' => 'localhost',
      'database' => 'cis_kku',
      'username' => 'root',
      'password' => '',
      'charset'   => 'utf8',
      'collation' => 'utf8_general_ci',
      'prefix'    => '',
    ]
  ]
]);

require '../src/Container.php';
require '../src/routes/Routes.php';

function moveUploadedFile($directory, UploadedFile $uploadedFile) {
  $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
  $basename = bin2hex(random_bytes(8));
  $filename = sprintf('%s.%0.8s', $basename, $extension);

  $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

  return $filename;
}

$app->run();