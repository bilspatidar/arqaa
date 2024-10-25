<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Document_upload extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('Document_upload_model');
        $this->load->helper('security');
    
    }

    //document_upload start
   
    public function document_upload_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->Document_upload_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->Document_upload_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Document_upload fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function document_upload_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->Document_upload_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Document_upload fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function document_upload_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
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
                    $data['users_id'] = $this->input->post('users_id',TRUE);
                    $data['title'] = $this->input->post('title',TRUE);
                    $data['document_category_id'] = $this->input->post('document_category_id',TRUE);
                    $data['document_sub_category_id'] = $this->input->post('document_sub_category_id',TRUE);
                    $data['document_number'] = $this->input->post('document_number',TRUE);
                    $data['status'] = 'Active';
                    $data['added'] = date('Y-m-d H:i:s');
                    $data['added_by'] = $session_id;
                    if(!empty($_POST['document_front_file'])) {
                        $base64_image = $_POST['document_front_file'];
                        $quality = 90;
                        $radioConfig = [
                            'resize' => [
                                'width' => 500,
                                'height' => 300
                            ]
                        ];
                        $uploadFolder = 'document_upload'; 
                        $data['document_front_file'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
                         }
                if(!empty($_POST['document_back_file'])){
                        $base64_image = $_POST['document_back_file'];
                        $quality = 90;
                        $radioConfig = [
                            'resize' => [
                            'width' => 500,
                            'height' => 300
                            ]
                         ];
                        $uploadFolder = 'document_upload'; 
                        $data['document_back_file'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
                       }
                

                if ($res = $this->Document_upload_model->create($data)) {
                    // document_category creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->Document_upload_model->get($res);
                    $final['message'] = 'Document upload created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // document_category creation failed, this should never happen
                    $this->response([ 'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
                }
            }
        }
        if ($params == 'add111') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
        print_r($_POST);
        exit();
            if (!empty($_POST)) {
                if (!isset($_POST['users_id'])) {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Error in form submission',
                        'errors' => 'User field is missing'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                    return;
                }
        
                // Retrieve POST data for multiple users
                $user_ids = $_POST['users_id'];
                $titles = $_POST['title'];
                $documentCategoryId = $_POST['document_category_id'];
                $documentSubCategory_id = $_POST['document_sub_category_id'];
                $document_numbers = $_POST['document_number'];
                $ids = $_POST['id'];
        
                // Check if user_id field is not empty
                if (empty($user_ids)) {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Error in form submission',
                        'errors' => 'IDs field is missing or empty'
                    ], REST_Controller::HTTP_BAD_REQUEST);
                    return;
                }
        
                // Loop through each user data and perform update or insert
                $created_documents = [];
                foreach ($user_ids as $key => $user_id) {
                    // Retrieve data for specific user
                    $ID = $ids[$key];
                    $title = $titles[$key];
                    $document_category_id = $documentCategoryId[$key];
                    $document_sub_category_id = $documentSubCategory_id[$key];
                    $document_number = $document_numbers[$key];
        
                    // Check if documents record exists for the given date and user
                    $documents_check = $this->db->get_where('documents', array('users_id' => $user_id))->result();
       
                    if (count($documents_check) > 0) {
                        // Update the existing record
                        $updatedata = array(
                            'user_id' => $user_id,
                            'title' => $title,
                            'document_category_id' => $document_category_id,
                            'document_sub_category_id' => $document_sub_category_id,
                            'document_number' => $document_number,
                            'updated' => date('Y-m-d H:i:s'),
                            'updated_by' => $session_id
                        );
        
                        if (!$this->Document_upload_model->update($updatedata, $ID)) {
                            $this->response([
                                'status' => FALSE,
                                'message' => 'Error in form submission',
                                'errors' => 'Failed to update data in the database'
                            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                            return;
                        }
                    } else {
                        // Insert a new record
                        $insertdata = array(
                            'user_id' => $user_id,
                            'status' => $status,
                            'remarks' => $remark,
                            'latitude' => $latitude,
                            'longitude' => $longitude,
                            'date' => $date,
                            'created' => date('Y-m-d H:i:s'),
                            'created_by' => $session_id
                        );
        
                        if (!$this->Document_upload_model->create($insertdata)) {
                            $this->response([
                                'status' => FALSE,
                                'message' => 'Error in form submission',
                                'errors' => 'Failed to insert data into the database'
                            ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                            return;
                        }
                    }
        
                    // Add data to created_documents array
                    $created_documents[] = $insertdata;
                }
        
                $this->response([
                    'status' => TRUE,
                    'message' => 'documents updated successfully.',
                    'data' => $created_documents
                ], REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'No data received',
                    'errors' => 'No data received from the form'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        if ($params == 'upload') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
        
            // set validation rules
            $this->form_validation->set_rules('users_id', 'User Name', 'trim|required|xss_clean');
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
				$users_id = $this->input->post('users_id',TRUE);
                $data['users_id'] = $users_id;
				$data['document_category_id'] = $this->input->post('document_category_id',TRUE);
                	if(!empty($_POST['document_front_file'])) {
					$base64_image = $_POST['document_front_file'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
							'width' => 500,
							'height' => 300
						]
					];
					$uploadFolder = 'document_upload'; 
					$data['document_front_file'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('documents',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->document_front_file;
						if(file_exists($img) && !empty($img)){
							unlink($img);		
						}
					}
				}
			if(!empty($_POST['document_back_file'])){
					$base64_image = $_POST['document_back_file'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'document_upload'; 
					$data['document_back_file'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('documents',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->document_back_file;
						if(file_exists($img) && !empty($img)){
							unlink($img);		
						}
					}
				}
				
               
                $res = $this->Document_upload_model->upload($data, $users_id);
        
                if ($res) {
                    // document_upload update ok
                    $final = array();
                    $final['status'] = true;
                    // $final['data'] = $this->Document_upload_model->get($id);
                    $final['message'] = 'Document Upload updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // document_upload update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating document_upload. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        if ($params == 'update') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
        
            // set validation rules
            $this->form_validation->set_rules('users_id', 'User Name', 'trim|required|xss_clean');
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
				$users_id = $this->input->post('users_id',TRUE);
                $data['users_id'] = $users_id;
				$data['document_category_id'] = $this->input->post('document_category_id',TRUE);
                	if(!empty($_POST['document_front_file'])) {
					$base64_image = $_POST['document_front_file'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
							'width' => 500,
							'height' => 300
						]
					];
					$uploadFolder = 'document_upload'; 
					$data['document_front_file'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('documents',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->document_front_file;
						if(file_exists($img) && !empty($img)){
							unlink($img);		
						}
					}
				}
			if(!empty($_POST['document_back_file'])){
					$base64_image = $_POST['document_back_file'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'document_upload'; 
					$data['document_back_file'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('documents',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->document_back_file;
						if(file_exists($img) && !empty($img)){
							unlink($img);		
						}
					}
				}
				
               
                $res = $this->Document_upload_model->update($data, $users_id);
        
                if ($res) {
                    // document_upload update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->Document_upload_model->get($id);
                    $final['message'] = 'Document Upload updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // document_upload update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating document_upload. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function document_upload_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->Document_upload_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Document deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // document_upload end
}
