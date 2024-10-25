<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Branch_transfer extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
	

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('branch_transfer_model');
        $this->load->helper('security');
    }

   
    public function branch_transfer_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);

        $id = $this->input->get('id') ? $this->input->get('id') : 0;

        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 5 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];


        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
        
        $totalRecords         =  $this->branch_transfer_model->get('yes',$id,$limit,$offset,$filterData);
        $data         =  $this->branch_transfer_model->get('no',$id,$limit,$offset,$filterData);
      
        $totalPages = ceil($totalRecords / $limit);

        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Branch Transfer fetched successfully.'
        ];
       $this->response($response, REST_Controller::HTTP_OK); 
    }

  
    public function branch_transfer_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data    =  $this->branch_transfer_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Branch Transfer fetched successfully.'
        ];
       $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function branch_transfer_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('branch_id', 'Branch Name', 'trim|required|xss_clean');
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
                $data['branch_id'] = $this->input->post('branch_id',TRUE);
                $data['product_id'] = $this->input->post('product_id',TRUE);
                $data['adminRemarks'] = $this->input->post('adminRemarks',TRUE);

                $data['status'] = 'Pending';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;
				
                if ($res = $this->branch_transfer_model->create($data)) {
                    // branch_transfer creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->branch_transfer_model->get($res);
                    $final['message'] = 'Branch Transfer created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // branch_transfer creation failed, this should never happen
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
            $this->form_validation->set_rules('branch_id', 'Branch Name', 'trim|required|xss_clean');
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
                $data['branch_id'] = $this->input->post('branch_id',TRUE);
                $data['product_id'] = $this->input->post('product_id',TRUE);
                $data['adminRemarks'] = $this->input->post('adminRemarks',TRUE);

        
                $status = $this->input->post('status',TRUE);
                if (!empty($status)) {
                    $data['status'] = $status;
                }
				
                $data['updatedBy'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
                $id = $this->input->post('id');
                $res = $this->branch_transfer_model->update($data, $id);
        
                if ($res) {
                    // branch_transfer update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->branch_transfer_model->get($id);
                    $final['message'] = 'Branch Transfer updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // branch_transfer update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating branch_transfer. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function branch_transfer_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->branch_transfer_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Branch Transfer deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // branch_transfer end
}
