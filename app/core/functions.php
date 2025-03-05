<?php

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

if (!defined("ROOT")) die("direct script access denied");


$PATH = "";
function setPath(string $path): void {
    global $PATH;
    $PATH = $path;
}

function getPath(): string {
    global $PATH;
    return $PATH;
}

function set_value($key, $default = '')
{
  if (!empty($_POST[$key])) {
    return $_POST[$key];
  } else if (!empty($default)) {
    return $default;
  }

  return null;
}

function get_date($date)
{
  return date("jS M, Y H:m:s a", strtotime($date));
}

function set_select($key, $value, $default = '')
{
  if (!empty($_POST[$key])) {
    if ($value == $_POST[$key])
      return ' selected ';
  } else if (!empty($default)) {
    if ($value == $default)
      return ' selected ';
  }

  return '';
}

function set_checked($key, $value, $default = '')
{
  if (!empty($_POST[$key])) {
    if ($value == $_POST[$key])
      return ' checked ';
  } else if (!empty($default)) {
    if ($value == $default)
      return ' checked ';
  }

  return '';
}


function user_can(string $permission): bool
{
  $role = Auth::getRole();

  if (Auth::is_admin()) {
    return true;
  }

  $permission = strtolower($permission);

  if (Auth::logged_in()) {
    $query = "SELECT permission FROM permissions_map WHERE disabled = 0 AND role_id = :role";

    $myroles = (new Database())->query($query, ['role' => $role]);

    if ($myroles) {
      $myroles = array_column($myroles, 'permission');
    } else {
      $myroles = [];
    }

    if (in_array($permission, $myroles)) {
      return true;
    }
  }

  return false;
}


function show($stuff)
{
  echo "<pre style='z-index: 9999999'>";
  print_r($stuff);
  echo "</pre>";
}

function dd($stuff) {
    echo "<pre style='z-index: 9999999'>";
    print_r($stuff);
    echo "</pre>";
    die;
}

function redirect($link)
{
  header("Location: " . getPath() . "/" . $link);
  die;
}

function message($msg = "", $erase = false)
{
  if (!empty($msg)) {
    $_SESSION['message'] = $msg;
  } else {
    if (!empty($_SESSION['message'])) {
      $msg = $_SESSION['message'];

      if ($erase) {
        unset($_SESSION['message']);
      }
      return $msg;
    }
  }
  return false;
}

function alert($msg = "",  $erase = false, $goodAlert = true)
{
    if (!empty($msg)) {
        $_SESSION['message']['message'] = $msg;
        $_SESSION['message']['class'] = $goodAlert ? "alert" : "alert-danger";
    } else {
        if (!empty($_SESSION['message'])) {
            $msg = $_SESSION['message'];

            if ($erase) {
                unset($_SESSION['message']);
            }
            return $msg;
        }
    }
    return false;
}

function esc($str)
{
    if(!empty($str))
        return nl2br(htmlspecialchars($str));

}

function csrf()
{
  $code = md5(time());
  $_SESSION['csrf_code'] = $code;
  echo "<input class='js-csrf_code' name='csrf_code' type='hidden' value='$code' />";
}

function str_to_url($url)
{
  $alias = mb_strtolower($url);

  // Odstranění mezer na začátku a na konci
  $alias = trim($alias);

  $diakritika = array(
    "á" => "a",
    "č" => "c",
    "ď" => "d",
    "é" => "e",
    "ě" => "e",
    "í" => "i",
    "ň" => "n",
    "ř" => "r",
    "š" => "s",
    "ť" => "t",
    "ú" => "u",
    "ů" => "u",
    "ý" => "y",
    "ž" => "z",
    " " => "-",
  );

  foreach ($diakritika as $znak => $nahrada) {
    $alias = str_replace($znak, $nahrada, $alias);
  }

  return
    strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $alias)));;
}

function resize($filename, $max_size = 700)
{

  /** check what kind of file type it is **/
  $type = mime_content_type($filename);

  if (file_exists($filename)) {
    switch ($type) {

      case 'image/png':
        $image = imagecreatefrompng($filename);
        break;

      case 'image/gif':
        $image = imagecreatefromgif($filename);
        break;

      case 'image/jpeg':
        $image = imagecreatefromjpeg($filename);
        break;

      case 'image/webp':
        $image = imagecreatefromwebp($filename);
        break;

      default:
        return $filename;
        break;
    }

    $src_w = imagesx($image);
    $src_h = imagesy($image);

    if ($src_w > $src_h) {
      //reduce max size if image is smaller
      if ($src_w < $max_size) {
        $max_size = $src_w;
      }

      $dst_w = $max_size;
      $dst_h = ($src_h / $src_w) * $max_size;
    } else {

      //reduce max size if image is smaller
      if ($src_h < $max_size) {
        $max_size = $src_h;
      }

      $dst_w = ($src_w / $src_h) * $max_size;
      $dst_h = $max_size;
    }

    $dst_w = round($dst_w);
    $dst_h = round($dst_h);

    $dst_image = imagecreatetruecolor($dst_w, $dst_h);

    if ($type == 'image/png') {

      imagealphablending($dst_image, false);
      imagesavealpha($dst_image, true);
    }

    imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);

    imagedestroy($image);

    switch ($type) {

      case 'image/png':
        imagepng($dst_image, $filename, 8);
        break;

      case 'image/gif':
        imagegif($dst_image, $filename);
        break;

      case 'image/jpeg':
        imagejpeg($dst_image, $filename, 90);
        break;

      case 'image/webp':
        imagewebp($dst_image, $filename, 90);
        break;

      default:
        imagejpeg($dst_image, $filename, 90);
        break;
    }

    imagedestroy($dst_image);
  }

  return $filename;
}


