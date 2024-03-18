<?php

use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

if (!defined("ROOT")) die("direct script access denied");
require '../app/models/paypal-php-sdk/autoload.php';

class ThanksController extends Controller
{

  public function index()
  {
    $data["title"] = "Děkuji";
    $order = new Order();
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

    if (isset($_GET["success"]) && $_GET["success"] == "true" && isset($_SESSION['paypal_order_id'])) {
      $payerId = $_GET["PayerID"];

      $payment = Payment::get($_GET["paymentId"], $api);

      $execution = new PaymentExecution();
      $execution->setPayerId($payerId);

      $payment->execute($execution, $api);

      $order->update($_SESSION['paypal_order_id'], ["paid" => 1]);

      unset($_SESSION['paypal_order_id']);
    }

    $this->view("thanks", $data);
  }
}
