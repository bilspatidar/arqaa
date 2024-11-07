<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_model extends CI_Model {

    protected $table      = 'news';
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

    public function show($id) {
        $this->db->select("*");
        $this->db->from($this->table);
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        return $this->db->get()->result();
    }

    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id(); 
    }

    public function update($data, $id) {
        $this->db->where($this->primaryKey, $id);
        $this->db->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->where($this->primaryKey, $id);
        $this->db->delete($this->table);
        return $this->db->affected_rows();
    }

    public function get($isCount = '', $id = '', $limit = '', $page = '', $filterData = '') {
        $this->db->select("*");
        $this->db->from($this->table);

        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        
        if(isset($filterData['title']) && !empty($filterData['title'])) {
            $this->db->like('title', $filterData['title']);
        }
        
        if(isset($filterData['status']) && !empty($filterData['status'])) {
            $this->db->where('status', $filterData['status']);
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
