<?php

if (!defined("ROOT")) die("direct script access denied");

class CancelController extends Controller
{

  public function index()
  {
    $data["title"] = "Zrušit";

    $this->view("cancel", $data);
  }
}
