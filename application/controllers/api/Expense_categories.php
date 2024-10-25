<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Expense_categories extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('expense_categories_model');
        $this->load->helper('security');

    }

    //expense categories start
    public function expense_categories_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->expense_categories_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->expense_categories_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Expense Categories fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function expense_categories_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->expense_categories_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Expense Categories fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function expense_categories_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('name', 'Expense Category Name','trim|required|xss_clean|alpha_numeric_spaces|is_unique[pms_expense_categories.name]');

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
                $name = $this->input->post('name',TRUE);
                if (!empty($name)) {
                    $data['name'] = $name;
                }


                $data['status'] = 'Active';
                

                if ($res = $this->expense_categories_model->create($data)) {
                    // expense categories creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->expense_categories_model->get($res);
                    $final['message'] = 'Expense Categories created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // Expense Categories creation failed, this should never happen
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
            $id = $this->input->post('id',TRUE);
            // set validation rules
            $this->form_validation->set_rules('name', 'Expense Category Name','trim|required|xss_clean|alpha_numeric_spaces|edit_unique[pms_expense_categories.name.id.'.$id.']');
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
                // set variables from the form
                $name = $this->input->post('name',TRUE);
                if (!empty($name)) {
                    $data['name'] = $name;
                }

        
                $status = $this->input->post('status',TRUE);
                if (!empty($status)) {
                    $data['status'] = $status;
                }
        
                
                $res = $this->expense_categories_model->update($data, $id);
        
                if ($res) {
                    // expense categories update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->expense_categories_model->get($id);
                    $final['message'] = 'Expense Categories updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // Expense Categories update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Expense Categories. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function expense_categories_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->expense_categories_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Expense Categories deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // expense categories end
}
