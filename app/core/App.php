<?php

if (!defined("ROOT")) die("direct script access denied");

class App
{
  protected $controller = '_404Controller';
  protected $method = 'index';
  public static $page = '_404Controller';

  private Language $currentLanguage;

  function __construct()
  {
      Language::init();
      $url = $this->getURL();

      $language = $this->getLanguage($url[0]);
      LanguageFactory::setLanguage($language);
      setPath(ROOT . "/" . LanguageFactory::getLanguage()->getLanguageKey());

      $path = trim(__DIR__, 'core');
      $controllerIndex = 0;
      $methodIndex = 1;

      if ($language != null) {
          unset($url[0]);
          $methodIndex = 2;
          $controllerIndex = 1;
      }

      $filename =  $path . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . ucfirst($url[$controllerIndex]) . "Controller.php";
      if (file_exists($filename)) {
          require $filename;
          $this->controller = $url[$controllerIndex] . "Controller";
          self::$page = $url[$controllerIndex];
          unset($url[$controllerIndex]);
      } else {
          require  $path . DIRECTORY_SEPARATOR . "controllers" . DIRECTORY_SEPARATOR . $this->controller . ".php";
      }

      $myController = new $this->controller();
      $myMethod = $url[$methodIndex] ?? $this->method;

      $myMethod = str_replace("-", "_", $myMethod);

      if (!empty($url[$methodIndex])) {
          if (method_exists($myController, strtolower($myMethod))) {
              $this->method = strtolower($myMethod);
              unset($url[$methodIndex]);
          }
      }

      $url = array_values($url);
      call_user_func_array([$myController, $this->method], $url);
  }

  private function getURL()
  {
    $url = $_GET['url'] ?? 'home';
    $url = filter_var($url, FILTER_SANITIZE_URL);
    return explode("/", $url);
  }

  private function getLanguage(string $key): Language|null {
      $lang = null;

      foreach (Language::$languages as $language) {
          if ($language->getLanguageKey() == $key) {
              $lang = $language;
              break;
          }
      }

      return $lang;
  }
}
