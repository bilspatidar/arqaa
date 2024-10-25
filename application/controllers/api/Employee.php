<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Employee extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('Employee_joining_model');
        $this->load->model('User_branch_link_model');
        $this->load->model('Internal_model');
        $this->load->helper('security');
    }

    public function employee_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('users_id') ? $this->input->get('users_id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
       
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
        }
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->user_model->employee_get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->user_model->employee_get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Employee fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function employee_details_get($id){

       $id = $this->input->get('users_id') ? $this->input->get('users_id') : 0;
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
       }
    //    $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->user_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Employee fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function employee_post($params='') {
        if($params == 'add') {
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
            }

            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('alt_mobile', 'Alternate Mobile', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('user_type', 'User Type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('father_name', 'Father Name', 'trim|xss_clean');
            $this->form_validation->set_rules('mother_name', 'Mother Name', 'trim|xss_clean');
            $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|xss_clean');
            $this->form_validation->set_rules('doj', 'Date of Joining', 'trim|xss_clean');
            $this->form_validation->set_rules('country_id', 'Country ID', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('state_id', 'State ID', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('city_id', 'City ID', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('street_address', 'Street Address', 'trim|xss_clean');
            $this->form_validation->set_rules('street_address2', 'Street Address 2', 'trim|xss_clean');
            $this->form_validation->set_rules('profile_pic', 'Profile Picture', 'trim|xss_clean');
            $this->form_validation->set_rules('address_proof', 'Address Proof', 'trim|xss_clean');
            $this->form_validation->set_rules('id_proof', 'ID Proof', 'trim|xss_clean');
            $this->form_validation->set_rules('businessSignature', 'Business Signature', 'trim|xss_clean');
  
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
                $data['first_name'] = $this->input->post('first_name', TRUE);
                $data['last_name'] = $this->input->post('last_name', TRUE);
                $data['email'] = $this->input->post('email', TRUE);
                $data['mobile'] = $this->input->post('mobile', TRUE);
                $data['alt_mobile'] = $this->input->post('alt_mobile', TRUE);
                $data['password'] = $this->input->post('password', TRUE);
                $data['user_type'] = $this->input->post('user_type', TRUE);
                $data['father_name'] = $this->input->post('father_name', TRUE);
                $data['mother_name'] = $this->input->post('mother_name', TRUE);
                $data['dob'] = $this->input->post('dob', TRUE);
                $data['doj'] = $this->input->post('doj', TRUE);
                $data['country_id'] = $this->input->post('country_id', TRUE);
                $data['state_id'] = $this->input->post('state_id', TRUE);
                $data['city_id'] = $this->input->post('city_id', TRUE);
                $data['street_address'] = $this->input->post('street_address', TRUE);
                $data['street_address2'] = $this->input->post('street_address2', TRUE);
                $data['profile_pic'] = $this->input->post('profile_pic', TRUE);
                $data['address_proof'] = $this->input->post('address_proof', TRUE);
                $data['id_proof'] = $this->input->post('id_proof', TRUE);
                $data['businessSignature'] = $this->input->post('businessSignature', TRUE);
                $data['status'] = 'Active';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;

                if(!empty($_POST['profile_pic'])){
					$base64_image = $_POST['profile_pic'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['profile_pic'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}

                if(!empty($_POST['address_proof'])){
					$base64_image = $_POST['address_proof'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['address_proof'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}

                if(!empty($_POST['id_proof'])){
					$base64_image = $_POST['id_proof'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['id_proof'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}

                if(!empty($_POST['businessSignature'])){
					$base64_image = $_POST['businessSignature'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['businessSignature'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}

                if ($res = $this->user_model->create_user($data)) {
                    // Employee creation successful
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->user_model->employee_get($res);
                    $final['message'] = 'Employee created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // Employee creation failed
                    $this->response([
                        'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST,'','error');
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
            }
            
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
            // set validation rules for updating an existing employee
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('alt_mobile', 'Alternate Mobile', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('user_type', 'User Type', 'trim|required|xss_clean');
            $this->form_validation->set_rules('father_name', 'Father Name', 'trim|xss_clean');
            $this->form_validation->set_rules('mother_name', 'Mother Name', 'trim|xss_clean');
            $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|xss_clean');
            $this->form_validation->set_rules('doj', 'Date of Joining', 'trim|xss_clean');
            $this->form_validation->set_rules('country_id', 'Country ID', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('state_id', 'State ID', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('city_id', 'City ID', 'trim|xss_clean|numeric');
            $this->form_validation->set_rules('street_address', 'Street Address', 'trim|xss_clean');
            $this->form_validation->set_rules('street_address2', 'Street Address 2', 'trim|xss_clean');
            $this->form_validation->set_rules('profile_pic', 'Profile Picture', 'trim|xss_clean');
            $this->form_validation->set_rules('address_proof', 'Address Proof', 'trim|xss_clean');
            $this->form_validation->set_rules('id_proof', 'ID Proof', 'trim|xss_clean');
            $this->form_validation->set_rules('businessSignature', 'Business Signature', 'trim|xss_clean');
           
    
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
                // Set variables from the form
                $data['first_name'] = $this->input->post('first_name', TRUE);
                $data['last_name'] = $this->input->post('last_name', TRUE);
                $data['email'] = $this->input->post('email', TRUE);
                $data['mobile'] = $this->input->post('mobile', TRUE);
                $data['alt_mobile'] = $this->input->post('alt_mobile', TRUE);
                $data['password'] = $this->input->post('password', TRUE);
                $data['user_type'] = $this->input->post('user_type', TRUE);
                $data['father_name'] = $this->input->post('father_name', TRUE);
                $data['mother_name'] = $this->input->post('mother_name', TRUE);
                $data['dob'] = $this->input->post('dob', TRUE);
                $data['doj'] = $this->input->post('doj', TRUE);
                $data['country_id'] = $this->input->post('country_id', TRUE);
                $data['state_id'] = $this->input->post('state_id', TRUE);
                $data['city_id'] = $this->input->post('city_id', TRUE);
                $data['street_address'] = $this->input->post('street_address', TRUE);
                $data['street_address2'] = $this->input->post('street_address2', TRUE);
                $data['profile_pic'] = $this->input->post('profile_pic', TRUE);
                $data['address_proof'] = $this->input->post('address_proof', TRUE);
                $data['id_proof'] = $this->input->post('id_proof', TRUE);
                $data['businessSignature'] = $this->input->post('businessSignature', TRUE);
                $data['status'] = $this->input->post('status', TRUE);

                $data['updatedBy'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
        
				if(!empty($_POST['profile_pic'])){
					$base64_image = $_POST['profile_pic'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['profile_pic'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('users',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->profile_pic;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}

				if(!empty($_POST['address_proof'])){
					$base64_image = $_POST['address_proof'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['address_proof'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('users',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->address_proof;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}

				if(!empty($_POST['id_proof'])){
					$base64_image = $_POST['id_proof'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['id_proof'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('users',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->id_proof;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}

				if(!empty($_POST['businessSignature'])){
					$base64_image = $_POST['businessSignature'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['businessSignature'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('users',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->businessSignature;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
                // Get the ID from the request
                $id = $this->input->post('users_id');
        
                // Perform the update operation
                $res = $this->user_model->update($data, $id);
        
                if ($res) {
                    // Employee update successful
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->user_model->employee_get($id);
                    $final['message'] = 'Employee updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // Employee update failed
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating employee. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }

    public function employee_delete($id) {
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
        }

        $response = $this->user_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Employee deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
   
    public function employee_joining_delete($id) {
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
        }
        $result = $this->db->get_where('user_profile', array('id' => $id))->row(); 
        if ($result) {
        $users_id = $result->users_id;
        $response = $this->user_model->delete($users_id);
        } else {
            echo "Record not found";
            $response = $this->user_model->delete($users_id);
        }


        $response = $this->Employee_joining_model->delete($id);
        if ($response) {
            $this->response(['status' => true, 'message' => 'Employee deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function employee_joining_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
        
        $isAuthorized = $this->is_authorized();
		$user_type   =  $isAuthorized['data']->user_type;
        $userId   =  $isAuthorized['data']->id;
        if($user_type == 'superadmin'){
            $getTokenData = $this->is_authorized('superadmin');
        }elseif($user_type == 'admin'){
            $getTokenData = $this->is_authorized('admin');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }
        


        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->Employee_joining_model->get('yes', $id, $limit, $offset, $filterData,$user_type,$userId);
        $data =  $this->Employee_joining_model->get('no', $id, $limit, $offset, $filterData,$user_type,$userId);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Employee fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function employee_joining_details_get($id=''){

         $id = $this->input->get('id') ? $this->input->get('id') : 0;


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
         }


        //  $getTokenData = $this->is_authorized('superadmin');
         $data =  $this->Employee_joining_model->show($id);
         $response = [
             'status' => true,
             'data' => $data,
             'message' => 'Employee fetched successfully.'
         ];
         $this->response($response, REST_Controller::HTTP_OK); 
     }

    public function employee_joining_post($params='') {
        if($params == 'add') {
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
            }
            // $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);
                // print_r($_POST);
                // exit();
            // set validation rules
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            // $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|xss_clean');
            // $this->form_validation->set_rules('father_name', 'Father Name', 'trim|xss_clean');
            // $this->form_validation->set_rules('mother_name', 'Mother Name', 'trim|xss_clean');
            // $this->form_validation->set_rules('gender', 'Gender', 'trim|required|xss_clean');
            // $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|xss_clean');
            // $this->form_validation->set_rules('blood_group', 'Blood Group', 'trim|xss_clean');
            // $this->form_validation->set_rules('identification_mark', 'Identification Mark', 'trim|xss_clean');
            // $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|xss_clean|numeric');
            // $this->form_validation->set_rules('alt_mobile', 'Alternate Mobile', 'trim|xss_clean|numeric');
            // $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
            // $this->form_validation->set_rules('id_proof', 'ID Proof', 'trim|xss_clean');
            // $this->form_validation->set_rules('permanent_address', 'Permanent Address', 'trim|xss_clean');
            // $this->form_validation->set_rules('district', 'District', 'trim|xss_clean');
            // $this->form_validation->set_rules('state_id', 'State ID', 'trim|xss_clean|numeric');
            // $this->form_validation->set_rules('pincode', 'Pincode', 'trim|xss_clean|numeric');
            // $this->form_validation->set_rules('present_address', 'Present Address', 'trim|xss_clean');
            // $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|xss_clean');
            // $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|xss_clean');
            // $this->form_validation->set_rules('account_no', 'Account  No', 'trim|xss_clean');
            // $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'trim|xss_clean');
            // $this->form_validation->set_rules('height', 'Height', 'trim|xss_clean');
            // $this->form_validation->set_rules('weight', 'Weight', 'trim|xss_clean');
            // $this->form_validation->set_rules('detail_of_arm', 'Detail of ARM', 'trim|xss_clean');
            // $this->form_validation->set_rules('arm_code', 'ARM Code', 'trim|xss_clean');
            // $this->form_validation->set_rules('license_no', 'License No', 'trim|xss_clean');
            // $this->form_validation->set_rules('issue_date', 'Issue Date', 'trim|xss_clean');
            // $this->form_validation->set_rules('police_station', 'Police Station', 'trim|xss_clean');

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
                $userData = array(
                    'first_name' => $this->input->post('first_name', TRUE),
                    'last_name' => $this->input->post('last_name', TRUE),
                    'father_name' => $this->input->post('father_name', TRUE),
                    'mother_name' => $this->input->post('mother_name', TRUE),
                    'password' => password_hash($this->input->post('password',TRUE),PASSWORD_DEFAULT),
                    'dob' => $this->input->post('dob', TRUE),
                    'mobile' => $this->input->post('mobile', TRUE),
                    'user_type' => $this->input->post('user_type', TRUE),
                    'alt_mobile' => $this->input->post('alt_mobile', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'country_id' => $this->input->post('country_id', TRUE),
                    'state_id' => $this->input->post('state_id', TRUE),
                    'status' => 'Active',
                    'parent_id' => $session_id,
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                );
                if(!empty($_POST['profile_pic'])){
					$base64_image = $_POST['profile_pic'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$userData['profile_pic'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}
                $userId = $this->user_model->create_user($userData);
                
                $data = array(
                    'users_id' => $userId,
                    'first_name' => $this->input->post('first_name', TRUE),
                    'last_name' => $this->input->post('last_name', TRUE),
                    'father_name' => $this->input->post('father_name', TRUE),
                    'mother_name' => $this->input->post('mother_name', TRUE),
                    'gender' => $this->input->post('gender', TRUE),
                    'dob' => $this->input->post('dob', TRUE),
                    'blood_group' => $this->input->post('blood_group', TRUE),
                    'identification_mark' => $this->input->post('identification_mark', TRUE),
                    'mobile' => $this->input->post('mobile', TRUE),
                    'alt_mobile' => $this->input->post('alt_mobile', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'aadhar_no' => $this->input->post('aadhar_no', TRUE),
                    'id_proof' => $this->input->post('id_proof', TRUE),
                    'permanent_address' => $this->input->post('permanent_address', TRUE),
                    'country_id' => $this->input->post('country_id', TRUE),
                    'district' => $this->input->post('district', TRUE),
                    'state_id' => $this->input->post('state_id', TRUE),
                    'pincode' => $this->input->post('pincode', TRUE),
                    'present_address' => $this->input->post('present_address', TRUE),
                    'present_district' => $this->input->post('present_district', TRUE),
                    'present_state_id' => $this->input->post('present_state_id', TRUE),
                    'present_pincode' => $this->input->post('present_pincode', TRUE),
                    'bank_name' => $this->input->post('bank_name', TRUE),
                    'branch_name' => $this->input->post('branch_name', TRUE),
                    'account_no' => $this->input->post('account_no', TRUE),
                    'ifsc_code' => $this->input->post('ifsc_code', TRUE),
                    'height' => $this->input->post('height', TRUE),
                    'weight' => $this->input->post('weight', TRUE),
                    'detail_of_arm' => $this->input->post('detail_of_arm', TRUE),
                    'arm_code' => $this->input->post('arm_code', TRUE),
                    'license_no' => $this->input->post('license_no', TRUE),
                    'issue_date' => $this->input->post('issue_date', TRUE),
                    'expiry_date' => $this->input->post('expiry_date', TRUE),
                    'issue_state_id' => $this->input->post('issue_state_id', TRUE),
                    'issue_district' => $this->input->post('issue_district', TRUE),
                    'case_of_year' => $this->input->post('case_of_year', TRUE),
                    'police_station' => $this->input->post('police_station', TRUE),
                    'court_name' => $this->input->post('court_name', TRUE),
                    'crime' => $this->input->post('crime', TRUE),
                    'PV_issue_date' => $this->input->post('PV_issue_date', TRUE),
                    'PV_police_station' => $this->input->post('PV_police_station', TRUE),
                    'PV_district' => $this->input->post('PV_district', TRUE),
                    'PV_state_id' => $this->input->post('PV_state_id', TRUE),
                    // 'employee_status' => $this->input->post('employee_status', TRUE),
                    'status' => 'Active',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                );

                if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 
					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}
                if(!empty($_POST['resume'])){
					$base64_image = $_POST['resume'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 
					$data['resume'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}
                if(!empty($_POST['passport_photo'])){
					$base64_image = $_POST['passport_photo'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 
					$data['passport_photo'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}
                
                if(!empty($_POST['aadhar_front'])){
					$base64_image = $_POST['aadhar_front'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['aadhar_front'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}
                if(!empty($_POST['aadhar_back'])){
					$base64_image = $_POST['aadhar_back'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['aadhar_back'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}
                if(!empty($_POST['case_file'])){
					$base64_image = $_POST['case_file'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
				}


                if ($res = $this->Employee_joining_model->create($data)) {
                    // Employee creation successful
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->Employee_joining_model->get($res);
                    $final['message'] = 'Employee Joined created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // Employee creation failed
                    $this->response([
                        'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }

        if ($params == 'update') {
            // ini_set('display_errors',1);
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
            }
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
            // print_r($_POST);
            // exit();
            // set validation rules for updating an existing employee
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
            
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
                // Set variables from the form
                $id = $this->input->post('id');
                $users_id = $this->input->post('users_id');
                
                $userData = array(
                    'first_name' => $this->input->post('first_name', TRUE),
                    'last_name' => $this->input->post('last_name', TRUE),
                    'father_name' => $this->input->post('father_name', TRUE),
                    'mother_name' => $this->input->post('mother_name', TRUE),
                    'user_type' => $this->input->post('user_type', TRUE),
                    'dob' => $this->input->post('dob', TRUE),
                    'mobile' => $this->input->post('mobile', TRUE),
                    'alt_mobile' => $this->input->post('alt_mobile', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'country_id' => $this->input->post('country_id', TRUE),
                    'state_id' => $this->input->post('state_id', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                );
                if(!empty($_POST['profile_pic'])){
					$base64_image = $_POST['profile_pic'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$userData['profile_pic'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('users',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->profile_pic;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
                    $userId = $this->user_model->update($userData,$users_id);
                
                    $data = array(
                    'users_id' => $users_id,
                    'first_name' => $this->input->post('first_name', TRUE),
                    'last_name' => $this->input->post('last_name', TRUE),
                    'father_name' => $this->input->post('father_name', TRUE),
                    'expiry_date' => $this->input->post('expiry_date', TRUE),
                    'mother_name' => $this->input->post('mother_name', TRUE),
                    'gender' => $this->input->post('gender', TRUE),
                    'user_type' => $this->input->post('user_type', TRUE),
                    'dob' => $this->input->post('dob', TRUE),
                    'blood_group' => $this->input->post('blood_group', TRUE),
                    'identification_mark' => $this->input->post('identification_mark', TRUE),
                    'mobile' => $this->input->post('mobile', TRUE),
                    'alt_mobile' => $this->input->post('alt_mobile', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'aadhar_no' => $this->input->post('aadhar_no', TRUE),
                    'id_proof' => $this->input->post('id_proof', TRUE),
                    'permanent_address' => $this->input->post('permanent_address', TRUE),
                    'country_id' => $this->input->post('country_id', TRUE),
                    'district' => $this->input->post('district', TRUE),
                    'state_id' => $this->input->post('state_id', TRUE),
                    'pincode' => $this->input->post('pincode', TRUE),
                    'present_address' => $this->input->post('present_address', TRUE),
                    'present_district' => $this->input->post('present_district', TRUE),
                    'present_state_id' => $this->input->post('present_state_id', TRUE),
                    'present_pincode' => $this->input->post('present_pincode', TRUE),
                    'bank_name' => $this->input->post('bank_name', TRUE),
                    'branch_name' => $this->input->post('branch_name', TRUE),
                    'account_no' => $this->input->post('account_no', TRUE),
                    'ifsc_code' => $this->input->post('ifsc_code', TRUE),
                    'height' => $this->input->post('height', TRUE),
                    'weight' => $this->input->post('weight', TRUE),
                    'detail_of_arm' => $this->input->post('detail_of_arm', TRUE),
                    'arm_code' => $this->input->post('arm_code', TRUE),
                    'license_no' => $this->input->post('license_no', TRUE),
                    'issue_date' => $this->input->post('issue_date', TRUE),
                    'issue_state_id' => $this->input->post('issue_state_id', TRUE),
                    'issue_district' => $this->input->post('issue_district', TRUE),
                    'case_of_year' => $this->input->post('case_of_year', TRUE),
                    'police_station' => $this->input->post('police_station', TRUE),
                    'court_name' => $this->input->post('court_name', TRUE),
                    'crime' => $this->input->post('crime', TRUE),
                    'PV_issue_date' => $this->input->post('PV_issue_date', TRUE),
                    'PV_police_station' => $this->input->post('PV_police_station', TRUE),
                    'PV_district' => $this->input->post('PV_district', TRUE),
                    'PV_state_id' => $this->input->post('PV_state_id', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'employee_status' => $this->input->post('employee_status', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                );
               
				if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('user_profile',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->image;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
                if(!empty($_POST['resume'])){
					$base64_image = $_POST['resume'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 
					$data['resume'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
                    $imgData = $this->db->get_where('user_profile',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->resume;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
                }
                if(!empty($_POST['passport_photo'])){
					$base64_image = $_POST['passport_photo'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 
					$data['passport_photo'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
                    $imgData = $this->db->get_where('user_profile',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->passport_photo;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
                }
                if(!empty($_POST['aadhar_front'])){
					$base64_image = $_POST['aadhar_front'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['aadhar_front'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
                    $imgData = $this->db->get_where('user_profile',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->aadhar_front;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
                }
                if(!empty($_POST['aadhar_back'])){
					$base64_image = $_POST['aadhar_back'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['aadhar_back'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
                    $imgData = $this->db->get_where('user_profile',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->aadhar_back;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
                }
                if(!empty($_POST['case_file'])){
					$base64_image = $_POST['case_file'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('user_profile',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->case_file;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
                // Get the ID from the request
               // $id = $this->input->post('users_id');
        
                // Perform the update operation
                $res = $this->Employee_joining_model->update($data, $id);
        
                if ($res) {
                    // Employee update successful
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->Employee_joining_model->get($id);
                    $final['message'] = 'Employee updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // Employee update failed
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating employee. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }

    public function user_branch_link_delete($id) {
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
        }
        $result = $this->db->get_where('user_branch_link', array('id' => $id))->row(); 
        if ($result) {
            $response = $this->User_branch_link_model->delete($id);
            if ($response) {
                $this->response(['status' => true, 'message' => 'User branch link deleted successfully.'], REST_Controller::HTTP_OK);
            } else {
                $this->response(['status' => false, 'message' => 'Failed to delete user branch link.'], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            $this->response(['status' => false, 'message' => 'Record not found'], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
    public function user_branch_link_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
       
        // $getTokenData = $this->is_authorized('superadmin');
        $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        if($user_type == 'superadmin'){
            $this->is_authorized('superadmin');
        }elseif($user_type == 'admin'){
            $getTokenData = $this->is_authorized('admin');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->User_branch_link_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->User_branch_link_model->get('no',$id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'User branch links fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function user_branch_link_details_get($id='') {
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
       
        // $getTokenData = $this->is_authorized('superadmin');
        $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        if($user_type == 'superadmin'){
            $this->is_authorized('superadmin');
        }elseif($user_type == 'admin'){
            $getTokenData = $this->is_authorized('admin');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }
        $data =  $this->User_branch_link_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'User branch link fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function user_branch_link_post($params='') {
        if ($params == 'add') {
            // $getTokenData = $this->is_authorized('superadmin');
            
            $isAuthorized = $this->is_authorized();
            $user_type   =  $isAuthorized['data']->user_type;
            if($user_type == 'superadmin'){
                $getTokenData = $this->is_authorized('superadmin');
            } elseif($user_type == 'admin'){
                $getTokenData = $this->is_authorized('admin');
            } elseif($user_type == 'supervisor'){
                $getTokenData = $this->is_authorized('supervisor');
            } elseif($user_type == 'employee'){
                $getTokenData = $this->is_authorized('employee');
            }
            
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
            $postData = json_decode($this->input->raw_input_stream, true);
            
            if (isset($postData['branch_id']) && isset($postData['user_id[]'])) {
                $user_ids = explode(',', $postData['user_id[]']);
                $branch_id = $postData['branch_id'];
                
                if (!empty($user_ids)) {
                    // Prepare data for all users
                    $data = array();
                    foreach ($user_ids as $user_id) {
                        
                        $this->Internal_model->update_status($user_id);
                        
                        $from_role = $this->Internal_model->get_from_role($user_id);
                        $to_role = $this->Internal_model->get_from_role($user_id);
                        
                        $branch_employee_code = $this->Internal_model->GenerateEmployeeBranchCode($user_id);
                        
                        $data[] = array(
                            'user_id' => $user_id,
                            'branch_id' => $branch_id,
                            'branch_employee_code' => $branch_employee_code,
                            'from_role' => $from_role,
                            'to_role' => $to_role,
                            'transfer_date' => date('Y-m-d H:i:s'),
                            'status' => 'Active',
                            'created_at' => date('Y-m-d H:i:s')
                        );
                    }
                    // print_r($data);
                    // exit();
                    // Insert data into the database
                    if ($this->db->insert_batch('user_branch_link', $data)) {
                        $final = array(
                            'status' => true,
                            'message' => 'User branch links created successfully.'
                        );
                        $this->response($final, REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Error in submit form',
                            'errors' => [$this->db->error()]
                        ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                    }
                } else {
                    // user_id array is empty
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Empty user_id',
                        'errors' => 'No user_id received from the form'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                // Branch_id or user_id not found in the POST data
                $this->response([
                    'status' => FALSE,
                    'message' => 'Missing branch_id or user_id',
                    'errors' => 'Branch_id or user_id not found in the POST data'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        if ($params == 'add00000') {
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
            }

            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
            $postData = json_decode($this->input->raw_input_stream, true);
            
            if (isset($postData['branch_id']) && isset($postData['user_id[]'])) {
                $user_ids = explode(',', $postData['user_id[]']);
                $branch_id = $postData['branch_id'];
                
                if (!empty($user_ids)) {
                    // Prepare data for all users
                    $data = array();
                    foreach ($user_ids as $user_id) {
                        
                        $this->Internal_model->update_status($user_id);
                        
                        $from_role = $this->Internal_model->get_from_role($user_id);
                        $to_role = $this->Internal_model->get_from_role($user_id); 
                        $branch_employee_code = $this->Internal_model->GenerateEmployeeBranchCode($user_id);
                        
                        $data[] = array(
                            'user_id' => $user_id,
                            'branch_id' => $branch_id,
                            'branch_employee_code' => $branch_employee_code,
                            'from_role' => $from_role,
                            'to_role' => $to_role,
                            'transfer_date' => date('Y-m-d H:i:s'),
                            'status' => 'Active',
                            'created_at' => date('Y-m-d H:i:s')
                        );
                    }
            
                    // Insert data into the database
                    if ($this->db->insert_batch('user_branch_link', $data)) {
                        $final = array(
                            'status' => true,
                            'message' => 'User branch links created successfully.'
                        );
                        $this->response($final, REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' =>'Error in submit form',
                            'errors' => [$this->db->error()]
                        ], REST_Controller::HTTP_BAD_REQUEST,'','error');
                    }
                } else {
                    // user_id array is empty
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Empty user_id',
                        'errors' => 'No user_id received from the form'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                // Branch_id or user_id not found in the POST data
                $this->response([
                    'status' => FALSE,
                    'message' => 'Missing branch_id or user_id',
                    'errors' => 'Branch_id or user_id not found in the POST data'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
            if($params == 'update') {
                // Check authorization
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
                }
                // $getTokenData = $this->is_authorized('superadmin');
                $usersData = json_decode(json_encode($getTokenData), true);
                 $session_id = $getTokenData['data']->id;;
            
                // Get JSON data from input stream
                $_POST = json_decode($this->input->raw_input_stream, true);
             
                // Set validation rules
                $this->form_validation->set_rules('user_id', 'User Name', 'trim|required|xss_clean');
                // $this->form_validation->set_rules('branch_employee_code', 'Branch Employee Code', 'trim|required|xss_clean');
                // $this->form_validation->set_rules('from_role', 'From Role', 'trim|xss_clean');
                // $this->form_validation->set_rules('to_role', 'To Role', 'trim|xss_clean');
                // $this->form_validation->set_rules('transfer_date', 'Transfer Date', 'trim|xss_clean');
                
                // Run validation
                if ($this->form_validation->run() === false) {
                    $array_error = array_map(function ($val) {
                        return str_replace(array("\r", "\n"), '', strip_tags($val));
                    }, array_filter(explode(".", trim(strip_tags(validation_errors())))));
        
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Error in form submission',
                        'errors' => $array_error
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                } else {
                    // Get data from the form
                    $id = $this->input->post('id');
                    $data['user_id'] = $this->input->post('user_id');
                    $data['branch_id'] = $this->input->post('branch_id');
                    $data['status'] = $this->input->post('status');
        
                    // Perform the update operation
                    $res = $this->User_branch_link_model->update($data, $id);
        
                    if ($res) {
                        // Update successful
                        $final = array();
                        $final['status'] = true;
                        $final['data'] = $this->User_branch_link_model->get($id);
                        $final['message'] = 'User Branch Link updated successfully.';
                        $this->response($final, REST_Controller::HTTP_OK);
                    } else {
                        // Update failed
                        $this->response([
                            'status' => FALSE,
                            'message' => 'There was a problem updating User Branch Link. Please try again',
                            'errors' => [$this->db->error()]
                        ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                    }
                }
            }
        
            
    }

    public function user_post($params='') {
        if($params == 'add') {
          
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
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);
            // print_r($_POST);
            // exit();
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
            $this->form_validation->set_rules('mobile', 'Mobile','trim|required|xss_clean|alpha_numeric_spaces|is_unique[users.mobile]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
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
                $userData = array(
                    'first_name' => $this->input->post('first_name', TRUE),
                    'last_name' => $this->input->post('last_name', TRUE),
                    'password' => password_hash($this->input->post('password',TRUE),PASSWORD_DEFAULT),
                    // 'gender' => $this->input->post('gender', TRUE),
                    'user_type' => $this->input->post('user_type', TRUE),
                    'dob' => $this->input->post('dob', TRUE),
                    'mobile' => $this->input->post('mobile', TRUE),
                    'alt_mobile' => $this->input->post('alt_mobile', TRUE),
                    'employee_code' => $this->Internal_model->GenerateEmployeeCode(),
                    'status' => 'Active',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                );
                $userId = $this->user_model->create_user($userData);
                if(!empty($userId) && ($userId)>0){
                $data = array(
                    'users_id' => $userId,
                    'first_name' => $this->input->post('first_name', TRUE),
                    'last_name' => $this->input->post('last_name', TRUE),
                    'gender' => $this->input->post('gender', TRUE),
                    'user_type' => $this->input->post('user_type', TRUE),
                    'dob' => $this->input->post('dob', TRUE),
                    'mobile' => $this->input->post('mobile', TRUE),
                    'alt_mobile' => $this->input->post('alt_mobile', TRUE),
                    'password' => $this->input->post('password', TRUE),
                    'status' => 'Active',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                );
                if(!empty($_POST['resume'])){
					$base64_image = $_POST['resume'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 
					$data['resume'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}
                if(!empty($_POST['passport_photo'])){
					$base64_image = $_POST['passport_photo'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 
					$data['passport_photo'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
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
					$uploadFolder = 'employee'; 
					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}
                if(!empty($_POST['aadhar_front'])){
					$base64_image = $_POST['aadhar_front'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['aadhar_front'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}
                if(!empty($_POST['aadhar_back'])){
					$base64_image = $_POST['aadhar_back'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['aadhar_back'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
				}
                if(!empty($_POST['case_file'])){
					$base64_image = $_POST['case_file'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
				}


                if ($res = $this->Employee_joining_model->create($data)) {
                    // Employee creation successful
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->Employee_joining_model->get($res);
                    $final['message'] = 'Employee Joined created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // Employee creation failed
                    $this->response([
                        'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }else{
                $this->response([
                'status' => FALSE,
                'message' =>'Error in submit form',
                'errors' =>[$this->db->error()]
                ], REST_Controller::HTTP_BAD_REQUEST,'','error');
            }
            }
        }

        if ($params == 'update') {
            // ini_set('display_errors',1);
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
            }
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|xss_clean');
            
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
                // Set variables from the form
                $id = $this->input->post('id');
                $users_id = $this->input->post('users_id');
                
                $userData = array(
                    'first_name' => $this->input->post('first_name', TRUE),
                    'password' => password_hash($this->input->post('password',TRUE),PASSWORD_DEFAULT),
                    'gender' => $this->input->post('gender', TRUE),
                    'user_type' => $this->input->post('user_type', TRUE),
                    'dob' => $this->input->post('dob', TRUE),
                    'mobile' => $this->input->post('mobile', TRUE),
                    'alt_mobile' => $this->input->post('alt_mobile', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'employee_status' => $this->input->post('employee_status', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                );
                    $userId = $this->user_model->update($userData,$users_id);
                
                    $data = array(
                    'users_id' => $users_id,
                    'first_name' => $this->input->post('first_name', TRUE),
                    'last_name' => $this->input->post('last_name', TRUE),
                    'user_type' => $this->input->post('user_type', TRUE),
                    'dob' => $this->input->post('dob', TRUE),
                    'mobile' => $this->input->post('mobile', TRUE),
                    'alt_mobile' => $this->input->post('alt_mobile', TRUE),
                    'password' => password_hash($this->input->post('password',TRUE),PASSWORD_DEFAULT),
                    'status' => $this->input->post('status', TRUE),
                    'employee_status' => $this->input->post('employee_status', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                );
               
				if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('user_profile',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->image;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
                if(!empty($_POST['resume'])){
					$base64_image = $_POST['resume'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 
					$data['resume'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
                    $imgData = $this->db->get_where('user_profile',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->resume;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
                }
                if(!empty($_POST['passport_photo'])){
					$base64_image = $_POST['passport_photo'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 
					$data['passport_photo'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
                    $imgData = $this->db->get_where('user_profile',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->passport_photo;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
                }
                if(!empty($_POST['aadhar_front'])){
					$base64_image = $_POST['aadhar_front'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['aadhar_front'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
                    $imgData = $this->db->get_where('user_profile',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->aadhar_front;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
                }
                if(!empty($_POST['aadhar_back'])){
					$base64_image = $_POST['aadhar_back'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['aadhar_back'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);	
                    $imgData = $this->db->get_where('user_profile',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->aadhar_back;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
                }
                if(!empty($_POST['case_file'])){
					$base64_image = $_POST['case_file'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'employee'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('user_profile',array('users_id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->case_file;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
                // Get the ID from the request
               // $id = $this->input->post('users_id');
        
                // Perform the update operation
                $res = $this->Employee_joining_model->update($data, $id);
        
                if ($res) {
                    // Employee update successful
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->Employee_joining_model->get($id);
                    $final['message'] = 'Employee updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // Employee update failed
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating employee. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }
    
}   
    

