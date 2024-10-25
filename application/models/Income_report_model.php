<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Income_report_model extends CI_Model {

    protected $table      = 'payments'; 
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
        $this->db->update($this->table, $data, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    

    public function get($isCount = '',$id='',$limit='',$page = '',$filterData='',$user_type='',$UserID='') {
        $this->db->select("$this->table.*,(pms_project.title) as project_name,(payment_mode.name) as payment_mode_name");
        $this->db->from($this->table);
        $this->db->join('pms_project',"pms_project.id=$this->table.project_id",'left');
        $this->db->join('payment_mode',"payment_mode.id=$this->table.payment_mode_id",'left');

        // $this->db->order_by('id','DESC');
        if($user_type == 'manager') {
            $this->db->where('addedBy',$UserID);
        }
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
		if(isset($filterData['project']) && !empty($filterData['project'])){
			$this->db->where('payments.project_id',$filterData['project']);
		}
		if(isset($filterData['status']) && !empty($filterData['status'])){
			$this->db->like('payments.status',$filterData['status']);
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
