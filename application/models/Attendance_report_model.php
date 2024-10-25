<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_report_model extends CI_Model {

    protected $table = 'attendance';
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
    
    public function update($data, $id)
    {
        $response = $this->db->update($this->table, $data, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }
    
    public function delete($id)
    {
        $this->db->delete($this->table, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }
    
    public function get($isCount = '',$id='',$limit='',$page = '',$filterData='',$user_type='',$UserID='') {
        $this->db->select("attendance.*,(users.first_name) as FirstName");
        $this->db->from($this->table);
        $this->db->join('users', 'users.id = attendance.user_id');
        if($user_type == 'admin') {
            $this->db->where('created_by',$UserID);
        }elseif($user_type == 'supervisor') {
            $this->db->where('created_by',$UserID);
        }
        if(!empty($id)){
            $this->db->where($this->primaryKey,$id);
        }
        if(isset($filterData['name']) && !empty($filterData['name'])){
            $this->db->where('attendance.user_id',$filterData['name']);
        }
        if(isset($filterData['status']) && !empty($filterData['status'])){
            $this->db->where('attendance.status',$filterData['status']);
        }
        if(isset($filterData['from_date']) && !empty($filterData['from_date'])){
            $this->db->where('attendance.date >=',$filterData['from_date']);
        }
        if(isset($filterData['to_date']) && !empty($filterData['to_date'])){
            $this->db->where('attendance.date<=',$filterData['to_date']);
        }
        // if(isset($filterData['from_date']) && !empty($filterData['from_date'])){
		// 	$from_date = date('Y-m-d',strtotime($filterData['from_date']));
		// 	$this->db->where("CAST(attendance.date AS DATE)>=",$from_date);
		// }
		// if(isset($filterData['to_date']) && !empty($filterData['to_date'])){
		// 	$to_date = date('Y-m-d',strtotime($filterData['to_date']));
		// 	$this->db->where("CAST(attendance.date AS DATE)<=",$to_date);
		// }
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
