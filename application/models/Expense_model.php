<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense_model extends CI_Model {

    protected $table      = 'monthly_cost'; 
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
        $this->db->select("$this->table.*,(pms_project.title) as project_name,
        (pms_expense_categories.name) as categories_name,(users.first_name) as first_name");
        $this->db->from($this->table);
        $this->db->join('pms_project',"pms_project.id=$this->table.project_id",'left');
        $this->db->join('pms_expense_categories',"pms_expense_categories.id=$this->table.expense_category_id",'left');
        $this->db->join('users',"users.id=$this->table.employee_id",'left');
        if($user_type == 'manager') {
            $this->db->where('expenses.addedBy',$UserID);
        }
        $this->db->order_by('id','DESC');
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
		if(isset($filterData['project']) && !empty($filterData['project'])){
			$this->db->like('expenses.project_id',$filterData['project']);
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
