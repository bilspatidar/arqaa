<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Internal_model extends CI_Model {

    protected $table      = 'document_category';
    protected $primaryKey = 'id';

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



    public function get_document_category() {
        $this->db->select("*");
        $this->db->from($this->table); 
        $this->db->where('status','Active'); 
        return $this->db->get()->result();
    }
    public function getDocumentCategory() {
        $this->db->select("documents.*, users.first_name as firstName, users.id as UserId");
        $this->db->from('documents');
        $this->db->join('users', 'users.id = documents.users_id', 'left');
        $this->db->where('documents.status', 'Active');
        
        $query = $this->db->get();
        
        if ($query === FALSE) {
            $error = $this->db->error();
            log_message('error', 'Database Error: ' . $error['message']);
            return array();
        }
        
        return $query->result();
    }
    
    public function get_document_sub_category() {
        $this->db->select("*");
        $this->db->from('document_subcategory'); 
        $this->db->where('status','Active'); 
        return $this->db->get()->result();
    }
    public function get_currency($array=''){
        $this->db->select('id, name,symbol');
        $this->db->from('currency');
        $this->db->group_by('name');  // 'name' ke basis par grouping
        return $this->db->get()->result();
    }
    
    
    public function get_country($array=''){
        $this->db->select('id,name');
        
             $this->db->from('countries');
        return $this->db->get()->result();
      }
      
	public function get_state($country_id=''){
        $this->db->select('id,name');
        if(!empty($country_id)){
            $this->db->where('country_id',$country_id);
        }
        $this->db->from('states');
        return $this->db->get()->result();
      }
      public function get_city($state_id=''){
        $this->db->select('id,name');
        if(!empty($state_id)){
            $this->db->where('state_id',$state_id);
        }
        $this->db->from('cities');
        return $this->db->get()->result();
      }

    public function state_show($country_id) {
        $this->db->select("states.*");
        $this->db->from('states');
       // $this->db->join($this->table, "$this->table.users_id = states.id");
        if (!empty($country_id)) {
            $this->db->where("states.country_id", $country_id);
        }
        return $this->db->get()->result();
    }
    public function city_show($state_id) {
        $this->db->select("*");
        $this->db->from('cities');
        if (!empty($state_id)) {
            $this->db->where("state_id", $state_id);
        }
        return $this->db->get()->result();
    }
    public function get_salary_head() {
        $this->db->select("*");
        $this->db->from('salary_head');
        $this->db->where("status", 'Active');
        return $this->db->get()->result();
    }
    public function get_site() {
        $this->db->select("*");
        $this->db->from('branch');
        $this->db->where("status", 'Active');
        return $this->db->get()->result();
    }
    public function get_expense_categories() {
        $this->db->select("*");
        $this->db->from('pms_expense_categories');
        $this->db->where("status", 'Active');
        return $this->db->get()->result();
    }
    public function get_expense_user() {
        $this->db->select('users.*');
        $this->db->from('users');
        $this->db->join('expenses',"expenses.addedBy=users.id",'left');
        $this->db->where('users.user_type !=', 'superadmin');
        $this->db->where('users.status', 'Active');
        $this->db->group_by('users.id');
        return $this->db->get()->result();
    }
    public function get_user_details($id='') {
        $this->db->select("user_profile.*,users.first_name,users.last_name,users.father_name,users.mother_name,
        users.user_type,users.dob,users.mobile,users.email,users.state_id,(states.name) as state_name,(cities.name) as city_name");
        $this->db->from('user_profile');
		$this->db->join('users',"users.id=user_profile.users_id",'left');
        $this->db->join('states',"users.state_id=states.id",'left');
        $this->db->join('cities',"users.city_id=cities.id",'left');
        if(!empty($id)) {
            $this->db->where('user_profile.users_id', $id);
        }
        return $this->db->get()->result();
    }
    

    public function get_col_by_key($table,$key,$value,$col_name){
	    $this->db->select($col_name);
	    $this->db->from($table);
	    $this->db->where($key,$value);
	    $res = $this->db->get();
	    if($res->num_rows()>0)
	    {
	     return $res->row()->$col_name;
	    }
	    else
	    {
	     $na ="";
	     return $na; 
	    }
	}

    public function getUser($date = '') {
        $userDetails = $this->session->userdata('user_details');
        $user_type = $userDetails['user_type'];
        $users_id = $userDetails['id'];
        $branch_id = $this->get_branch_id($users_id);
      
        if (!empty($date)) {
            $this->db->select('user_profile.*, (user_profile.users_id) as users_name, (attendance.id) as attendance_id, attendance.remarks, attendance.latitude, attendance.longitude, attendance.status');
            $this->db->join('attendance', 'attendance.user_id = users.id AND attendance.date = "' . $date . '"', 'left');    
        } else {
            $this->db->select('user_profile.*, (user_profile.users_id) as users_name');   
        }
        $this->db->from('users');
        $this->db->join('user_profile', 'user_profile.users_id = users.id');
        $this->db->join('user_branch_link', 'user_branch_link.user_id = users.id' , 'left');
        $this->db->where('user_profile.user_type !=', 'superadmin');
        $this->db->where('user_profile.status', 'Active');
        if($user_type == 'admin'){
            $this->db->where('user_branch_link.branch_id', $branch_id);
            $this->db->where('users.id !=', $users_id);
            $this->db->where('user_branch_link.branch_id >', 0); 
        }elseif($user_type == 'supervisor'){
            $this->db->where('user_branch_link.branch_id', $branch_id);
            $this->db->where('users.id !=', $users_id);
            $this->db->where('users.user_type !=', 'admin');
            $this->db->where('user_branch_link.branch_id >', 0); 
        }
        $this->db->group_by('users.id');
        return $this->db->get()->result();
    }
    public function get_user() {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_type !=', 'superadmin');
        $this->db->where('status', 'Active');
        $this->db->group_by('id');
        return $this->db->get()->result();
    }
    public function get_user_employee() {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_type', 'employee');
        $this->db->where('status', 'Active');
        return $this->db->get()->result();
    }
    public function get_agent() {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_type', 'agent');
        $this->db->where('status', 'Active');
        return $this->db->get()->result();
    }
    public function get_manager() {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_type', 'manager');
        $this->db->where('status', 'Active');
        return $this->db->get()->result();
    }
    public function get_branch() {
    $this->db->select('*');
    $this->db->from('branch');
    $this->db->where('status', 'Active');
  
    return $this->db->get()->result();
}
public function get_branch_id($id='') {
    $this->db->select('branch_id');
    $this->db->from('user_branch_link');
    $this->db->where('user_id', $id);
    $this->db->where('status', 'Active');
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->row()->branch_id;
    } else {
        return 0;
    }
}
public function get_from_role($id = '') {
    $this->db->select('user_type');
    $this->db->from('users');
    $this->db->where('id', $id);
    $this->db->where('status', 'Active');
    $result = $this->db->get()->row(); 
    if ($result) {
        return $result->user_type; 
    } else {
        return ''; 
    }
}
public function update_status($user_id=''){
    $data['status'] = 'Deactive';
    $this->db->where('user_id', $user_id);
    $this->db->order_by('id', 'desc');
    $this->db->limit(1);
    $this->db->update('user_branch_link',$data);
}
    public function get_user_document($date = '') {
        
        $this->db->select('user_profile.*, (user_profile.users_id) as users_name');
        $this->db->from('users');
        $this->db->join('user_profile', 'user_profile.users_id = users.id');
        $this->db->where('user_profile.user_type !=', 'superadmin');
        $this->db->where('user_profile.status', 'Active');
        $this->db->group_by('users.id');
    
        return $this->db->get()->result();
    }    
    public function GenerateEmployeeCode(){
        $this->db->select('employee_code');
        $this->db->from('users');
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        $ifAny = $this->db->get();
       if($ifAny->num_rows()>0){
         $employee_code = $ifAny->row()->employee_code+1;
        }
       return $employee_code;
   }
   private function get_last_branch_employee_code() {
    $this->db->select('branch_employee_code');
    $this->db->from('user_branch_link');
    $this->db->order_by('id', 'desc');
    $this->db->limit(1);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        return $query->row()->branch_employee_code;
    } else {
        return 0;
    }
}
   public function GenerateEmployeeBranchCode($id=''){
    $check_user = $this->db->get_where('user_branch_link',array('user_id' => $id));
    if($check_user->num_rows()>0){
        return $this->get_last_branch_employee_code() + 1;
    //     return 17;
    //     exit();
    // $this->db->select('branch_employee_code');
    // $this->db->from('user_branch_link');
    // $this->db->order_by('id', 'desc');
    // $this->db->limit(1);
    // $query = $this->db->get();
    //     $new_code = $query->row()->branch_employee_code + 1;
    } else {    
    $this->db->select('employee_code');
    $this->db->from('users');
    $this->db->order_by('id', 'desc');
    $this->db->where('id', $id);
    $this->db->limit(1);
    $query = $this->db->get();
    if ($query->num_rows() > 0) {
        $new_code = $query->row()->employee_code + 1;
    } else {
        $new_code = '1';
    } 
    return $new_code;
}
}
    public function getDPSCode($code=''){
        return 'DPS'.$code;
    }
    public function getUserRole($array=''){
		$userDetails = $this->session->userdata('user_details');
        $user_type = $userDetails['user_type'];

        $this->db->select('id,slug,name');
        $this->db->from('user_role');
        if($user_type=='admin'){
            $this->db->where('id >',1);
        }
        $this->db->where('status','Active');
      return $this->db->get()->result();
    }
    public function get_user_document_category($users_id = '',$document_category_id='') {
        $this->db->select("documents.*,(users.first_name) as firstName,(document_category.name) as DC_name,(users.id) as UserId");
        $this->db->from('documents');
        $this->db->join('users','users.id = documents.users_id','left');
        $this->db->join('document_category','document_category.id = documents.document_category_id','left');
        $this->db->order_by('documents.id','desc');
        // return $this->db->get()->result();
        $data = $this->db->get();
        if($data->num_rows()>0){
            return $data->result();
        }else{
            return "No";
        }
            }

    public function get_payment_mode() {
        $this->db->select("*");
        $this->db->from('payment_mode');
        $this->db->where("status", 'Active');
        return $this->db->get()->result();
    }
    public function get_project() {
        $this->db->select("*");
        $this->db->from('pms_project');
        // $this->db->where("status", 'Active');
        return $this->db->get()->result();
    }
    public function get_machines() {
        $this->db->select("*");
        $this->db->from('machines');
        $this->db->where("status", 'Active');
        return $this->db->get()->result();
    }
    public function get_blog_category() {
        $this->db->select("*");
        $this->db->from('blog_category');
        $this->db->where("status", 'Active');
        return $this->db->get()->result();
    }
    public function get_total_expenses($project_id='') {
        $this->db->select("*");
        $this->db->from('expenses');
        $this->db->where("project_id", $project_id);
        $this->db->where("status", 'Approved');
        return $this->db->get()->result();
    }
    public function get_total_income($project_id='') {
        $this->db->select("*");
        $this->db->from('payments');
        $this->db->where("project_id", $project_id);
        $this->db->where("status", 'Approved');
        return $this->db->get()->result();
    }
    public function getTotalExpenses($project_id='') {
        $this->db->select("*");
        $this->db->from('expenses');
        $this->db->where("project_id", $project_id);
        $this->db->where("status", 'Approved');
        $query = $this->db->get();
        if($query->num_rows()>0){
            $result = $query->result();
            $sumAmount =0;
            foreach($result as $row){
                $sumAmount += $row->amount;
                return $sumAmount;
            }
        }else{
            return 0;
        }
    }
    public function getTotalIncome($project_id='') {
        $this->db->select("*");
        $this->db->from('payments');
        $this->db->where("project_id", $project_id);
        $this->db->where("status", 'Approved');
        $query = $this->db->get();
        if($query->num_rows()>0){
            $result = $query->result();
            $sumAmount =0;
            foreach($result as $row){
                $sumAmount += $row->amount;
                return $sumAmount;
            }
        }else{
            return 0;
        }
    }

   public function git_services (){
    $this->db->select('*');
    $this->db->from('services');
    $this->db->where('status','Active');
    return $this->db->get()->result();
   }
   public function git_projects (){
    $this->db->select('*');
    $this->db->from('pms_project');
    return $this->db->get()->result();
   }
   public function git_blog (){
    $this->db->select('*');
    $this->db->from('blog');
    $this->db->where('image !=','');
    return $this->db->get()->result();
   }
   public function get_about_data() {
    $this->db->select('*');
    $this->db->from('about');
    $query = $this->db->get()->result();
    return $query;
}
   public function get_superadmin_details (){
    $this->db->select('*');
    $this->db->from('users');
    $this->db->where('id','713');
    return $this->db->get()->result();
   }

   public function getexpensesProject($project_id='') {
    $this->db->select("amount");
    $this->db->from('expenses');
    $this->db->where("project_id", $project_id);
    $this->db->where("status", 'Approved');
    $data = $this->db->get()->result();
     $result = $data[0]->amount;
     if($result>0){
        $amount = $data[0]->amount;
     }else{
        $amount = 0;
     }
    return $amount;
    }
   public function getTotalIncomeIndex($project_id=''){
    $this->db->select('amount');
    $this->db->from('payments');
    $this->db->where("project_id", $project_id);
    $data = $this->db->get()->result();
     $result = $data[0]->amount;
    return $result;
}

    public function get_categories($id='') {
        $this->db->select("*");
        $this->db->from('category');
		if(!empty($id) && ($id)>0){  
        $this->db->where("id", $id);
		}
        $this->db->where("status", 'Active');
        return $this->db->get()->result();
    }
	
    public function get_type($id='') {
        $this->db->select("*");
        $this->db->from('user_role');
		if(!empty($id) && ($id)>0){  
        $this->db->where("slug", $id);
		}
        $this->db->where("status", 'Active');
        return $this->db->get()->result();
    }
    public function get_languages($id='') {
        $this->db->select("*");
        $this->db->from('languages');
		if(!empty($id) && ($id)>0){  
        $this->db->where("id", $id);
		}
        // $this->db->where("status", 'Active');
        return $this->db->get()->result();
    }

	public function getUserDetails($users_id='') {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id',$users_id);
        $this->db->where('status', 'Active');
        return $this->db->get()->result();
    }

}