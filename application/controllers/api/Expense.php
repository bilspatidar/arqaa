<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Expense extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('expense_model');
        $this->load->helper('security');
    }

    public function expense_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);

        $id = $this->input->get('id') ? $this->input->get('id') : 0;

        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 5 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];


        // $getTokenData = $this->is_authorized('superadmin');
        $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        $user_id   =  $isAuthorized['data']->id;
        if($user_type == 'superadmin'){
            $getTokenData = $this->is_authorized('superadmin');
        }elseif($user_type == 'admin'){
            $getTokenData = $this->is_authorized('admin');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }elseif($user_type == 'manager'){
            $getTokenData = $this->is_authorized('manager');
        }
        $offset = ($page - 1) * $limit;
        
        $totalRecords         =  $this->expense_model->get('yes',$id,$limit,$offset,$filterData,$user_type,$user_id);
        $data         =  $this->expense_model->get('no',$id,$limit,$offset,$filterData,$user_type,$user_id);
      
        $totalPages = ceil($totalRecords / $limit);

        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Expense fetched successfully.'
        ];
       $this->response($response, REST_Controller::HTTP_OK); 
    }
   
    public function expense_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        // $getTokenData = $this->is_authorized('superadmin');
        $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        if($user_type == 'superadmin'){
            $getTokenData = $this->is_authorized('superadmin');
        }elseif($user_type == 'admin'){
            $getTokenData = $this->is_authorized('admin');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }elseif($user_type == 'manager'){
            $getTokenData = $this->is_authorized('manager');
        }
        $data =  $this->expense_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Expense details fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function expense_post($params='') {
        if ($params == 'add') {
            // $getTokenData = $this->is_authorized('superadmin');
            $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        if($user_type == 'superadmin'){
            $getTokenData = $this->is_authorized('superadmin');
        }elseif($user_type == 'admin'){
            $getTokenData = $this->is_authorized('admin');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }elseif($user_type == 'manager'){
            $getTokenData = $this->is_authorized('manager');
        }
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);
         
            // set validation rules
             $this->form_validation->set_rules('expense_category_id', 'Expense Category Name', 'trim|required|xss_clean|alpha_numeric_spaces');
           
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
                $parts_name = $this->input->post('parts_name', TRUE);
                $salary_month = $this->input->post('salary_month', TRUE);
                $employee_id = $this->input->post('employee_id', TRUE);
                $machine_id = $this->input->post('machine_id', TRUE);
                $data = array(
                    'title' => $this->input->post('title', TRUE),
                    'expense_category_id' => $this->input->post('expense_category_id', TRUE),
                    'project_id' => $this->input->post('project_id', TRUE),
                    'amount' => $this->input->post('amount', TRUE),
                    'payment_mode_id' => $this->input->post('payment_mode_id', TRUE),
                    'admin_remarks' => $this->input->post('admin_remarks', TRUE),
                    'remarks' => $this->input->post('remarks', TRUE),
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                );
                if ($user_type == 'manager') {
                    $data['status'] = 'Pending';
                }elseif($user_type == 'superadmin'){
                    $data['status'] = 'Approved';
                }
                if (!empty($parts_name)) {
                    $data['parts_name'] = $this->input->post('parts_name', TRUE);
                }
                if (!empty($machine_id)) {
                    $data['machine_id'] = $this->input->post('machine_id', TRUE);
                }
                if (!empty($employee_id)) {
                    $data['employee_id'] = $this->input->post('employee_id', TRUE);
                }
                if (!empty($salary_month)) {
                    $data['salary_month'] = $this->input->post('salary_month', TRUE);
                }
                if(!empty($_POST['file'])){
					$base64_image = $_POST['file'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['file'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}

                if ($res = $this->expense_model->create($data)) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->expense_model->get($res);
                    $final['message'] = 'Expense mode created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }

        if ($params == 'update') {
            // $getTokenData = $this->is_authorized('superadmin');
            $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        if($user_type == 'superadmin'){
            $getTokenData = $this->is_authorized('superadmin');
        }elseif($user_type == 'admin'){
            $getTokenData = $this->is_authorized('admin');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }elseif($user_type == 'manager'){
            $getTokenData = $this->is_authorized('manager');
        }
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];
    
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            // set validation rules
          
            $this->form_validation->set_rules('expense_category_id', 'Expense Category Name', 'trim|required|xss_clean|alpha_numeric_spaces');
           
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
                $id = $this->input->post('id', TRUE);
                $parts_name = $this->input->post('parts_name', TRUE);
                $salary_month = $this->input->post('salary_month', TRUE);
                $employee_id = $this->input->post('employee_id', TRUE);
                $machine_id = $this->input->post('machine_id', TRUE);
                $data = array(
                    'expense_category_id' => $this->input->post('expense_category_id', TRUE),
                    'project_id' => $this->input->post('project_id', TRUE),
                    'amount' => $this->input->post('amount', TRUE),
                    'payment_mode_id' => $this->input->post('payment_mode_id', TRUE),
                    'admin_remarks' => $this->input->post('admin_remarks', TRUE),
                    'remarks' => $this->input->post('remarks', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                );
                if ($user_type == 'manager') {
                    $data['status'] = 'Pending';
                }elseif($user_type == 'superadmin'){
                    $data['status'] = $this->input->post('status', TRUE);
                }
                if (!empty($parts_name)) {
                    $data['parts_name'] = $this->input->post('parts_name', TRUE);
                }
                if (!empty($machine_id)) {
                    $data['machine_id'] = $this->input->post('machine_id', TRUE);
                }
                if (!empty($employee_id)) {
                    $data['employee_id'] = $this->input->post('employee_id', TRUE);
                }
                if (!empty($salary_month)) {
                    $data['salary_month'] = $this->input->post('salary_month', TRUE);
                }
                if ($this->expense_model->update($data, $id)) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->expense_model->get($id);
                    $final['message'] = 'Expense updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' =>'Error in update',
                        'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }
    }

    public function expense_delete($id) {
        // $this->is_authorized('superadmin');
        $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        if($user_type == 'superadmin'){
            $this->is_authorized('superadmin');
        }elseif($user_type == 'admin'){
             $this->is_authorized('admin');
        }elseif($user_type == 'supervisor'){
            $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
             $this->is_authorized('employee');
        }elseif($user_type == 'manager'){
             $this->is_authorized('manager');
        }

        $response = $this->expense_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Expense mode deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}
