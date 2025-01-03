<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Company_user extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('user_model');
        $this->load->helper('security');
    }

    
    public function company_user_list_post($role='') {
        $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
    
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $role = $this->input->get('role') ? $this->input->get('role') : '';
    
        $page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
        $limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
        $filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];
    
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->user_model->get('yes', $id, $limit, $offset, $filterData,$role);
        $data =  $this->user_model->get('no', $id, $limit, $offset, $filterData,$role);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Usuario de la empresa obtenido correctamente.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }
    
    public function company_user_details_get(){
        $id = $this->input->get('id') ? $this->input->get('id') : 0;
        $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $data =  $this->company_user_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'El usuario de la empresa fetched correctamente.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }


    public function company_user_post($params='') {
        if($params=='add') {
            $getTokenData = $this->is_authorized(array('superadmin','admin','company','freelancer'));
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
                $data['paternal_surname'] = $this->input->post('paternal_surname',TRUE);
                $data['maternal_surname'] = $this->input->post('maternal_surname',TRUE);
                $data['country'] = $this->input->post('country',TRUE);
                $data['state'] = $this->input->post('state',TRUE);
                $data['cologne'] = $this->input->post('cologne',TRUE);
				$data['mail'] = $this->input->post('mail',TRUE);
				$data['street'] = $this->input->post('street',TRUE);
                $data['crossings'] = $this->input->post('crossings',TRUE);
                $data['external_number'] = $this->input->post('external_number',TRUE);
                $data['interior_number'] = $this->input->post('interior_number',TRUE);
                $data['zip_code'] = $this->input->post('zip_code',TRUE);
                $data['password'] = password_hash($this->input->post('password',TRUE),PASSWORD_DEFAULT);
                $data['confirm_password'] = $this->input->post('confirm_password',TRUE);
                $data['cellular'] = $this->input->post('cellular',TRUE);
                $data['guy'] = $this->input->post('guy',TRUE);
                $data['radio'] = $this->input->post('radio',TRUE);
                $data['languages'] = $this->input->post('languages',TRUE);
				if(!empty($_POST['image'])){
					$base64_image = $_POST['image'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'company_user'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
				}
					
				$data['status'] = 'Active';
                $data['added'] = date('Y-m-d H:i:s');
                $data['addedBy'] = $session_id;

                if ($res = $this->company_user_model->create($data)) {
                    // Company User creation ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->company_user_model->get($res);
                    $final['message'] = 'Usuario de la empresa creado exitosamente.';
                    $this->response($final, REST_Controller::HTTP_OK); 
                } else {
                    // Company user creation failed, this should never happen
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
				$id = $this->input->post('id',TRUE);
                $data['name'] = $this->input->post('name',TRUE);
                $data['paternal_surname'] = $this->input->post('paternal_surname',TRUE);
                $data['maternal_surname'] = $this->input->post('maternal_surname',TRUE);
                $data['country'] = $this->input->post('country',TRUE);
                $data['state'] = $this->input->post('state',TRUE);
                $data['cologne'] = $this->input->post('cologne',TRUE);
				$data['mail'] = $this->input->post('mail',TRUE);
				$data['street'] = $this->input->post('street',TRUE);
                $data['crossings'] = $this->input->post('crossings',TRUE);
                $data['external_number'] = $this->input->post('external_number',TRUE);
                $data['interior_number'] = $this->input->post('interior_number',TRUE);
                $data['zip_code'] = $this->input->post('zip_code',TRUE);
                $data['password'] = password_hash($this->input->post('password',TRUE),PASSWORD_DEFAULT);
                $data['confirm_password'] = $this->input->post('confirm_password',TRUE);
                $data['cellular'] = $this->input->post('cellular',TRUE);
                $data['guy'] = $this->input->post('guy',TRUE);
                $data['radio'] = $this->input->post('radio',TRUE);
                $data['languages'] = $this->input->post('languages',TRUE);
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
					$uploadFolder = 'company_user'; 

					$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
					$imgData = $this->db->get_where('company_user',array('id'=>$id));
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
                
                $res = $this->company_user_model->update($data, $id);
        
                if ($res) {
                    // company_user update ok
                    $final = array();
                    $final['status'] = true;
                    $final['data'] = $this->company_user_model->get($id);
                    $final['message'] = 'Usuario de la empresa actualizado exitosamente.';
                    $this->response($final, REST_Controller::HTTP_OK);
                } else {
                    // company_user update failed, this should never happen
                    $this->response([
                        'status' => FALSE,
                        'message' => 'Hubo un problema al actualizar el usuario de la empresa. Por favor inténtalo de nuevo',
                        'errors' => [$this->db->error()]
                    ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
                }
            }
        }
        
    }

    public function company_user_delete($id) {
        $this->is_authorized(array('superadmin','admin','company','freelancer'));
        $response = $this->company_user_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Usuario de la empresa eliminado exitosamente.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'No eliminada'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    // company_user end
}
