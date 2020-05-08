<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// namespace Sample;
require __DIR__ . '/vendor/autoload.php';
//1. Import the PayPal SDK client that was created in `Set up Server-Side SDK`.
use Sample\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

class GetOrder
{

var $orders;
// private $order_id = $orders[0];
public function __construct($orders)
{
    $this->getOrder($orders[0],$orders[1]);
} 


   // 2. Set up your server to receive a call from the client
  /**
   *You can use this function to retrieve an order by passing order ID as an argument.
   */
  public static function getOrder($orderId,$pattern)
  {
    // 3. Call PayPal to get the transaction details
    $client = PayPalClient::client();
    $response = $client->execute(new OrdersGetRequest($orderId));
    
    $CI =   &get_instance();
    $data_a = json_encode($response->result, JSON_PRETTY_PRINT);
    $data = json_decode($data_a, true);
    if ($data) 
    {
        if ($data['status'] == 'COMPLETED') 
        {
            $order_status = $data['status'];
            $amount = $data['purchase_units'][0]['amount']['value'];
            $tracking_id = $data['id'];
            $bank_ref_no = $data['purchase_units'][0]['payments']['captures'][0]['id'];
            $failure_message = '';
            $payment_mode = 'Online';
            $card_name = '';
            $status_code = $data['purchase_units'][0]['payments']['captures'][0]['final_capture'];
            $status_message = $data['purchase_units'][0]['payments']['captures'][0]['status'];
            $paypal_gross_amount = $data['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['gross_amount']['currency_code'].' '.$data['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['gross_amount']['value'];
            $paypal_paypal_fee = $data['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['currency_code'].' '.$data['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['paypal_fee']['value'];
            $paypal_net_amount = $data['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['currency_code'].' '.$data['purchase_units'][0]['payments']['captures'][0]['seller_receivable_breakdown']['net_amount']['value'];
            $currency = $data['purchase_units'][0]['amount']['currency_code'];
            $billing_name = $data['purchase_units'][0]['shipping']['name']['full_name'];
            $billing_address = $data['purchase_units'][0]['shipping']['address']['address_line_1'];
            $billing_city = $data['purchase_units'][0]['shipping']['address']['admin_area_2'];
            $billing_state = $data['purchase_units'][0]['shipping']['address']['admin_area_1'];
            $billing_zip = $data['purchase_units'][0]['shipping']['address']['postal_code'];
            $billing_country = $data['purchase_units'][0]['shipping']['address']['country_code'];
            $billing_email = $data['payer']['email_address'];
            $billing_tel = '';
            $delivery_name = '';
            $delivery_address = '';
            
            $trans_date = $data['purchase_units'][0]['payments']['captures'][0]['create_time'];
            
            /*

                script you want to done with transactions

            */

            echo 1;
        }
        else
        {
            echo 0;//json_encode(array("status"=>'false'));  
        }
    }
    else
    {
        echo 0;//json_encode(array("status"=>'false'));    
    }
  }
}

/**
 *This driver function invokes the getOrder function to retrieve
 *sample order details.
 *
 *To get the correct order ID, this sample uses createOrder to create a new order
 *and then uses the newly-created order ID with GetOrder.
 */
if (!count(debug_backtrace()))
{
  GetOrder::getOrder($orders[0], true);
}
?>