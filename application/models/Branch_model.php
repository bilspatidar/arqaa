<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_model extends CI_Model {

    protected $table      = 'branch'; // Make sure to change 'branch' to the actual table name for the Branch entity.
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
        $response = $this->db->update($this->table, $data, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    public function get_branch($id='',$filterData='') {
        $this->db->select("*");
        $this->db->from($this->table);
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
		if(isset($filterData['name']) && !empty($filterData['name'])){
			$this->db->where('name',$filterData['name']);
		}
		if(isset($filterData['status'])){
			$this->db->where('status',$filterData['status']);
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


 public function get00($isCount = '',$id='',$limit='',$page = '',$filterData='') {
	
    $this->db->select("*");
	$this->db->from($this->table);
	$this->db->order_by('id','desc');
    if (!empty($id)) {
        $this->db->where($this->table . '.' . $this->primaryKey, $id);
    }
        if(isset($filterData['name']) && !empty($filterData['name'])){
            $this->db->like('name', $filterData['name']);
        }
        
         if(isset($filterData['status']) && !empty($filterData['status'])){
            $this->db->like('status', $filterData['status']);
        }
        

        $this->db->order_by($this->table.'.'.$this->primaryKey, 'desc');
		$query = $this->db->get();
		if (!$query) {
				die("Database error: " . $this->db->error()['message'] . "\nSQL Query: " . $this->db->last_query());
			}
		return $query->result();
        //return $this->db->get()->result();
    }

    public function get($isCount = '',$id='',$limit='',$page = '',$filterData='') {
        
        $this->db->select("*");
        $this->db->from($this->table);
       
        
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        
        if(isset($filterData['name']) && !empty($filterData['name'])){
            $this->db->like('name', $filterData['name']);
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
