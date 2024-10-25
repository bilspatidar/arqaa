<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Pms_project extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('pms_project_model');
        $this->load->helper('security');
    }

    
    public function pms_project_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        // $getTokenData = $this->is_authorized('superadmin');
        $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        $user_id   =  $isAuthorized['data']->id;
        if($user_type == 'superadmin'){
            $getTokenData = $this->is_authorized('superadmin');
        }elseif($user_type == 'manager'){
            $getTokenData = $this->is_authorized('manager');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->pms_project_model->get('yes', $id, $limit, $offset, $filterData,$user_type,$user_id);
        $data =  $this->pms_project_model->get('no', $id, $limit, $offset, $filterData,$user_type,$user_id);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Project fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function pms_project_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        // $getTokenData = $this->is_authorized('superadmin');
        $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        if($user_type == 'superadmin'){
            $getTokenData = $this->is_authorized('superadmin');
        }elseif($user_type == 'manager'){
            $getTokenData = $this->is_authorized('manager');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }
        $data =  $this->pms_project_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Project fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function pms_project_post($params='') {
        if ($params == 'add') {
            // $getTokenData = $this->is_authorized('superadmin');
            $isAuthorized = $this->is_authorized();
            $user_type = $isAuthorized['data']->user_type;
            if ($user_type == 'superadmin') {
                $getTokenData = $this->is_authorized('superadmin');
            } elseif ($user_type == 'manager') {
                $getTokenData = $this->is_authorized('manager');
            } elseif ($user_type == 'supervisor') {
                $getTokenData = $this->is_authorized('supervisor');
            } elseif ($user_type == 'employee') {
                $getTokenData = $this->is_authorized('employee');
            }
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
            //  print_r($_POST);
            //  exit();
            // set validation rules
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean|alpha_numeric_spaces');
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
        
                $amount = $this->input->post('amount', TRUE);
                $hrs_rate = $this->input->post('hrs_rate', TRUE);
                $est_hrs = $this->input->post('est_hrs', TRUE);
                if (!empty($amount)) {
                    $data['amount'] = $amount;
                }
                if (!empty($hrs_rate)) {
                    $data['hrs_rate'] = $hrs_rate;
                }
                if (!empty($est_hrs)) {
                    $data['est_hrs'] = $est_hrs;
                }
        
                $data['agent_id'] = $this->input->post('agent_id', TRUE);
                $data['manager_id'] = $this->input->post('manager_id', TRUE);
                $data['agent_commission'] = $this->input->post('agent_commission', TRUE);
                $data['title'] = $this->input->post('title', TRUE);
                $data['description'] = $this->input->post('description', TRUE);
                $data['location'] = $this->input->post('location', TRUE);
                $data['state_id'] = $this->input->post('state_id', TRUE);
                $data['city_id'] = $this->input->post('city_id', TRUE);
                $data['billing_type'] = $this->input->post('billing_type', TRUE);
                $data['status'] = $this->input->post('status', TRUE);
                $data['added'] = date('Y-m-d H:i:s');
                $data['added_by'] = $session_id;
                if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'pms_projects'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
				}
                // $employeeId = $this->input->post('employee_id', TRUE);
                // $emp_id = implode(",",$employeeId);
                // $data['employee_id'] = $emp_id;
                // $employeeId = $this->input->post('employee_id', TRUE);
                // if (is_array($employeeId)) {
                //     $emp = implode(',', $employeeId);
                //     $data['employee_id'] = $emp;
                // } 
                // $data['employee_id'] = $emp;
                // $employeeId = $_POST['employee_id'];
                // $emp = implode(',', $employeeId);
                // $data['employee_id'] = $emp;
                    
                if ($res = $this->pms_project_model->create($data)) {
                    // category creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->pms_project_model->get($res);
                    $final['message'] = 'Project created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // category creation failed, this should never happen
                    $this->response(['status' => FALSE,
                        'message' => 'Error in submit form',
                        'errors' => [$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
        if ($params == 'update') {
            // $getTokenData = $this->is_authorized('superadmin');
            $isAuthorized = $this->is_authorized();
            $user_type   =  $isAuthorized['data']->user_type;
            if($user_type == 'superadmin'){
                $getTokenData = $this->is_authorized('superadmin');
            }elseif($user_type == 'manager'){
                $getTokenData = $this->is_authorized('manager');
            }elseif($user_type == 'supervisor'){
                $getTokenData = $this->is_authorized('supervisor');
            }elseif($user_type == 'employee'){
                $getTokenData = $this->is_authorized('employee');
            }
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
          
            // set validation rules
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean|alpha_numeric_spaces');
            // $this->form_validation->set_rules('status', 'Status', 'trim|xss_clean|alpha');
        
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
                $amount = $this->input->post('amount',TRUE);
                $hrs_rate = $this->input->post('hrs_rate',TRUE);
                $est_hrs = $this->input->post('est_hrs',TRUE);
                if(!empty($amount)){
                    $data['amount'] = $amount;
                }
                if(!empty($hrs_rate)){
                    $data['hrs_rate'] = $hrs_rate;
                }
                if(!empty($est_hrs)){
                    $data['est_hrs'] = $est_hrs;
                }
				$id = $this->input->post('id',TRUE);
                $data['agent_id'] = $this->input->post('agent_id',TRUE);
                $data['manager_id'] = $this->input->post('manager_id',TRUE);
                $data['agent_commission'] = $this->input->post('agent_commission',TRUE);
                $data['title'] = $this->input->post('title',TRUE);
                $data['description'] = $this->input->post('description',TRUE);
                $data['location'] = $this->input->post('location',TRUE);
                $data['state_id'] = $this->input->post('state_id',TRUE);
                $data['city_id'] = $this->input->post('city_id',TRUE);
                $data['billing_type'] = $this->input->post('billing_type',TRUE);
                $data['status'] = $this->input->post('status',TRUE);
                $data['updated_by'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
                
                $employeeId = $this->input->post('employee_id', TRUE);
                if (is_array($employeeId)) {
                    $emp = implode(',', $employeeId);
                    $data['employee_id'] = $emp;
                } 
                
                if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'pms_project'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
					$imgData = $this->db->get_where('pms_project',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->image;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
                $res = $this->pms_project_model->update($data, $id);
        
                if ($res) {
                    // category update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->pms_project_model->get($id);
                    $final['message'] = 'Project updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // category update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Project. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function pms_project_delete($id) {
        // $this->is_authorized('superadmin');
        $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        if($user_type == 'superadmin'){
             $this->is_authorized('superadmin');
        }elseif($user_type == 'manager'){
             $this->is_authorized('manager');
        }elseif($user_type == 'supervisor'){
            $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
           $this->is_authorized('employee');
        }elseif($user_type == 'manager'){
            $this->is_authorized('manager');
        }
        $response = $this->pms_project_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Project deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // Category end
}
