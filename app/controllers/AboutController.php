<?php

if (!defined("ROOT")) die("direct script access denied");

class AboutController extends Controller
{

  public function index()
  {
    $data['title'] = "O nás";

    $this->view("about", $data);
  }
}
