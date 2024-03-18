<?php

if (!defined("ROOT")) die("direct script access denied");

class SignupController extends Controller
{

  public function index()
  {
    if (Auth::logged_in()) redirect("home");
    $data['title'] = "Zaregistrovat se";
    $data['errors'] = [];
    $user = new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      if ($user->validate($_POST)) {

        if (isset($_POST["g-token"])) {

          //first validate the google token
          $secretKey = "6LdYCzskAAAAABqIDcwNod2CQ123U-Ejv3aF53nt";
          $token = $_POST["g-token"];
          $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $token . "&remoteip=" . $_SERVER["REMOTE_ADDR"];

          $request = file_get_contents($url);
          $response = json_decode($request);

          if (true || $response->success) {
            $_POST['date'] = date("Y-m-d");
            $_POST['role_id'] = 1;
            $_POST['banned'] = 0;
            $_POST['image'] = "";
            $_POST['gender'] = "";
            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $_POST['token'] = getRandomString(60);
            $_POST['status'] = 0;

            $user->insert($_POST);

            $to = $_POST["email"];
            $subject = "Ověření emailu";

            $message = "
              <html>
              <head>
              <title>Ověření emailu</title>
              </head>
              <body>
              <p>Važený zákazníku,</p>
              <p>děkujeme za Vaši zaregistraci. Prosím ověřte svůj email pomocí odkazu</p>
              <p>Klikněte <a href='" . ROOT . "/verify/" . $_POST['token'] . "'>zde</a></p>
              </body>
              </html>
              ";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: ' . MYEMAIL . "\r\n";

            if($_SERVER['SERVER_NAME'] == 'localhost') {
                $emailClass = new Mail();
                if($emailClass->send_mail($to, $subject, $message, $headers)) {
                    message("Prosím oveřte svůj email a poté se přihlaste.");
                    redirect("login");
                } else {
                    $data['errors']['terms'] = "Něco se pokazilo";
                }
            } else {
                if (mail($to, $subject, $message, $headers)) {
                    message("Prosím oveřte svůj email a poté se přihlaste.");
                    redirect("login");
                } else {
                    $data['errors']['terms'] = "Něco se pokazilo";
                }
            }
          } else {
            $data['errors']['terms'] = "Něco se pokazilo";
          }
        } else {
          $data['errors']['terms'] = "Token je požadován!";
        }
      }
    }

    $data['errors'] = $user->errors;
    $this->view("signup", $data);
  }
}
