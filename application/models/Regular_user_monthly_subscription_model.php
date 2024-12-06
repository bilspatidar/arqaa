<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Regular_user_monthly_subscription_model extends CI_Model {

    protected $table      = 'regular_user_monthly_subscription';
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


     // Fetch by sub_type
    public function get_by_sub_type($sub_type) {
        $this->db->select("*");
        $this->db->from($this->table);
        if (!empty($sub_type)) {
            $this->db->where('sub_type', $sub_type);
        }
    return $this->db->get()->result();
    }
    
    public function update($data, $id) {
        $response = $this->db->update($this->table, $data, array($this->primaryKey => $id));
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey => $id));
        return $this->db->affected_rows();
    }

    public function get($isCount = '', $id = '', $limit = '', $page = '', $filterData = '') {
        $this->db->select("*");
        $this->db->from($this->table);
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        
        if(isset($filterData['name']) && !empty($filterData['name'])) {
            $this->db->like('name', $filterData['name']);
        }
        
        if(isset($filterData['sub_type']) && !empty($filterData['sub_type'])) {
            $this->db->like('sub_type', $filterData['sub_type']);
        }
        
        
        if(isset($filterData['status']) && !empty($filterData['status'])) {
            $this->db->where('status', $filterData['status']);
        }
        if(isset($filterData['from_date']) && !empty($filterData['from_date'])) {
            $from_date = date('Y-m-d', strtotime($filterData['from_date']));
            $this->db->where('CAST(added AS DATE) >=', $from_date);
        }
        if(isset($filterData['to_date']) && !empty($filterData['to_date'])) {
            $to_date = date('Y-m-d', strtotime($filterData['to_date']));
            $this->db->where('CAST(added AS DATE) <=', $to_date);
        }

        $this->db->order_by($this->primaryKey, 'desc');

        if($isCount == 'yes') {
            $all_res = $this->db->get();
            return $all_res->num_rows();
        } else {
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
        }
    }
}
