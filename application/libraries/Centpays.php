<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Centpays{
	protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
        // Load the model in the library constructor
        $this->CI->load->model('v2_model');
		$this->CI->load->library('encrypt');
    }
    public function payment($paymentGatewayId,$payment_encrypt_key,$token) {
		
		$payment 	= $this->CI->v2_model->getPaymentGateway($paymentGatewayId,$payment_encrypt_key);
		if($payment->num_rows()>0){
			
			$merchantData = $this->CI->v2_model->validateToken($token); 
			if($merchantData->num_rows()>0){
				$merchant_id    = $merchantData->row()->merchant_id;
				$amount     	= $merchantData->row()->amount;
				$cardnumber     = $merchantData->row()->cardnumber;
				$cardcvv        = $merchantData->row()->cardcvv;
				$cardnumber     = $this->CI->encrypt->decode($cardnumber);
				$cardcvv        = $this->CI->encrypt->decode($cardcvv);
				
				$liveApi_key    = $payment->row()->live_api;
				$live_secret    = $payment->row()->live_secret;
				$live_url 	    = $payment->row()->live_url;
				$payment_charge = $payment->row()->transaction_charge;
				
				$merchant_transaction_charge = $this->CI->Common->get_col_by_key('users','users_id',$merchant_id,'merchant_pay_in_charge');
				$merchant_fee =  $amount*$merchant_transaction_charge/100;
				$fee =  $amount*$payment_charge/100;
				$netAmt = $amount-$merchant_fee;
				$updateData = [
					'amount'		=>$netAmt,
					'fee'			=>$fee,
					'merchant_fee'	=>$merchant_fee,
					'payment_id'	=>$paymentGatewayId,
				];
				$this->CI->v2_model->update($updateData,$token);
				$expiryyear = substr($merchantData->row()->expiryyear, 0, 2);
				$cardExpire = $expiryyear.$merchantData->row()->expirymonth;
				
				$postData = [
                        'name'		=>$merchantData->row()->firstname.' '.$merchantData->row()->lastname, 
                        'email'		=>$merchantData->row()->email, 
                        'phone'		=>$merchantData->row()->phone, 
                        'amount'	=>$amount, 
                        'currency'	=>$merchantData->row()->currency, 
                        'transaction_id'=>$token, 
                        'order_number'=>$token, 
                        'back_url'	=>'https://localhost/cp/api/v2/merchant_callback/'.$payment_encrypt_key,
            			'requestMode'=>$merchantData->row()->requestMode,
            			'cardNo'	=>$cardnumber,
						'cardCVC'	=>$cardcvv,
            			'cardExpire'=>$cardExpire
                    ];
					
					$post_data = json_encode($postData);
					
                    $url = $live_url; 
                    $header_data = [
                    'api-key: '.$liveApi_key.'',
                    'api-secret: '.$live_secret.'',
                    'Content-Type: application/json',
                      ];
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS,$post_data);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_HTTPHEADER,$header_data);
                    $response = curl_exec($curl);
                    curl_close($curl);
					return $response;
			}else{
				return false;
			}
		}else{
			return false;
		}
    }
}
