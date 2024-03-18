<?php

if (!defined("ROOT")) die("direct script access denied");

class VerifyController extends Controller
{

  public function index($token = null)
  {
    $user = new User();
    if (!empty($token) && $user->query("UPDATE users SET status = 1 WHERE token = '$token' LIMIT 1")) {
      $this->view("verify", ["title" => "Ověření Emailu"]);
    } else {
      redirect("home");
    }
  }
}
