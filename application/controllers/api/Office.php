<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Office extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('office_model');
        $this->load->helper('security');
    }

    public function department_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);

        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1;
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10;
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];

        $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
        $offset = ($page - 1) * $limit;

        $totalRecords = $this->office_model->get('yes', $id, $limit, $offset, $filterData);
        $data = $this->office_model->get('no', $id, $limit, $offset, $filterData);

        $totalPages = ceil($totalRecords / $limit);

        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Departments fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function department_details_get() {
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
        $data = $this->office_model->show($id);

        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Department fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function department_post($params = '') {
        if ($params == 'add') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            $this->form_validation->set_rules('name', 'Department Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('code', 'Department Code', 'trim|required|xss_clean|alpha_numeric_spaces');

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
                $data = [
                    'name' => $this->input->post('name', TRUE),
                    'code' => $this->input->post('code', TRUE),
                    'status' => 'Active',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                ];

                if ($res = $this->office_model->create($data)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->get($res),
                        'message' => 'Department created successfully.'
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

        if ($params == 'update') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            $this->form_validation->set_rules('name', 'Department Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('code', 'Department Code', 'trim|required|xss_clean|alpha_numeric_spaces');

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
                $id = $this->input->post('id', TRUE);
                $data = [
                    'name' => $this->input->post('name', TRUE),
                    'code' => $this->input->post('code', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                ];

                if ($this->office_model->update($data, $id)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->get($id),
                        'message' => 'Department updated successfully.'
                    ];
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating department. Please try again.',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }

    public function department_delete($id) {
        $this->is_authorized(array('superadmin', 'admin'));
        $response = $this->office_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Department deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    // Designation
    public function designation_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);

        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1;
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10;
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];

        $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
        $offset = ($page - 1) * $limit;

        $totalRecords = $this->office_model->designation_get('yes', $id, $limit, $offset, $filterData);
        $data = $this->office_model->designation_get('no', $id, $limit, $offset, $filterData);

        $totalPages = ceil($totalRecords / $limit);

        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Designation fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function designation_post($params = '') {
        if ($params == 'add') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            $this->form_validation->set_rules('name', 'Department Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('code', 'Department Code', 'trim|required|xss_clean|alpha_numeric_spaces');

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
                $data = [
                    'name' => $this->input->post('name', TRUE),
                    'code' => $this->input->post('code', TRUE),
                    'status' => 'Active',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                ];

                if ($res = $this->office_model->designation_create($data)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->designation_get($res),
                        'message' => 'Designation created successfully.'
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

        if ($params == 'update') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            $this->form_validation->set_rules('name', 'Department Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('code', 'Department Code', 'trim|required|xss_clean|alpha_numeric_spaces');

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
                $id = $this->input->post('id', TRUE);
                $data = [
                    'name' => $this->input->post('name', TRUE),
                    'code' => $this->input->post('code', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                ];

                if ($this->office_model->designation_update($data, $id)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->designation_get($id),
                        'message' => 'Designation updated successfully.'
                    ];
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating designation. Please try again.',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }

    public function designation_delete($id) {
        $this->is_authorized(array('superadmin', 'admin'));
        $response = $this->office_model->designation_delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Designation deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    //Financial_year

    public function financial_year_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);

        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1;
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10;
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];

        $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
        $offset = ($page - 1) * $limit;

        $totalRecords = $this->office_model->financial_year_get('yes', $id, $limit, $offset, $filterData);
        $data = $this->office_model->financial_year_get('no', $id, $limit, $offset, $filterData);

        $totalPages = ceil($totalRecords / $limit);

        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Financial_year fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function financial_year_post($params = '') {
        if ($params == 'add') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            $this->form_validation->set_rules('name', 'Department Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('year', 'Department Code', 'trim|required|xss_clean|numeric');

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
                $data = [
                    'name' => $this->input->post('name', TRUE),
                    'year' => $this->input->post('year', TRUE),
                    'status' => 'Active',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                ];

                if ($res = $this->office_model->financial_year_create($data)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->financial_year_get($res),
                        'message' => 'Financial_year created successfully.'
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

        if ($params == 'update') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            $this->form_validation->set_rules('name', 'Department Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('year', 'Department Code', 'trim|required|xss_clean|numeric');

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
                $id = $this->input->post('id', TRUE);
                $data = [
                    'name' => $this->input->post('name', TRUE),
                    'year' => $this->input->post('year', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                ];

                if ($this->office_model->financial_year_update($data, $id)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->financial_year_get($id),
                        'message' => 'Financial_year updated successfully.'
                    ];
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating financial_year. Please try again.',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }

    public function financial_year_delete($id) {
        $this->is_authorized(array('superadmin', 'admin'));
        $response = $this->office_model->designation_delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Financial_year deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    //Company
    public function company_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1;
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10;
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
        $offset = ($page - 1) * $limit;
    
        $totalRecords = $this->office_model->company_get('yes', $id, $limit, $offset, $filterData);
        $data = $this->office_model->company_get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Company data fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK);
    }
    
    public function company_post($params = '') {
        if ($params == 'add') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            // Validation rules
            $this->form_validation->set_rules('name', 'Company Name', 'trim|required|min_length[3]|max_length[255]|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[255]|xss_clean');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|numeric|max_length[15]|xss_clean');
            $this->form_validation->set_rules('gst_no', 'GST Number', 'trim|max_length[50]|xss_clean|alpha_numeric');
    
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
                $data = [
                    'name' => $this->input->post('name', TRUE),
                    'short_name' => $this->input->post('short_name', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'mobile' => $this->input->post('mobile', TRUE),
                    'fax' => $this->input->post('fax', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'gst_no' => $this->input->post('gst_no', TRUE),
                    'registration_no' => $this->input->post('registration_no', TRUE),
                    'shop_acc_no' => $this->input->post('shop_acc_no', TRUE),
                    'pf_no' => $this->input->post('pf_no', TRUE),
                    'esi_no' => $this->input->post('esi_no', TRUE),
                    'pan_no' => $this->input->post('pan_no', TRUE),
                    'service_tax_no' => $this->input->post('service_tax_no', TRUE),
                    'tan_no' => $this->input->post('tan_no', TRUE),
                    'msme_no' => $this->input->post('msme_no', TRUE),
                    'ci_no' => $this->input->post('ci_no', TRUE),
                    'pf_percentage' => $this->input->post('pf_percentage', TRUE),
                    'esi_percentage' => $this->input->post('esi_percentage', TRUE),
                    'website' => $this->input->post('website', TRUE),
                    'lin_no' => $this->input->post('lin_no', TRUE),
                    'logo' => $this->input->post('logo', TRUE),
                    'bill_logo' => $this->input->post('bill_logo', TRUE),
                    'icard_header' => $this->input->post('icard_header', TRUE),
                    'icard_footer' => $this->input->post('icard_footer', TRUE),
                    'icard_sign' => $this->input->post('icard_sign', TRUE),
                    'icard_seal' => $this->input->post('icard_seal', TRUE),
                    'status' => 'Active',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                ];
    
                if ($res = $this->office_model->company_create($data)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->company_get($res),
                        'message' => 'Company created successfully.'
                    ];
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Error in form submission',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    
        if ($params == 'update') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            $this->form_validation->set_rules('name', 'Company Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('short_name', 'Short Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
    
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
                $id = $this->input->post('id', TRUE);
                $data = [
                    'name' => $this->input->post('name', TRUE),
                    'short_name' => $this->input->post('short_name', TRUE),
                    'phone' => $this->input->post('phone', TRUE),
                    'mobile' => $this->input->post('mobile', TRUE),
                    'fax' => $this->input->post('fax', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'gst_no' => $this->input->post('gst_no', TRUE),
                    'registration_no' => $this->input->post('registration_no', TRUE),
                    'shop_acc_no' => $this->input->post('shop_acc_no', TRUE),
                    'pf_no' => $this->input->post('pf_no', TRUE),
                    'esi_no' => $this->input->post('esi_no', TRUE),
                    'pan_no' => $this->input->post('pan_no', TRUE),
                    'service_tax_no' => $this->input->post('service_tax_no', TRUE),
                    'tan_no' => $this->input->post('tan_no', TRUE),
                    'msme_no' => $this->input->post('msme_no', TRUE),
                    'ci_no' => $this->input->post('ci_no', TRUE),
                    'pf_percentage' => $this->input->post('pf_percentage', TRUE),
                    'esi_percentage' => $this->input->post('esi_percentage', TRUE),
                    'website' => $this->input->post('website', TRUE),
                    'lin_no' => $this->input->post('lin_no', TRUE),
                    'logo' => $this->input->post('logo', TRUE),
                    'bill_logo' => $this->input->post('bill_logo', TRUE),
                    'icard_header' => $this->input->post('icard_header', TRUE),
                    'icard_footer' => $this->input->post('icard_footer', TRUE),
                    'icard_sign' => $this->input->post('icard_sign', TRUE),
                    'icard_seal' => $this->input->post('icard_seal', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                ];
    
                if ($this->office_model->company_update($data, $id)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->company_get($id),
                        'message' => 'Company updated successfully.'
                    ];
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating company. Please try again.',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }
    
    
    public function company_delete($id) {
        $this->is_authorized(array('superadmin', 'admin'));
        $response = $this->office_model->company_delete($id);
    
        if ($response) {
            $this->response(['status' => true, 'message' => 'Company deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
     
    //Banks
    public function banks_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1;
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10;
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
        $offset = ($page - 1) * $limit;
    
        $totalRecords = $this->office_model->banks_get('yes', $id, $limit, $offset, $filterData);
        $data = $this->office_model->banks_get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Banks data fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK);
    }
    
    public function banks_post($params = '') {
        if ($params == 'add') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            // Validation rules
            $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required|min_length[3]|max_length[255]|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('acc_no', 'Account Number', 'trim|required|numeric|xss_clean');
            $this->form_validation->set_rules('ifsc_code', 'IFSC Code', 'trim|required|max_length[15]|xss_clean|alpha_numeric');
            $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required|max_length[255]|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('bank_address', 'Bank Address', 'trim|required|xss_clean');
    
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
                $data = [
                    'bank_name' => $this->input->post('bank_name', TRUE),
                    'acc_no' => $this->input->post('acc_no', TRUE),
                    'ifsc_code' => $this->input->post('ifsc_code', TRUE),
                    'branch_name' => $this->input->post('branch_name', TRUE),
                    'bank_address' => $this->input->post('bank_address', TRUE),
                    'status' => 'Active',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                ];
    
                if ($res = $this->office_model->banks_create($data)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->banks_get($res),
                        'message' => 'Banks created successfully.'
                    ];
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Error in form submission',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    
        if ($params == 'update') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            $this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('branch_name', 'Branch Name', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('acc_no', 'Account Number', 'trim|required|numeric|xss_clean');
    
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
                $id = $this->input->post('id', TRUE);
                $data = [
                    'bank_name' => $this->input->post('bank_name', TRUE),
                    'branch_name' => $this->input->post('branch_name', TRUE),
                    'acc_no' => $this->input->post('acc_no', TRUE),
                    'ifsc_code' => $this->input->post('ifsc_code', TRUE),
                    'bank_address' => $this->input->post('bank_address', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                ];
    
                if ($this->office_model->banks_update($data, $id)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->banks_get($id),
                        'message' => 'Banks updated successfully.'
                    ];
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating bank. Please try again.',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }
    
    public function banks_delete($id) {
        $this->is_authorized(array('superadmin', 'admin'));
        $response = $this->office_model->banks_delete($id);
    
        if ($response) {
            $this->response(['status' => true, 'message' => 'Banks deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    //Client_services
    public function client_services_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);

        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1;
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10;
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];

        $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
        $offset = ($page - 1) * $limit;

        $totalRecords = $this->office_model->client_services_get('yes', $id, $limit, $offset, $filterData);
        $data = $this->office_model->client_services_get('no', $id, $limit, $offset, $filterData);

        $totalPages = ceil($totalRecords / $limit);

        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Client_services fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function client_services_details_get() {
        $id = $this->input->get('id') ? $this->input->client_services_get('id') : 0;
        $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
        $data = $this->office_model->show($id);

        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Client_services fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function client_services_post($params = '') {
        if ($params == 'add') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

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
                $data = [
                    'name' => $this->input->post('name', TRUE),
                    'status' => 'Active',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                ];

                if ($res = $this->office_model->client_services_create($data)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->client_services_get($res),
                        'message' => 'Client_services created successfully.'
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

        if ($params == 'update') {
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

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
                $id = $this->input->post('id', TRUE);
                $data = [
                    'name' => $this->input->post('name', TRUE),
                    'status' => $this->input->post('status', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                ];

                if ($this->office_model->client_services_update($data, $id)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->client_services_get($id),
                        'message' => 'Client_services updated successfully.'
                    ];
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Client_services. Please try again.',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }

    public function client_services_delete($id) {
        $this->is_authorized(array('superadmin', 'admin'));
        $response = $this->office_model->client_services_delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Client_services deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    //LWF
    public function lwf_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);

        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1;
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10;
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];

        $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
        $offset = ($page - 1) * $limit;

        $totalRecords = $this->office_model->lwf_get('yes', $id, $limit, $offset, $filterData);
        $data = $this->office_model->lwf_get('no', $id, $limit, $offset, $filterData);

        $totalPages = ceil($totalRecords / $limit);

        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'LWF records fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }


    // Create or Update LWF records
    public function lwf_post($params = '') {
        if ($params == 'add') {
            // Get session user data
            $getTokenData = $this->is_authorized(array('superadmin', 'admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            // Parse JSON input
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            // Set validation rules
            $this->form_validation->set_rules('state_id', 'State ID', 'trim|required');
            $this->form_validation->set_rules('from_range', 'From Range', 'trim|required');
            $this->form_validation->set_rules('to_range', 'To Range', 'trim|required');
            $this->form_validation->set_rules('number_of_employees', 'Number of Employees', 'trim|required|numeric');
            $this->form_validation->set_rules('submission_date', 'Submission Date', 'trim|required');
            $this->form_validation->set_rules('lwf_employee_amount', 'LWF Employee Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('lwf_employer_amount', 'LWF Employer Amount', 'trim|required|numeric');
    
            // Validate input data
            if ($this->form_validation->run() === false) {
                $array_error = array_map(function ($val) {
                    return str_replace(array("\r", "\n"), '', strip_tags($val));
                }, array_filter(explode(".", trim(strip_tags(validation_errors())))));
    
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error in submit form',
                    'errors' => $array_error
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                return;
            }
    
            // Prepare data for insertion
            $data = [
                'state_id' => $this->input->post('state_id', TRUE),
                'lwf_application_type' => 'Monthly',
                'from_range' => $this->input->post('from_range', TRUE),
                'to_range' => $this->input->post('to_range', TRUE),
                'number_of_employees' => $this->input->post('number_of_employees', TRUE),
                'submission_date' => $this->input->post('submission_date', TRUE),
                'lwf_employee_amount' => $this->input->post('lwf_employee_amount', TRUE),
                'lwf_employer_amount' => $this->input->post('lwf_employer_amount', TRUE),
                'added' => date('Y-m-d H:i:s'),
                'addedBy' => $session_id
            ];
    
            // Handle base64 document upload if provided
            if (!empty($_POST['document'])) {
                try {
                    $base64_image = $_POST['document'];
                    $quality = 90; // Image quality
                    $resizeConfig = [
                        'resize' => [
                            'width' => 500,
                            'height' => 300
                        ]
                    ];
                    $uploadFolder = 'document_upload'; // Directory for uploaded files
                    $data['document'] = $this->upload_media->upload_and_save($base64_image, $quality, $resizeConfig, $uploadFolder);
                } catch (Exception $e) {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Document upload failed',
                        'errors' => [$e->getMessage()]
                    ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR, '', 'error');
                    return;
                }
            }
    
            // Save data to the database
            if ($res = $this->office_model->lwf_create($data)) {
                $final = [
                    'status' => true,
                    'data' => $this->office_model->lwf_get($res),
                    'message' => 'LWF record created successfully.'
                ];
                $this->response($final, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Failed to create LWF record',
                    'errors' => [$this->db->error()]
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            }
        }
    
    
        if ($params == 'update') {
            $getTokenData = $this->is_authorized(['superadmin', 'admin']);
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
        
            $_POST = json_decode($this->input->raw_input_stream, true);
        
            // Set validation rules
            $this->form_validation->set_rules('id', 'ID', 'trim|required|numeric');
            $this->form_validation->set_rules('state_id', 'State ID', 'trim|required');
            $this->form_validation->set_rules('from_range', 'From Range', 'trim|required');
            $this->form_validation->set_rules('to_range', 'To Range', 'trim|required');
            $this->form_validation->set_rules('number_of_employees', 'Number of Employees', 'trim|required|numeric');
            $this->form_validation->set_rules('submission_date', 'Submission Date', 'trim|required');
            $this->form_validation->set_rules('lwf_employee_amount', 'LWF Employee Amount', 'trim|required|numeric');
            $this->form_validation->set_rules('lwf_employer_amount', 'LWF Employer Amount', 'trim|required|numeric');
        
            if ($this->form_validation->run() === false) {
                $array_error = array_map(function ($val) {
                    return str_replace(["\r", "\n"], '', strip_tags($val));
                }, array_filter(explode(".", trim(strip_tags(validation_errors())))));
        
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error in submit form',
                    'errors' => $array_error
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            } else {
                $id = $this->input->post('id', TRUE);
                $data = [
                    'state_id' => $this->input->post('state_id', TRUE),
                    'lwf_application_type' => $this->input->post('lwf_application_type', TRUE),
                    'from_range' => $this->input->post('from_range', TRUE),
                    'to_range' => $this->input->post('to_range', TRUE),
                    'number_of_employees' => $this->input->post('number_of_employees', TRUE),
                    'submission_date' => $this->input->post('submission_date', TRUE),
                    'lwf_employee_amount' => $this->input->post('lwf_employee_amount', TRUE),
                    'lwf_employer_amount' => $this->input->post('lwf_employer_amount', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                ];
        
                // Handle Base64 document decoding if provided
                if (!empty($_POST['document'])) {
                    $base64_document = $_POST['document'];
                    $uploadFolder = 'document_upload';
                    $data['document'] = $this->upload_media->upload_and_save($base64_document, 100, [], $uploadFolder);
                }
        
                if ($this->office_model->lwf_update($data, $id)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->lwf_get($id),
                        'message' => 'LWF record updated successfully.'
                    ];
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating the LWF record. Please try again.',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
             }  
            
            
         }
    }
    // Delete LWF record
    public function lwf_delete($id) {
        $this->is_authorized(array('superadmin', 'admin'));
        $response = $this->office_model->lwf_delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'LWF record deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'LWF record not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    //Master_gst
    public function master_gst_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1;
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10;
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(['superadmin', 'admin']);
        $offset = ($page - 1) * $limit;
    
        $totalRecords = $this->office_model->master_gst_get('yes', $id, $limit, $offset, $filterData);
        $data = $this->office_model->master_gst_get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Master GST records fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK);
    }
    
    // Create or Update Master GST Records
    public function master_gst_post($params = '') {
        if ($params == 'add') {
            $getTokenData = $this->is_authorized(['superadmin', 'admin']);
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            $this->form_validation->set_rules('country_id', 'Country ID', 'trim|required');
            $this->form_validation->set_rules('state_id', 'State ID', 'trim|required');
            $this->form_validation->set_rules('gstin', 'GSTIN', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|numeric');
    
            if ($this->form_validation->run() === false) {
                $array_error = array_map(function ($val) {
                    return str_replace(["\r", "\n"], '', strip_tags($val));
                }, array_filter(explode(".", trim(strip_tags(validation_errors())))));
    
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error in submit form',
                    'errors' => $array_error
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                return;
            }
    
            $data = [
                'country_id' => $this->input->post('country_id', TRUE),
                'state_id' => $this->input->post('state_id', TRUE),
                'gstin' => $this->input->post('gstin', TRUE),
                'address' => $this->input->post('address', TRUE),
                'pincode' => $this->input->post('pincode', TRUE),
                'added' => date('Y-m-d H:i:s'),
                'addedBy' => $session_id
            ];
    
            if (!empty($_POST['file'])) {
                try {
                    $base64_file = $_POST['file'];
                    $uploadFolder = 'gst_documents';
                    $data['file'] = $this->upload_media->upload_and_save($base64_file, 100, [], $uploadFolder);
                } catch (Exception $e) {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'File upload failed',
                        'errors' => [$e->getMessage()]
                    ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR, '', 'error');
                    return;
                }
            }
    
            if ($res = $this->office_model->master_gst_create($data)) {
                $final = [
                    'status' => true,
                    'data' => $this->office_model->master_gst_get($res),
                    'message' => 'Master GST record created successfully.'
                ];
                $this->response($final, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Failed to create Master GST record',
                    'errors' => [$this->db->error()]
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            }
        }
    
        if ($params == 'update') {
            $getTokenData = $this->is_authorized(['superadmin', 'admin']);
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];
    
            $_POST = json_decode($this->input->raw_input_stream, true);
    
            $this->form_validation->set_rules('id', 'ID', 'trim|required|numeric');
            $this->form_validation->set_rules('state_id', 'State ID', 'trim|required');
            $this->form_validation->set_rules('gstin', 'GSTIN', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|numeric');
    
            if ($this->form_validation->run() === false) {
                $array_error = array_map(function ($val) {
                    return str_replace(["\r", "\n"], '', strip_tags($val));
                }, array_filter(explode(".", trim(strip_tags(validation_errors())))));
    
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error in submit form',
                    'errors' => $array_error
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            } else {
                $id = $this->input->post('id', TRUE);
                $data = [
                    'country_id' => $this->input->post('country_id', TRUE),
                    'state_id' => $this->input->post('state_id', TRUE),
                    'gstin' => $this->input->post('gstin', TRUE),
                    'address' => $this->input->post('address', TRUE),
                    'pincode' => $this->input->post('pincode', TRUE),
                    'updated' => date('Y-m-d H:i:s'),
                    'updatedBy' => $session_id
                ];
    
                if (!empty($_POST['file'])) {
                    $base64_file = $_POST['file'];
                    $uploadFolder = 'gst_documents';
                    $data['file'] = $this->upload_media->upload_and_save($base64_file, 100, [], $uploadFolder);
                }
    
                if ($this->office_model->master_gst_update($data, $id)) {
                    $final = [
                        'status' => true,
                        'data' => $this->office_model->master_gst_get($id),
                        'message' => 'Master GST record updated successfully.'
                    ];
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating the Master GST record. Please try again.',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
    }
    
    // Delete Master GST Record
    public function master_gst_delete($id) {
        $this->is_authorized(['superadmin', 'admin']);
        $response = $this->office_model->master_gst_delete($id);
    
        if ($response) {
            $this->response(['status' => true, 'message' => 'Master GST record deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Master GST record not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    // ESIC Code
public function esic_code_list_post() {
    $input_data = file_get_contents('php://input');
    $request_data = json_decode($input_data, true);

    $id = $this->input->get('id') ? $this->input->get('id') : 0;
    $page = isset($request_data['page']) ? $request_data['page'] : 1;
    $limit = isset($request_data['limit']) ? $request_data['limit'] : 10;
    $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];

    $getTokenData = $this->is_authorized(['superadmin', 'admin']);
    $offset = ($page - 1) * $limit;

    $totalRecords = $this->office_model->esic_code_get('yes', $id, $limit, $offset, $filterData);
    $data = $this->office_model->esic_code_get('no', $id, $limit, $offset, $filterData);

    $totalPages = ceil($totalRecords / $limit);

    $response = [
        'status' => true,
        'data' => $data,
        'pagination' => [
            'page' => $page,
            'totalPages' => $totalPages,
            'totalRecords' => $totalRecords
        ],
        'message' => 'ESIC Code records fetched successfully.'
    ];
    $this->response($response, REST_Controller::HTTP_OK);
}

// Create or Update ESIC Code Records
public function esic_code_post($params = '') {
    if ($params == 'add') {
        $getTokenData = $this->is_authorized(['superadmin', 'admin']);
        $usersData = json_decode(json_encode($getTokenData), true);
        $session_id = $usersData['data']['id'];

        $_POST = json_decode($this->input->raw_input_stream, true);

        $this->form_validation->set_rules('country_id', 'Country ID', 'trim|required');
        $this->form_validation->set_rules('state_id', 'State ID', 'trim|required');
        $this->form_validation->set_rules('city_id', 'City ID', 'trim|required');
        $this->form_validation->set_rules('esic_code', 'ESIC Code', 'trim|required');

        if ($this->form_validation->run() === false) {
            $array_error = array_map(function ($val) {
                return str_replace(["\r", "\n"], '', strip_tags($val));
            }, array_filter(explode(".", trim(strip_tags(validation_errors())))));

            $this->response([
                'status' => FALSE,
                'message' => 'Error in submit form',
                'errors' => $array_error
            ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            return;
        }

        $data = [
            'country_id' => $this->input->post('country_id', TRUE),
            'state_id' => $this->input->post('state_id', TRUE),
            'city_id' => $this->input->post('city_id', TRUE),
            'esic_code' => $this->input->post('esic_code', TRUE),
            'added' => date('Y-m-d H:i:s'),
            'addedBy' => $session_id
        ];

        if (!empty($_POST['document'])) {
            try {
                $base64_file = $_POST['document'];
                $uploadFolder = 'esic_documents';
                $data['document'] = $this->upload_media->upload_and_save($base64_file, 100, [], $uploadFolder);
            } catch (Exception $e) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Document upload failed',
                    'errors' => [$e->getMessage()]
                ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR, '', 'error');
                return;
            }
        }

        if ($res = $this->office_model->esic_code_create($data)) {
            $final = [
                'status' => true,
                'data' => $this->office_model->esic_code_get($res),
                'message' => 'ESIC Code record created successfully.'
            ];
            $this->response($final, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to create ESIC Code record',
                'errors' => [$this->db->error()]
            ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
        }
    }

    if ($params == 'update') {
        $getTokenData = $this->is_authorized(['superadmin', 'admin']);
        $usersData = json_decode(json_encode($getTokenData), true);
        $session_id = $usersData['data']['id'];

        $_POST = json_decode($this->input->raw_input_stream, true);

        $this->form_validation->set_rules('id', 'ID', 'trim|required|numeric');
        $this->form_validation->set_rules('state_id', 'State ID', 'trim|required');
        $this->form_validation->set_rules('city_id', 'City ID', 'trim|required');
        $this->form_validation->set_rules('esic_code', 'ESIC Code', 'trim|required');

        if ($this->form_validation->run() === false) {
            $array_error = array_map(function ($val) {
                return str_replace(["\r", "\n"], '', strip_tags($val));
            }, array_filter(explode(".", trim(strip_tags(validation_errors())))));

            $this->response([
                'status' => FALSE,
                'message' => 'Error in submit form',
                'errors' => $array_error
            ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
        } else {
            $id = $this->input->post('id', TRUE);
            $data = [
                'country_id' => $this->input->post('country_id', TRUE),
                'state_id' => $this->input->post('state_id', TRUE),
                'city_id' => $this->input->post('city_id', TRUE),
                'esic_code' => $this->input->post('esic_code', TRUE),
                'updated' => date('Y-m-d H:i:s'),
                'updatedBy' => $session_id
            ];

            if (!empty($_POST['document'])) {
                $base64_file = $_POST['document'];
                $uploadFolder = 'esic_documents';
                $data['document'] = $this->upload_media->upload_and_save($base64_file, 100, [], $uploadFolder);
            }

            if ($this->office_model->esic_code_update($data, $id)) {
                $final = [
                    'status' => true,
                    'data' => $this->office_model->esic_code_get($id),
                    'message' => 'ESIC Code record updated successfully.'
                ];
                $this->response($final, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'There was a problem updating the ESIC Code record. Please try again.',
                    'errors' => [$this->db->error()]
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            }
        }
    }
}

// Delete ESIC Code Record
public function esic_code_delete($id) {
    $this->is_authorized(['superadmin', 'admin']);
    $response = $this->office_model->esic_code_delete($id);

    if ($response) {
        $this->response(['status' => true, 'message' => 'ESIC Code record deleted successfully.'], REST_Controller::HTTP_OK);
    } else {
        $this->response(['status' => false, 'message' => 'ESIC Code record not deleted'], REST_Controller::HTTP_BAD_REQUEST);
    }
}

// PF Code
public function pf_code_list_post() {
    $input_data = file_get_contents('php://input');
    $request_data = json_decode($input_data, true);

    $id = $this->input->get('id') ? $this->input->get('id') : 0;
    $page = isset($request_data['page']) ? $request_data['page'] : 1;
    $limit = isset($request_data['limit']) ? $request_data['limit'] : 10;
    $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];

    $getTokenData = $this->is_authorized(['superadmin', 'admin']);
    $offset = ($page - 1) * $limit;

    $totalRecords = $this->office_model->pf_code_get('yes', $id, $limit, $offset, $filterData);
    $data = $this->office_model->pf_code_get('no', $id, $limit, $offset, $filterData);

    $totalPages = ceil($totalRecords / $limit);

    $response = [
        'status' => true,
        'data' => $data,
        'pagination' => [
            'page' => $page,
            'totalPages' => $totalPages,
            'totalRecords' => $totalRecords
        ],
        'message' => 'PF Code records fetched successfully.'
    ];
    $this->response($response, REST_Controller::HTTP_OK);
}

// Create or Update PF Code Records
public function pf_code_post($params = '') {
    if ($params == 'add') {
        $getTokenData = $this->is_authorized(['superadmin', 'admin']);
        $usersData = json_decode(json_encode($getTokenData), true);
        $session_id = $usersData['data']['id'];

        $_POST = json_decode($this->input->raw_input_stream, true);

        $this->form_validation->set_rules('country_id', 'Country ID', 'trim|required');
        $this->form_validation->set_rules('state_id', 'State ID', 'trim|required');
        $this->form_validation->set_rules('pf_code', 'PF Code', 'trim|required');

        if ($this->form_validation->run() === false) {
            $array_error = array_map(function ($val) {
                return str_replace(["\r", "\n"], '', strip_tags($val));
            }, array_filter(explode(".", trim(strip_tags(validation_errors())))));

            $this->response([
                'status' => FALSE,
                'message' => 'Error in submit form',
                'errors' => $array_error
            ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            return;
        }

        $data = [
            'country_id' => $this->input->post('country_id', TRUE),
            'state_id' => $this->input->post('state_id', TRUE),
            'pf_code' => $this->input->post('pf_code', TRUE),
            'added' => date('Y-m-d H:i:s'),
            'addedBy' => $session_id
        ];

        if (!empty($_POST['document'])) {
            try {
                $base64_file = $_POST['document'];
                $uploadFolder = 'pf_documents';
                $data['document'] = $this->upload_media->upload_and_save($base64_file, 100, [], $uploadFolder);
            } catch (Exception $e) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Document upload failed',
                    'errors' => [$e->getMessage()]
                ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR, '', 'error');
                return;
            }
        }

        if ($res = $this->office_model->pf_code_create($data)) {
            $final = [
                'status' => true,
                'data' => $this->office_model->pf_code_get($res),
                'message' => 'PF Code record created successfully.'
            ];
            $this->response($final, REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'Failed to create PF Code record',
                'errors' => [$this->db->error()]
            ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
        }
    }

    if ($params == 'update') {
        $getTokenData = $this->is_authorized(['superadmin', 'admin']);
        $usersData = json_decode(json_encode($getTokenData), true);
        $session_id = $usersData['data']['id'];

        $_POST = json_decode($this->input->raw_input_stream, true);

        $this->form_validation->set_rules('id', 'ID', 'trim|required|numeric');
        $this->form_validation->set_rules('state_id', 'State ID', 'trim|required');
        $this->form_validation->set_rules('pf_code', 'PF Code', 'trim|required');

        if ($this->form_validation->run() === false) {
            $array_error = array_map(function ($val) {
                return str_replace(["\r", "\n"], '', strip_tags($val));
            }, array_filter(explode(".", trim(strip_tags(validation_errors())))));

            $this->response([
                'status' => FALSE,
                'message' => 'Error in submit form',
                'errors' => $array_error
            ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
        } else {
            $id = $this->input->post('id', TRUE);
            $data = [
                'country_id' => $this->input->post('country_id', TRUE),
                'state_id' => $this->input->post('state_id', TRUE),
                'pf_code' => $this->input->post('pf_code', TRUE),
                'updated' => date('Y-m-d H:i:s'),
                'updatedBy' => $session_id
            ];

            if (!empty($_POST['document'])) {
                $base64_file = $_POST['document'];
                $uploadFolder = 'pf_documents';
                $data['document'] = $this->upload_media->upload_and_save($base64_file, 100, [], $uploadFolder);
            }

            if ($this->office_model->pf_code_update($data, $id)) {
                $final = [
                    'status' => true,
                    'data' => $this->office_model->pf_code_get($id),
                    'message' => 'PF Code record updated successfully.'
                ];
                $this->response($final, REST_Controller::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'There was a problem updating the PF Code record. Please try again.',
                    'errors' => [$this->db->error()]
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            }
        }
    }
}

// Delete PF Code Record
public function pf_code_delete($id) {
    $this->is_authorized(['superadmin', 'admin']);
    $response = $this->office_model->pf_code_delete($id);

    if ($response) {
        $this->response(['status' => true, 'message' => 'PF Code record deleted successfully.'], REST_Controller::HTTP_OK);
    } else {
        $this->response(['status' => false, 'message' => 'PF Code record not deleted'], REST_Controller::HTTP_BAD_REQUEST);
    }
}

}
