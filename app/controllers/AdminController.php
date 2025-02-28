<?php

use JetBrains\PhpStorm\NoReturn;

if (!defined("ROOT")) die("direct script access denied");

class AdminController extends Controller
{

  public function index()
  {
    if (!Auth::is_admin()) {
      redirect("login");
    }
    redirect("admin/dashboard");
  }

  public function dashboard()
  {
    if (!Auth::is_admin()) {
      redirect("login");
    }

    $data['title'] = "Dashboard";

    $users = new User();
    $data["users"] = $users->where(["role_id" => 1], "desc", 3);
    $data["users_count"] = $users->findAll("desc", 1000) ? count($users->findAll("desc", 1000) ?? []) : 0;


    $categories = new Category();
    $data["categories"] = $categories->findAll("desc", 3);
    $data["categories_count"] = $categories->findAll() ? count($categories->findAll()) : 0;

    $products = new Product();
    $data["products"] = $products->findAll();
    $data["products_count"] = $products->findAll() ? count($products->findAll()) : 0;

    $orders = new Order();
    $data["orders_count"] = $orders->findAll() ? count($orders->findAll()) : 0;

    $this->view("admin/dashboard", $data);
  }

  public function categories($action = null, $id = null)
  {
    if (!Auth::is_admin()) {
      redirect("login");
    }
    $data['title'] = "Categories";
    $data['action'] = $action;
    $data['id'] = $id;

    //pagination vars
    $limit = 10;
    $data['pager'] = new Pager($limit);
    $offset = $data['pager']->offset;

    $category = new Category();
    $product = new Product();

    if ($action == "add") {
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if ($category->validate($_POST)) {
          $_POST['slug'] = str_to_url($_POST['category']);
          $category->insert($_POST);
          message("Your category was succesfully created.");

          redirect("admin/categories");
        }
        $data['errors'] = $category->errors;
      }
    } else if ($action == "delete") {
      $data['row'] = $row = $category->first(['id' => $id]);
      if ($row) {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
          if ($product->query("SELECT * FROM product WHERE category_id = :category_id", ["category_id" => $row->id])) {
            message("You cant delete this category, because its already used.");
            redirect("admin/categories");
          } else {
            $category->delete($row->id);
            message("The category was succesfully deleted.");

            redirect("admin/categories");
          }
        }
      } else {
        $data["errors"]["id"] = "That category does not exist";
      }
    } else if ($action == "edit") {
      $data['row'] = $row = $category->first(['id' => $id]);
      if ($row) {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
          if ($category->validate($_POST)) {
            $_POST['slug'] = str_to_url($_POST['category']);
            $category->update($row->id, $_POST);

            message("The category was succesfully edited.");
            redirect("admin/categories");
          }
          $data['errors'] = $category->errors;
        }
      } else {
        $data["errors"]["id"] = "That category does not exist";
      }
    } else {
      $data['rows'] = $category->findAll($order = 'desc', $limit, $offset);
    }


    $this->view("admin/categories", $data);
  }

  public function users($action = null, $id = null)
  {
    if (!Auth::is_admin()) {
      redirect("login");
    }

    $data["title"] = "Users";
    $data['action'] = $action;
    $data['id'] = $id;

    $user = new User();

    //pagination vars
    $limit = 10;
    $data["pager"] = new Pager($limit);
    $offset = $data["pager"]->offset;

    if ($action == "edit") {
      $data["row"] = $row = $user->first(["id" => $id]);
      if ($row) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          //[TODO] Admin should be able to edit users detais - image, name, emial... 
          $folder = "uploads/images/";
          if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
            file_put_contents($folder . "index.php", "<?php lol");
            file_put_contents("uploads/index.php", "<?php lol");
          }

          //validate image
          $allowedImagesExt = ["image/jpeg", "image/png"];
          $image_errors = [];

          if (!empty($_FILES["image"]["name"])) {
            if ($_FILES["image"]["error"] == 0) {
              if (in_array($_FILES["image"]["type"], $allowedImagesExt)) {
                //OK
                $destination = $folder . time() . $_FILES["image"]["name"];
                $_POST["image"] = $destination;
              } else {
                $image_errors["image"] = "Tento typ souboru není povolen!";
              }
            } else {
              $image_errors["image"] = "Obrázek se nepodařilo nahrát.";
            }
          }

          if ($user->update($row->id, $_POST)) {
            if (!empty($destination)) {
              move_uploaded_file($_FILES["image"]["tmp_name"], $destination);

              resize($destination);

              if ($row && file_exists($row->image)) {
                unlink($row->image);
              }
            }

            message("The user was edited successfully!");
          } else {
            message("Something went wrog!");
          }
          redirect("admin/users");
        }
      } else {
        $data["errors"]["id"] = "That user does not exist";
      }
    } elseif ($action == "delete") {
      $data["row"] = $row = $user->first(["id" => $id]);
      if ($row) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (file_exists($row->image)) {
            unlink($row->image);
          }
          $user->delete($row->id);
          message("The user was succesfully deleted.");

          redirect("admin/users");
        }
      } else {
        $data["errors"]["id"] = "That user does not exist";
      }
    } else {
      $data["rows"] = $user->where(["role_id" => 1], 'desc', $limit, $offset);
    }


    $this->view("admin/users", $data);
  }

  public function products($action = null, $id = null)
  {

    if (!Auth::is_admin()) {
      redirect("login");
    }

    $data["title"] = "Products";
    $data['action'] = $action;
    $data['id'] = $id;

    $product = new Product();
    $category = new Category();

    //pagination vars
    $limit = 10;
    $data["pager"] = new Pager($limit);
    $offset = $data["pager"]->offset;

    if ($action == "add") {
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $_POST['slug'] = str_to_url($_POST['name']);
        $_POST['date'] = date("Y-m-d");
        $_POST['views'] = 0;
        //crate folder if not exits
        $folder = "uploads/images/products/";
        if (!file_exists($folder)) {
          mkdir($folder, 0777, true);
          file_put_contents($folder . "index.php", "<?php lol");
        }

        //validate image
        $imageErrors = [];
        $allowedExt = ["image/png", "image/jpeg"];
        if (!empty($_FILES["product_image"]["name"])) {
          if ($_FILES["product_image"]["error"] == 0) {
            if (in_array($_FILES["product_image"]["type"], $allowedExt)) {
              //good
              $destination = $folder . time() . $_FILES["product_image"]["name"];
              $_POST["product_image"] = $destination;
            } else {
              $imageErrors["product_image"] = "This file type is not allowed! Allowed typse are: " . join(",", $allowedExt);
            }
          } else {
            $imageErrors["product_image"] = "Could not upload the image.";
          }
        } else {
          $imageErrors["product_image"] = "Image is required.";
        }

        if ($product->validate($_POST) && empty($imageErrors)) {
          //upload the image
          if (!empty($destination)) {
            move_uploaded_file($_FILES["product_image"]["tmp_name"], $destination);
          }

          $product->insert($_POST);

          message("Your product was succesfully created.");

          redirect("admin/products");
        } else {;
          $data["errors"] = array_merge($product->errors, $imageErrors);
        }
      }
    } else if ($action == "edit") {
      $data["row"] = $row = $product->first(["id" => $id]);
      //[TODO] check if id is valid in categoires, products and users :D srada no debile 
      if ($row) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $_POST['slug'] = str_to_url($_POST['name']);
          //crate folder if not exits
          $folder = "uploads/images/products/";
          if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
            file_put_contents($folder . "index.php", "<?php lol");
          }

          //validate image
          $imageErrors = [];
          $allowedExt = ["image/png", "image/jpeg"];
          if (!empty($_FILES["product_image"]["name"])) {
            if ($_FILES["product_image"]["error"] == 0) {
              if (in_array($_FILES["product_image"]["type"], $allowedExt)) {
                //good
                $destination = $folder . time() . $_FILES["product_image"]["name"];
                $_POST["product_image"] = $destination;
              } else {
                $imageErrors["product_image"] = "This file type is not allowed! Allowed typse are: " . join(",", $allowedExt);
              }
            } else {
              $imageErrors["product_image"] = "Could not upload the image.";
            }
          }
          if ($product->validate($_POST) && empty($imageErrors)) {
            //upload the image
            if (!empty($destination)) {
              move_uploaded_file($_FILES["product_image"]["tmp_name"], $destination);

              //delete old image 
              if ($row && file_exists($row->product_image)) {
                unlink($row->product_image);
              }
            }

            $product->update($row->id, $_POST);

            message("Your product was succesfully updated.");

            redirect("admin/products");
          } else {;
            $data["errors"] = array_merge($product->errors, $imageErrors);
          }
        }
      } else {
        $data["errors"]["id"] = "That product does not exist";
      }
    } else if ($action == "delete") {
      $data["row"] = $row = $product->first(["id" => $id]);
      if ($row) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if (file_exists($row->product_image)) {
            unlink($row->product_image);
          }
          $product->delete($row->id);
          message("The product was deleted!");

          redirect("admin/products");
        }
      } else {
        $data["errors"]["id"] = "That product does not exist";
      }
    }

    $data["categories"] = $category->where(["disabled" => 0]);
    $data["rows"] = $product->findAll('desc', $limit, $offset);

    $this->view("admin/products", $data);
  }

  public function orders($action = null, $id = null)
  {
    if (!Auth::is_admin()) {
      redirect("login");
    }

    $data["title"] = "Orders";

    $order = new Order();
    $order_details  = new Order_details();
    $product = new Product();
    $address_class = new Address();

    $data['action'] = $action;

    //pagination vars
    $limit = 10;
    $data["pager"] = new Pager($limit);
    $offset = $data["pager"]->offset;
    $isValidId = false;

    if ($action == "view") {
      $isValidId = $order->first(["id" => $id]) ? true : false;

      if ($isValidId) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          if ($_POST["checked"]) {
            if ($order->update($id, ["status" => "doručeno"])) {
              message("Order was updated succesfully");
              redirect("admin/orders");
            }
          }
        }

        //get oreders data
        $query = "SELECT orders.id, orders.firstname, orders.lastname, orders.email, orders.order_date, orders.paid, orders.amount AS 'order_amount', order_details.amount AS 'product_price' , order_details.quantity,product.id AS 'product_id', product.name, category.category, orders.status 
        FROM orders
        JOIN order_details ON orders.id = order_details.order_id
        JOIN product ON product.id = order_details.product_id
        JOIN category ON category.id = product.category_id
        WHERE orders.id = :id;";

        $data["row"] = $order->query($query, ["id" => $id]);

        $addres_id = $order->first(["id" => $id]);
        $data["row_address"] = $address_class->where(["id" => $addres_id->shipping_address]);

        //[TODO] if order has user, that is registerd show that user on user details page and create a link to the user ->> for fun lol if you have time so not now

        //show($data["row"]);
        // $data["order"] = $order->first(["id" => $id], "desc", 1);
        // $data["address"] = $address_class->first(["id" => $data["order"]->shipping_address]);

        // $details = $order_details->where(["order_id" => $id]);
        // //get all products, that are in order 
        // foreach ($details as $detail) {
        //   //$detail->product = $product->first(["id" => $detail->id]);
        // }
        // show($details);
        // $data["details"] = $details;
      } else {
        $data["errors"]["id"] = "That order does not exist";
      }
    } else {
      $data["rows"] = $order->findAll('desc', $limit, $offset);
    }

    $this->view('admin/orders', $data);
  }

  public function slider($action = null)
  {

    if (!Auth::is_admin()) {
      redirect("login");
    }
    $data['title'] = "Slider";
    $slider = new Slider();

    $data["rows"] = [];
    $rows = $slider->findAll("asc");

    foreach ($rows as $key => $row) {
      $num = $row->id;
      $data["rows"][$num] = $row;
    }

    $id = $_POST["id"] ?? 0;
    $row = $slider->first(["id" => $id]);

    if ($action == "add") {
      //insert blank slide 
      $slider->insert(["image" => null, "title" => null, "description" => null, "disabled" => 1]);
      redirect("admin/slider");
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ($_POST["action"] == "remove") {
        $arr = [];
        if ($row = $slider->first(["id" => $_POST["id"]])) {
          if (file_exists($row->image)) {
            unlink($row->image);
          }
          $slider->delete($_POST["id"]);
          $arr["message"] = "Slider was deleted!";
        } else {
          $arr['message'] = "That slider does not exits!";
        }
        echo json_encode($arr);
        die;
      } else {
        //crate folder if not exits
        $folder = "uploads/images/slider/";
        if (!file_exists($folder)) {
          mkdir($folder, 0777, true);
          file_put_contents($folder . "index.php", "<?php lol");
        }

        //validate image
        $allowedExt = ["image/png", "image/jpeg"];
        if (!empty($_FILES["image"]["name"])) {
          if ($_FILES["image"]["error"] == 0) {
            if (in_array($_FILES["image"]["type"], $allowedExt)) {
              //good
              $destination = $folder . time() . $_FILES["image"]["name"];
              $_POST["image"] = $destination;
            } else {
              $slider->errors["image"] = "This file type is not allowed! Allowed typse are: " . join(",", $allowedExt);
            }
          } else {
            $slider->errors["image"] = "Could not upload the image.";
          }
        }

        if ($slider->validate($_POST, $id)) {

          if (!empty($destination)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $destination);

            resize($destination);
            if ($row && file_exists($row->image)) {
              unlink($row->image);
            }
          }

          if ($row) {
            unset($_POST['id']);
            $slider->update($id, $_POST);
          } else {
            $slider->insert($_POST);
          }
        }
        $arr = [];
        if (empty($slider->errors)) {
          $arr['message'] = "Slide saved successfully";
        } else {
          $arr['message'] = "Please correct these errors";
          $arr['id'] = $id;
          $arr['errors'] = $slider->errors;
        }

        echo json_encode($arr);
        die;
      }
    }

    $this->view("admin/slider", $data);
  }

  public function translations() {
      //TODO: add edit and remove languages
      $data['title'] = LanguageFactory::getLocalized("page.title.translations");

      $languageClass = new Lang();
      $translationsClass = new Translation();

      $langs = $languageClass->findAll();
      $data['languages']['fields'] = $languageClass->getFields();
      $data['languages']['data'] = $langs ?? [];
      $data['fields'] = $translationsClass->getFields();
      $data['translations'] = $translationsClass->findAll();

      $this->view("admin/translations", $data);
  }

  public function translationApi() {
      //TODO: filtering the translation table - will be fun :)
      $method = $_SERVER['REQUEST_METHOD'];
      $translationClass = new Translation();
      $data = json_decode(file_get_contents("php://input", true));

      if ($method == "POST") {
          // just update it hould be good;
          // validate the data --> for now just chekc if not empty
          $rowId = $data->rowId;
          $languageKey = $data->languageKey;
          $translation = $data->translation;

          if (!empty($rowId) && !empty($languageKey) && !empty($translation)) {
              $translationRow = $translationClass->first(["id" => $rowId]);
              if ($translationRow && in_array($languageKey, $translationClass->getFields()) && $translationRow->$languageKey != $translation) {
                  $check = $translationClass->query(
                      "UPDATE " . $translationClass->table . " SET `" . $languageKey . "`=:translation " . "WHERE id=:id",
                      ["translation" => $translation, "id" => $rowId]
                  );
                  if ($check) {
                    $this->respond(["message" => "Value saved successfully"], 200);
                  } else {
                      $this->respond(["error" => "Something went wrong"], 500);
                  }
              }
          } else {
              $this->respond(["error" => "Invalid parameters"], 400);
          }
      }
  }

  #[NoReturn] function respond(mixed $data, int $statusCode) {
      http_response_code($statusCode);
      echo json_encode($data);
      die;
  }
}
