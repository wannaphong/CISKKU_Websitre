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
  $capsule = new \Illuminate\Database\Capsule\Manager;
  $capsule->addConnection($container['settings']['db']);
  $capsule->setAsGlobal();
  $capsule->bootEloquent();
  return $capsule;
};