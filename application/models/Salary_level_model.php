<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_level_model extends CI_Model {

    protected $table      = 'salary_level'; 
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

    public function get_notification($id='', $filterData='') {
        $this->db->select("*");
        $this->db->from($this->table);
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        return $this->db->get()->result();
    }

    public function get($isCount='', $id='', $limit='', $page='', $filterData='') {
        $this->db->select("$this->table.*,(salary_head.head_name) as salary_head_name");
        $this->db->from($this->table);
        $this->db->join('salary_head','salary_level.salary_head_id = salary_head.id','left');
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        if(isset($filterData['name']) && !empty($filterData['name'])){
            $this->db->where('salary_level.name', $filterData['name']);
        }
        if(isset($filterData['status']) && !empty($filterData['status'])){
            $this->db->where('salary_level.status',$filterData['status']);
        }
        if(isset($filterData['salary_head_id']) && !empty($filterData['salary_head_id'])){
            $this->db->where('salary_level.salary_head_id', $filterData['salary_head_id']);
        }
        if(isset($filterData['salary_head_value']) && !empty($filterData['salary_head_value'])){
            $this->db->where('salary_level.salary_head_value', $filterData['salary_head_value']);
        }
        
        if($isCount == 'yes'){
            $all_res = $this->db->get();
            return $all_res->num_rows();
        } else {
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
        }
    } 
}
