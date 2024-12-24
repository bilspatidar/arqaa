<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_model extends CI_Model {

    protected $table      = 'pages';
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

    public function get($isCount = '', $id = '', $limit = '', $page = '', $filterData = '') {
        $this->db->select("*");
        $this->db->from($this->table);
    
        // Filter by 'id' if provided
        if (!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
    
        // Filter by 'page_name' if provided in the filterData
        if (isset($filterData['page_name']) && !empty($filterData['page_name'])) {
            $this->db->where('page_name', $filterData['page_name']);
        }
    
        // Order by the primary key in descending order
        $this->db->order_by($this->primaryKey, 'desc');
    
        // If the isCount flag is 'yes', return the count of records
        if ($isCount == 'yes') {
            $all_res = $this->db->get();
            return $all_res->num_rows();
        } else {
            // Otherwise, apply limit and offset (page) for pagination
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
        }
    }
    
}
