<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services_model extends CI_Model {

    protected $table      = 'services';
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
     * Create a new service record.
     *
     * @param array $data
     * @return int
     */
    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id(); 
    }

    /**
     * Show service details by ID.
     *
     * @param int $id
     * @return array
     */
    public function show($id) {
        $this->db->select("*");
        $this->db->from($this->table);
        if (!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        return $this->db->get()->result();
    }

    /**
     * Update service record.
     *
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id) {
        $response = $this->db->update($this->table, $data, array($this->primaryKey => $id));
        return $this->db->affected_rows();
    }

    /**
     * Delete service record by ID.
     *
     * @param int $id
     * @return int
     */
    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey => $id));
        return $this->db->affected_rows();
    }

    /**
     * Get services list with pagination and filtering.
     *
     * @param string $isCount
     * @param int $id
     * @param int $limit
     * @param int $page
     * @param array $filterData
     * @return mixed
     */
    public function get($isCount = '', $id = '', $limit = '', $page = '', $filterData = '') {
        $this->db->select("*");
        $this->db->from($this->table);

        // Filter by ID if provided
        if (!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }

        // Filter by title
        if (isset($filterData['name']) && !empty($filterData['name'])) {
            $this->db->where('title', $filterData['name']);
        }

        // Filter by status
        if (isset($filterData['status']) && !empty($filterData['status'])) {
            $this->db->where('status', $filterData['status']);
        }

        // Filter by category_id
        if (isset($filterData['category_id']) && !empty($filterData['category_id'])) {
            $this->db->where('category_id', $filterData['category_id']);
        }

        // Filter by sub_category_id
        if (isset($filterData['sub_category_id']) && !empty($filterData['sub_category_id'])) {
            $this->db->where('sub_category_id', $filterData['sub_category_id']);
        }

        // Order by primary key in descending order
        $this->db->order_by($this->primaryKey, 'desc');

        // Return count of records if requested
        if ($isCount == 'yes') {
            return $this->db->count_all_results();
        } else {
            // Apply pagination
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
        }
    }
}
