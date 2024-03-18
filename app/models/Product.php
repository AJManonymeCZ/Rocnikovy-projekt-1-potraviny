<?php

class Product extends Model
{
  public $errors = [];
  protected $table = "product";

  protected $allowedColumns = [
    "id",
    "name",
    "description",
    "product_image",
    "category_id",
    "slug",
    "date",
    "price",
    "views",
    "removed",
  ];

  protected $afterSelect = [
    'get_category'
  ];


  public function validate($data)
  {
    $this->errors = [];
    if (!empty($data)) {
      if (empty($data['name'])) {
        $this->errors['name'] = "A name field is required";
      } else if (!preg_match("/^[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ ]+$/", trim($data['name']))) {
        $this->errors['name'] = "Category can only have latters";
      }

      if (empty($data['description'])) {
        $this->errors['description'] = "A description field is required";
      } else if (strlen($data['description']) > 5000) {
        $this->errors['description'] = "Description can have 5000 letters";
      }

      if (empty($data['category_id'])) {
        $this->errors['category_id'] = "A category field is required";
      }

      if (empty($data['price'])) {
        $this->errors['price'] = "A price field is required";
      } else if (!preg_match("/^\d+(,\d{3})*(\.\d{1,2})?$/", trim($data['price']))) {
        $this->errors['price'] = "Price can have only numbers";
      }


      if (empty($this->errors)) {
        return true;
      }
    }
    return false;
  }


  protected function get_category($data)
  {
    if (!empty($data[0]->category_id)) {
      foreach ($data as $key => $row) {
        $query = "SELECT category.category FROM category 
        JOIN product ON product.category_id = category.id 
        WHERE product.id = :id";
        $res = $this->query($query, ['id' => $row->id]);

        if ($res) {
          $data[$key]->category_name = $res[0]->category;
        }
      }
    }
    return $data;
  }
}
