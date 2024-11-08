<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    require(APPPATH.'/libraries/REST_Controller.php');
    use Restserver\Libraries\REST_Controller;

class User extends REST_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
    $this->cors_header();
    parent::__construct();
	$this->load->helper('security');
		
		$this->load->model('user_model');
        header('Access-Control-Allow-Origin: *');
		
	}

	/**
	 * register function.
	 * 
	 * @access public
	 * @return void
	 */
	 


	public function register_post() {
         
		$_POST = json_decode($this->input->raw_input_stream, true);

			
		// set validation rules
		$this->form_validation->set_rules('name', 'Username', 'trim|required|xss_clean|alpha_numeric|min_length[3]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|is_unique[users.email]');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|xss_clean|min_length[10]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[6]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|min_length[6]|matches[password]');
		
		if ($this->form_validation->run() === false) {
			
			// validation not ok, send validation errors to the view
           $array_error = array_map(function ($val) {
				return str_replace(array("\r", "\n"), '', strip_tags($val));
			}, array_filter(explode(".", trim(strip_tags(validation_errors())))));
            $this->response([
                    'status' => FALSE,
					'errors' =>$array_error,
                    'message' =>'Error in submit form'
              ], REST_Controller::HTTP_BAD_REQUEST,'','error');
			
		} else {
			
			// set variables from the form
			$data['name'] = $this->input->post('name',TRUE);
			$data['email']    = $this->input->post('email',TRUE);
			$data['mobile']    = $this->input->post('mobile',TRUE);
			$data['password'] = password_hash($this->input->post('password',TRUE),PASSWORD_DEFAULT);
			$data['added'] = date('Y-m-d H:i:s');
			$data['status'] = 'Deactive';
			$data['user_type'] = $this->input->post('user_type',TRUE);
			
			if ($res = $this->user_model->create_user($data)) {
				if($data['user_type']=='merchant'){
				$data2['merchant_id'] = $res;
				$data2['mid'] = $this->merchant_keys_model->generateMid();
				$data2['api_key'] = $this->Common->GenerateLiveAPI();
				$data2['added'] = date('Y-m-d H:i:s');
				$data2['added_by'] = $res;
				$this->merchant_keys_model->create($data2);
				}
				
				// user creation ok
                $token_data['id'] = $res; 
                $token_data['username'] = $data['email'];
				
				$token_data['id']      = (int)$res;
				$token_data['user_type']      = (string)$data['user_type'];
				$token_data['email']     = (string)$data['email'];
				$token_data['name']     = (string)$data['name'];
				$token_data['logged_in']    = (bool)true;
				$token_data['status'] = (bool)$data['status'];
				
				
				// user login ok
				
				
				
                $tokenData = $this->authorization_token->generateToken($token_data);
                $final = array();
                $final['access_token'] = $tokenData;
                $final['status'] = true;
                $final['id'] = $res;
                $final['message'] = 'Thank you for registering your new account!';
                $final['note'] = 'You have successfully register.';
                $final['user_type'] = $token_data['user_type'];
				$final['logged_in'] =  (bool)true;

                $this->response($final, REST_Controller::HTTP_OK); 

			} else {
				
				// user creation failed, this should never happen
				$this->response([ 'status' => FALSE,
                    'message' =>'There was a problem creating your new account. Please try again',
					'errors' =>[$this->db->error()]], REST_Controller::HTTP_BAD_REQUEST,'','error');
			}
			
		}
		
	}
	
	//merchant start
	

	

	
	//merchant end
	
	public function valid_password($password = '')
    {
        $password = trim($password);
        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>§~]/';
        if (empty($password))
        {
            $this->form_validation->set_message('valid_password', 'The {field} field is required.');
            return FALSE;
        }
        if (preg_match_all($regex_lowercase, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least one lowercase letter.');
            return FALSE;
        }
        if (preg_match_all($regex_uppercase, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least one uppercase letter.');
            return FALSE;
        }
        if (preg_match_all($regex_number, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must have at least one number.');
            return FALSE;
        }
        if (preg_match_all($regex_special, $password) < 1)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must have at least one special character.' . ' ' . htmlentities('!@#$%^&*()\-_=+{};:,<.>§~'));
            return FALSE;
        }
        if (strlen($password) < 5)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field must be at least 5 characters in length.');
            return FALSE;
        }
        if (strlen($password) > 32)
        {
            $this->form_validation->set_message('valid_password', 'The {field} field cannot exceed 32 characters in length.');
            return FALSE;
        }
        return TRUE;
    }
	 public function date_valid($date)
  {
    $parts = explode("/", $date);
    if (count($parts) == 3) {      
      if (checkdate($parts[2], $parts[0], $parts[1]))
      {
        return TRUE;
      }
    }
    $this->form_validation->set_message('date_valid', 'The {field} field must be yyyy/mm/dd format.');
    return false;
  }
	/**
	 * login function.
	 * 
	 * @access public
	 * @return void
	 */

	 public function login_post() {
		 // Enable error reporting


		$_POST = json_decode($this->input->raw_input_stream, true);
		// Validation rules set karein
		$this->form_validation->set_rules('email', 'Email/Mobile', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
	
		if ($this->form_validation->run() == false) {
			// Validation me koi error hai, use view me bhej dein
			$array_error = array_map(function ($val) {
				return str_replace(array("\r", "\n"), '', strip_tags($val));
			}, array_filter(explode(".", trim(strip_tags(validation_errors())))));
			$this->response([
				'status' => FALSE,
				'errors' =>$array_error,
				'message' =>'Form submit me error hai'
			], REST_Controller::HTTP_BAD_REQUEST,'','error');
	
		} else {
			// Form se variables set karein
			$email = $this->input->post('email');
			$password = $this->input->post('password');
	
			// Check karein ki identifier ek email hai ya mobile number
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$user = $this->user_model->resolve_user_login($email, $password, 'email');
			} else {
				$user = $this->user_model->resolve_user_login($email, $password, 'mobile');
			}
	
			if ($user) {
				// Handle successful login
				$users_id = $this->user_model->get_user_id_from_username($email); // Assuming you have a method to get user ID from identifier
				$user = $this->user_model->get_user($users_id);
				
				if($user->status=='Deactive'){
					// Account inactive hai
					$this->response(
						[
							'status' => FALSE,
							'message' =>'Account active nahi hai, kripya admin se sampark karein'
						], 
						REST_Controller::HTTP_UNAUTHORIZED
					);
				}
				
				// Session user data set karein
				$token_data['id'] = (int)$user->id;
				$token_data['user_type'] = (string)$user->user_type;
				$token_data['email'] = (string)$user->email;
				$token_data['name'] = (string)$user->name;
				$token_data['logged_in'] = (bool)true;
				$token_data['status'] = (bool)$user->status;
				
				// Successful login
				$tokenData = $this->authorization_token->generateToken($token_data);
				$final = array();
				$final['access_token'] = $tokenData;
				$final['status'] = true;
				$final['message'] = 'Login success!';
				$final['note'] = 'You are now logged in.';
				$final['logged_in'] = (bool)true;
				$final['user_type'] = $token_data['user_type'];
				$final['id'] = $token_data['id'];
				// CI session start
				$this->session->set_userdata('user_details', $final);
				// CI session end
				$this->response($final, REST_Controller::HTTP_OK); 
			} else {
				// Login failed
				$this->response(
					[
						'status' => FALSE,
						'message' =>'Wrong email or password'
					], 
					REST_Controller::HTTP_UNAUTHORIZED
				);
			}
		}
	}
	
	
	


	/**
	 * logout function.
	 * 
	 * @access public
	 * @return void
	 */
	public function logout_get() {

		if ($this->session->userdata('user_details')) {
			
			// remove session datas

			$this->session->unset_userdata('user_details');
			// user logout ok
			echo"1";
			
		} else {
			
			echo"0";
		}
		
	}
	
	public function update_password_post($params=''){
		if(!empty($params)){
			$getTokenData = $this->is_authorized($params);
		}else{
			$getTokenData = $this->is_authorized();
		}
		$usersData = json_decode(json_encode($getTokenData), true);
		$session_id = $usersData['data']['id'];
	
		$_POST = json_decode($this->input->raw_input_stream, true);
		
		// Validate old and new passwords
		$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
		$this->form_validation->set_rules('password', 'New Password', 'trim|required');
		$this->form_validation->set_rules('cPassword', 'Confirm New Password', 'trim|required|matches[password]');
	
		if ($this->form_validation->run() === false) {
			// Validation failed, send validation errors to the view
			$array_error = array_map(function ($val) { return str_replace(array("\r", "\n"), '', strip_tags($val));}, array_filter(explode(".", trim(strip_tags(validation_errors())))));
			$this->response(['status' => FALSE,'errors' => $array_error,'message' => 'Error in submit form'], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
		} else {
			// Update password
			$new_password = $this->input->post('password');
			$old_password = $this->input->post('old_password');
			if($new_password==$old_password){
				$this->response(['status' => FALSE,'errors' => ['Please choose different password'],'message' => 'Error in submit form'], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
			}
			else
			{
				$users_id = $usersData['data']['id']; 
				$exist_password =   $this->db->get_where('users',array('id'=>$users_id))->row()->password;
				if(password_verify($old_password, $exist_password))
				{
					$data['password'] = password_hash($new_password, PASSWORD_DEFAULT);
					$data['updatedBy'] = $session_id;
					$data['updated'] = date('Y-m-d H:i:s');
					$user_type = $usersData['data']['user_type']; // Assuming you are updating the password for the currently logged-in user
			
					$res = $this->user_model->update($data, $users_id);
			
					if ($res) {
						// Password update successful
						$final = array();
						$final['status'] = true;
						$final['data'] = $this->user_model->get($user_type, $users_id);
						$final['message'] = 'Password updated successfully.';
						$this->response($final, REST_Controller::HTTP_OK);
					} else {
						// Password update failed
						$this->response([
							'status' => FALSE,
							'errors' => [$this->db->error()],
							'message' => 'There was a problem updating password. Please try again',
						], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
					}
				  }
				  else
				  {
					  $this->response([
							'status' => FALSE,
							'errors' => ['Old Password does not match'],
							'message' => 'Error in submit form',
						], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
					 
				   }
				}
		    }	
	    }

		public function profile_update_post($params=""){
			{
				$getTokenData = $this->is_authorized();
				$usersData = json_decode(json_encode($getTokenData), true);
				$session_id = $usersData['data']['id'];
		
				$_POST = json_decode($this->input->raw_input_stream, true);
				$id = $this->input->post('id');
				// set validation rules
				$this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces|min_length[3]');
				$this->form_validation->set_rules('email',$this->lang->line('email'), 'required|edit_unique[users.email.id.'.$id.']');
				$this->form_validation->set_rules('mobile',$this->lang->line('mobile'), 'required|min_length[10]|edit_unique[users.mobile.id.'.$id.']');
				$this->form_validation->set_rules('address', 'Address', 'trim|required');
		
				if ($this->form_validation->run() === false) {
					$array_error = array_map(function ($val) {
						return str_replace(array("\r", "\n"), '', strip_tags($val));
					}, array_filter(explode(".", trim(strip_tags(validation_errors())))));
		
					$this->response([
						'status' => FALSE,
						'errors' => $array_error,
						'message' => 'Error in submit form'
					], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
				} else {
					// set variables from the form
					$data['name'] = $this->input->post('name');
					$data['company_name'] = $this->input->post('company_name');
					$data['address'] = $this->input->post('address');
					$data['mobile'] = $this->input->post('mobile');
					$data['email'] = $this->input->post('email');
					$users_id = $this->input->post('id');
					// Handle image upload
					
					///image 
				if(!empty($_POST['profile_pic'])){
					$base64_image = $_POST['profile_pic'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'users'; 

					$data['profile_pic'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
					$imgData = $this->db->get_where('users',array('id'=>$users_id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->profile_pic;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
				////image
					// populate $data array with the values from the form fields
					$data['updatedBy'] = $session_id;
					$data['updated'] = date('Y-m-d H:i:s');
					
					$res = $this->user_model->update($data, $users_id);
					
					
					if ($res) {
						// Profile update successful
						
						$final = array();
						$final['status'] = true;
						$final['data'] = $this->user_model->profile_list_get($users_id);
						$final['message'] = 'Profile updated successfully.';
						$this->response($final, REST_Controller::HTTP_OK);
						
					} else {
						// Profile update failed
						$this->response([
							'status' => FALSE,
							'message' => 'There was a problem updating the profile. Please try again',
							'errors' => [$this->db->error()]
						], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
					}
				}
			}
		}
		
	public function user_profile_update_post($params=""){
		if($params=='update'){
				$getTokenData = $this->is_authorized();
				$usersData = json_decode(json_encode($getTokenData), true);
				$session_id = $usersData['data']['id'];
		
				$_POST = json_decode($this->input->raw_input_stream, true);
				$id = $this->input->post('id');
				// set validation rules
				$this->form_validation->set_rules('name', 'Name', 'trim|required|alpha_numeric_spaces|min_length[3]');
				$this->form_validation->set_rules('email',$this->lang->line('email'), 'required|edit_unique[users.email.id.'.$id.']');
				$this->form_validation->set_rules('mobile',$this->lang->line('mobile'), 'required|min_length[10]|edit_unique[users.mobile.id.'.$id.']');
				$this->form_validation->set_rules('address', 'Address', 'trim|required');
		
				if ($this->form_validation->run() === false) {
					$array_error = array_map(function ($val) {
						return str_replace(array("\r", "\n"), '', strip_tags($val));
					}, array_filter(explode(".", trim(strip_tags(validation_errors())))));
		
					$this->response([
						'status' => FALSE,
						'errors' => $array_error,
						'message' => 'Error in submit form'
					], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
				} else {
				
					$data['name'] = $this->input->post('name');
					$data['address'] = $this->input->post('address');
					$data['mobile'] = $this->input->post('mobile');
					$data['email'] = $this->input->post('email');
					//$id = $this->input->post('id');
					//$users_id = $this->input->post('id');
					// Handle image upload
					
					///image 
				if(!empty($_POST['profile_pic'])){
					$base64_image = $_POST['profile_pic'];
					$quality = 90;
					$radioConfig = [
						'resize' => [
						'width' => 500,
						'height' => 300
						]
					 ];
					$uploadFolder = 'users'; 

					$data['profile_pic'] = $this->upload_media->upload_and_save($base64_image, $quality, $radioConfig, $uploadFolder);
					
					$imgData = $this->db->get_where('users',array('id'=>$id));
					if($imgData->num_rows()>0){
						$img =  $imgData->row()->profile_pic;
						if(file_exists($img) && !empty($img))
						{
							unlink($img);		
						}
					}
				}
				////image
					// populate $data array with the values from the form fields
					$data['updatedBy'] = $session_id;
					$data['updated'] = date('Y-m-d H:i:s');
					
					$res = $this->user_model->update($data, $id);
					
					
					if ($res) {
						// Profile update successful
						
						$final = array();
						$final['status'] = true;
						//$final['data'] = $this->user_model->profile_list_get($id);
						$final['message'] = 'Profile updated successfully.';
						redirect('admin/master/my_profile', 'refresh');

						exit();
						$this->response($final, REST_Controller::HTTP_OK);
						redirect ('admin/master/my_profile');
					} else {
						// Profile update failed
						$this->response([
							'status' => FALSE,
							'message' => 'There was a problem updating the profile. Please try again',
							'errors' => [$this->db->error()]
						], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
					}
				}
			}
		}

	public function profile_list_get($id=''){
		$getTokenData = $this->is_authorized();
		
		$final = array();
		$final['status'] = true;
		$final['data'] = $this->user_model->profile_list_get($id);
		$final['message'] = 'Profile data fetched successfully.';
		$this->response($final, REST_Controller::HTTP_OK); 
	}
	
	public function table_name_get(){
        $tables = $this->db->list_tables();
		$sr = 1;
        foreach ($tables as $table){
           echo $sr ++ .' '.$table.'<br>';
        }
    }
	
	public function field_name_get(){
		$table = 'users'; 
		$fields = $this->db->list_fields($table);
		$sr = 1;

		echo '<h3>Fields in ' . $table . ' table:</h3>';
		echo '<ul>';
		foreach ($fields as $field){
			echo '<li>' . $sr++ . '. ' . $field . '</li>';
		}
		echo '</ul>';

		// अब fields के data को display करें
		$query = $this->db->get($table); // पूरा table data retrieve करें
		$results = $query->result_array();

		echo '<h3>Data in ' . $table . ' table:</h3>';
		echo '<table border="1" cellpadding="5" cellspacing="0">';
		echo '<tr>';

		// Table header (fields के नाम)
		foreach ($fields as $field){
			echo '<th>' . $field . '</th>';
		}
		echo '</tr>';

		// Table data
		foreach ($results as $row){
			echo '<tr>';
			foreach ($fields as $field){
				echo '<td>' . $row[$field] . '</td>';
			}
			echo '</tr>';
		}
		echo '</table>';
}

public function signup_post() {
    // Decode the JSON input
	// log_message('debug', 'signup_post method called');
    $_POST = json_decode($this->input->raw_input_stream, true);

	$this->form_validation->set_rules('name', 'Username', 'trim|required|xss_clean|alpha_numeric|min_length[3]');
	$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|is_unique[users.email]');
	$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|xss_clean|min_length[10]');
	$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[6]');
	$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|min_length[6]|matches[password]');
	$this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required');
	$this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
	$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
	

    if ($this->form_validation->run() === false) {
        // Validation not ok, send validation errors to the view
        $array_error = array_map(function ($val) {
            return str_replace(array("\r", "\n"), '', strip_tags($val));
        }, array_filter(explode(".", trim(strip_tags(validation_errors())))));
        
        $this->response([
            'status' => FALSE,
            'errors' => $array_error,
            'message' => 'Error in submit form'
        ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
    } else {
        // Set variables from the form
		$data = [
			'name' => $this->input->post('name', TRUE),
			'email' => $this->input->post('email', TRUE),
			'mobile' => $this->input->post('mobile', TRUE),
			'password' => password_hash($this->input->post('password', TRUE), PASSWORD_DEFAULT),
			'date_of_birth' => $this->input->post('date_of_birth', TRUE),
			'user_type' => $this->input->post('user_type', TRUE),
			'last_name' => $this->input->post('last_name', TRUE),
			'country_id' => $this->input->post('country_id', TRUE),
			'zip_code' => $this->input->post('zip_code', TRUE),
			'languages' => $this->input->post('languages', TRUE),
			'address' => $this->input->post('address', TRUE), // Add address here
			'profile_pic' => $this->input->post('profile_pic', TRUE), // Add profile_pic here
			'added' => date('Y-m-d H:i:s'),
			'status' => 'Active',
		];
		

        // Create user in the database
        if ($res = $this->user_model->create_user($data)) {
            // User creation ok
            $token_data = [
                'id' => $res,
                'username' => $data['email'],
                'user_type' => (string) $data['user_type'],
                'email' => (string) $data['email'],
                'name' => (string) $data['name'],
                'logged_in' => (bool) true,
                'status' => (bool) $data['status'],
            ];

            // Generate token
            $tokenData = $this->authorization_token->generateToken($token_data);
            $final = [
                'access_token' => $tokenData,
                'status' => true,
                'id' => $res,
                'message' => 'Thank you for signup your new account!',
                'note' => 'You have successfully signup.',
                'user_type' => $token_data['user_type'],
                'logged_in' => (bool) true,
            ];

            $this->response($final, REST_Controller::HTTP_OK);
        } else {
            // User creation failed, this should never happen
            $this->response([
                'status' => FALSE,
                'message' => 'There was a problem creating your new account. Please try again',
                'errors' => [$this->db->error()]
            ], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
        }
    }
}


public function company_user_post($params='') {

	if($params=='add') {
		$getTokenData = $this->is_authorized('superadmin');
		$usersData = json_decode(json_encode($getTokenData), true);
		$session_id = $usersData['data']['id'];

		$_POST = json_decode($this->input->raw_input_stream, true);

		// set validation rules
		$this->form_validation->set_rules('name', 'Username', 'trim|required|xss_clean|alpha_numeric|min_length[3]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|is_unique[users.email]');
		$this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|xss_clean|min_length[10]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|min_length[6]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|min_length[6]|matches[password]');
	
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
			$data['last_name'] = $this->input->post('last_name',TRUE);
			$date_of_birth = $this->input->post('date_of_birth', TRUE);

			// अगर डेट पिकर से ली गई तारीख सही है तो उसे फॉर्मेट करें
			if ($date_of_birth) {
				$formatted_date_of_birth = date('Y-m-d', strtotime($date_of_birth));
				$data['date_of_birth'] = $formatted_date_of_birth;
			} else {
				$data['date_of_birth'] = NULL; // अगर तारीख नहीं है तो NULL कर सकते हैं
			}
							$data['country_id'] = $this->input->post('country_id',TRUE);
			$data['email'] = $this->input->post('email',TRUE);
			$data['state_id'] = $this->input->post('state_id',TRUE);
			$data['cologne'] = $this->input->post('cologne',TRUE);
			$data['street'] = $this->input->post('street',TRUE);
			$data['crossings'] = $this->input->post('crossings',TRUE);
			$data['external_number'] = $this->input->post('external_number',TRUE);
			$data['interior_number'] = $this->input->post('interior_number',TRUE);
			$data['zip_code'] = $this->input->post('zip_code',TRUE);
			$data['password'] = password_hash($this->input->post('password',TRUE),PASSWORD_DEFAULT);
			$data['confirm_password'] = $this->input->post('confirm_password',TRUE);
			$data['mobile'] = $this->input->post('mobile',TRUE);
			$data['user_type'] = $this->input->post('guy',TRUE);
			$radius = $this->input->post('radius', TRUE);
			 $data['radius'] = (is_null($radius) || $radius === '') ? 0 : (int)$radius; // Ensure it's an integer


		   $languages = $this->input->post('languages');
			if (is_array($languages)) {
				$languages = implode(',', $languages);
			} else {
				$languages = ''; // Handle the case where no languages are selected
			}
			$data['languages'] = $languages;

		   $languages = $this->input->post('languages');
				if(!empty($languages)){
				$languages = implode(",",$languages);
				$data['languages'] = $languages;
				}
			
		   // $data['image'] = $this->input->post('image',TRUE);
			if(!empty($_POST['image'])){
				$base64_image = $_POST['image'];
				$quality = 90;
				$radiusConfig = [
					'resize' => [
					'width' => 500,
					'height' => 300
					]
				 ];
				$uploadFolder = 'regular_user'; 

				$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radiusConfig, $uploadFolder);
				
			}
				
			$data['status'] = 'Active';
			$data['added'] = date('Y-m-d H:i:s');
			$data['addedBy'] = $session_id;

			if ($res = $this->user_model->create_user($data)) {
				// Regular User creation ok
				$final = array();
				$final['status'] = true;
				$final['data'] = $this->user_model->get();
				$final['message'] = 'Regular User created successfully.';
				$this->response($final, REST_Controller::HTTP_OK); 
			} else {
				// Regular user creation failed, this should never happen
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
			$data['last_name'] = $this->input->post('last_name',TRUE);
			$date_of_birth = $this->input->post('date_of_birth', TRUE);

			// अगर डेट पिकर से ली गई तारीख सही है तो उसे फॉर्मेट करें
			if ($date_of_birth) {
				$formatted_date_of_birth = date('Y-m-d', strtotime($date_of_birth));
				$data['date_of_birth'] = $formatted_date_of_birth;
			} else {
				$data['date_of_birth'] = NULL; // अगर तारीख नहीं है तो NULL कर सकते हैं
			}
			$data['country_id'] = $this->input->post('country_id',TRUE);
			$data['email'] = $this->input->post('email',TRUE);
			$data['state_id'] = $this->input->post('state_id',TRUE);
			$data['cologne'] = $this->input->post('cologne',TRUE);
			$data['street'] = $this->input->post('street',TRUE);
			$data['crossings'] = $this->input->post('crossings',TRUE);
			$data['external_number'] = $this->input->post('external_number',TRUE);
			$data['interior_number'] = $this->input->post('interior_number',TRUE);
			$data['zip_code'] = $this->input->post('zip_code',TRUE);
			$data['password'] = password_hash($this->input->post('password',TRUE),PASSWORD_DEFAULT);
			$data['confirm_password'] = $this->input->post('confirm_password',TRUE);
			$data['mobile'] = $this->input->post('mobile',TRUE);
			$data['guy'] = $this->input->post('guy',TRUE);
			$radius = $this->input->post('radius', TRUE);
			$data['radius'] = (is_null($radius) || $radius === '') ? 0 : (int)$radius; // Ensure it's an integer

			$languages = $this->input->post('languages');
				if (is_array($languages)) {
					$languages = implode(",", $languages);
				} else {
					$languages = ''; // Handle the case where no languages are selected
				}
				$data['languages'] = $languages;


			$status = $this->input->post('status',TRUE);
			if (!empty($status)) {
				$data['status'] = $status;
			}
			
			///image 
			if(!empty($_POST['image'])){
				$base64_image = $_POST['image'];
				$quality = 90;
				$radiusConfig = [
					'resize' => [
					'width' => 500,
					'height' => 300
					]
				 ];
				$uploadFolder = 'regular_user'; 

				$data['image'] = $this->upload_media->upload_and_save($base64_image, $quality, $radiusConfig, $uploadFolder);
				
				$imgData = $this->db->get_where('regular_user',array('id'=>$id));
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
			
			$res = $this->regular_user_model->update($data, $id);
	
			if ($res) {
				// regular_user update ok
				$final = array();
				$final['status'] = true;
				$final['data'] = $this->regular_user_model->get($id);
				$final['message'] = 'Regular user updated successfully.';
				$this->response($final, REST_Controller::HTTP_OK);
			} else {
				// regular_user update failed, this should never happen
				$this->response([
					'status' => FALSE,
					'message' => 'There was a problem updating regular user. Please try again',
					'errors' => [$this->db->error()]
				], REST_Controller::HTTP_BAD_REQUEST, '', 'error');
			}
		}
	}
	
}
   
public function company_user_list_post($role='') {
	$input_data = file_get_contents('php://input');
	$request_data = json_decode($input_data, true);

	$id = $this->input->get('id') ? $this->input->get('id') : 0;
	$role = $role ? $role : '';

	$page = isset($request_data['page']) ? $request_data['page'] : 1; // Default to page 1 if not provided
	$limit = isset($request_data['limit']) ? $request_data['limit'] : 10; // Default limit to 10 if not provided
	$filterData = isset($request_data['filterData']) ? $request_data['filterData'] : [];

	$getTokenData = $this->is_authorized('superadmin');
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
	$getTokenData = $this->is_authorized('superadmin');
	$data =  $this->user_model->show($id);
	$response = [
		'status' => true,
		'data' => $data,
		'message' => 'El usuario de la empresa fetched correctamente.'
	];
	$this->response($response, REST_Controller::HTTP_OK); 
}

public function company_user_delete($id) {
	$this->is_authorized('superadmin');
	$response = $this->user_model->delete($id);

	if ($response) {
		$this->response(['status' => true, 'message' => 'regular user deleted successfully.'], REST_Controller::HTTP_OK);
	} else {
		$this->response(['status' => false, 'message' => 'Not deleted'], REST_Controller::HTTP_BAD_REQUEST);
	}
}
	


}

?>