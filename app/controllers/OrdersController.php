<?php

if (!defined("ROOT")) die("direct script access denied");

class OrdersController extends Controller
{

  public function index()
  {

    if (!Auth::logged_in()) {
      redirect("login");
    }

    $data['title'] = "Objednávky";

    $order = new Order();
    $address = new Address();

    //pagination vars
    $limit = 10;
    $data["pager"] = new Pager($limit);
    $offset = $data["pager"]->offset;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $data_type = $_POST["data_type"] ?? null;
      $id = $order->first(["id" => $_POST['id']]) ? $_POST['id'] : false;

      if ($id) {
        if ($data_type == "order") {
          //get information about order 
          $query = "SELECT orders.id, orders.firstname, orders.lastname, orders.email, orders.order_date, orders.paid, orders.amount AS 'order_amount', order_details.amount AS 'product_price' , order_details.quantity,product.id AS 'product_id', product.name, category.category, orders.status
          FROM orders
          JOIN order_details ON orders.id = order_details.order_id
          JOIN product ON product.id = order_details.product_id
          JOIN category ON category.id = product.category_id
          WHERE orders.id = :id;";

          $arr = [];
          $arr["row"] = $order->query($query, ["id" => $id]);

          $addres_id = $order->first(["id" => $id]);
          $arr["row_address"] = $address->where(["id" => $addres_id->shipping_address]);

          echo json_encode($arr);
          die;
        }
      } else {
        $arr = [];

        $arr["error"] = "Tato objednávka neni validní";
        echo json_encode($arr);
        die;
      }
    }

    $data["orders"] = $order->query("select * from orders where users_id = :user_id", ["user_id" => Auth::getId()]);

    $this->view("orders", $data);
  }
}
