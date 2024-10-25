<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Pages extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('pages_model');
		$this->load->helper("security");
    }

    public function pages_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->pages_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->pages_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Pages list fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function pages_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->pages_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Pages details fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function pages_post($params='') {
        if($params=='add') {	
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];

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
            
				$title = $this->input->post('title',TRUE);
                if (!empty($title)) {
                    $data['title'] = $title;
                }
				$description = $this->input->post('description',TRUE);
                if (!empty($description)) {
                    $data['description'] = $description;
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
					$uploadFolder = 'pages'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
				
				}
					
				$data['status'] = 'Active';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;

                if ($res = $this->pages_model->create($data)) {
                   
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->pages_model->get($res);
                    $final['message'] = 'Data created successfully.';
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
            $this->form_validation->set_rules('status', 'Status', 'trim|alpha');
            $this->form_validation->set_rules('contact_no', 'Contact no', 'trim|numeric');
            $this->form_validation->set_rules('alt_contact_no', 'Alternative Contact no', 'trim|numeric');
            $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        
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
				$id = $this->input->post('id',TRUE);
                $contact_no = $this->input->post('contact_no',TRUE);
                if (!empty($contact_no)) {
                    $data['contact_no'] = $contact_no;
                }
				$alt_contact_no = $this->input->post('alt_contact_no',TRUE);
                if (!empty($alt_contact_no)) {
                    $data['alt_contact_no'] = $alt_contact_no;
                }
				$email = $this->input->post('email',TRUE);
                if (!empty($email)) {
                    $data['email'] = $email;
                }
				$address1 = $this->input->post('address1',TRUE);
                if (!empty($address1)) {
                    $data['address1'] = $address1;
                }
				$address2 = $this->input->post('address2',TRUE);
                if (!empty($address2)) {
                    $data['address2'] = $address2;
                }
				$map_link = $this->input->post('map_link',TRUE);
                if (!empty($map_link)) {
                    $data['map_link'] = $map_link;
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
					$uploadFolder = 'pages'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
					$imgData = $this->db->get_where('pages',array('id'=>$id));
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
               
        
                if ($res = $this->pages_model->update($data, $id)) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->pages_model->get($id);
                    $final['message'] = 'Data updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
					$data['added'] = date('Y-m-d H:i:s');
					$data['addedBy'] = $session_id;
					if ($res = $this->pages_model->create($data)) {
						
						$final = array();
						$final['status'] = true;
						$final['data'] = $this->pages_model->get($res);
						$final['message'] = 'Data created successfully.';
						$this->response($final, REST_Controller::HTTP_OK); 
					} else {
						$this->response([ 'status' => FALSE,
							'message' =>'Error in submit form',
							'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
					}
                    
                }
            }
        }
        
    }

    public function pages_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->pages_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Data deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // Blog end
}
