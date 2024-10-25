<?php
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\REST_Controller;

class Attendance extends REST_Controller {

    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->model('attendance_model');
        $this->load->helper('security');
    }

    public function attendance_list_post() {
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
        }elseif($user_type == 'admin'){
            $getTokenData = $this->is_authorized('admin');
        }elseif($user_type == 'supervisor'){
            $getTokenData = $this->is_authorized('supervisor');
        }elseif($user_type == 'employee'){
            $getTokenData = $this->is_authorized('employee');
        }
        $offset = ($page - 1) * $limit;
    
        $totalRecords =  $this->attendance_model->get('yes', $id, $limit, $offset, $filterData,$user_type,$userId);
        $data =  $this->attendance_model->get('no', $id, $limit, $offset, $filterData,$user_type,$userId);
    
        $totalPages = ceil($totalRecords / $limit);
    
        $response = [
            'status' => true,
            'data' => $data,
            'pagination' => [
                'page' => $page,
                'totalPages' => $totalPages,
                'totalRecords' => $totalRecords
            ],
            'message' => 'Attendance list fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

    public function attendance_details_get(){
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
        $data =  $this->attendance_model->show($id);
        $response = [
            'status' => true,
            'data' => $data,
            'message' => 'Attendance details fetched successfully.'
        ];
        $this->response($response, REST_Controller::HTTP_OK); 
    }

   public function attendance_post($params='') {
    if ($params == 'add') {
        $isAuthorized = $this->is_authorized();
        $user_type   =  $isAuthorized['data']->user_type;
        
        if ($user_type == 'superadmin') {
            $this->is_authorized('superadmin');
        } elseif ($user_type == 'admin') {
            $getTokenData = $this->is_authorized('admin');
        } elseif ($user_type == 'supervisor') {
            $getTokenData = $this->is_authorized('supervisor');
        } elseif ($user_type == 'employee') {
            $getTokenData = $this->is_authorized('employee');
        }
        
        $usersData = json_decode(json_encode($getTokenData), true);
        $session_id = $usersData['data']->id;
        
        if (!empty($_POST)) {
            // print_r($_POST); // Form se bheje gaye data ko print karein
            
            if (!isset($_POST['date'])) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error in form submission',
                    'errors' => 'Date field is missing'
                ], REST_Controller::HTTP_BAD_REQUEST);
                return;
            }
    
            $user_ids = $_POST['user_id'];
            $statuses = $_POST['status'];
            $remarks = $_POST['remarks'];
            $latitudes = $_POST['latitude'];
            $longitudes = $_POST['longitude'];
            $date = $_POST['date'];
            $ids = $_POST['id'];
            
            if (empty($user_ids)) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error in form submission',
                    'errors' => 'IDs field is missing or empty'
                ], REST_Controller::HTTP_BAD_REQUEST);
                return;
            }
    
            $created_attendances = [];
            foreach ($user_ids as $key => $user_id) {
                $ID = $ids[$key];
                $status = $statuses[$key];
                $remark = $remarks[$key];
                $latitude = $latitudes[$key];
                $longitude = $longitudes[$key];
                
                $attendance_check = $this->db->get_where('attendance', array('date' => $date, 'user_id' => $user_id))->result();
                
                if (count($attendance_check) > 0) {
                    $updatedata = array(
                        'user_id' => $user_id,
                        'status' => $status,
                        'remarks' => $remark,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'date' => $date,
                        'updated' => date('Y-m-d H:i:s'),
                        'updated_by' => $session_id
                    );
    
                    // Debugging update query
                    if (!$this->attendance_model->update($updatedata, $ID)) {
                        echo $this->db->last_query(); // Last executed query
                        print_r($this->db->error()); // Any database error
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Error in form submission',
                            'errors' => 'Failed to update data in the database'
                        ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                        return;
                    }
                } else {
                    $insertdata = array(
                        'user_id' => $user_id,
                        'status' => $status,
                        'remarks' => $remark,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'date' => $date,
                        'created' => date('Y-m-d H:i:s'),
                        'created_by' => $session_id
                    );
    
                    // Debugging insert query
                    if (!$this->attendance_model->create($insertdata)) {
                        echo $this->db->last_query(); // Last executed query
                        print_r($this->db->error()); // Any database error
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Error in form submission',
                            'errors' => 'Failed to insert data into the database'
                        ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                        return;
                    }
                }
                
                $created_attendances[] = $insertdata;
            }
            
            $this->response([
                'status' => TRUE,
                'message' => 'Attendance updated successfully.',
                'data' => $created_attendances
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'No data received',
                'errors' => 'No data received from the form'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    if ($params == 'adddddd') {
        // Get token data
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
        $usersData = json_decode(json_encode($getTokenData), true);
        $session_id = $usersData['data']['id'];
    
        if (!empty($_POST)) {
          
            if (!isset($_POST['date'])) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error in form submission',
                    'errors' => 'Date field is missing'
                ], REST_Controller::HTTP_BAD_REQUEST);
                return;
            }
    
            // Retrieve POST data for multiple users
            $user_ids = $_POST['user_id'];
            $statuses = $_POST['status'];
            $remarks = $_POST['remarks'];
            $latitudes = $_POST['latitude'];
            $longitudes = $_POST['longitude'];
            $date = $_POST['date'];
            $ids = $_POST['id'];
    
            // Check if user_id field is not empty
            if (empty($user_ids)) {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Error in form submission',
                    'errors' => 'IDs field is missing or empty'
                ], REST_Controller::HTTP_BAD_REQUEST);
                return;
            }
    
            // Loop through each user data and perform update or insert
            $created_attendances = [];
            foreach ($user_ids as $key => $user_id) {
                // Retrieve data for specific user
                $ID = $ids[$key];
                $status = $statuses[$key];
                $remark = $remarks[$key];
                $latitude = $latitudes[$key];
                $longitude = $longitudes[$key];
    
                // Check if attendance record exists for the given date and user
                $attendance_check = $this->db->get_where('attendance', array('date' => $date, 'user_id' => $user_id))->result();
   
                if (count($attendance_check) > 0) {
                    // Update the existing record
                    $updatedata = array(
                        'user_id' => $user_id,
                        'status' => $status,
                        'remarks' => $remark,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'date' => $date,
                        'updated' => date('Y-m-d H:i:s'),
                        'updated_by' => $session_id
                    );
    
                    if (!$this->attendance_model->update($updatedata, $ID)) {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Error in form submission',
                            'errors' => 'Failed to update data in the database'
                        ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                        return;
                    }
                } else {
                    // Insert a new record
                    $insertdata = array(
                        'user_id' => $user_id,
                        'status' => $status,
                        'remarks' => $remark,
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'date' => $date,
                        'created' => date('Y-m-d H:i:s'),
                        'created_by' => $session_id
                    );
    
                    if (!$this->attendance_model->create($insertdata)) {
                        $this->response([
                            'status' => FALSE,
                            'message' => 'Error in form submission',
                            'errors' => 'Failed to insert data into the database'
                        ], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
                        return;
                    }
                }
    
                // Add data to created_attendances array
                $created_attendances[] = $insertdata;
            }
    
            $this->response([
                'status' => TRUE,
                'message' => 'Attendance updated successfully.',
                'data' => $created_attendances
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => FALSE,
                'message' => 'No data received',
                'errors' => 'No data received from the form'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    if ($params == 'update') {
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
        $usersData = json_decode(json_encode($getTokenData), true);
        $session_id = $usersData['data']['id'];
    
        $_POST = json_decode($this->input->raw_input_stream, true);
        $id = $this->input->post('id',TRUE);
        // set validation rules
        $this->form_validation->set_rules('user_id', 'User Name', 'trim|required|xss_clean|numeric');
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
            $data['user_id'] = $this->input->post('user_id',TRUE);
            $data['remarks'] = $this->input->post('remarks',TRUE);
            $data['latitude'] = $this->input->post('latitude',TRUE);
            $data['longitude'] = $this->input->post('longitude',TRUE);
            $data['date'] = $this->input->post('date',TRUE);
            $data['status'] = $this->input->post('status',TRUE);
            $data['updated'] = date('Y-m-d H:i:s');
            $data['updated_by'] = $session_id;
    
            
            $res = $this->attendance_model->update($data, $id);
    
            if ($res) {
                // attendance update ok
                $final = array();
                $final['status'] = true;
                $final['data'] = $this->attendance_model->get($id);
                $final['message'] = 'Attendance updated successfully.';
                $this->response($final, REST_Controller::HTTP_OK);
            } else {
                // attendance update failed, this should never happen
                $this->response([
                    'status' => FALSE,
                    'message' => 'There was a problem updating Attendance. Please try again',
                    'errors' => [$this->db->error()]
                ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
            }
        }
      }       
    }
    public function attendance_delete($id) {
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
        $response = $this->attendance_model->delete($id);

        if ($response) {
            $this->response(['status' => true, 'message' => 'Attendance deleted successfully.'], REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
