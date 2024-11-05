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
        $this->load->helper('security');
    }

    
    public function regular_user_monthly_subscription_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
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
    
    public function regular_user_monthly_subscription_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->regular_user_monthly_subscription_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Suscripción Mensual Usuarios Regular fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function regular_user_monthly_subscription_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
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
}
