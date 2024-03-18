<?php

if (!defined("ROOT")) die("direct script access denied");

class EditprofileController extends Controller
{

  public function index()
  {
    // check if user is logged in 
    if (!Auth::logged_in()) {
      message("Please login to edit your profile!");
      redirect("login");
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $user = new User();
      $addressClass = new Address();
      $userAddress = new UserAddress();

      $row = $user->first(["id" => Auth::getId()]);
      // create folder if not exists 
      $folder = "uploads/images/";
      if (!file_exists($folder)) {
        mkdir($folder, 0777, true);
        file_put_contents($folder . "index.php", "<?php lol");
        file_put_contents("uploads/index.php", "<?php lol");
      }

      //validate image
      $allowedImagesExt = ["image/jpeg", "image/png"];
      $allowed = ["jpeg", "png"];
      $image_errors = [];

      if (!empty($_FILES["image"]["name"])) {
        if ($_FILES["image"]["error"] == 0) {
          if (in_array($_FILES["image"]["type"], $allowedImagesExt)) {
            //OK
            $destination = $folder . time() . $_FILES["image"]["name"];
            $_POST["image"] = $destination;
          } else {
            $image_errors["image"] = "Povoleny jsou: " . implode(" a ", $allowed) . " obrázky";
          }
        } else {
          $image_errors["image"] = "Obrázek se nepodařilo nahrát.";
        }
      }

      if ($user->user_validate($_POST, $row->id)) {
        // echo json_encode(var_dump($_POST["gender"]));
        // die;
        if (!empty($destination)) {
          move_uploaded_file($_FILES["image"]["tmp_name"], $destination);

          resize($destination);

          if ($row && file_exists($row->image)) {
            unlink($row->image);
          }
        }

        if ($addressClass->validate($_POST)) {
          if ($add = $userAddress->first(["users_id" => $row->id])) {
            //update user address 
            $addressClass->update($add->address_id, $_POST);
          } else {
            //insert new user address
            $last_id = $addressClass->insert($_POST, true);
            $userAddress->insert(["users_id" => $row->id, "address_id" => $last_id]);
          }
        }
      }

      if (empty($_POST["password"])) {
        unset($_POST["password"]);
      } else {
        if ($_POST["password"] == $_POST["retype_password"]) {
          $_POST["password"] = password_hash($_POST["password"], PASSWORD_DEFAULT);
        } else {
          $user->errors["password"] = "Hesla se nechodují";
        }
      }

      $errors = array_merge($user->errors, $addressClass->errors, $image_errors);
      $arr = [];

      if (empty($errors)) {

        $user->update($row->id, $_POST);
        $row2 = $user->first(["id" => $row->id]);

        $_SESSION['user'] = $row2;

        $arr["message"] = "Váš profil se uložil!";
      } else {
        $arr["message"] = "Prosím opravte chyby";
        $arr["errors"] = $errors;
      }

      echo json_encode($arr);
      die;
    }
  }
}
