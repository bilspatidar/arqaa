<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    protected $table      = 'users'; 
    protected $primaryKey = 'users_id';

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
            $this->db->where($this->primaryKey, $id);
        }
        return $this->db->get()->result();
    }

    public function update($data, $id) {
        $this->db->update($this->table, $data, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    public function get($isCount = '',$id='',$limit='',$page = '',$filterData='') {
        $this->db->select("*");
        $this->db->from($this->table);
        $this->db->order_by('users_id','DESC');
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
}
