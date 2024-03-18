<?php

if (!defined("ROOT")) die("direct script access denied");

class HomeController extends Controller
{

  public function index()
  {
    $data['title'] = "Domů";

    $product = new Product();
    $data["latest_products"] = $product->findAll($order = "desc", 6);
    $data["most_viewed_products"] = $product->query("SELECT * FROM product ORDER BY product.views DESC LIMIT 4;");

    $slider = new Slider();
    $data["sliders"] = $slider->where(["disabled" => 0]);
    $data["dots"] = count($data["sliders"]);

    $this->view("home", $data);
  }
}
