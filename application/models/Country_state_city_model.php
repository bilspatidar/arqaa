<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Country_state_city_model extends CI_Model {

    protected $table      = 'countries';
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



    public function get($isCount = '',$id='',$limit='',$page = '',$filterData='') {
        $this->db->select("*");
        $this->db->from($this->table);  
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        if(isset($filterData['name']) && !empty($filterData['name'])){
            $this->db->like('name', $filterData['name']);
            $this->db->or_like('shortName', $filterData['name']);
        }
    
        if(isset($filterData['status']) && !empty($filterData['status'])){
            $this->db->where('status', $filterData['status']);
        }      
        $this->db->order_by($this->primaryKey, 'desc'); 
        if($isCount=='yes'){
        $all_res = $this->db->get();
        return $all_res->num_rows();   
       }
       else{
        $this->db->limit($limit, $page);
        return $this->db->get()->result();
       }
    }
    public function get_state($isCount = '',$id='',$limit='',$page = '',$filterData='') {
        $this->db->select("*");
        $this->db->from('states'); 
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        if(isset($filterData['name']) && !empty($filterData['name'])){
            $this->db->like('name', $filterData['name']);
        }
    
        if(isset($filterData['country_id']) && !empty($filterData['country_id'])){
            $this->db->where('country_id', $filterData['country_id']);
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
    public function get_city($isCount = '',$id='',$limit='',$page = '',$filterData='') {
        $this->db->select("*");
        $this->db->from('cities');
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        if(isset($filterData['name']) && !empty($filterData['name'])){
            $this->db->like('name', $filterData['name']);
        }
        if(isset($filterData['state_id']) && !empty($filterData['state_id'])){
            $this->db->where('state_id', $filterData['state_id']);
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
    
}
