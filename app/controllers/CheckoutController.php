<?php

if (!defined("ROOT")) die("direct script access denied");

class CheckoutController extends Controller
{

    public function index()
    {
        $data["title"] = "Pokladna";

        if (empty($_SESSION["CART"])) redirect("shop");

        $product = new Product();
        $order = new Order();
        $order_details = new Order_details();
        $address = new Address();
        $user = new User();

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


        if (
            $_SERVER['REQUEST_METHOD'] == "POST" &&
            is_array($data["CART"])
        ) {
            //TODO CHECKOUT AND VALIDATE INPUTS ESPECIALY FOR PAYMENT METHOD!! 
            $isGoodOrder = $order->validate($_POST);
            $isGoodAddres = $address->validate($_POST);

            if ($data["total"] > 15) {
                if ($isGoodOrder && $isGoodAddres) {
                    //die("HERE");
                    $arr = $_POST;
                    $arr["paid"] = 0;
                    $arr["status"] = "čekající";
                    $arr["order_date"] = date("Y-m-d H:i:s");
                    $arr["amount"] = round(floatval($data["total"]), 2);

                    if (Auth::logged_in()) {
                        $arr["users_id"] = Auth::getId();
                    } else {
                        $arr["users_id"] = NULL;
                    }

                    $arr['order_id'] = 0;
                    // EVERY TIME I HAVE TO INSET NEW ADDRES BCS USER CAN CHANGE IT
                    if ($shipping_address = $address->insert($_POST, true)) {
                        $arr["shipping_address"] = $shipping_address;
                    }

                    if ($order_id = $order->insert($arr, true)) {
                        $arr['order_id'] = $order_id;
                        //insert data to order_details 
                        foreach ($data["CART"] as $cart_arr) {
                            $arr2 = [];
                            $arr2["order_id"] = $order_id;
                            $arr2["product_id"] = $cart_arr["id"];
                            $arr2["quantity"] = $cart_arr["qty"];
                            $arr2["amount"] = $cart_arr["row"]->price;
                            $arr2["total"] = $cart_arr["qty"] * $arr["amount"];

                            $order_details->insert($arr2);
                        }
                        if ($_POST['payment_method'] == 'card') {
                            stripe_checkout($arr);
                            //unset cart items
                            unset($_SESSION["CART"]);
                        } else if ($_POST['payment_method'] == 'paypal') {
                            paypal_checkout($arr);
                        }
                    }
                } else {
                    $data["errors"] = array_merge($order->errors, $address->errors);
                }
            } else {
                $data["errors"]["error_amount"] = "Částka musí byt vyšší než 15 Kč!";
            }
            //var_dump($_POST);
        }

        $this->view("checkout", $data);
    }
}
