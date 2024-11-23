<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Master extends CI_Controller {

    function __construct() {
        parent::__construct(); 

         $language = $this->session->userdata('language') ?: 'english';  // Default to 'english'
        
        // Dynamically load the language file based on session
        $this->lang->load($language . '_lang', $language);
    }


public function categories(){
    
      is_login(array('superadmin','admin'));
      $header_data['page_title'] = $this->lang->line('categorias');
      $this->load->view('includes/header',$header_data);
      $this->load->view('master/categories');
      $this->load->view('includes/footer');
}

public function regular_user_monthly_subscription(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('subscription');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/regular_user_monthly_subscription');
  $this->load->view('includes/footer');
}
public function monthly_subscription_for_company_users(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('subscriptionCompany');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/monthly_subscription_for_company_users');
  $this->load->view('includes/footer');
}

public function boost_your_profile(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('top');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/boost_your_profile');
  $this->load->view('includes/footer');
}
public function additional_services(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('Additional');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/additional_services');
  $this->load->view('includes/footer');
}

public function banners (){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('banner');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/banners');
  $this->load->view('includes/footer');
}
public function taxes (){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('tax');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/taxes');
  $this->load->view('includes/footer');
}
public function cv (){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('cv');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/cv');
  $this->load->view('includes/footer');
}

public function add_user (){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('add_user');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/regular_user');
  $this->load->view('includes/footer');
}
public function users ($role=''){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('users');
  $page_data['role'] = $role;
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/company_user',$page_data);
  $this->load->view('includes/footer');
}

public function application_user ($role=''){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('application_user');
  $page_data['role'] = $role;
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/application_user',$page_data);
  $this->load->view('includes/footer');
}


public function registered_users (){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('REGISTERED_USERS');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/registered_users');
  $this->load->view('includes/footer');
}
public function services(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('ragistered_services');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/services');
  $this->load->view('includes/footer');
}
public function cart(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('cart');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/cart');
  $this->load->view('includes/footer');
}
public function papular(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('papular');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/papular');
  $this->load->view('includes/footer');
}

public function days_and_times(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('days_and_times');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/days_and_times');
  $this->load->view('includes/footer');
}
public function reported_users(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('reported_user');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/reported_users');
  $this->load->view('includes/footer');
}
public function earrings(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('pending_services');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/earrings');
  $this->load->view('includes/footer');
}
public function news_categories(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('news_categories');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/news_categories');
  $this->load->view('includes/footer');
}
public function news(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('news');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/news');
  $this->load->view('includes/footer');
}

public function my_profile(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('my_profile');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/my_profile');
  $this->load->view('includes/footer');
}
public function setting(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('setting');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/setting');
  $this->load->view('includes/footer');
}
public function metals(){
    
        is_login(array('superadmin','admin'));
        $header_data['page_title'] = "Metal";
        $this->load->view('includes/header');
        $this->load->view('master/metal',$header_data);
        $this->load->view('includes/footer');
    
}

public function product(){
    
      is_login(array('superadmin','admin'));
      $header_data['page_title'] = "Product";
      $this->load->view('includes/header');
      $this->load->view('master/product',$header_data);
      $this->load->view('includes/footer');
}
public function document_subcategory(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = "Document Subcategory";
  $this->load->view('includes/header');
  $this->load->view('master/document_subcategory',$header_data);
  $this->load->view('includes/footer');
}

public function sub_category(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('subcategorys');
  $this->load->view('includes/header');
  $this->load->view('master/sub_category',$header_data);
  $this->load->view('includes/footer');
}

public function expense_categories(){    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = "Expense Category";
  $this->load->view('includes/header');
  $this->load->view('master/expense_categories',$header_data);
  $this->load->view('includes/footer');
}
  public function expenses($project_id=''){
    is_login(array('superadmin','admin'));
    $header_data['page_title'] = "Expense";
    $data['project_id'] = $project_id;
    $this->load->view('includes/header');
    $this->load->view('master/expense',$data);
    $this->load->view('includes/footer');
  }

  public function machines(){
    is_login(array('superadmin','admin'));
    $header_data['page_title'] = "Machines";
    $this->load->view('includes/header');
    $this->load->view('master/machines',$header_data);
    $this->load->view('includes/footer');
  }

public function country(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] ="Country";
  $this->load->view('includes/header');
  $this->load->view('master/country',$header_data);
  $this->load->view('includes/footer');
}

public function state(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] ="State";
  $this->load->view('includes/header');
  $this->load->view('master/state',$header_data);
  $this->load->view('includes/footer');
}
public function kyc_details(){
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = "KYC Details";
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/kyc_details');
  $this->load->view('includes/footer');
}
public function cities(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] ="Cities";
  $this->load->view('includes/header');
  $this->load->view('master/cities',$header_data);
  $this->load->view('includes/footer');
}


    public function projects($status = '') {
        is_login(array('superadmin','admin'));
        $header_data['page_title'] = "Project";
        $data['status'] = $status;
        $this->load->view('includes/header');
        $this->load->view('master/pms_project', $data);
        $this->load->view('includes/footer');
    }

    public function payments($project_id = '') {
      is_login(array('superadmin','admin'));
      $header_data['page_title'] = "Payments";
      $data['project_id'] = $project_id;
      $this->load->view('includes/header');
      $this->load->view('master/payments', $data);
      $this->load->view('includes/footer');
  }
  public function project_details($project_id) {
    is_login(array('superadmin','admin'));
    $header_data['page_title'] = "Project Details";
    $data['row'] = $this->db->get('pms_project',array('id'=>$project_id))->result();
    $this->load->view('includes/header');
    $this->load->view('master/project_details', $data);
    $this->load->view('includes/footer');
}
    public function edit_form($page='',$table='',$key='',$value=''){
		
		$page_data['row'] = $this->db->get_where($table,array($key=>$value))->result();
		$page_data['token'] = $_POST['token'];
		$this->load->view($page,$page_data);
	}

  public function map(){
    
    is_login(array('superadmin','admin'));
    $header_data['page_title'] = $this->lang->line('map');
    // $this->load->view('includes/header',$header_data);
    $this->load->view('master/map');
    // $this->load->view('includes/footer');
  }
  public function open_a_country() {
    is_login(array('superadmin', 'admin'));
    $header_data['page_title'] = $this->lang->line('map');
    $this->load->view('master/open_a_country');

}
public function delete_country() {
  is_login(array('superadmin', 'admin'));
  $header_data['page_title'] = $this->lang->line('map');
  $this->load->view('master/delete_country');

}
  public function profile_details(){
    
    is_login(array('superadmin','admin'));
    $header_data['page_title'] = $this->lang->line('profile_details');
    $this->load->view('includes/header',$header_data);
    $this->load->view('master/profile_details');
    $this->load->view('includes/footer');
  }

public function manage_country(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('manage_country');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/manage_country');
  $this->load->view('includes/footer');
}
public function income_report(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('income_report');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/Income_report');
  $this->load->view('includes/footer');
}

public function handy_andy(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('Handy_Andy_s');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/handy_andy');
  $this->load->view('includes/footer');
}
public function company(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('company');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/company');
  $this->load->view('includes/footer');
}
public function manage_your_staff(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('manage_your_staff');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/manage_your_staff');
  $this->load->view('includes/footer');
}
public function Monthly_fixed_cost(){
    
  is_login(array('superadmin','admin'));
  $header_data['page_title'] = $this->lang->line('Monthly_fixed_cost');
  $this->load->view('includes/header',$header_data);
  $this->load->view('master/Monthly_fixed_cost');
  $this->load->view('includes/footer');
}
} 
?>




