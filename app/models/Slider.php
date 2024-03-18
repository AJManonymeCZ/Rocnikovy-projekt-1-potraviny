<?php

if (!defined("ROOT")) die("direct script access denied");

class Slider extends Model
{
  public $errors = [];
  protected $table = "slider_images";

  protected $allowedColumns = [
    "id",
    "image",
    "title",
    "description",
    "disabled",
  ];

  public function validate($data)
  {
    $this->errors = [];
    if (!empty($data)) {

      if (!preg_match("/^[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ ]+$/", trim($data['title']))) {
        $this->errors['title'] = "Title can only have latters";
      }

      if (strlen($data['description']) > 50) {
        $this->errors['description'] = "Description can have 50 letters";
      }

      if (empty($this->errors)) {
        return true;
      }
    }
    return false;
  }
}
