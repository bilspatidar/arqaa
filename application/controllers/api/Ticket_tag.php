<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Ticket_tag extends REST_Controller {

    public function __construct() {
         $this->cors_header();
        parent::__construct();
        $this->load->model('ticket_tag_model');
        $this->load->helper('security');
    }


    // Ticket_tag start
    public function ticket_tag_list_post() {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized('superadmin');
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->ticket_tag_model->get('yes', $id, $limit, $offset, $filterData);
        $data =  $this->ticket_tag_model->get('no', $id, $limit, $offset, $filterData);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Ticket_tag list fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function ticket_tag_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized('superadmin');
        $data =  $this->ticket_tag_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Ticket_tag details fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function ticket_tag_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized('superadmin');
            $usersData = json_decode(json_encode($getTokenData), true);
            $session_id = $usersData['data']['users_id'];

            $_POST = json_decode($this->input->raw_input_stream, true);

            // set validation rules
            $this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');
            $this->form_validation->set_rules('assign_id', 'Assign ID', 'trim|required|xss_clean|numeric');
            // Add validation rules for other fields if needed

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
                $data = array(
                    
                    'title' => $this->input->post('title',TRUE),
                    'description' => $this->input->post('description',TRUE),
                    'assign_id' => $this->input->post('assign_id',TRUE),
					'ticket_id' => $this->input->post('ticket_id',TRUE),
                );
					if(!empty($_POST['attachment'])){
					$base64_image = $_POST['attachment'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'ticket_tag'; 
					$data['attachment'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
				}
                $data['added'] = date('Y-m-d H:i:s');
               // $data['added_by'] = $session_id;

                if ($res = $this->ticket_tag_model->create($data)) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->ticket_tag_model->get($res);
                    $final['message'] = 'Ticket tag created successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
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
        
            // set validation rules
			$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean|alpha_numeric_spaces');
            $this->form_validation->set_rules('status', 'Status', 'trim|alpha');
        
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
                    $data['title'] = $this->input->post('title',TRUE);
                    $data['description'] = $this->input->post('description',TRUE);
                    $data['assign_id'] = $this->input->post('assign_id',TRUE);
                    $data['ticket_id'] = $this->input->post('ticket_id',TRUE);
					if(!empty($_POST['attachment'])){
					$base64_image = $_POST['attachment'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'ticket_tag'; 
					$data['attachment'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					$imgData = $this->db->get_where('ticket_tag',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->attachment;
						if(file_exists($img) && !empty($img)){
							unlink($img);		
						}
					}
				}
                $res = $this->ticket_tag_model->update($data, $id);
        
                if ($res) {
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->ticket_tag_model->get($id);
                    $final['message'] = 'Ticket Tag updated successfully.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    $this->response([
                        'status' => FALSE,
                        'message' => 'There was a problem updating Ticket Tag. Please try again',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }

    }

    public function ticket_tag_delete($id) {
		
        $this->is_authorized('superadmin');
        $response = $this->ticket_tag_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Ticket tag deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // Ticket_tag end

   
}
?>
