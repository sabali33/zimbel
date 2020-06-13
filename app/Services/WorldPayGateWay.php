<?php
namespace App\Services;

use Worldpay;
use WorldpayException;

class WorldPayGateWay
{
    public function __construct()
    {
        $this->worldpay = new Worldpay\Worldpay('T_S_6fe5ea35-d0be-4c68-9610-913bb033c254');
    }
    public function charge($data)
    {
        try {
            $response = $this->worldpay->createOrder(array(
                'token' => $data['token'],
                'amount' => round( $data['amount']),
                'currencyCode' => 'USD',
                'name' => $data['name'],
                //'billingAddress' => $data['billing_address'],
                'orderDescription' => $data['description'],
                'customerOrderCode' => $data['order_code']
            ));
            if ($response['paymentStatus'] === 'SUCCESS') {
                $worldpayOrderCode = $response['orderCode'];
            } else {
                throw new WorldpayException(print_r($response, true));
            }
        } catch (WorldpayException $e) {
            echo 'Error code: ' .$e->getCustomCode() .'
            HTTP status code:' . $e->getHttpStatusCode() . '
            Error description: ' . $e->getDescription()  . '
            Error message: ' . $e->getMessage();
        } catch (Exception $e) {
            echo 'Error message: '. $e->getMessage();
        }
        return $worldpayOrderCode;
    }
    public function refund(Payment $payment)
    {
        $order_code = $payment->order_code;
        $response = '';
        try {
            // Refund the order using the Worldpay order code
            $response = $worldpay->refundOrder($order_code);
            $response = json_decode($response, true);
            //$response = 'Payment <span id="order-code">'.$worldpayOrderCode.'</span> has been refunded!';
        } catch (WorldpayException $e) {
            // Worldpay has thrown an exception
            $response = $e;
        }
        return $response;
    }
}