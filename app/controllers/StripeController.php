<?php

if (!defined("ROOT")) die("direct script access denied");

class StripeController extends Controller
{

  public function index()
  {
    $order = new Order();

    // webhook.php
    //
    // Use this sample code to handle webhook events in your integration.
    //
    // 1) Paste this code into a new file (webhook.php)
    //
    // 2) Install dependencies
    //   composer require stripe/stripe-php
    //
    // 3) Run the server on http://localhost:4242
    //   php -S localhost:4242
    require '../app/models/stripe-php-master/init.php';

    $endpoint_secret = 'whsec_e8VkG5Sh3mPqYhFwSiFoESoMcaajvcSD';

    $payload = @file_get_contents('php://input');
    $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
    $event = null;

    try {
      $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        $endpoint_secret
      );
    } catch (\UnexpectedValueException $e) {
      // Invalid payload
      http_response_code(400);
      exit();
    } catch (\Stripe\Exception\SignatureVerificationException $e) {
      // Invalid signature
      http_response_code(400);
      exit();
    }

    // Handle the event
    switch ($event->type) {
      case 'checkout.session.async_payment_failed':
        $session = $event->data->object;
      case 'checkout.session.async_payment_succeeded':
        $session = $event->data->object;
      case 'checkout.session.completed':
        $session = $event->data->object;
        //update paid status 
        $order_id = $session->metadata->order_id;

        $order->update($order_id, ["paid" => 1, "raw" => $payload]);


      case 'checkout.session.expired':
        $session = $event->data->object;
        // ... handle other event types
      default:
        echo 'Received unknown event type ' . $event->type;
    }

    http_response_code(200);
  }
}
