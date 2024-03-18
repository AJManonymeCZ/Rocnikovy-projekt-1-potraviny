<?php

if (!defined("ROOT")) die("direct script access denied");

class Category extends Model
{
  public $errors = [];
  protected $table = "category";

  protected $allowedColumns = [
    "id",
    "category",
    "disabled",
    "slug",
  ];

  public function validate($data)
  {
    $this->errors = [];
    if (!empty($data)) {
      if (empty($data['category'])) {
        $this->errors['category'] = "A category field is required";
      } else if (!preg_match("/^[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ ]+$/", trim($data['category']))) {
        $this->errors['category'] = "Category can only have latters";
      }
      // else if (!empty($this->where(['name' => $data['name']]))) {
      //   $this->errors['name'] = "Category already exists";
      // }

      if ((int)$_POST['disabled'] != 0 && (int)$_POST['disabled'] != 1) {
        $this->errors['disabled'] = "A disabled field is required";
      }

      if (empty($this->errors)) {
        return true;
      }
    }
    return false;
  }
}
