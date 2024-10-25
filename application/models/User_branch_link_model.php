<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_branch_link_model extends CI_Model {

    protected $table = 'user_branch_link';
    protected $primaryKey = 'id';

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
    
    public function update($data, $id){
        $response = $this->db->update($this->table, $data, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }
    
    public function delete($id)
    {
        $this->db->delete($this->table, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }
    
    public function get($isCount = '',$id='',$limit='',$page = '',$filterData='') {
        $this->db->select("user_branch_link.*,(users.first_name) as FirstName ,(branch.name) as branchName");
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = user_branch_link.user_id');
        $this->db->join('branch', 'branch.id = user_branch_link.branch_id');
        if(!empty($id)){
            $this->db->where($this->primaryKey,$id);
        }

        if(isset($filterData['user_id']) && !empty($filterData['user_id'])){
            $this->db->where('user_branch_link.user_id',$filterData['user_id']);
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
}
