<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Earrings extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('earrings_model');
        $this->load->helper('security');
    }

    
    public function earrings_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->earrings_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->earrings_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'earrings fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function earrings_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->earrings_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'earrings fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function earrings_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean|alpha_numeric_spaces');
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
                $data['name'] = $this->input->post('name',TRUE);
                $data['user_id'] = $this->input->post('user_id',TRUE);
                $data['category_id'] = $this->input->post('category_id',TRUE);
                $data['state'] = $this->input->post('state',TRUE);
                $data['description'] = $this->input->post('description',TRUE);
				if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'earrings'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
				}
					
				$data['status'] = 'Active';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;

                if ($res = $this->earrings_model->create($data)) {
                    // earrings creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->earrings_model->get($res);
                    $final['message'] = 'earrings created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // earrings creation failed, this should never happen
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
            $this->form_validation->set_rules('name', 'earrings Name', 'trim|required|xss_clean|alpha_numeric_spaces');
        
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
                $data['name'] = $this->input->post('name',TRUE);
                $data['user_id'] = $this->input->post('user_id',TRUE);
                $data['category_id'] = $this->input->post('category_id',TRUE);
                $data['state'] = $this->input->post('state',TRUE);
                $data['description'] = $this->input->post('description',TRUE);
                $data['status'] = $this->input->post('status',TRUE);
				
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
					$uploadFolder = 'earrings'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
					$imgData = $this->db->get_where('earrings',array('id'=>$id));
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
                
                $res = $this->earrings_model->update($data, $id);
        
                if ($res) {
                    // earrings update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->earrings_model->get($id);
                    $final['message'] = 'earrings updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // earrings update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating earrings. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function earrings_delete($id) {
        $this->is_authorized('superadmin');
        $response = $this->earrings_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'earrings deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // earrings end
}
