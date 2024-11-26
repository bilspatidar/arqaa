<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reported_users_model extends CI_Model {

    protected $table      = 'reported_users';
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

    /**
     * Create a new reported user record
     */
    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id(); 
    }

    /**
     * Get the details of a reported user by ID
     */
    public function show($id) {
        $this->db->select("*");
        $this->db->from($this->table);
    
        if (!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
    
        $query = $this->db->get();
    
        if ($query === false) {
            log_message('error', 'Database Error: ' . $this->db->error()['message']);
            return false;
        }
    
        return $query->result();
    }
    

    /**
     * Update a reported user record
     */
    public function update($data, $id) {
        $response = $this->db->update($this->table, $data, array($this->primaryKey => $id));
        return $this->db->affected_rows();
    }

    /**
     * Delete a reported user record by ID
     */
    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey => $id));
        return $this->db->affected_rows();
    }

    /**
     * Get a list of reported users with pagination and optional filters
     */
    public function get($isCount = '', $id = '', $limit = '', $page = '', $filterData = '') {
        $this->db->select("id, user_id, remark, status, added, addedBy, updated, updatedBy");
        $this->db->from($this->table);
    
        if (!empty($id)) {
            $this->db->where($this->primaryKey, $id);
            return $this->db->get()->row();
        }
    
        if (isset($filterData['user_id']) && !empty($filterData['user_id'])) {
            $this->db->where('user_id', $filterData['user_id']);
        }
    
        if (isset($filterData['status']) && !empty($filterData['status'])) {
            $this->db->where('status', $filterData['status']);
        }
    
        $this->db->order_by($this->primaryKey, 'desc');
    
        if ($isCount == 'yes') {
            return $this->db->count_all_results();
        } else {
            $this->db->limit($limit, $page);
            $query = $this->db->get();
    
            // Check for query error
            if ($query === false) {
                log_message('error', 'Database Query Error: ' . $this->db->error()['message']);
                return false;
            }
    
            return $query->result();
        }
    }
    
}
