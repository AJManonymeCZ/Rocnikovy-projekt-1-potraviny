<?php

if (!defined("ROOT")) die("direct script access denied");

class _404Controller extends Controller
{

  public function index()
  {
    $data['title'] = "404";
    $this->view("_404", $data);
  }
}
