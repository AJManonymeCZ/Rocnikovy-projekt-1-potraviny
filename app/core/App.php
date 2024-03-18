<?php

if (!defined("ROOT")) die("direct script access denied");

class App
{
  protected $controller = '_404Controller';
  protected $method = 'index';
  public static $page = '_404Controller';

  function __construct()
  {
    $url = $this->getURL();
    $path = trim(__DIR__, 'core');

    $filename =  $path . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . ucfirst($url[0]) . "Controller.php";
    if (file_exists($filename)) {
      require $filename;
      $this->controller = $url[0] . "Controller";
      self::$page = $url[0];
      unset($url[0]);
    } else {
      require  $path . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . $this->controller . ".php";
    }

    $myController = new $this->controller();
    $myMethod = $url[1] ?? $this->method;
    $myMethod = str_replace("-", "_", $myMethod);

    if (!empty($url[1])) {
      if (method_exists($myController, strtolower($myMethod))) {
        $this->method = strtolower($myMethod);
        unset($url[1]);
      }
    }

    $url = array_values($url);
    call_user_func_array([$myController, $this->method], $url);
  }

  private function getURL()
  {
    $url = $_GET['url'] ?? 'home';
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $arr = explode("/", $url);
    return $arr;
  }
}
