<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface;

class Controller {
  
  private $container;

  public function __construct ($container) {
    $this->container = $container;
  }

  public function __get ($property) {
    if ($this->container->{$property}) {
      return $this->container->{$property};
    }
  }
}