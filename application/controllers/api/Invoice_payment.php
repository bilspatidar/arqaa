<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Invoice_payment extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('invoice_payment_model');
        $this->load->helper('security');
    }

    public function invoice_payment_list_post($id='') {
        $getTokenData = $this->is_authorized('superadmin');
        $filterData = json_decode($this->input->raw_input_stream, true);
        $final = array();
        $final['status'] = true;
        $final['data'] = $this->invoice_payment_model->get($id,$filterData);
        $final['message'] = 'Invoice payment fetched successfully.';
        $this->response($final, REST_Controller::HTTP_OK);
    }

    public function invoice_payment_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('invoice_id', 'invoice_id', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('cash_amount', 'cash_amount', 'trim|numeric');
            $this->form_validation->set_rules('wallet_amount', 'Wallet amount', 'trim|numeric');
            $this->form_validation->set_rules('payment_mode_id', 'Payment mode', 'trim|numeric');

            // ... (any additional validation rules)

            if ($this->form_validation->run() === false) {
                $array_error = array_map(function ($val) {
                    return str_replace(array("\r", "\n"), '', strip_tags($val));
                }, array_filter(explode(".", trim(strip_tags(validation_errors())))));

                $this->response([
                    'status' => FALSE,
                    'message' =>'Error in submit form',
                    'errors' =>$array_error
                ], REST_Controller::HTTP_BAD_REQUEST,'','error');
            } else {
                // set variables from the form
                $title = $this->input->post('title',TRUE);
                if (!empty($title)) {
                    $data['title'] = $title;
                }
				$amount = $this->input->post('amount',TRUE);
                if (!empty($amount)) {
                    $data['amount'] = $amount;
                }
				$invoice_id = $this->input->post('invoice_id',TRUE);
                if (!empty($invoice_id)) {
                    $data['invoice_id'] = $invoice_id;
                }
				$cash_amount = $this->input->post('cash_amount',TRUE);
                if (!empty($cash_amount)) {
                    $data['cash_amount'] = $cash_amount;
                }
				$wallet_amount = $this->input->post('wallet_amount',TRUE);
                if (!empty($wallet_amount)) {
                    $data['wallet_amount'] = $wallet_amount;
                }
				$notes = $this->input->post('notes',TRUE);
                if (!empty($notes)) {
                    $data['notes'] = $notes;
                }
				$payment_mode_id = $this->input->post('payment_mode_id',TRUE);
                if (!empty($payment_mode_id)) {
                    $data['payment_mode_id'] = $payment_mode_id;
                }
				
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;
				$res = $this->invoice_payment_model->create($data);
				
                if ($res) {

                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->invoice_payment_model->get($res);
                    $final['message'] = 'Invoice Payment created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                   
                    $this->response([ 'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }
     
        if ($params == 'update') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
        
            // set validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
            $this->form_validation->set_rules('invoice_id', 'invoice_id', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('cash_amount', 'cash_amount', 'trim|numeric');
            $this->form_validation->set_rules('wallet_amount', 'Wallet amount', 'trim|numeric');
            $this->form_validation->set_rules('payment_mode_id', 'Payment mode', 'trim|numeric');
            
            if ($this->form_validation->run() === false) {
                $array_error = array_map(function ($val) {
                    return str_replace(array("\r", "\n"), '', strip_tags($val));
                }, array_filter(explode(".", trim(strip_tags(validation_errors())))));
        
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error in submit form',
                    'errors' => $array_error
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            } else {
                // set variables from the form
                
				$title = $this->input->post('title',TRUE);
                if (!empty($title)) {
                    $data['title'] = $title;
                }
				$amount = $this->input->post('amount',TRUE);
                if (!empty($amount)) {
                    $data['amount'] = $amount;
                }
				$invoice_id = $this->input->post('invoice_id',TRUE);
                if (!empty($invoice_id)) {
                    $data['invoice_id'] = $invoice_id;
                }
				$cash_amount = $this->input->post('cash_amount',TRUE);
                if (!empty($cash_amount)) {
                    $data['cash_amount'] = $cash_amount;
                }
				$wallet_amount = $this->input->post('wallet_amount',TRUE);
                if (!empty($wallet_amount)) {
                    $data['wallet_amount'] = $wallet_amount;
                }
				$notes = $this->input->post('notes',TRUE);
                if (!empty($notes)) {
                    $data['notes'] = $notes;
                }
				$payment_mode_id = $this->input->post('payment_mode_id',TRUE);
                if (!empty($payment_mode_id)) {
                    $data['payment_mode_id'] = $payment_mode_id;
                }
				$id = $this->input->post('id',TRUE);
				$data['updatedBy'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
				
				$res = $this->invoice_payment_model->update($data,$id);
				
                if ($res) {
                    
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->invoice_payment_model->get($id);
                    $final['message'] = 'Invoice Payment updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                   
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Invoice Payment. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }

    public function invoice_payment_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->invoice_payment_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Invoice Payment deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
