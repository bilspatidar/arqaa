<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Services extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('services_model');
        $this->load->helper('security');

    }

    //services start
    public function services_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->services_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->services_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Services fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function services_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $data =  $this->services_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Services fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function services_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('category_id', 'Category', 'trim|required|integer');
            $this->form_validation->set_rules('subcategory_id', 'SubCategory', 'trim|required|integer');

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
                $image_base64 = (empty($_POST['image_base64']) || !is_array($_POST['image_base64'])) 
                ? '[]' 
                : json_encode($_POST['image_base64']); // Save the array as JSON              
                $data['description'] = $this->input->post('description',TRUE);
                $data['amount'] = $this->input->post('amount',TRUE);
                $data['category_id'] = $this->input->post('category_id', TRUE);
                $data['subcategory_id'] = $this->input->post('subcategory_id', TRUE);
                $data['currency'] = $this->input->post('currency', TRUE);
                $data['image_base64'] = $image_base64;
                $data['country_id'] = $session_id;	
				$data['status'] = 'Active';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;

                
                if ($res = $this->services_model->create($data)) {
                    // services creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->services_model->get($res);
                    $final['message'] = 'Services created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // services creation failed, this should never happen
                    $this->response([ 'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }

        if ($params == 'update') {
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
            $id = $this->input->post('id',TRUE);
            // set validation rules
            $this->form_validation->set_rules('title', 'Services Title','trim|required|xss_clean|alpha_numeric_spaces|edit_unique[services.title.id.'.$id.']');
            $this->form_validation->set_rules('status', 'Status', 'trim');
            $this->form_validation->set_rules('category_id', 'Category', 'trim|required|integer');
            $this->form_validation->set_rules('subcategory_id', 'SubCategory', 'trim|required|integer');
        
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
                $data['description'] = $this->input->post('description',TRUE);
                $data['title'] = $this->input->post('title',TRUE);
                $data['status'] = $this->input->post('status',TRUE);
                $data['category_id'] = $this->input->post('category_id', TRUE);
                $data['subcategory_id'] = $this->input->post('subcategory_id', TRUE);
                $data['updated'] = date('Y-m-d H:i:s');
                $data['updatedBy'] = $session_id;
                if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'services'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
					$imgData = $this->db->get_where('services',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->image;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
                $res = $this->services_model->update($data, $id);
        
                if ($res) {
                    // services update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->services_model->get($id);
                    $final['message'] = 'Services updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    //  Services update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Services. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function services_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->services_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Services deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    
    public function all_services_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
        
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->services_model->get_all_services('yes', $id, $limit, $offset, $filterData);
        $data =  $this->services_model->get_all_services('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'All Services fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    
    //  services end

    public function service_status_post($params = '') {
        if ($params == 'add') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin', 'company', 'freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            // Set validation rules
            $this->form_validation->set_rules('service_id', 'Service ID', 'trim|required|integer');
            $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[Accepted,Ongoing,Rejected,Finished]');
    
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
                $data['service_id'] = $this->input->post('service_id', TRUE);
                $data['status'] = $this->input->post('status', TRUE);
                // $data['remarks'] = $this->input->post('remarks', TRUE);
                $data['added_by'] = $session_id;
                $data['added'] = date('Y-m-d H:i:s');
    
                if ($res = $this->services_model->create_service_status($data)) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->services_model->get_service_status($res);
                    $final['message'] = 'Service status created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Error in submit form',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }
    
    public function service_status_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        // Extract 'service_id' from request body
        $service_id = isset($request_data['service_id']) ? $request_data['service_id'] : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        // Verify the token and check authorization
        $getTokenData = $this->is_authorized(array('superadmin', 'admin', 'company', 'freelancer'));
        $offset = ($page - 1) * $limit;
    
        // Fetch total records count
        $totalRecords = $this->services_model->get_service_status('yes', 0, $service_id, $limit, $offset, $filterData);
    
        // Fetch the actual data
        $data = $this->services_model->get_service_status('no', 0, $service_id, $limit, $offset, $filterData);
    
        // Calculate total pages
        $totalPages = ceil($totalRecords / $limit);
    
        // Prepare the response
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Service status fetched successfully.'
        ];
    
        // Send the response
        $this->response($response, REST_Controller::HTTP_OK);
    }
    
}
