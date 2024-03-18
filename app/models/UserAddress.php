<?php

class Useraddress extends Model
{
  public $errors = [];
  protected $table = "user_address";

  protected $allowedColumns = [
    "users_id",
    "address_id",
  ];

  public function validate($data)
  {
    $this->errors = [];
    if (!empty($data)) {

      if (empty($this->errors)) {
        return true;
      }
    }
    return false;
  }
}
