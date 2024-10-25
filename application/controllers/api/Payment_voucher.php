<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Payment_voucher extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
	

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('payment_voucher_model');
        $this->load->helper('security');
    }

   
    public function payment_voucher_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);

        $id = $this->input->get('id') ? $this->input->get('id') : 0;

        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 5 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];


        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
        
        $totalRecords         =  $this->payment_voucher_model->get('yes',$id,$limit,$offset,$filterData);
        $data         =  $this->payment_voucher_model->get('no',$id,$limit,$offset,$filterData);
      
        $totalPages = ceil($totalRecords / $limit);

        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Payment Voucher fetched successfully.'
        ];
       $this->response($response, REST_Controller::HTTP_OK); 
    }

  
    public function payment_voucher_details_get($id=''){
        //$id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data    =  $this->payment_voucher_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Payment Voucher fetched successfully.'
        ];
       $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function payment_voucher_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('Date', 'Date', 'trim|required|xss_clean');
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
                $data['Date'] = $this->input->post('Date');
                $data['PartyId'] = $this->input->post('PartyId');
                $data['Amount'] = $this->input->post('Amount');
                $data['PaymentModeId'] = $this->input->post('PaymentModeId');
                $data['AccountHeadId'] = $this->input->post('AccountHeadId');
                $data['Narration'] = $this->input->post('Narration',TRUE);

                $data['status'] = 'Pending';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;
				
                if ($res = $this->payment_voucher_model->create($data)) {
                    // Payment Voucher creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->payment_voucher_model->get($res);
                    $final['message'] = 'Payment Voucher created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // Payment Voucher creation failed, this should never happen
					//$this->response($base64_image, REST_Controller::HTTP_OK);
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
            $this->form_validation->set_rules('Date', 'Date', 'trim|required|xss_clean');
            $this->form_validation->set_rules('status', 'Status', 'trim');
        
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
                $data['Date'] = $this->input->post('Date',TRUE);
                $data['PartyId'] = $this->input->post('PartyId',TRUE);
                $data['Amount'] = $this->input->post('Amount',TRUE);
                $data['PaymentModeId'] = $this->input->post('PaymentModeId',TRUE);
                $data['AccountHeadId'] = $this->input->post('AccountHeadId',TRUE);
                $data['Narration'] = $this->input->post('Narration',TRUE);

                $status = $this->input->post('status',TRUE);
                if (!empty($status)) {
                    $data['status'] = $status;
                }
				
                $data['updatedBy'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
                $id = $this->input->post('id');
                $res = $this->payment_voucher_model->update($data, $id);
        
                if ($res) {
                    // Payment Voucher update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->payment_voucher_model->get($id);
                    $final['message'] = 'Payment Voucher updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // Payment Voucher update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Payment Voucher. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function payment_voucher_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->payment_voucher_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Payment Voucher deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // Payment Voucher end
}
