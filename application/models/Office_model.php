<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Office_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Create a new department
     *
     * @param array $data Department data
     * @return int|bool Inserted ID or false on failure
     */
    public function create($data) {
        $this->db->insert('department', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function designation_create($data) {
        $this->db->insert('designation', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function financial_year_create($data) {
        $this->db->insert('financial_year', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function company_create($data) {
        $this->db->insert('company', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    /**
     * Get department(s) by ID or with filters
     *
     * @param string $count Whether to count records or fetch data ('yes'/'no')
     * @param int $id Department ID
     * @param int $limit Number of records to fetch
     * @param int $offset Records offset for pagination
     * @param array $filterData Additional filters
     * @return array|int List of departments or count
     */
    public function get($count = 'no', $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        $this->db->select('*')->from('department');
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if ($count === 'yes') {
            return $this->db->count_all_results();
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function designation_get($count = 'no', $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        $this->db->select('*')->from('designation');
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if ($count === 'yes') {
            return $this->db->count_all_results();
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function financial_year_get($count = 'no', $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        $this->db->select('*')->from('financial_year');
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if ($count === 'yes') {
            return $this->db->count_all_results();
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function company_get($count = 'no', $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        $this->db->select('*')->from('company');
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        if ($count === 'yes') {
            return $this->db->count_all_results();
        }
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }


    /**
     * Update department
     *
     * @param array $data Updated data
     * @param int $id Department ID
     * @return bool Success or failure
     */
    public function update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('department', $data);
        return $this->db->affected_rows() > 0;
    }

    public function designation_update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('designation', $data);
        return $this->db->affected_rows() > 0;
    }

    public function financial_year_update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('financial_year', $data);
        return $this->db->affected_rows() > 0;
    }

    public function company_update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('company', $data);
        return $this->db->affected_rows() > 0;
    }

    /**
     * Delete department by ID
     *
     * @param int $id Department ID
     * @return bool Success or failure
     */
    public function delete($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('department')) {
            return true;
        }
        return false;
    }
    
    public function designation_delete($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('designation')) {
            return true;
        }
        return false;
    }


    public function financial_year_delete($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('financial_year')) {
            return true;
        }
        return false;
    }

    public function company_delete($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('company')) {
            return true;
        }
        return false;
    }
}
