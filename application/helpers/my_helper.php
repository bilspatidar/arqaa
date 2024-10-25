<?php
/**
*@if(CheckPermission('crm', 'read'))
**/
	
     function getUserEnv($id){
        $CI = get_instance();
	    $CI->db->select('env');
	    $CI->db->from('users');
	    $CI->db->where('id',$id);
	    $res = $CI->db->get();
	    if($res->num_rows()>0)
	    {
	     return $res->row()->env;
	    }
	    else
	    {
	     $na ="Test";
	    return $na; 
	    } 
    }
    
    
    
    function getMemberMobile($member_id){
        $CI = get_instance();
	    $CI->db->select('mobile');
	    $CI->db->from('member');
	    $CI->db->where('member_id',$member_id);
	    $res = $CI->db->get();
	    if($res->num_rows()>0)
	    {
	     return $res->row()->mobile;
	    }
	    else
	    {
	     $na ="";
	    return $na; 
	    } 
    }
    function getMemberAltMobile($member_id){
        $CI = get_instance();
	    $CI->db->select('alt_mobile');
	    $CI->db->from('member');
	    $CI->db->where('member_id',$member_id);
	    $res = $CI->db->get();
	    if($res->num_rows()>0)
	    {
	     return $res->row()->alt_mobile;
	    }
	    else
	    {
	     $na ="";
	    return $na; 
	    } 
    }
    function getDeleteOption(){  
		$CI = get_instance();
		$CI->db->select('value');
		$CI->db->from('settings');
		$CI->db->where('name','isDeletePin');
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
		 if($query->row()->value==1){
		     return 'delete_me_password';
		 } 
		 else{
		       return 'delete_me';
		 }
       	}
		else
		{
		return 'delete_me';
		}
		
		
	}
	/***
	 * row_per_page
	 * pp
	 * isDeletePin
	 * dateFormate
	 * dateTimeFormat
	 * 
	 * 
	 * ***/
	function getSetting($name){  
		$CI = get_instance();
		$CI->db->select('value');
		$CI->db->from('settings');
		$CI->db->where('name',$name);
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
		return $query->row()->value;  
       	}
		else
		{
		return 10;
		}
		
		
	}
	function getDateTimeFormat($datetime){
	    $CI = get_instance();
		$CI->db->select('value');
		$CI->db->from('settings');
		$CI->db->where('name','dateTimeFormat');
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
		$values =  $query->row()->value;  
		return date($values,strtotime($datetime));
       	}
		else
		{
		return $datetime;
		}
	}
	function getDateFormat($date){
	    $CI = get_instance();
		$CI->db->select('value');
		$CI->db->from('settings');
		$CI->db->where('name','dateFormate');
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
		$values =  $query->row()->value;  
		return date($values,strtotime($date));
       	}
		else
		{
		return $date;
		}
	}
	
	function getTimeFormat($date){
	    $CI = get_instance();
		$CI->db->select('value');
		$CI->db->from('settings');
		$CI->db->where('name','timeFormate');
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
		$values =  $query->row()->value;  
		return date($values,strtotime($date));
       	}
		else
		{
		return $date;
		}
	}
	
	function get_date(){
	    return date('Y-m-d');
	}
	
   function get_dateTime(){
	    return date('Y-m-d H:i:s');
	}
	
	
	
	function getRowPerPage(){  
		$CI = get_instance();
		$CI->db->select('value');
		$CI->db->from('settings');
		$CI->db->where('name','row_per_page');
		$query = $CI->db->get();
		if($query->num_rows()>0)
		{
		return $query->row()->value;  
       	}
		else
		{
		return 10;
		}
		

		
	}
		
	function is_login($type=''){ 
		if(!empty($type)){
			if(is_array($type) || is_object($type)){
				
		  if(isset($_SESSION['user_details']) && in_array($_SESSION['user_details']['user_type'],$type)){
			  return true;
		  }else{
			 redirect( base_url().'admin/login', 'refresh');
		  }
			}
				else {
			if(isset($_SESSION['user_details']) && $_SESSION['user_details']['user_type']==$type){
			  return true;
		  }else{
			 redirect( base_url().'admin/login', 'refresh');
		  }
				}
		}
		else {
			if(isset($_SESSION['user_details'])){
			  return true;
		  }else{
			 redirect( base_url().'admin/login', 'refresh');
		  }
		}
		  
	  }
    function is_web_login(){ 
      if(isset($_SESSION['web_user'])){
          return true;
      }else{
         redirect( base_url().'web/index/login', 'refresh');
      }
  }
  
      function user_login(){ 
      if(isset($_SESSION['set_user_details'])){
          return true;
      }else{
         redirect( base_url().'login/login/login', 'refresh');
      }
  }
  
  function is_front_login(){ 
	if(isset($_SESSION['front_user'])){
		return true;
	}else{
	   redirect( base_url().'front/index/login', 'refresh');
	}
}

    function getUser($col_name=''){
	    if(isset($_SESSION['user_details'])){
	    $user_id = $_SESSION['user_details']['id'];
	    if(!empty($col_name)){
	        $CI = get_instance();
	        $CI->db->select($col_name);
	    $CI->db->from('users');
	    $CI->db->where('id',$user_id);
	    $res = $CI->db->get();
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
	    }
	}
	function getUserInfo($col_name='',$user_id=''){
	    if(!empty($user_id)){
	    
	    if(!empty($col_name)){
	        $CI = get_instance();
	        $CI->db->select($col_name);
	    $CI->db->from('users');
	    $CI->db->where('id',$user_id);
	    $res = $CI->db->get();
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
	    }
	}
	
	

?>
