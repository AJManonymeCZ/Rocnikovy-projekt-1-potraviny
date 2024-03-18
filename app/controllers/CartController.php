<?php

if (!defined("ROOT")) die("direct script access denied");

class CartController extends Controller
{

  public function index()
  {
    $data['title'] = "Cart";

    $order = new Order();
    $order_details = new Order_details();
    $product = new Product();


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    }

    $cart = $_SESSION["CART"] ?? [];
    $total = 0;

    if (!empty($cart)) {
      foreach ($cart as $key => $arr) {
        $cart[$key]['row'] = $product->first(['id' => $arr['id']]);
        $total += $arr["qty"] * $cart[$key]['row']->price;
      }
    }

    $data["CART"] = $cart;
    $data["total"] = $total;

    $this->view("cart", $data);
  }

  public function handle_data()
  {
    $product = new Product();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

      $data_type = $_POST["data_type"] ?? null;
      $id = $_POST['id'] ?? 0;

      if (!empty($_SESSION["CART"])) {
        $cart = $_SESSION["CART"];
      } else {
        $cart = $_SESSION["CART"] = [];
      }

      if ($data_type == "add") {
        //add item to cart 

        //fisrt check if item is in DB check if qty is valid
          $isQty = false;
          if(!empty($_POST['qty'])) {
              if(preg_match("/^[1-9]+$/", $_POST['qty'])) {
                  $isQty = true;
              }
          }
          if (empty($product->first(["id" => $id]))) {
          return;
        }

        if (empty($cart)) {
          $arr2['id'] = $id;
          $arr2['qty'] = $isQty ? $_POST['qty'] : 1;
          $arr[] = $arr2;
          $_SESSION["CART"] = $arr;
        } else {
          $found = false;

          foreach ($cart as $key => $arr) {
            if ($arr['id'] == $id) {
                if($isQty)
                    $cart[$key]["qty"] = $_POST['qty'];
                 else
                    $cart[$key]["qty"]++;

              $found = true;
            }
          }

          if (!$found) {
            $arr['id'] = $id;
            $arr['qty'] = $isQty ? $_POST['qty'] : 1;
            $cart[] = $arr;
          }
          $_SESSION["CART"] = $cart;
        }

        $arr = [];
        $arr["message"] = "";
        $arr["action"] = "add";

        echo json_encode($arr);
      } else if ($data_type == "remove") {
        //remove item to cart 
        if (!empty($cart)) {
          foreach ($cart as $key => $arr) {
            if ($arr['id'] == $id) {
              array_splice($cart, $key, 1);
            }
          }
          $_SESSION["CART"] = $cart;

          $arr = [];
          $arr["message"] = "";
          $arr["action"] = "reload";

          echo json_encode($arr);
        }
      } else if ($data_type == "remove_all") {
        $_SESSION["CART"] = [];

        $arr = [];
        $arr["message"] = "";
        $arr["action"] = "";

        echo json_encode($arr);
      } else if ($data_type == "change_qty") {
        $qty = 0;

        $_POST["value"] = intval($_POST["value"]);

        if (!empty($_POST["value"]) && is_int($_POST["value"]) && $_POST["value"] > 0) {
          $qty = $_POST["value"];
        } else {
          $qty = 1;
        }

        if (!empty($cart)) {
          foreach ($cart as $key => $arr) {
            if ($arr['id'] == $id) {
              $cart[$key]["qty"] = $qty;
            }
          }

          $_SESSION["CART"] = $cart;

          $arr = [];
          $arr["message"] = "";
          $arr["action"] = "reload";

          echo json_encode($arr);
        }
      } else if ($data_type == "get_cart") {
        $arr = [];

        if (!empty($_SESSION["CART"])) {
          $arr["data"] = true;
        } else {
          $arr["data"] = false;
        }

        $arr["message"] = "";
        $arr["action"] = "cart";

        echo json_encode($arr);
      }
    }
  }
}
