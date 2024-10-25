<?php
defined('BASEPATH') OR exit('No direct script access allowed ');
class Document_upload extends CI_Controller {

    function __construct() {
        parent::__construct(); 
    }


    public function document_upload(){
	  //ini_set('display_errors',1);
      $header_data['page_title'] = "Document Upload";
      $this->load->view('includes/header',$header_data);
      $this->load->view('document_upload/document_upload');
      $this->load->view('includes/footer');
    }
    public function document_upload_data(){
      $filterData = array(
          'name' => $this->input->post('name'), 
          'status' => $this->input->post('status')
      );
      $data['filterData'] = $filterData;
      $this->load->view('document_upload/document_upload_data', $data);
  }
} 
?>

