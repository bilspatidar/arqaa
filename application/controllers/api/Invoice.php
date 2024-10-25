<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Invoice extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('invoice_model');
        $this->load->helper('security');
    }

	public function invoice_details_get($id='') {
        $getTokenData = $this->is_authorized('superadmin');
        $filterData = json_decode($this->input->raw_input_stream, true);
        $final = array();
        $final['status'] = true;
        $final['data'] = $this->invoice_model->invoice_details($id);
        $final['message'] = 'Invoice details fetched successfully.';
        $this->response($final, REST_Controller::HTTP_OK);
    }
    public function invoice_list_post($id='') {
        $getTokenData = $this->is_authorized('superadmin');
        $filterData = json_decode($this->input->raw_input_stream, true);
        $final = array();
        $final['status'] = true;
        $final['data'] = $this->invoice_model->get($id,$filterData);
        $final['message'] = 'Invoice fetched successfully.';
        $this->response($final, REST_Controller::HTTP_OK);
    }

    public function invoice_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('users_id', 'User', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('invoice_type', 'Invoice type', 'trim|required|xss_clean|alpha');
            $this->form_validation->set_rules('paid_amount', 'Paid amount', 'trim|numeric');
            $this->form_validation->set_rules('wallet_amount', 'Wallet amount', 'trim|numeric');
            $this->form_validation->set_rules('reward_point', 'Reward point', 'trim|numeric');
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
                $users_id = $this->input->post('users_id',TRUE);
                if (!empty($users_id)) {
                    $data['users_id'] = $users_id;
                }
				$amount = $this->input->post('amount',TRUE);
                if (!empty($amount)) {
                    $data['amount'] = $amount;
                }
				$paid_amount = $this->input->post('paid_amount',TRUE);
                if (!empty($paid_amount)) {
                    $data['paid_amount'] = $paid_amount;
                }
				$wallet_amount = $this->input->post('wallet_amount',TRUE);
                if (!empty($wallet_amount)) {
                    $data['wallet_amount'] = $wallet_amount;
                }
				$reward_point = $this->input->post('reward_point',TRUE);
                if (!empty($reward_point)) {
                    $data['reward_point'] = $reward_point;
                }
				$payment_mode_id = $this->input->post('payment_mode_id',TRUE);
                if (!empty($payment_mode_id)) {
                    $data['payment_mode_id'] = $payment_mode_id;
                }
				$invoice_type = $this->input->post('invoice_type',TRUE);
				$data['invoice_type'] = $invoice_type;
				
				$invoice_number = $this->invoice_model->generateInvoiceNo($invoice_type);
				$data['invoice_number'] = $invoice_number;
                
				$notes = $this->input->post('notes',TRUE);
                if (!empty($notes)) {
                    $data['notes'] = $notes;
                }
				$shipping_address = $this->input->post('shipping_address',TRUE);
                if (!empty($shipping_address)) {
                    $data['shipping_address'] = $shipping_address;
                }
				
				///image 
				if(!empty($_POST['attachment'])){
					$base64_image = $_POST['attachment'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
							'width' => 500,
							'height' => 300
						]
					 ];
					$uploadFolder = 'invoice'; // Change this to your desired folder name

					$data['attachment'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
				}
				////image 
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;
				$invoice_id = $this->invoice_model->create($data);
				$product_id = $_POST['product_id'];
				$gst_amount = $_POST['gst_amount'];
				$amounts 	= $_POST['amounts'];
				for($i=0;$i<count($product_id);$i++){
					$data2['invoice_id'] = $invoice_id;
					$data2['product_id'] = $product_id[$i];
					$data2['amount'] 	 = $amounts[$i];
					$data2['gst_amount'] = $gst_amount[$i];
					$this->invoice_model->insert_invoice_items($data2);
				}
                if ($invoice_id) {

                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->invoice_model->get($invoice_id);
                    $final['message'] = 'Invoice created successfully.';
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
			$this->form_validation->set_rules('users_id', 'User', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|css_clean|numeric');
            $this->form_validation->set_rules('invoice_type', 'Invoice type', 'trim|required|xss_clean|alpha');
            $this->form_validation->set_rules('paid_amount', 'Paid amount', 'trim|numeric');
            $this->form_validation->set_rules('wallet_amount', 'Wallet amount', 'trim|numeric');
            $this->form_validation->set_rules('reward_point', 'Reward point', 'trim|numeric');
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
                
				$users_id = $this->input->post('users_id',TRUE);
                if (!empty($users_id)) {
                    $data['users_id'] = $users_id;
                }
				$amount = $this->input->post('amount',TRUE);
                if (!empty($amount)) {
                    $data['amount'] = $amount;
                }
				$paid_amount = $this->input->post('paid_amount',TRUE);
                if (!empty($paid_amount)) {
                    $data['paid_amount'] = $paid_amount;
                }
				$wallet_amount = $this->input->post('wallet_amount',TRUE);
                if (!empty($wallet_amount)) {
                    $data['wallet_amount'] = $wallet_amount;
                }
				$reward_point = $this->input->post('reward_point',TRUE);
                if (!empty($reward_point)) {
                    $data['reward_point'] = $reward_point;
                }
				$payment_mode_id = $this->input->post('payment_mode_id',TRUE);
                if (!empty($payment_mode_id)) {
                    $data['payment_mode_id'] = $payment_mode_id;
                }
				
				$notes = $this->input->post('notes',TRUE);
                if (!empty($notes)) {
                    $data['notes'] = $notes;
                }
				$shipping_address = $this->input->post('shipping_address',TRUE);
                if (!empty($shipping_address)) {
                    $data['shipping_address'] = $shipping_address;
                }
				
				$id = $this->input->post('id',TRUE);
				///image 
				if(!empty($_POST['attachment'])){
					$base64_image = $_POST['attachment'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
							'width' => 500,
							'height' => 300
						]
					 ];
					$uploadFolder = 'invoice'; // Change this to your desired folder name

					$data['attachment'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
					$imgData = $this->db->get_where('invoice',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->attachment;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
				////image 
                $data['updatedBy'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
				
				$res = $this->invoice_model->update($data,$id);
				$product_id = $_POST['product_id'];
				$gst_amount = $_POST['gst_amount'];
				$amounts 	= $_POST['amounts'];
				$count = count($product_id);
				if($count>0){
					$this->db->where('invoice_id',$id);
					$this->db->delete('invoice_items');
					for($i=0;$i<$count;$i++){
						$data2['invoice_id'] = $id;
						$data2['product_id'] = $product_id[$i];
						$data2['amount'] 	 = $amounts[$i];
						$data2['gst_amount'] = $gst_amount[$i];
						$this->invoice_model->insert_invoice_items($data2);
					}
				}
            
                if ($res) {
                    
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->invoice_model->get($id);
                    $final['message'] = 'Invoice updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                   
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Invoice. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }

    public function invoice_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->invoice_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Invoice deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
