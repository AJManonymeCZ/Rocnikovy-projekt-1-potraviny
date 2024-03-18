<?php

class Address extends Model
{
  public $errors = [];
  protected $table = "address";

  protected $allowedColumns = [
    "country",
    "postcode",
    "street",
    "town",

  ];

  public function validate($data)
  {
    $this->errors = [];
    if (!empty($data)) {

      $countries = ["czechia", "slovakia"];

      if (!empty($data['town']) && !preg_match("/^[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ ]+$/", trim($data['town']))) {
        $this->errors['town'] = "Město se muže skládat jenom ze znaků a mezer";
      }

      if (!empty($data['country']) && !in_array($data['country'], $countries)) {
        $this->errors['country'] = "Jenom tyto země jsou povoleny: " + implode(',', $countries);
      }

      if (!empty($data['postcode']) && !preg_match("/^[0-9 ]+$/", trim($data['postcode']))) {
        $this->errors['postcode'] = "PCČ se muže skladat z číslic";
      }

      if (!empty($data['street']) && !preg_match("/^[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ0-9'\.\-\s\,]+$/", trim($data['street']))) {
        $this->errors['street'] = "Ulice se muže skládat jenom ze znaků a mezer";
      }

      if (empty($this->errors)) {
        return true;
      }
    }
    return false;
  }
}
