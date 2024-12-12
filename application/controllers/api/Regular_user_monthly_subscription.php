<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Regular_user_monthly_subscription extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('regular_user_monthly_subscription_model');
        $this->load->model('business_hrs_model');
        $this->load->model('user_purchasing_model');  
        $this->load->helper('security');
    }

    
    public function regular_user_monthly_subscription_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->regular_user_monthly_subscription_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->regular_user_monthly_subscription_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Suscripción Mensual Usuarios Regular fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    

    public function regular_user_monthly_subscription_details_get() {
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $sub_type = $this->input->get('sub_type') ? $this->input->get('sub_type') : '';
    
        // Authorization check
        $getTokenData = $this->is_authorized('superadmin');
    
        // Fetch data based on id or sub_type
        if (!empty($id)) {
            $data = $this->regular_user_monthly_subscription_model->show($id);
        } elseif (!empty($sub_type)) {
            $data = $this->regular_user_monthly_subscription_model->get_by_sub_type($sub_type);
        } else {
            $data = [];
        }
    
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Suscripcion Mensual Usuarios Regular fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK);
    }
    


    public function regular_user_monthly_subscription_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('concept', 'concept', 'trim|required');
            $this->form_validation->set_rules('price', 'price', 'trim|required');
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
                $data['concept'] = $this->input->post('concept',TRUE);
                $data['price'] = $this->input->post('price',TRUE);
                $data['currency'] = $this->Common->get_user_currency($session_id);
                $data['sub_type'] = $this->input->post('sub_type',TRUE);
                $data['tax'] = $this->input->post('tax',TRUE);
                $data['country'] = $this->Common->get_user_country($session_id);

                if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'regular_user_monthly_subscription'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
				}
				$data['status'] = 'Active';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;

                if ($res = $this->regular_user_monthly_subscription_model->create($data)) {
                    // creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->regular_user_monthly_subscription_model->get($res);
                    $final['message'] = 'Suscripción Mensual Usuarios Regular created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // creation failed, this should never happen
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
            $this->form_validation->set_rules('concept', 'concept', 'trim|required|xss_clean|alpha_numeric_spaces');
        
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
                $data['concept'] = $this->input->post('concept',TRUE);
                $data['price'] = $this->input->post('price',TRUE);
                $data['currency'] = $this->input->post('currency',TRUE);
                $data['sub_type'] = $this->input->post('sub_type',TRUE);
				$data['status'] = $this->input->post('status',TRUE);

                if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'regular_user_monthly_subscription'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
					$imgData = $this->db->get_where('regular_user_monthly_subscription',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->image;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
                $res = $this->regular_user_monthly_subscription_model->update($data, $id);
        
                if ($res) {
                    // update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->regular_user_monthly_subscription_model->get($id);
                    $final['message'] = 'Suscripción Mensual Usuarios Regular updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Suscripción Mensual Usuarios Regular. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function regular_user_monthly_subscription_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->regular_user_monthly_subscription_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Suscripción Mensual Usuarios Regular deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // Suscripción Mensual Usuarios Regular end

    public function languages_get() {
        // Load the Language model if you haven't already
        $this->load->model('language_model');
    
        // Get pagination parameters from the query string
        $page = $this->get('page') ? $this->get('page') : 1; // Default to page 1
        $limit = $this->get('limit') ? $this->get('limit') : 10; // Default limit to 10
        $offset = ($page - 1) * $limit;
    
        // Get all countries with their languages
        $languagesData = $this->language_model->get_all_languages($limit, $offset);
    
        // Prepare response
        $data = $languagesData['data'];
        $totalRecords = $languagesData['totalRecords'];
        $totalPages = ceil($totalRecords / $limit);
    
        if ($data) {
            $response = [
                'status' => true,
                'data' => $data,
                'pagination' => [
                    'page' => $page,
                    'totalPages' => $totalPages,
                    'totalRecords' => $totalRecords
                ],
                'message' => 'Countries and their languages fetched successfully.'
            ];
            $this->response($response, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No languages found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
    
     // Add Business Hours for Regular User
    public function business_hours_add_post() {
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));  // Get user details from token
        $usersData = json_decode(json_encode($getTokenData), true);
        $user_id = $usersData['data']['id'];
        $_POST = json_decode($this->input->raw_input_stream, true);


        $days = $_POST['days'];  // Array of days
        $from_time = $_POST['from_time'];
        $to_time = $_POST['to_time'];
        $status = $_POST['status'] ? $_POST['status'] : 'Active';  // Default to 'Active'

        if (!is_array($days)) {
            $this->response(['status' => FALSE, 'message' => 'Days must be an array'], REST_Controller::HTTP_BAD_REQUEST);
        }
        foreach ($days as $day) {
            $data = [
                'user_id' => $user_id,
                'day' => $day['day'],
                'from_time' => $day['from_time'],
                'to_time' => $day['to_time'],
                'status' => $day['status']
            ];
            
            //$this->db->insert('business_hrs',$data);

            // Add business hour for each day
           $this->business_hrs_model->add($data);
        }

                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $days;//$this->category_model->get($res);
                    $final['message'] = 'Business hours added successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
    }

   

    public function business_hours_get() {
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer')); // Get user details from token
        $usersData = json_decode(json_encode($getTokenData), true);
        $user_id = $usersData['data']['id'];
    
        $businessHoursData = $this->business_hrs_model->get_business_hours($user_id, $limit, $offset);
        
        // Prepare response
        $data = $businessHoursData['data'];
       
        
        if ($data) {
            $response = [
                'status' => true,
                'data' => $data,
                'message' => 'Business hours fetched successfully.'
            ];
            $this->response($response, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No business hours found.'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function advertisement_data_post($params = '') {
        if ($params == 'add') {
            // Ensure token is valid
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            // Get data from form-data (multipart)
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            // Set validation rules
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('details', 'Details', 'trim|required');
    
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
                $files = (empty($_POST['files']) || !is_array($_POST['files'])) ? '[]' : json_encode($_POST['files']);
    
                // Prepare data for insertion into the database
                $data = [
                    'amount' => $this->input->post('amount', TRUE),
                    'currency' => $this->input->post('currency', TRUE),
                    'details' => $this->input->post('details', TRUE),
                    'subscription_id' => $this->input->post('subscription_id', TRUE),
                    'transaction_id' => $this->input->post('transaction_id', TRUE),
                    'files' => $files,  // Ensure files is never null
                    'status' => 'Completed',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                ];
    
                // Insert the data using model
                if ($res = $this->user_purchasing_model->create($data)) {
                    $final = [
                        'status' => true,
                        'data' =>$this->user_purchasing_model->get($res),
                        'message' => 'User purchasing record created successfully.'
                    ];
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
    
    public function advertisement_data_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->user_purchasing_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->user_purchasing_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'User purchshasing fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function boost_profile_data_post($params = '') {
        if ($params == 'add') {
            // Ensure token is valid
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
        
            // Get data from form-data (multipart)
            $_POST = json_decode($this->input->raw_input_stream, true);
        
            // Set validation rules
            $this->form_validation->set_rules('currency', 'Currency', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('transaction_id', 'Transaction ID', 'trim|required');
        
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
                // Prepare data for insertion into the database
                $data = [
                    'currency' => $this->input->post('currency', TRUE),
                    'subscription_id' => $this->input->post('subscription_id', TRUE),
                    'amount' => $this->input->post('amount', TRUE),
                    'transaction_id' => $this->input->post('transaction_id', TRUE),
                    "details" => $this->input->post('details', TRUE),
                    'status' => 'Completed',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id,
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                ];
        
                // Insert the data using model
                if ($res = $this->user_purchasing_model-> create_boost_profile_data($data)) {
                    $final = [
                        'status' => true,
                        'data' => $this->user_purchasing_model->get_boost_profile_data($res),
                        'message' => 'Boost profile data created successfully.'
                    ];
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

    public function boost_profile_data_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->user_purchasing_model->get_boost_profile_data('yes', $id, $limit, $offset, $filterData);
        $data =  $this->user_purchasing_model->get_boost_profile_data('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Boost profile data fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }


    
    public function cv_resume_data_post($params = '') {
        if ($params == 'add') {
            // Ensure token is valid
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            // Get data from form-data (multipart)
             $_POST = json_decode($this->input->raw_input_stream, true);
    
            // Set validation rules
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('details', 'Details', 'trim|required');
    
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
                // Decode files JSON string into array, or set an empty array if no files are provided
                if(!empty($_POST['file'])){
					$base64_image = $_POST['file'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => "100%",
						'height' => "100%"
						]
					 ];
					$uploadFolder = 'category'; 
					$data['file'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
				}

                  // Prepare data for insertion into the database
                $data = [
                   'amount' => $this->input->post('amount', TRUE),
                   'subscription_id' => $this->input->post('subscription_id', TRUE),
                   'currency' => $this->input->post('currency', TRUE),
                   'details' => $this->input->post('details', TRUE),
                   'transaction_id' => $this->input->post('transaction_id', TRUE),
                   'status' => 'Completed',
                   'added' => date('Y-m-d H:i:s'),
                   'addedBy' => $session_id,
                   'file_base64' => $_POST['file']
                    ];
                // Insert the data using model
                if ($res = $this->user_purchasing_model->create_cv_resume_data($data)) {
                    $final = [
                        'status' => true,
                        'data' => $this->user_purchasing_model->get_cv_resume_data($res),
                        'message' => 'Cv resume data record created successfully.'
                    ];
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

    public function cv_resume_data_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->user_purchasing_model->get_cv_resume_data('yes', $id, $limit, $offset, $filterData);
        $data =  $this->user_purchasing_model->get_cv_resume_data('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Cv resume data fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function extra_service_data_post($params = '') {
        if ($params == 'add') {
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            $_POST = json_decode($this->input->raw_input_stream, true);
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('details', 'Details', 'trim|required');
    
            if ($this->form_validation->run() === false) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error in submit form',
                    'errors' => array_filter(explode("\n", strip_tags(validation_errors())))
                ], REST_Controller::HTTP_BAD_REQUEST);
            } else {
                $data = [
                    'amount' => $this->input->post('amount', TRUE),
                    'details' => $this->input->post('details', TRUE),
                    'currency' => $this->input->post('currency', TRUE),
                    'status' => 'Completed',
                    'transaction_id' => $this->input->post('transaction_id', TRUE),
                    'subscription_id' => $this->input->post('subscription_id', TRUE),
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id,
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                ];
        
                if ($res = $this->user_purchasing_model->create_multiple_service_data($data)) {
                    $this->response([
                        'status' => TRUE,
                        'data' => $this->user_purchasing_model->get_multiple_service_data($res),
                        'message' => 'Record created successfully.'
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Error in submit form',
                        'errors' => [
                            'database' => $this->db->error(),
                            'query' => $this->db->last_query()
                        ]
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }
    }
    
    
    public function extra_service_data_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->user_purchasing_model->get_multiple_sevice_data('yes', $id, $limit, $offset, $filterData);
        $data =  $this->user_purchasing_model->get_multiple_sevice_data('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Multiple service data fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
       
    public function review_rating_post($params = '') {
        if ($params == 'add') {
            // Authorize the user
            $getTokenData = $this->is_authorized(array('superadmin', 'admin', 'company', 'freelancer'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            // Get input data
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            // Form validation rules
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required|numeric');
            $this->form_validation->set_rules('service_id', 'Service ID', 'trim|required|numeric');
            $this->form_validation->set_rules('service_rating', 'Service Rating', 'trim|required|numeric|greater_than[0]|less_than_equal_to[5]');
            $this->form_validation->set_rules('time_rating', 'Time Rating', 'trim|required|numeric|greater_than[0]|less_than_equal_to[5]');
            $this->form_validation->set_rules('payment_rating', 'Payment Rating', 'trim|required|numeric|greater_than[0]|less_than_equal_to[5]');
            $this->form_validation->set_rules('review', 'Review', 'trim|required');
    
            if ($this->form_validation->run() === false) {
                // Validation errors
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error in submit form',
                    'errors' => array_filter(explode("\n", strip_tags(validation_errors())))
                ], REST_Controller::HTTP_BAD_REQUEST);
            } else {
                // Prepare data for insertion
                $data = [
                    'user_id' => $this->input->post('user_id', TRUE),
                    'service_id' => $this->input->post('service_id', TRUE),
                    'service_rating' => $this->input->post('service_rating', TRUE),
                    'time_rating' => $this->input->post('time_rating', TRUE),
                    'payment_rating' => $this->input->post('payment_rating', TRUE),
                    'review' => $this->input->post('review', TRUE),
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                ];
    
                // Insert data
                if ($res = $this->user_purchasing_model->create_review_rating($data)) {
                    $this->response([
                        'status' => TRUE,
                        'data' => $this->user_purchasing_model->get_review_rating($res),
                        'message' => 'Review and rating added successfully.'
                    ], REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Error in submit form',
                        'errors' => [
                            'database' => $this->db->error(),
                            'query' => $this->db->last_query()
                        ]
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }
    }
    
    public function review_rating_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->user_purchasing_model->get_review_rating('yes', $id, $limit, $offset, $filterData);
        $data =  $this->user_purchasing_model->get_review_rating('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Review rating fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
}
