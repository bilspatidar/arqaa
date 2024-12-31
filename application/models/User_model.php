<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

	protected $table      = 'users';
	protected $primaryKey = 'id';
	protected $merchant_keys = 'merchant_keys';
	protected $merchant_id = 'merchant_id';
	protected $documents = 'documents';
	protected $users_id = 'users_id';
	protected $invoice = 'invoice';
	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->database();		
		
	}
	
	/**
	 * create_user function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	
	 public function create_employee($data) {
		$this->db->insert($this->table, $data);
		return $this->db->insert_id(); 
	}
	
	 public function create_user($data) {
		$this->db->insert($this->table, $data);
		return $this->db->insert_id(); 
	}


	
	public function get_permission_by_module($module_name, $user_id) {ini_set('display_errors', 1);
		// Query to check if the permission exists for the given module and user
		// $this->db->where('module_name', $module_name);
		$this->db->where('user_id', $user_id);
		$query = $this->db->get('user_permission');
		
		if ($query->num_rows() > 0) {
			return $query->row_array();  // Return the existing permission row
		}
		return null;  // No permission found
	}
	
	public function create_user_permission($data) {
		// Insert the permission data into the user_permissions table
		$this->db->insert('user_permission', $data);
		return $this->db->insert_id();  // Return the ID of the newly inserted record
	}
	public function update_permission($permission_id, $data) {
		// Update the permission record for the given permission ID
		$this->db->where('id', $permission_id);
		$this->db->update('user_permission', $data);
		return $this->db->affected_rows();  // Return number of affected rows
	}
	
	
	
	public function show($id) {
        $this->db->select("*");
        $this->db->from($this->table);
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        return $this->db->get()->result();
    }

	public function update($data, $id)
    {
        $response = $this->db->update($this->table, $data, array($this->primaryKey=>$id));
		return $this->db->affected_rows();
    }
	
	public function delete($id)
    {
        $this->db->delete($this->table, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }
	
	public function member_profile_get($isCount = '',$id='',$limit='',$page = '',$filterData=''){
		$this->db->select("$this->table.id, $this->table.name, $this->table.email, $this->table.mobile, $this->table.password, $this->table.company_name, $this->table.postal_code, $this->table.country_id, $this->table.state_id, $this->table.city_id, $this->table.street_address, $this->table.street_address2, $this->table.business_type_id, $this->table.business_category_id, $this->table.business_subcategory_id, $this->table.skypeID, $this->table.websiteURL, $this->table.business_registered, $this->table.user_type, $this->table.merchant_pay_in_charge, $this->table.merchant_pay_out_charge, $this->table.settelment_charge, $this->table.turnover, $this->table.chargeback_percentage, $this->table.status, $this->table.added, $this->table.addedBy, $this->documents.document_number, $this->documents.document_category_id, $this->documents.document_sub_category_id, $this->documents.title, $this->documents.document_front_file, $this->documents.document_back_file, $this->invoice.amount, $this->invoice.paid_amount, $this->invoice.wallet_amount, $this->invoice.reward_point, $this->invoice.payment_mode_id, $this->invoice.invoice_type, $this->invoice.invoice_number, $this->invoice.attachment, $this->invoice.notes, $this->invoice.shipping_address");
				$this->db->from($this->table);
				//$this->db->join($this->documents, "$this->documents.users_id = $this->table.users_id");
				$this->db->join($this->documents,"$this->documents.$this->users_id=$this->table.$this->primaryKey", "left");
				$this->db->join($this->invoice,"$this->invoice.$this->users_id=$this->table.$this->primaryKey", "left"	);
				if(!empty($id)){
					$this->db->where($this->table.'.'.$this->primaryKey,$id);
				}
				if(isset($filterData['invoice_number']) && !empty($filterData['invoice_number'])){
					$this->db->where($this->invoice.'.'.'invoice_number',$filterData['invoice_number']);
				}
				if(isset($filterData['payment_mode_id']) && !empty($filterData['payment_mode_id'])){
					$this->db->where($this->invoice.'.'.'payment_mode_id',$filterData['payment_mode_id']);
				}
				if(isset($filterData['invoice_type']) && !empty($filterData['invoice_type'])){
					$this->db->where($this->invoice.'.'.'invoice_type',$filterData['invoice_type']);
				}
				if(isset($filterData['document_number']) && !empty($filterData['document_number'])){
					$this->db->where($this->documents.'.'.'document_number',$filterData['document_number']);
				}
				if(isset($filterData['document_category_id']) && !empty($filterData['document_category_id'])){
					$this->db->where($this->documents.'.'.'document_category_id',$filterData['document_category_id']);
				}
				if(isset($filterData['document_sub_category_id']) && !empty($filterData['document_sub_category_id'])){
					$this->db->where($this->documents.'.'.'document_sub_category_id',$filterData['document_sub_category_id']);
				}
				if(isset($filterData['title']) && !empty($filterData['title'])){
					$this->db->where($this->documents.'.'.'title',$filterData['title']);
				}
				$this->db->order_by($this->table.'.'.$this->primaryKey,'asc');
				if(isset($filterData['users_id']) && !empty($filterData['users_id'])){
					$this->db->where($this->table.'.'.'id',$filterData['users_id']);
				}
				if(isset($filterData['name']) && !empty($filterData['name'])){
					$this->db->like($this->table.'.'.'name',$filterData['name']);
					$this->db->or_like($this->table.'.'.'email',$filterData['name']);
					$this->db->or_like($this->table.'.'.'mobile',$filterData['name']);
				}
				if(isset($filterData['business_type_id']) && !empty($filterData['business_type_id'])){
					$this->db->where($this->table.'.'.'business_type_id',$filterData['business_type_id']);
				}
				if(isset($filterData['business_category_id']) && !empty($filterData['business_category_id'])){
					$this->db->where($this->table.'.'.'business_category_id',$filterData['business_category_id']);
				}
				if(isset($filterData['business_subcategory_id']) && !empty($filterData['business_subcategory_id'])){
					$this->db->where($this->table.'.'.'business_subcategory_id',$filterData['business_subcategory_id']);
				}
				if(isset($filterData['city_id']) && !empty($filterData['city_id'])){
					$this->db->where($this->table.'.'.'city_id',$filterData['city_id']);
				}
				if(isset($filterData['state_id']) && !empty($filterData['state_id'])){
					$this->db->where($this->table.'.'.'state_id',$filterData['state_id']);
				}
				if(isset($filterData['country_id']) && !empty($filterData['country_id'])){
					$this->db->where($this->table.'.'.'country_id',$filterData['country_id']);
				}
				if(isset($filterData['status']) && !empty($filterData['status'])){
					$this->db->where($this->table.'.'.'status',$filterData['status']);
				}
				if(isset($filterData['from_date']) && !empty($filterData['from_date'])){
					$from_date = date('Y-m-d',strtotime($filterData['from_date']));
					$this->db->where('CAST('.$this->table.'.'.'added AS DATE)>=',$from_date);
				}
				if(isset($filterData['to_date']) && !empty($filterData['to_date'])){
					$to_date = date('Y-m-d',strtotime($filterData['to_date']));
					$this->db->where('CAST('.$this->table.'.'.'added AS DATE)<=',$to_date);
				}
				$this->db->order_by($this->table.'.'.$this->primaryKey,'desc');

				if($isCount=='yes'){
					$all_res = $this->db->get();
					return $all_res->num_rows();
						
				   }
				   else{
					$this->db->limit($limit, $page);
					return $this->db->get()->result();
				   }

	}
	
	
	public function get($isCount ='',$id='',$limit='',$page ='',$filterData='',$role='') {
		
        $this->db->select("*");
        $this->db->from($this->table);
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
		// if(isset($filterData['name']) && !empty($filterData['name'])){
		// 	$this->db->like('name',$filterData['name']);
		// }
		if(isset($filterData['status'])){
			$this->db->where('status',$filterData['status']);
		}
        if(!empty($role)){
			$this->db->where('user_type',$role);
		}
        
		$this->db->order_by($this->primaryKey,'desc');
        if($isCount=='yes'){
            $all_res = $this->db->get();
            return $all_res->num_rows();
                
           }
           else{
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
           }
        
    }
	public function profile_list_get($id=''){
		
		/*$this->db->select("$this->table.id,$this->table.name,$this->table.email,$this->table.mobile,$this->table.company_name,$this->table.address,$this->table.profile_pic,$this->table.user_type,$this->table.status");
		*/
		$this->db->select("$this->table.id,$this->table.name,$this->table.email,$this->table.mobile,$this->table.address,$this->table.profile_pic,$this->table.user_type,$this->table.status");
		$this->db->from($this->table);
		if(!empty($id)){
			$this->db->where($this->table.'.'.$this->primaryKey,$id);
		}
		$this->db->order_by($this->table.'.'.$this->primaryKey,'desc');
		return $this->db->get()->result();
		
	}
	
	public function get_user_data($id = 0) {
		$this->db->select("*");
		$this->db->from('users'); // Replace 'users' with your actual table name
		
		// If an ID is provided, filter by the user ID
		if ($id > 0) {
			$this->db->where('id', $id);
		}
	
		// Execute the query
		$query = $this->db->get();
	
		// Return a single user record if ID is provided, otherwise return all records
		if ($id > 0) {
			return $query->row_array(); // Fetch a single user record
		} else {
			return $query->result_array(); // Fetch all user records
		}
	}
	
	

	public function delete_merchant($id)
    {
        $res = $this->db->delete($this->table, array($this->primaryKey=>$id));
		if($res){
			$this->db->delete($this->merchant_keys, array($this->merchant_id=>$id));
		}
        return $this->db->affected_rows();
    }
	
	/**
	 * resolve_user_login function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login00($username, $password) {
		
		$this->db->select('email,password');
		$this->db->from('users');
		$this->db->where('email',$username);
		$hash = $this->db->get()->row('password');
		
		return $this->verify_password_hash($password,$hash);
		
	}
	public function resolve_user_login($identifier, $password, $identifier_type) {
		if ($identifier_type === 'email') {
			$this->db->where('email', $identifier);
		} else {
			$this->db->where('mobile', $identifier);
		}
		
		$this->db->select('email, password');
		$this->db->from('users');
		$hash = $this->db->get()->row('password');
		
		return $this->verify_password_hash($password, $hash);
	}
	
	/**
	 * 
	 * get_user_id_from_username function.
	 * 
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_id_from_username($email) {
		
		$this->db->select('id');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->or_where('mobile', $email);
		// if ($email === 'email') {
		// 	$this->db->where('email', $email);
		// } else {
		// 	$this->db->where('mobile', $email);
		// }

		return $this->db->get()->row('id');
		
	}
	
	
	public function validate_user_by_email_or_phone($email) {
		
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->or_where('mobile', $email);
		$get_res = $this->db->get();
		if($get_res->num_rows()>0){
		    return $get_res->result();
		}
		else{
		    return false;
		}
		
	}
	
	public function validate_user_by_email_or_phone_and_otp($email,$otp){
	    $this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('forgot_email_otp', $otp);
		$get_res = $this->db->get();
		if($get_res->num_rows()>0){
		    return $get_res->result();
		}
		else{
		    return false;
		}
	}
	
	public function validate_user_by_email_or_phone_and_token($email,$token){
	    $this->db->select('*');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('user_token', $token);
		$get_res = $this->db->get();
		if($get_res->num_rows()>0){
		    return $get_res->result();
		}
		else{
		    return false;
		}
	}
	
	
	
	/**
	 * get_user function.
	 * 
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {
		
		$this->db->from('users');
		$this->db->where('id', $user_id);
		return $this->db->get()->row();
		
	}
	
	/**
	 * hash_password function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {
		
		return password_hash($password, PASSWORD_BCRYPT);
		
	}
	
	/**
	 * verify_password_hash function.
	 * 
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {
		
		return password_verify($password, $hash);
		
	}
	
	public function employee_get($isCount = '',$id='',$limit='',$page = '',$filterData='') {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->order_by('id','DESC');
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
		if(isset($filterData['first_name']) && !empty($filterData['first_name'])){
			$this->db->like('first_name',$filterData['first_name']);
		}
		if(isset($filterData['status']) && !empty($filterData['status'])){
			$this->db->like('status',$filterData['status']);
		}
       
        if($isCount=='yes'){
            $all_res = $this->db->get();
            return $all_res->num_rows();
                
           }
           else{
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
           }
    }

	public function employee_joi_get($isCount = '',$id='',$limit='',$page = '',$filterData='') {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->order_by('id','DESC');
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
		if(isset($filterData['first_name']) && !empty($filterData['first_name'])){
			$this->db->like('first_name',$filterData['first_name']);
		}
		if(isset($filterData['status']) && !empty($filterData['status'])){
			$this->db->like('status',$filterData['status']);
		}
       
        if($isCount=='yes'){
            $all_res = $this->db->get();
            return $all_res->num_rows();
                
           }
           else{
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
           }
    }

	
	public function get_user_details($user_id) {
		$this->db->select('*'); // Adjust the fields to fetch only necessary ones.
		$this->db->from('users'); // Replace 'users' with your actual table name.
		$this->db->where('id', $user_id);
		$query = $this->db->get();
	
		if ($query->num_rows() > 0) {
			return $query->row_array(); // Return user details as an associative array.
		} else {
			return false; // No user found for the given user_id.
		}
	}
	
	public function chat_create($data) {
        $this->db->insert('chat', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

	public function chat_get($count = 'no', $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        $this->db->select('*')->from('chat');
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if ($count === 'yes') {
            return $this->db->count_all_results();
        }
		$this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

	public function chat_update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('chat', $data);
        return $this->db->affected_rows() > 0;
    }

	public function chat_delete($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('chat')) {
            return true;
        }
        return false;
    }
}
