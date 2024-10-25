<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common extends CI_Model {

    function __construct() {
       parent::__construct();
    }
    
	
	 function getYoutubeImage($e){
        //GET THE URL
        $url = $e;

        $queryString = parse_url($url, PHP_URL_QUERY);

        parse_str($queryString, $params);

        $v = $params['v'];  
        //DISPLAY THE IMAGE
        if(strlen($v)>0){
             $url ='http://i3.ytimg.com/vi/'.$v.'/0.jpg';
			 return $url;
        }
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
	
	    public function generateEncKey() {
	        $microTime = round(microtime(true) * 1000);
$strong =  filter_var( ($microTime + 15 * 60 * 1000), FILTER_SANITIZE_NUMBER_INT);
return password_hash($strong, PASSWORD_DEFAULT);
exit();
    $randomString = $this->mt();
    return $randomString;
}

  public function generateBarcode(){
    $date = date('YmdHis');
    $number = rand(0000,9999);
    $barcode = $date.$number;
	$check = $this->db->get_where('product',array('barcode'=>$barcode));
	if($check->num_rows()>0){
		$this->generateBarcode();
	}else{
		return $barcode;
	}
}

public function generateProductCode(){
	$date = date('YmdHis');
	$number = rand(0000,9999);
	$product_code = $date.$number;
	$check = $this->db->get_where('product',array('product_code'=>$product_code));
	if($check->num_rows()>0){
		$this->generateProductCode();
	}else{
		return $product_code;
	}
}

	public function getPaginition($allcount,$rowperpage,$current_url){
	    $this->load->library("pagination");
	    $config['base_url'] = $current_url;
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only"></span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close']  = '<span aria-hidden="true"></span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close']  = '</span></li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close']  = '</span></li>';
        $this->pagination->initialize($config);
        return $this->pagination->create_links();
        
	   
	}
	
	
	
    
	
	public function getBlogCategory($array=''){
      $this->db->select('id,name');
           $this->db->from('blog_category');
      return $this->db->get()->result();
    }
    
	
	
	
	/////////##########//////////////
	
	public function getCountry($array=''){
      $this->db->select('id,name');
      
           $this->db->from('countries');
      return $this->db->get()->result();
    }
	public function getState($country_id=''){
      $this->db->select('id,name');
      if(!empty($country_id)){
          $this->db->where('country_id',$country_id);
      }
           $this->db->from('states');
      return $this->db->get()->result();
    }
    
    public function getCity($state_id=''){
      $this->db->select('id,name');
      if(!empty($state_id)){
          $this->db->where('state_id',$state_id);
      }
      $this->db->from('cities');
      return $this->db->get()->result();
    }
     public function getPincode($cities_id=''){
      $this->db->select('id,pincode');
      if(!empty($cities_id)){
          $this->db->where('city_id',$cities_id);
      }
      $this->db->from('app_pincode');
      return $this->db->get()->result();
    }
        public function getCities($state_id=''){
      $this->db->select('id,name');
      $this->db->from('cities');
      return $this->db->get()->result();
    }
    public function getUserRole($array=''){
        $this->db->select('id,slug,name');
        $this->db->from('user_role');
        $this->db->where('status','Active');
      return $this->db->get()->result();
    }
    public function getUser($array=''){
        $this->db->select('user_profile.*');
        $this->db->from('users');
        $this->db->join('user_profile','user_profile.users_id = users.id');
        $this->db->where('user_profile.status','Active');
        $this->db->where('user_profile.user_type', 'employee');
      return $this->db->get()->result();
    }
    
	public function random_key_string($length = 25) {
	    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

  //////////// ////////////////////////


 function mt(){
$microTime = round(microtime(true) * 1000);
$strong =  filter_var( ($microTime + 15 * 60 * 1000), FILTER_SANITIZE_NUMBER_INT);
return password_hash($strong, PASSWORD_DEFAULT);

   }
 ///////////////// End Test Secret //////////

  	public function sentSMS($Mobile='',$SMS='',$templateId=''){
 $encodedSMS  = urlencode($SMS);   
  $curl = curl_init();
  curl_setopt_array($curl, array(
  CURLOPT_URL => "https://sms.sparkhub.in/api_v2/message/send",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "dlt_template_id=$templateId&sender_id=SFGPLT&mobile_no=$Mobile&message=$encodedSMS&unicode=0",
  CURLOPT_HTTPHEADER => array(
    "authorization: Bearer 55qgaFdMrL76SirjgUKEtRcO8ZCPcBYsAuKMyMUncLw-1Ml-3b_yeyhj2L3ARjPl",
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  //$result =  "cURL Error #:" . $err;
 $result = 0;
} else {

   $json = json_decode($response, true);
   if($json['success']==1){
   $result = 1;    
   }
   else
   {
   $result = 0;       
   }
 
}


return $result; 


 }


 public function getSubcategory($Category=''){
     $this->db->select('id,name');
     $this->db->from('sub_categories');
     $this->db->order_by('name','asc');
     if(!empty($Category)){
         $this->db->where('category_id',$Category);
     }
            $this->db->where('status','Active');
            $this->db->where('isDelete',0);
           
     return $this->db->get()->result();
 }
 
 public function getlThrecategory($lThree=''){
     $this->db->select('id,name');
     $this->db->from('level_three_category');
     $this->db->order_by('name','asc');
     if(!empty($lThree)){
         $this->db->where('sub_category_id',$lThree);
     }
            $this->db->where('status','Active');
            $this->db->where('isDelete',0);
           
     return $this->db->get()->result();
 }
 
  
 public function getGalleryCategory($array=''){
     $this->db->select('id,name');
     $this->db->from('gallery_category');
            $this->db->where('status','Active');
     return $this->db->get()->result();
 }
  
   public function getCategory($array=''){
     $this->db->select('id,name');
     $this->db->from('category');
     $this->db->order_by('name','asc');
     $this->db->where('status','Active');
     return $this->db->get()->result();
 }
  public function get_sub_category(){
	  $this->db->select('*');
	  $this->db->from('sub_category');
	  $this->db->where('status','Active');
     return $this->db->get()->result();
  } 
  public function getBrand(){
	  $this->db->select('*');
	  $this->db->from('brand');
	  $this->db->where('status','Active');
     return $this->db->get()->result();
  }
  public function getUnit(){
	  $this->db->select('*');
	  $this->db->from('unit');
	  $this->db->where('status','Active');
     return $this->db->get()->result();
  }
  public function getGeners($array=''){
     $this->db->select('id,title');
     $this->db->from('geners');
     $this->db->order_by('title','asc');
     $this->db->where('status','Active');
     $this->db->where('isDelete',0);
     return $this->db->get()->result();
 }
 
 
 public function convert_unique_array($array){
	 $gener_id = array();
	 $sub_key = 'gener_id';
	 foreach($array as $gener_single){
		 
	     if(strpos( $gener_single->gener_id, ","))
			 { 
		$array_s =  explode(',', $gener_single->gener_id);
		for($i=0;$i<count($array_s);$i++){
		$gener_id[] = 	$array_s[$i]; //[$sub_key => $array_s[$i]];
		}
        
         }
		 else {
          $gener_id[] = $gener_single->gener_id; //[$sub_key => $gener_single->gener_id];
		 }
									
	 }
	 return array_unique($gener_id);
 }
 public function getMediaGeners($sub_category_id =''){
    $this->db->select('gener_id');
    $this->db->from('media');
    $this->db->group_by('gener_id');
	if(!empty($sub_category_id)){
		$this->db->where('find_in_set("'.$sub_category_id.'", sub_category_id) <> 0');
	}
    return $this->db->get()->result();
}

public function GenerateLiveAPI(){
$microTime = round(microtime(true) * 1000);
$strong =  filter_var( ($microTime + 15 * 60 * 1000), FILTER_SANITIZE_NUMBER_INT);
return password_hash($strong, PASSWORD_DEFAULT);

   }


}

?>