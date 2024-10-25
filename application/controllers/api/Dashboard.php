<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Dashboard extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('dashboard_model');


    }

    public function getDashboard_post() {
        $getTokenData = $this->is_authorized();
		$usersData    = json_decode(json_encode($getTokenData), true);
		$user_type   =  $usersData['data']['user_type'];
		$users_id   =  $usersData['data']['id'];
		
		if($user_type =='merchant'){
			$merchant_id = $users_id;
		}else{
			$merchant_id = '';
		}
		$today = date('Y-m-d');
		$yesterday = date('Y-m-d',strtotime("-1 days"));
		$thismonth = date('Y-m');
		
		$filterData = json_decode($this->input->raw_input_stream, true);
		if(isset($filterData['currency']) && !empty($filterData['currency'])){
			$currency = $filterData['currency'];
		}else{
			$currency = '';
		}
        $final = array();
        $final['status'] = true;
        $final['todayTransactions'] = $this->dashboard_model->todayTransactions($today,$merchant_id,$currency);  
        $final['yesterdayTransactions'] = $this->dashboard_model->todayTransactions($yesterday,$merchant_id,$currency);  
        $final['monthTransactions'] = $this->dashboard_model->monthTransactions($thismonth,$merchant_id,$currency);  
        $final['totalTransactions'] = $this->dashboard_model->totalTransactions($merchant_id,$currency);  
        $final['recentTransactions'] = $this->dashboard_model->recentTransactions($merchant_id,$filterData);  
        $final['transactionStatus'] = $this->dashboard_model->transactionStatus($merchant_id,$filterData);  
        $final['message'] = 'Dashboard Data fetched successfully.';
        $this->response($final, REST_Controller::HTTP_OK);
    }
	public function getTransactionCurrency_get(){
		$getTokenData = $this->is_authorized();
		$usersData    = json_decode(json_encode($getTokenData), true);
		$user_type   =  $usersData['data']['user_type'];
		$users_id   =  $usersData['data']['users_id'];
		
		if($user_type =='merchant'){
			$merchant_id = $users_id;
		}else{
			$merchant_id = '';
		}
		$final = array();
		$final['status'] = true;
		$final['data'] = $this->dashboard_model->transactionCurrency($merchant_id);
		$final['message'] = 'Transaction currency data fetched successfully.';
		$this->response($final, REST_Controller::HTTP_OK); 
	}
	
    
 }

