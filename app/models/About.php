<?php

class About extends Model
{
  public $errors = [];
  protected $table = "";

  protected $allowedColumns = [];

  public function validate($data)
  {
    $this->errors = [];
    if (!empty($data)) {
      if (empty($data['name'])) {
        $this->errors['name'] = "A name is required";
      } else if (!preg_match("/^[a-zA-Z]+$/", trim($data['name']))) {
        $this->errors['name'] = "name can only have letters without spases";
      }

      if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $this->errors['email'] = "A email is not valid";
      }

      if (empty($data['description'])) {
        $this->errors['description'] = "A description is required";
      }

      if (empty($this->errors)) {
        return true;
      }
    }
    return false;
  }
}
