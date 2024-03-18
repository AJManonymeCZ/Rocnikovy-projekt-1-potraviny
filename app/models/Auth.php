<?php

if (!defined("ROOT")) die("direct script access denied");

class Auth
{
  public static function authenticate($user)
  {
    if (is_object($user)) {
      $_SESSION['user'] = $user;
    }
  }

  public static function logged_in()
  {
    if (!empty($_SESSION['user'])) {
      return true;
    }

    return false;
  }

  public static function logout()
  {
    if (!empty($_SESSION['user'])) {
      session_unset();
      session_regenerate_id();
    }
  }

  public static function is_admin()
  {
    if (!empty($_SESSION['user'])) {
      if (!empty($_SESSION['user']->role_name)) {
        if (strtolower($_SESSION['user']->role_name) == "admin") {
          return true;
        }
      }
    }

    return false;
  }

  public static function __callStatic($funcName, $arguments)
  {
    $key = str_replace("get", "", strtolower($funcName));
    if (!empty($_SESSION['user']->$key)) {
      if ($arguments) {
      }
      return $_SESSION['user']->$key;
    }
    return '';
  }
}
