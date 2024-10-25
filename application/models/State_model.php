<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State_model extends CI_Model {

    protected $table      = 'states';
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

    public function get($isCount = '',$id='',$limit='',$page = '',$filterData='') {
        $this->db->select("$this->table.*,(countries.name) as country_name");
        $this->db->from($this->table);
		$this->db->join('countries',"countries.id=$this->table.country_id");
        if(!empty($id)) {
            $this->db->where($this->table.'.'.$this->primaryKey, $id);
        }
		
		if(isset($filterData['name']) && !empty($filterData['name'])){
			$this->db->like($this->table.'.'.'name',$filterData['name']);
		}
		if(isset($filterData['country_id']) && !empty($filterData['country_id'])){
			$this->db->where($this->table.'.'.'country_id',$filterData['country_id']);
		}
		if(isset($filterData['status']) && !empty($filterData['status'])){
			$this->db->where($this->table.'.'.'status',$filterData['status']);
		}
		if(isset($filterData['from_date']) && !empty($filterData['from_date'])){
			$from_date = date('Y-m-d',strtotime($filterData['from_date']));
			$this->db->where('CAST('.$this->table.'.'.'added AS DATE)>=',$from_date);
		}
		if(isset($filterData['to_date']) && !empty($filterData['to_date'])){
			$to_date = date('Y-m-d',strtotime($filterData['to_date']));
			$this->db->where('CAST('.$this->table.'.'.'added AS DATE)<=',$to_date);
		}
		$this->db->order_by($this->table.'.'.$this->primaryKey,'desc');
        if($isCount=='yes'){
            $all_res = $this->db->get();
            return $all_res->num_rows();
                
           }
           else{
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
           }
    }
	public function parent_state($id='') {
		$this->db->select("$this->table.*,(countries.name) as country_name");
        $this->db->from($this->table);
		$this->db->join('countries',"countries.id=$this->table.country_id");
        if(!empty($id)) {
            $this->db->where($this->table.'.'.'country_id', $id);
        }
		$this->db->order_by($this->table.'.'.$this->primaryKey,'desc');
        return $this->db->get()->result();
    }
}
