<?php

if (!defined("ROOT")) die("direct script access denied");

class LogoutController extends Controller
{

  public function index()
  {

    Auth::logout();
    redirect('home');
  }
}
