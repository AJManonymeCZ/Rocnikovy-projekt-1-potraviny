<?php

class Codes extends Model
{
  public $errors = [];
  protected $table = "codes";

  protected $allowedColumns = [
    "id",
    "email",
    "code",
    "expire",
    "users_id",
  ];

  public function validate($data)
  {
    $this->errors = [];
    if (!empty($data)) {
    }
    return false;
  }
}
