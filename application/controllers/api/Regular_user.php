<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Regular_user extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('regular_user_model');
        $this->load->helper('security');
    }

    
    public function regular_user_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->regular_user_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->regular_user_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Regular User fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function regular_user_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->regular_user_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'regular user fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function regular_user_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('name', 'Username', 'trim|required|xss_clean|alpha_numeric|min_length[3]');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|is_unique[users.email]');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|xss_clean|min_length[10]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[6]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|min_length[6]|matches[password]');
		
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
                $data['last_name'] = $this->input->post('last_name',TRUE);
                $date_of_birth = $this->input->post('date_of_birth', TRUE);

                // अगर डेट पिकर से ली गई तारीख सही है तो उसे फॉर्मेट करें
                if ($date_of_birth) {
                    $formatted_date_of_birth = date('Y-m-d', strtotime($date_of_birth));
                    $data['date_of_birth'] = $formatted_date_of_birth;
                } else {
                    $data['date_of_birth'] = NULL; // अगर तारीख नहीं है तो NULL कर सकते हैं
                }
                                $data['country_id'] = $this->input->post('country_id',TRUE);
                $data['email'] = $this->input->post('email',TRUE);
                $data['state_id'] = $this->input->post('state_id',TRUE);
                $data['cologne'] = $this->input->post('cologne',TRUE);
                $data['street'] = $this->input->post('street',TRUE);
                $data['crossings'] = $this->input->post('crossings',TRUE);
                $data['external_number'] = $this->input->post('external_number',TRUE);
                $data['interior_number'] = $this->input->post('interior_number',TRUE);
                $data['zip_code'] = $this->input->post('zip_code',TRUE);
                $data['password'] = password_hash($this->input->post('password',TRUE),PASSWORD_DEFAULT);
                $data['confirm_password'] = $this->input->post('confirm_password',TRUE);
                $data['mobile'] = $this->input->post('mobile',TRUE);
                $data['user_type'] = $this->input->post('guy',TRUE);
                $radius = $this->input->post('radius', TRUE);
               $data['radius'] = (is_null($radius) || $radius === '') ? 0 : (int)$radius; // Ensure it's an integer


               $languages = $this->input->post('languages');
if (is_array($languages)) {
    $languages = implode(',', $languages);
} else {
    $languages = ''; // Handle the case where no languages are selected
}
$data['languages'] = $languages;

        $languages = $this->input->post('languages');
            if(!empty($languages)){
            $languages = implode(",",$languages);
            $data['languages'] = $languages;
            }
                
               // $data['image'] = $this->input->post('image',TRUE);
				if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radiusConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'regular_user'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radiusConfig, $uploadFolder);
					
				}
					
				$data['status'] = 'Active';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;

                if ($res = $this->regular_user_model->create($data)) {
                    // Regular User creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->regular_user_model->get($res);
                    $final['message'] = 'Regular User created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // Regular user creation failed, this should never happen
                    $this->response([ 'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }

        if ($params == 'update') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
        
            // set validation rules
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|alpha_numeric_spaces');
        
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
				$id = $this->input->post('id',TRUE);
                $data['name'] = $this->input->post('name',TRUE);
                $data['last_name'] = $this->input->post('last_name',TRUE);
                $date_of_birth = $this->input->post('date_of_birth', TRUE);

                // अगर डेट पिकर से ली गई तारीख सही है तो उसे फॉर्मेट करें
                if ($date_of_birth) {
                    $formatted_date_of_birth = date('Y-m-d', strtotime($date_of_birth));
                    $data['date_of_birth'] = $formatted_date_of_birth;
                } else {
                    $data['date_of_birth'] = NULL; // अगर तारीख नहीं है तो NULL कर सकते हैं
                }
                $data['country_id'] = $this->input->post('country_id',TRUE);
                $data['email'] = $this->input->post('email',TRUE);
                $data['state_id'] = $this->input->post('state_id',TRUE);
                $data['cologne'] = $this->input->post('cologne',TRUE);
                $data['street'] = $this->input->post('street',TRUE);
                $data['crossings'] = $this->input->post('crossings',TRUE);
                $data['external_number'] = $this->input->post('external_number',TRUE);
                $data['interior_number'] = $this->input->post('interior_number',TRUE);
                $data['zip_code'] = $this->input->post('zip_code',TRUE);
                $data['password'] = password_hash($this->input->post('password',TRUE),PASSWORD_DEFAULT);
                $data['confirm_password'] = $this->input->post('confirm_password',TRUE);
                $data['mobile'] = $this->input->post('mobile',TRUE);
                $data['guy'] = $this->input->post('guy',TRUE);
                $radius = $this->input->post('radius', TRUE);
                $data['radius'] = (is_null($radius) || $radius === '') ? 0 : (int)$radius; // Ensure it's an integer

                $languages = $this->input->post('languages');
if (is_array($languages)) {
    $languages = implode(",", $languages);
} else {
    $languages = ''; // Handle the case where no languages are selected
}
$data['languages'] = $languages;


				$status = $this->input->post('status',TRUE);
                if (!empty($status)) {
                    $data['status'] = $status;
                }
				
				///image 
				if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radiusConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'regular_user'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radiusConfig, $uploadFolder);
					
					$imgData = $this->db->get_where('regular_user',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->image;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
				////image  
                $data['updatedBy'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
                
                $res = $this->regular_user_model->update($data, $id);
        
                if ($res) {
                    // regular_user update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->regular_user_model->get($id);
                    $final['message'] = 'Regular user updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // regular_user update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating regular user. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function regular_user_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->regular_user_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'regular user deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // regular_user end
   
    
}
