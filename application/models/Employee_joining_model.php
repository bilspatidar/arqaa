<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_joining_model extends CI_Model {

    protected $table      = 'user_profile';
    protected $primaryKey = 'id';
    protected $primary_key = 'id';

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

    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id(); 
    }


    public function show($id) {
        $this->db->select("*");
        $this->db->from($this->table);
        if(!empty($id)) {
            $this->db->where($this->primary_key, $id);
        }
        return $this->db->get()->result();
    }
    
    public function update($data, $id) {
        $response = $this->db->update($this->table, $data, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    public function get($isCount = '',$id='',$limit='',$page = '',$filterData='',$user_type='',$UserID='') {
       
        $this->db->select("user_profile.*,(countries.name) as country_name,(states.name) as state_name,users.employee_code");
        $this->db->from($this->table);
        $this->db->join('countries','countries.id = user_profile.country_id','left');
        $this->db->join('states','states.id = user_profile.state_id','left');
        $this->db->join('users','users.id = user_profile.users_id','left');        
        if($user_type != 'superadmin') {
            $this->db->where('users.addedBy',$UserID);
        }
        if($user_type == 'admin') {
            $this->db->where('users.addedBy',$UserID);
            $this->db->or_where('users.parent_id',$UserID);
        }
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
    
}
