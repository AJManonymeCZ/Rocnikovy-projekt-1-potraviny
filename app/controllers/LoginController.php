<?php

if (!defined("ROOT")) die("direct script access denied");

class LoginController extends Controller
{

  public function index()
  {
    if (Auth::logged_in()) redirect("home");

    $data['title'] = "Přihlásit se";
    $data['errors'] = [];
    $user = new User();
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

      // validate 
      $row = $user->first(["email" => $_POST['email']]);

      if ($row && !$row->banned) {
        if ($row->status == 1) {
          if (password_verify($_POST['password'], $row->password)) {
            //authenticate
            Auth::authenticate($row);
            redirect("home");
          } else {
            $data['errors']['email'] = "Špatný email nebo heslo";
          }
        } else {
          $data['errors']['email'] = "Email není ověřen.";
        }
      } else if ($row && $row->banned) {
        $data['errors']['email'] = "Byl jste zabanován. Pokud jsi myslíte, že jste dostal ban neprávem, kontaktujte nás!";
      } else {
        $data['errors']['email'] = "Špatný email nebo heslo";
      }
    }

    $this->view("login", $data);
  }

  public function forgot()
  {
    if (Auth::logged_in()) redirect("home");

    $data['title'] = "Forgot";
    $errors = [];
    $mode = "enter_email";

    $user = new User();
    $codes = new Codes();

    if (isset($_GET['mode'])) {
      $mode = $_GET['mode'];
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      switch ($mode) {
        case 'enter_email':
          $email = $_POST["email"];
          //validate email
          if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Tento email není validní";
          } else if ($result = $user->where(['email' => $_POST['email']], 'desc', 1)) {
            //user is registred 
            $user_id = $result[0]->id;

            $_SESSION['forgot']['email'] = $email;

            if (!empty($user_id)) {
              $arr = [];
              $arr['expire'] = time() + (60 * 1);
              $arr['code'] = $code = rand(10000, 99999);
              $arr['email'] = addslashes($email);
              $arr['users_id'] = $user_id;

              $codes->insert($arr);

              $headers = 'Content-Type: text/plain; charset=utf-8' . "\r\n";

              //send email to user
                if($_SERVER['SERVER_NAME'] == 'localhost') {
                    $emailClass = new Mail();
                    $sended = $emailClass->send_mail($email, "Reset Password","Váš kod je: " . $code, $headers);

                    if(!$sended) {
                        var_dump("WRONG");
                        die;
                    }

                } else {
                    mail($email, 'Resetování hesla', "Váš kod je: " . $code, $headers);
                }
            }
          } else {
            $errors['email'] = "Tento emial nebyl nalezen!";
          }

          if (empty($errors)) {
            redirect('login/forgot?mode=enter_code');
            die;
          }
          break;
        case 'enter_code':
          $arr = [];
          $expire = time();
          $code = $_POST['code'];
          $email = addslashes($_SESSION['forgot']['email']);

          if ($result = $codes->where(["code" => $code, "email" => $email], 'desc', 1)) {
            if ($result[0]->expire > $expire) {
              $_SESSION['forgot']['code'] = $code;
              redirect('login/forgot?mode=enter_password');
              die;
            } else {
              $errors['code'] = "Kód vypršel, začněte znovu";
            }
          } else {
            $errors['code'] = "Kód je špatně";
          }
          break;
        case 'enter_password':

          $password = $_POST['password'];
          $retype_password = $_POST['retype_password'];

          if ($password != $retype_password) {
            $errors['password'] = "Passwords do not match";
          } else if (!isset($_SESSION['forgot']["email"]) || !isset($_SESSION['forgot']["code"])) {
            redirect('login/forgot');
          } else {
            $arr = [];
            $arr["email"] = addslashes($_SESSION['forgot']['email']);
            $arr["password"] = password_hash($password, PASSWORD_DEFAULT);

            $query = "UPDATE users SET password = :password WHERE email = :email LIMIT 1";
            $user->query($query, $arr);

            if (isset($_SESSION['forgot'])) {
              unset($_SESSION['forgot']);
            }

            message('Vaše heslo bylo změněno.');

            redirect('login');
            die;
          }

          break;

        default:
          # code...
          break;
      }
    }

    $data['mode'] = $mode;
    $data['errors'] = $errors;

    $this->view('forgot', $data);
  }
}
