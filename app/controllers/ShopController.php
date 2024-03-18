<?php

if (!defined("ROOT")) die("direct script access denied");

class ShopController extends Controller
{

  public function index()
  {
    $data['title'] = "Nakupovat";

    $category = new Category();
    $data["categories"] = $category->where(["disabled" => 0]);

    $product = new Product();
    $products = [];

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["category"])) {
      $products = $category->query(
        "SELECT product.id, product.name, product.description, product.price, product.slug, product.product_image, product.views, category.category
      FROM product 
      JOIN category ON category.id = product.category_id 
      WHERE category.slug = :slug ORDER BY product.views DESC
      ",
        ["slug" => $_GET["category"]]
      );

      if (!empty($products)) {
        $data["products"] = $products;
        $data["category_name"] = $products[0]->category;
      }
    } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $text = trim($_POST["data"]);
      $limit = 10;
      if (!empty($text) && preg_match_all("/^[a-zA-ZáčďéěíňóřšťůúýžÁČĎÉĚÍŇÓŘŠŤŮÚÝŽ]+$/", $text)) {
        $text = "%" . $text . "%";
        $query = "SELECT * FROM product WHERE name like :find ORDER BY views DESC limit $limit";

        $rows = $product->query($query, ['find' => $text]);

        $info["data_type"] = "search";
        $info["data"] = $rows;

        echo json_encode($info);
        die;
      } else {
        echo json_encode("");
        die;
      }
    } else {
      //TODO: MOST SELLS PRODUCTS
      $query = "SELECT product.id, product.name, product.description, product.price, product.slug, product.product_image, category.category, COUNT(order_details.product_id) 
      FROM product 
                JOIN order_details ON order_details.product_id = product.id 
                JOIN category ON category.id = product.category_id
                GROUP BY 2 
                ORDER BY COUNT(order_details.product_id) DESC LIMIT 9;";
      $data["products"] = $product->query($query);
      // show($data);
      // die;
    }

    $this->view("shop", $data);
  }
}
