<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Monthly_subscription_for_company_users extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
     */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('monthly_subscription_for_company_users_model');
        $this->load->helper('security');
    }

    public function monthly_subscription_for_company_users_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);

        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1; 
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; 
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];

        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;

        $totalRecords = $this->monthly_subscription_for_company_users_model->get('yes', $id, $limit, $offset, $filterData);
        $data = $this->monthly_subscription_for_company_users_model->get('no', $id, $limit, $offset, $filterData);

        $totalPages = ceil($totalRecords / $limit);

        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Subscriptions fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function monthly_subscription_for_company_users_details_get() {
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data = $this->monthly_subscription_for_company_users_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Subscription details fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function monthly_subscription_for_company_users_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // Set validation rules
            $this->form_validation->set_rules('concept', 'Concept', 'trim|required');
            $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
            $this->form_validation->set_rules('currency', 'Currency', 'trim|required|xss_clean');

            if ($this->form_validation->run() === false) {
                $array_error = array_map(function ($val) {
                    return str_replace(array("\r", "\n"), '', strip_tags($val));
                }, array_filter(explode(".", trim(strip_tags(validation_errors())))));

                $this->response([
                    'status' => FALSE,
                    'message' =>'Error in submit form',
                    'errors' =>$array_error
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            } else {
                // Set variables from the form
                $data = [
                    'concept' => $this->input->post('concept', TRUE),
                    'price' => $this->input->post('price', TRUE),
                    'currency' => $this->input->post('currency', TRUE),
                    'status' => 'Active',
                    'added' => date('Y-m-d H:i:s'),
                    'addedBy' => $session_id
                ];

                if ($res = $this->monthly_subscription_for_company_users_model->create($data)) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->monthly_subscription_for_company_users_model->get($res);
                    $final['message'] = 'Subscription created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    $this->response([ 'status' => FALSE,
                        'message' =>'Error in submit form',
                        'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
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
				$data['status'] = $this->input->post('status',TRUE);
                $res = $this->monthly_subscription_for_company_users_model->update($data, $id);
        
                if ($res) {
                    // update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->monthly_subscription_for_company_users_model->get($id);
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

    public function monthly_subscription_for_company_users_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->monthly_subscription_for_company_users_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Subscription deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