function get_image($file)
{
  return $file ? ROOT . "/" . $file : ROOT . "/assets/images/no_image.jpg";
}

function stripe_checkout($data)
{
    $path = trim(__DIR__,  'core');

  require $path . '/models/stripe-php-master/init.php';

  $stripe = new \Stripe\StripeClient('sk_test_51MNHa1A502N0UNRDM07VRHpBcldAe6ZgkB7M6pZTspRttPjiHGCIijXKqDAyBELl9JXuqAjJ2KWVTztIjxgrSEum005iftiS9L');

  $checkout_session = $stripe->checkout->sessions->create([
    'line_items' => [[
      'price_data' => [
        'currency' => 'czk',
        'product_data' => [
          'name' => 'Objednávka#' . $data["order_id"],
          'description' => 'Toto je popisek objednávky',
        ],
        'unit_amount_decimal' =>  round(floatval($data["amount"]) * 100, 2),
      ],
      'quantity' => 1,
    ]],
    'mode' => 'payment',
    'customer_email' => $data["email"],
    'metadata' => [
      'order_id' => $data["order_id"],
    ],
    'success_url' => ROOT . '/thanks',
    'cancel_url' =>  ROOT . '/cancel',
  ]);

  header("HTTP/1.1 303 See Other");
  header("Location: " . $checkout_session->url);
}

function paypal_checkout($arr)
{
  require '/var/www/localhost/web/app/models/paypal-php-sdk/autoload.php';
  $api = new ApiContext(
    new OAuthTokenCredential(
      'AZlqDcnt6LZ8bPOfwSHtsbKYuXwpcAhXw3EwHKLE9lI4jY4p3_jiSDhsBQiMP4_SQiTKSKBIOf1KPsnH',
      'ELVYn3Irc8As6CuevevUjbR4kl0We1TEzrkPIUtSktRflYSctsT-ePb9J0DUKOGTQAj7L7NeCy769YMa'
    )
  );

  $api->setConfig([
    'mode' => 'sandbox',
    'http.ConnectionTimeOut' => 30,
    'log.LogEnabled' => false,
    'log.FileName' => '',
    'log.LogLevel' => 'FINE',
    'validation.level' => 'log'
  ]);

  $payer = new Payer();
  $details = new Details();
  $amount = new Amount();
  $transaction = new Transaction();
  $payment = new Payment();
  $redirectUrls = new RedirectUrls();

  $payer->setPaymentMethod('paypal');

  $details->setShipping('0.00')->setTax('0.00')->setSubtotal(round(floatval($arr["amount"]), 2));

  $amount->setCurrency('CZK')->setTotal(round(floatval($arr["amount"]), 2))->setDetails($details);

  $transaction->setAmount($amount)->setDescription('Objednávka#' . $arr["order_id"]);

  $payment->setIntent('sale')->setPayer($payer)->setTransactions([$transaction]);

  $redirectUrls->setReturnUrl(ROOT . '/thanks?success=true')->setCancelUrl(ROOT . '/cancel');

  $payment->setRedirectUrls($redirectUrls);

  try {
    //code...
    $payment->create($api);
    $_SESSION['paypal_order_id'] = $arr["order_id"];
  } catch (Exception $e) {
    show($e);
    die;
  }

  foreach ($payment->getLinks() as $link) {
    if ($link->getRel() == 'approval_url') {
      $redirectUrl = $link->getHref();
    }
  }

  header('Location: ' . $redirectUrl);
  die;
}

function getRandomString($length = 32)
{
  return bin2hex(random_bytes($length / 2));
}

function display_under_comment($comment, $deep = 1) {
    $under_comments = $comment->under_comment ?? '';

    $comments = '';

    if(!empty($under_comments) && is_array($under_comments)) {
        foreach ($under_comments as $under_comment) {
            $under_comment = (new Comment())->calc_date($under_comment);
            $path = get_image($under_comment->image);

            $width = 100 - 3 * $deep;

            if($under_comment->is_mine) {
                $actions = " 
                    <div class='actions'>                                   
                            <div class='edit-delete'>
                                <span onclick='comments.editComment($under_comment->id)'><i class='bx bx-edit-alt'></i></span>
                                <span onclick='comments.deleteComment($under_comment->id)'><i class='bx bx-message-alt-x' ></i></span>
                            </div>
                    
                        <div class='replay-to'><span onclick='comments.collectData(event, $under_comment->product_id, $under_comment->id)' ><br> <i class='bx bx-share'></i></span></div>
                    </div>";
            } else {
                $actions = "
                    <div class='actions'>                                   
                        <div class='replay-to'><span onclick='comments.collectData(event, $under_comment->product_id, $under_comment->id)' ><br> <i class='bx bx-share'></i></span></div>
                    </div>
                ";
            }


            $comments .= "<div class='comment' data-id='$under_comment->id' style='width: ". $width ."%'>
                  <div class='header'>
                      <div class='img-holder'>
                          <img src='$path' alt=''>
                      </div>
                      <div class='user-details'>
                          <p>" . ucfirst(esc($under_comment->firstname)) . " " . ucfirst(esc($under_comment->lastname)) . "</p>
                          <span>$under_comment->diff_date</span>
                      </div>
                        ". $actions ."
                  </div>
                  <div class='content'>
                      <p>" . esc($under_comment->content) . "</p>
                  </div>
              </div>";

            $comments .= display_under_comment($under_comment, $deep + 1);
        }

    }

    return $comments;
}
