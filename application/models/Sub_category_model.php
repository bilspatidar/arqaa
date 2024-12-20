<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_category_model extends CI_Model {

    protected $table      = 'sub_category';
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
        $response = $this->db->update($this->table, $data, array($this->primaryKey => $id));
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey => $id));
        return $this->db->affected_rows();
    }

    public function get($isCount = '', $id = '', $limit = '', $page = '', $filterData = '') {
        $this->db->select("
            {$this->table}.*, 
            category.name as category_name
        ");
        $this->db->from($this->table);
    
        // Join with the category table to fetch category_name
        $this->db->join('category', "{$this->table}.category_id = category.id", 'left');
    
        // If a specific record ID is provided
        if (!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
    
        // Apply filters from $filterData
        if (!empty($filterData)) {
            if (isset($filterData['name']) && !empty($filterData['name'])) {
                $this->db->like("{$this->table}.name", $filterData['name']);
            }
            if (isset($filterData['category_id']) && !empty($filterData['category_id'])) {
                $this->db->where("{$this->table}.category_id", $filterData['category_id']);
            }
            if (isset($filterData['status']) && !empty($filterData['status'])) {
                $this->db->where("{$this->table}.status", $filterData['status']);
            }
            if (isset($filterData['from_date']) && !empty($filterData['from_date'])) {
                $from_date = date('Y-m-d', strtotime($filterData['from_date']));
                $this->db->where("DATE({$this->table}.added) >=", $from_date);
            }
            if (isset($filterData['to_date']) && !empty($filterData['to_date'])) {
                $to_date = date('Y-m-d', strtotime($filterData['to_date']));
                $this->db->where("DATE({$this->table}.added) <=", $to_date);
            }
        }
    
        // Ordering
        $this->db->order_by("{$this->table}.name", 'ASC');
    
        // Count total records if $isCount is 'yes'
        if ($isCount == 'yes') {
            $query = $this->db->get();
            return $query->num_rows();
        } else {
            // Apply pagination
            if (!empty($limit) && !empty($page)) {
                $offset = ($page - 1) * $limit;
                $this->db->limit($limit, $offset);
            }
    
            $query = $this->db->get();
            return $query->result();
        }
    }
    
}
