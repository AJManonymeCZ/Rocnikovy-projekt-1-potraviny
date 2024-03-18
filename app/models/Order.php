<?php

if (!defined("ROOT")) die("direct script access denied");

class Order extends Model
{
  public $errors = [];
  protected $table = "orders";

  protected $allowedColumns = [
    "id",
    "firstname",
    "lastname",
    "email",
    "shipping_address",
    "users_id",
    "order_date",
    "paid",
    "payment_method",
    "amount",
    "status",
    "raw",
  ];

  public function validate($data)
  {
    $this->errors = [];
    if (!empty($data)) {

      $payments = ["card", "paypal"];

      if (empty($data['firstname'])) {
        $this->errors['firstname'] = "A first name is required";
      } else if (!preg_match("/^[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ]+$/", trim($data['firstname']))) {
        $this->errors['firstname'] = "First name can only have letters witout spases";
      }

      if (empty($data['lastname'])) {
        $this->errors['lastname'] = "A last name is required";
      } else if (!preg_match("/^[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ]+$/", trim($data['lastname']))) {
        $this->errors['lastname'] = "First name can only have letters witout spases";
      }

      if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $this->errors['email'] = "A email is not valid";
      }

      if (empty($data["payment_method"])) {
        $this->errors['payment_method'] = "A payment method is required";
      } else if (!in_array($data["payment_method"], $payments)) {
        $this->errors["payment_method"] = "Payments methods, that are allowed: " . implode(",", $payments);
      }

      if (empty($this->errors)) {
        return true;
      }
    }
    return false;
  }
}
