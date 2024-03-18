<?php

if (!defined("ROOT")) die("direct script access denied");

class Order_details extends Model
{
  public $errors = [];
  protected $table = "order_details";

  protected $allowedColumns = [
    "id",
    "order_id",
    "product_id",
    "quantity",
    "total",
    "amount",
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
