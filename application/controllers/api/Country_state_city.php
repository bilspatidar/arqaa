<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Country_state_city extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('Country_state_city_model');
        $this->load->helper('security');
    }


    public function country_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->Country_state_city_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->Country_state_city_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Country fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function state_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->Country_state_city_model->get_state('yes', $id, $limit, $offset, $filterData);
        $data =  $this->Country_state_city_model->get_state('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Country fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function city_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->Country_state_city_model->get_city('yes', $id, $limit, $offset, $filterData);
        $data =  $this->Country_state_city_model->get_city('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Country fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function country_state_get($id=''){

         $id = $this->input->get('id') ? $this->input->get('id') : 0;
         $getTokenData = $this->is_authorized('superadmin');
         $data =  $this->Country_state_city_model->state_show($id);
         $response = [
             'status' => true,
             'data' => $data,
             'message' => 'State fetched successfully.'
         ];
         $this->response($response, REST_Controller::HTTP_OK); 
     }

     public function state_city_get($id=''){

        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->Country_state_city_model->city_show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'City fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

}