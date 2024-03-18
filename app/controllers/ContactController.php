<?php

if (!defined("ROOT")) die("direct script access denied");

class ContactController extends Controller
{

  public function index()
  {
    $data['title'] = "Kontaktujte nás";

    $about = new About();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ($about->validate($_POST)) {
        if (!empty($_POST["g-token"])) {
          //first validate the google token
          $secretKey = "6LdYCzskAAAAABqIDcwNod2CQ123U-Ejv3aF53nt";
          $token = $_POST["g-token"];
          $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $token . "&remoteip=" . $_SERVER["REMOTE_ADDR"];

          $request = file_get_contents($url);
          $response = json_decode($request);

          if ($response->success) {
            $to = MYEMAIL;
            $subject = "Get in touch";
            $message = $_POST["description"];
            // $headers = "From: " . $_POST["email"] . "\r\n" .
            //   "Reply-To:" . $_POST["email"] . "\r\n";
            $headers = 'Content-Type: text/plain; charset=utf-8' . "\r\n";
            $headers .= 'From: ' . $_POST["email"];

            if (mail($to, $subject, $message, $headers)) {
              message("Váš email se poslal.");
              redirect("contact");
            } else {
              message("Něco se pokazilo.");
              redirect("contact");
            }
          } else {
            $data["errors"]["description"] = "Něco se pokazilo!";
          }
        } else {
          $data["errors"]["description"] = "Token je požadován!";
        }
      }
      $data["errors"] = $about->errors;
    }

    $this->view("contact", $data);
  }
}
