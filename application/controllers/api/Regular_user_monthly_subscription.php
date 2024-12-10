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
    
    // public function regular_user_monthly_subscription_details_get(){
    //     $id = $this->input->get('id') ? $this->input->get('id') : 0;
    //     $getTokenData = $this->is_authorized('superadmin');
    //     $data =  $this->regular_user_monthly_subscription_model->show($id);
    //     $response = [
    //         'status' => true,
    //         'data' => $data,
    //         'message' => 'Suscripción Mensual Usuarios Regular fetched successfully.'
    //     ];
    //     $this->response($response, REST_Controller::HTTP_OK); 
    // }

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
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','Freelancer'));
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
                $data['currency'] = $this->input->post('currency',TRUE);
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
        $tokenData = $this->is_authorized();  // Get user details from token
        $user_id = $tokenData['data']['id'];

        $days = $this->input->post('days');  // Array of days
        $from_time = $this->input->post('from_time');
        $to_time = $this->input->post('to_time');
        $status = $this->input->post('status') ? $this->input->post('status') : 'Active';  // Default to 'Active'

        if (!is_array($days)) {
            $this->response(['status' => FALSE, 'message' => 'Days must be an array'], REST_Controller::HTTP_BAD_REQUEST);
        }

        foreach ($days as $day) {
            $data = [
                'user_id' => $user_id,
                'day' => $day,
                'from_time' => $from_time,
                'to_time' => $to_time,
                'status' => $status
            ];

            // Add business hour for each day
            $this->business_hrs_model->add($data);
        }

        $this->response(['status' => TRUE, 'message' => 'Business hours added successfully.'], REST_Controller::HTTP_OK);
    }

    // Update Business Hours for Regular User
    public function business_hours_update_post() {
        $tokenData = $this->is_authorized();  // Get user details from token
        $user_id = $tokenData['data']['id'];

        $id = $this->input->post('id');
        $day = $this->input->post('day');
        $from_time = $this->input->post('from_time');
        $to_time = $this->input->post('to_time');
        $status = $this->input->post('status') ? $this->input->post('status') : 'Active';

        // Check if the record exists
        $existing_data = $this->business_hrs_model->get_by_id($id);
        if (!$existing_data || $existing_data->user_id != $user_id) {
            $this->response(['status' => FALSE, 'message' => 'Business hour not found or unauthorized access'], REST_Controller::HTTP_BAD_REQUEST);
        }

        $data = [
            'day' => $day,
            'from_time' => $from_time,
            'to_time' => $to_time,
            'status' => $status
        ];

        // Update the business hours
        $this->business_hrs_model->update($id, $data);

        $this->response(['status' => TRUE, 'message' => 'Business hours updated successfully.'], REST_Controller::HTTP_OK);
    }

    public function business_hours_get() {
        // Load the Business Hours model if you haven't already
        $this->load->model('business_hrs_model');
        
        // Get pagination parameters from the query string
        $page = $this->get('page') ? $this->get('page') : 1; // Default to page 1
        $limit = $this->get('limit') ? $this->get('limit') : 10; // Default limit to 10
        $offset = ($page - 1) * $limit;
        
        // Get business hours for the logged-in user (you may need to adjust this based on your use case)
        $tokenData = $this->is_authorized(); // Get user details from token
        $user_id = $tokenData['data']['id'];
    
        // Get all business hours for the user with pagination
        $businessHoursData = $this->business_hrs_model->get_business_hours($user_id, $limit, $offset);
        
        // Prepare response
        $data = $businessHoursData['data'];
        $totalRecords = $businessHoursData['totalRecords'];
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

    public function user_purchasing_post($params = '') {
        if ($params == 'add') {
            // Ensure token is valid
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            // Get data from form-data (multipart)
            $_POST = $this->input->post();
    
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
                $files = !empty($_POST['files']) ? json_decode($_POST['files'], true) : [];
    
                // Prepare data for insertion into the database
                $data = [
                    'amount' => $this->input->post('amount', TRUE),
                    'details' => $this->input->post('details', TRUE),
                    'transaction_id' => $this->input->post('transaction_id', TRUE),
                    'files' => !empty($files) ? json_encode($files) : json_encode([]),  // Ensure files is never null
                    'status' => 'Pending',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                ];
    
                // Insert the data using model
                if ($res = $this->user_purchasing_model->create($data)) {
                    $final = [
                        'status' => true,
                        'data' => $this->user_purchasing_model->get($res),
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
    

    public function boost_profile_data_post($params = '') {
        if ($params == 'add') {
            // Ensure token is valid
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
        
            // Get data from form-data (multipart)
            $_POST = $this->input->post();
        
            // Set validation rules
            $this->form_validation->set_rules('position', 'Position', 'trim|required');
            $this->form_validation->set_rules('service_id', 'Service ID', 'trim|required|numeric');
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
                    'position' => $this->input->post('position', TRUE),
                    'service_id' => $this->input->post('service_id', TRUE),
                    'amount' => $this->input->post('amount', TRUE),
                    'transaction_id' => $this->input->post('transaction_id', TRUE),
                    'status' => 'Pending',
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
    
    public function cv_resume_data_post($params = '') {
        if ($params == 'add') {
            // Ensure token is valid
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            // Get data from form-data (multipart)
            $_POST = $this->input->post();
    
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
                $files = !empty($_POST['files']) ? json_encode($_POST['files']) : '';

                  // Prepare data for insertion into the database
                $data = [
                  'amount' => $this->input->post('amount', TRUE),
                   'details' => $this->input->post('details', TRUE),
                   'transaction_id' => $this->input->post('transaction_id', TRUE),
                   'files' => $files,   // Store files as a JSON string or text string
                   'status' => 'Pending',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
];
    
                // Insert the data using model
                if ($res = $this->user_purchasing_model->create_cv_resume_data($data)) {
                    $final = [
                        'status' => true,
                        'data' => $this->user_purchasing_model->get_cv_resume_data($res),
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


    public function multiple_service_data_post($params = '') {
        if ($params == 'add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            $_POST = $this->input->post();
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
                    'status' => 'Pending',
                    'is_used' => $this->input->post('is_used', TRUE) ?: 0,
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
    
    
    
       
}
