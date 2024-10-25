<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Income_report extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('income_report_model');
        $this->load->helper('security');
    }

    public function income_report_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
     
        // $getTokenData = $this->is_authorized('superadmin');
        $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        $userId   =  $isAuthorized['data']->id;
        if($user_type == 'superadmin'){
            $this->is_authorized('superadmin');
        }elseif($user_type == 'manager'){
            $getTokenData = $this->is_authorized('manager');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->income_report_model->get('yes', $id, $limit, $offset, $filterData,$user_type,$userId);
        $data =  $this->income_report_model->get('no', $id, $limit, $offset, $filterData,$user_type,$userId);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'income_report list fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function income_report_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        // $getTokenData = $this->is_authorized('superadmin');
        $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        if($user_type == 'superadmin'){
            $this->is_authorized('superadmin');
        }elseif($user_type == 'admin'){
            $getTokenData = $this->is_authorized('admin');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }
        $data =  $this->income_report_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'income_report details fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function income_report_delete($id) {
        // $this->is_authorized('superadmin');
        $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        if($user_type == 'superadmin'){
            $this->is_authorized('superadmin');
        }elseif($user_type == 'admin'){
            $getTokenData = $this->is_authorized('admin');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }
        $response = $this->income_report_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'income_report deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
