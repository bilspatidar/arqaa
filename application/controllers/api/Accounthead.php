<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Accounthead extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
	

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('accounthead_model');
        $this->load->helper('security');
    }

   
    public function accounthead_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);

        $id = $this->input->get('id') ? $this->input->get('id') : 0;

        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 5 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];


        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $offset = ($page - 1) * $limit;
        
        $totalRecords         =  $this->accounthead_model->get('yes',$id,$limit,$offset,$filterData);
        $data         =  $this->accounthead_model->get('no',$id,$limit,$offset,$filterData);
      
        $totalPages = ceil($totalRecords / $limit);

        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Accounthead fetched successfully.'
        ];
       $this->response($response, REST_Controller::HTTP_OK); 
    }

  
    public function accounthead_details_get($id=''){
        //$id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $data    =  $this->accounthead_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Accounthead fetched successfully.'
        ];
       $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function accounthead_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
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
                $data['name'] = $this->input->post('name',TRUE);
                $data['date'] = $this->input->post('date',TRUE);
                $data['type'] = $this->input->post('type',TRUE);
                $data['accountNo'] = $this->input->post('accountNo',TRUE);
                $data['openingBalance'] = $this->input->post('openingBalance',TRUE);

                $data['status'] = 'Pending';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;
				
                if ($res = $this->accounthead_model->create($data)) {
                    // accounthead creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->accounthead_model->get($res);
                    $final['message'] = 'Accounthead created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // accounthead creation failed, this should never happen
					//$this->response($base64_image, REST_Controller::HTTP_OK);
					 $this->response([ 'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }

        if ($params == 'update') {

            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
        
            // set validation rules
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
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
                $data['name'] = $this->input->post('name',TRUE);
                $data['date'] = $this->input->post('date',TRUE);
                $data['type'] = $this->input->post('type',TRUE);
                $data['accountNo'] = $this->input->post('accountNo',TRUE);
                $data['openingBalance'] = $this->input->post('openingBalance',TRUE);

                $status = $this->input->post('status',TRUE);
                if (!empty($status)) {
                    $data['status'] = $status;
                }
				
                $data['updatedBy'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
                $id = $this->input->post('id');
                $res = $this->accounthead_model->update($data, $id);
        
                if ($res) {
                    // accounthead update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->accounthead_model->get($id);
                    $final['message'] = 'Accounthead updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // accounthead update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating accounthead. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function accounthead_delete($id) {
        $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $response = $this->accounthead_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Accounthead deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // Accounthead end
}
