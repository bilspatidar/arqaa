<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Expense extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('expense_model');
        $this->load->helper('security');
    }

    
    public function expense_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->category_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->category_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'category fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function expense_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));

        $data =  $this->category_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'category fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function expense_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized(array('superadmin','admin'));
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('cost_type', 'Cost Type', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('amount', 'Cost', 'trim|required|xss_clean');
            $this->form_validation->set_rules('concept', 'Concept', 'trim|required|xss_clean');
        

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
                $cost_type = $this->input->post('cost_type',TRUE);
                if (!empty($cost_type)) {
                    $data['cost_type'] = $cost_type;
                }

                $country_id = $this->input->post('country_id',TRUE);
                if (!empty($country_id)) {
                    $data['country_id'] = $country_id;
                }

                $currency = $this->input->post('currency',TRUE);
                if (!empty($currency)) {
                    $data['currency'] = $currency;
                }

                $amount = $this->input->post('amount',TRUE);
                if (!empty($amount)) {
                    $data['amount'] = $amount;
                }

                $concept = $this->input->post('concept',TRUE);
                if (!empty($concept)) {
                    $data['concept'] = $concept;
                }

                $tax = $this->input->post('tax',TRUE);
                if (!empty($tax)) {
                    $data['tax'] = $tax;
                }

                $tax_concept = $this->input->post('tax_concept',TRUE);
                if (!empty($tax_concept)) {
                    $data['tax_concept'] = $tax_concept;
                }
                $month = $this->input->post('month',TRUE);
                if (!empty($month)) {
                    $data['month'] = $month;
                }
                $year = $this->input->post('year',TRUE);
                if (!empty($year)) {
                    $data['year'] = $year;
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
                    $uploadFolder = 'category'; 

                    $data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
                    
                }
                    
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;

                if ($res = $this->expense_model->create($data)) {
                    // category creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = 'ok';
                    $final['message'] = 'Data created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // category creation failed, this should never happen
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
        
            // set validation rules
            $this->form_validation->set_rules('name', 'Category Name', 'trim|required|xss_clean|alpha_numeric_spaces');
        
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
                $name = $this->input->post('name',TRUE);
                if (!empty($name)) {
                    $data['name'] = $name;
                }
                $status = $this->input->post('status',TRUE);
                if (!empty($status)) {
                    $data['status'] = $status;
                }
                
                ///image 
                if(!empty($_POST['image'])){
                    $base64_image = $_POST['image'];
                    $quality = 90;
                    $radioConfig = [
                        'resize' => [
                        'width' => 500,
                        'height' => 300
                        ]
                     ];
                    $uploadFolder = 'category'; 

                    $data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
                    
                    $imgData = $this->db->get_where('category',array('id'=>$id));
                    if($imgData->num_rows()>0){
                        $img =  $imgData->row()->image;
                        if(file_exists($img) && !empty($img))
                        {
                            unlink($img);       
                        }
                    }
                }
                ////image  
                $data['updatedBy'] = $session_id;
                $data['updated'] = date('Y-m-d H:i:s');
                
                $res = $this->category_model->update($data, $id);
        
                if ($res) {
                    // category update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->category_model->get($id);
                    $final['message'] = 'Category updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // category update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating category. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function expense_delete($id) {
        $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $response = $this->category_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Category deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

   
}
