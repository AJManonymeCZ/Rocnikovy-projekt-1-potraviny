<?php

if (!defined("ROOT")) die("direct script access denied");

class Controller
{
  public function view($view, $data = [])
  {

    extract($data);

    $path = trim(__DIR__,  'core');

    $filename =  $path . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . $view . "View.php";
    if (file_exists($filename)) {
      require $filename;
    } else {
      echo "Could not found view file: " . $filename;
    }
  }
}
