<?php
$container = $app->getContainer();

$container['view'] = function ($container) {
  $dir = dirname(__DIR__);
  $view = new \Slim\Views\Twig($dir . '/src/views', [
    'cache' => false // "$dir/tmp/cache"
  ]);
  $basePath = rtrim(str_ireplace('Index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
  $view->addExtension(new Slim\Views\TwigExtension($container->get('router'), $basePath));
  return $view;
};

$container['db'] = function ($container) {
  $settings = $container->get('settings')['db'];
  $pdo = new PDO("mysql:host=" . $settings['host'] . ";dbname=" . $settings['dbname'] . ";charset=utf8", $settings['user'], $settings['pass']);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  return $pdo;
};