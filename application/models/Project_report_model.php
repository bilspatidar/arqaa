<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Project_report_model extends CI_Model {

    protected $table      = 'pms_project';
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

    public function get($isCount = '',$id='',$limit='',$page = '',$filterData='',$user_type='',$UserID='') {
        $this->db->select("$this->table.*,(states.name) as state_name");
        $this->db->from($this->table);
        $this->db->join('states',"states.id=$this->table.state_id",'left');
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
		if($user_type == 'manager') {
            $this->db->where('added_by',$UserID);
        }elseif($user_type == 'agent') {
            $this->db->where('agent_id',$UserID);
        }
		if(isset($filterData['name']) && !empty($filterData['name'])){
			$this->db->where('pms_project.title',$filterData['name']);
		}
		if(isset($filterData['manager_id']) && !empty($filterData['manager_id'])){
			$this->db->where('pms_project.manager_id',$filterData['manager_id']);
		}
        if(isset($filterData['agent_id']) && !empty($filterData['agent_id'])){
			$this->db->where('pms_project.agent_id',$filterData['agent_id']);
		}
        if(isset($filterData['billing_type']) && !empty($filterData['billing_type'])){
			$this->db->where('pms_project.billing_type',$filterData['billing_type']);
		}
        if(isset($filterData['status']) && !empty($filterData['status'])){
			$this->db->where('pms_project.status',$filterData['status']);
		}
		if(isset($filterData['from_date']) && !empty($filterData['from_date'])){
			$from_date = date('Y-m-d',strtotime($filterData['from_date']));
			$this->db->where('CAST(pms_project.added AS DATE)>=',$from_date);
		}
		if(isset($filterData['to_date']) && !empty($filterData['to_date'])){
			$to_date = date('Y-m-d',strtotime($filterData['to_date']));
			$this->db->where('CAST(pms_project.added AS DATE)<=',$to_date);
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
