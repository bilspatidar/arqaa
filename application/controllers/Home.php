<?php


//deploy ok oksss okkk mmm
class Home extends CI_Controller {
    
	  /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response
    */
    public function __construct() {
	header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "OPTIONS") {
        die();
    }
    parent::__construct();
     
       $this->load->model('currency_model');
	   header('Access-Control-Allow-Origin: *');
	}
	
	
	function index(){

	    echo"HELLO";
	}
	
	
}
