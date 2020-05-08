<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function paypal()
    {
        // $data1 = json_decode(file_get_contents('php://input'),true);
        $this->data['order'] =  rand(10000,4);//$_POST['pattern'];//'1-10-year-0-0';
        $this->data['amount'] =  100;
        $this->data['currency'] =  'USD';//$_POST['currency'];
        // $this->load->library('PayPalCheckoutSdk/PayPalClient');
        $this->load->view('paypal/index',$this->data);
    }

    public function paypal_order()
    {
        $data = json_decode(file_get_contents('php://input'),true);
        // echo $data['orderID'];
        $oderid = array($data['orderID'],$data['pattern']);
        $this->load->library('GetOrder',$oderid);
    }
}
