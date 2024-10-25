<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class About extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('about_model');
        $this->load->helper('security');
    }

    // about start
    public function about_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
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
        }elseif($user_type == 'manager'){
            $getTokenData = $this->is_authorized('manager');
        }
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->about_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->about_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'About fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function about_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->about_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'About fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function about_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean|alpha_numeric_spaces');
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
                    $id = $this->input->post('id',TRUE);
                    $data['title'] = $this->input->post('title',TRUE);
                    $data['description'] = $this->input->post('description',TRUE);
				if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'about'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
				}	
				// $data['status'] = 'Active';
                // $data['added'] = date('Y-m-d H:i:s');
                // $data['addedBy'] = $session_id;
                $checkabout = $this->about_model->check_about_data($id);
                if($checkabout->num_rows()>0){
                    $res = $this->about_model->update($data, $id);
                    if ($res) {
                        $final = array();
                        $final['status'] = true;
                        $final['data'] = $this->about_model->get($id);
                        $final['message'] = 'About updated successfully.';
                        $this->response($final, REST_Controller::HTTP_OK);
                    } else {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'There was a problem updating about. Please try again',
                            'errors' => [$this->db->error()]
                        ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                    }
                }else{
                    if ($res = $this->about_model->create($data)) {
                        $final = array();
                        $final['status'] = true;
                        $final['data'] = $this->about_model->get($res);
                        $final['message'] = 'About created successfully.';
                        $this->response($final, REST_Controller::HTTP_OK); 
                    } else {
                        $this->response([ 'status' => FALSE,
                            'message' =>'Error in submit form',
                            'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
                    }
                }
            }
        }

        if ($params == 'update') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
        
            // set validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('category_id', 'Category', 'trim|required|xss_clean|numeric');
            $this->form_validation->set_rules('status', 'Status', 'trim|xss_clean|alpha');
        
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
				$id = $this->input->post('id');
                $category_id = $this->input->post('category_id',TRUE);
                if (!empty($category_id)) {
                    $data['category_id'] = $category_id;
                }
				$title = $this->input->post('title',TRUE);
                if (!empty($title)) {
                    $data['title'] = $title;
                }
				$description = $this->input->post('description',TRUE);
                if (!empty($description)) {
                    $data['description'] = $description;
                }
				$status = $this->input->post('status',TRUE);
                if (!empty($status)) {
                    $data['status'] = $status;
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
					$uploadFolder = 'about'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
					$imgData = $this->db->get_where('about',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->image;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
				
                $data['updatedBy'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
                
                $res = $this->about_model->update($data, $id);
        
                if ($res) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->about_model->get($id);
                    $final['message'] = 'About updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating about. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function about_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->about_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'About deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // About end
}
