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

    public function banks_create($data) {
        $this->db->insert('banks', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function client_services_create($data) {
        $this->db->insert('client_services', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function lwf_create($data) {
        $this->db->insert('lwf', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function master_gst_create($data) {
        $this->db->insert('master_gst', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function esic_code_create($data) {
        $this->db->insert('esic_code', $data);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function pf_code_create($data) {
        $this->db->insert('pf_code', $data);
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

    public function banks_get($count = 'no', $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        $this->db->select('*')->from('banks');
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

    public function client_services_get($count = 'no', $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        $this->db->select('*')->from('client_services');
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

    public function lwf_get($count = 'no', $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        $this->db->select('*')->from('lwf');
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

    public function master_gst_get($count = 'no', $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        $this->db->select('*')->from('master_gst');
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

    public function esic_code_get($count = 'no', $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        $this->db->select('*')->from('esic_code');
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

    public function pf_code_get($count = 'no', $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        $this->db->select('*')->from('pf_code');
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

    public function banks_update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('banks', $data);
        return $this->db->affected_rows() > 0;
    }

    public function client_services_update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('client_services', $data);
        return $this->db->affected_rows() > 0;
    }

    public function lwf_update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('lwf', $data);
        return $this->db->affected_rows() > 0;
    }


    public function master_gst_update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('master_gst', $data);
        return $this->db->affected_rows() > 0;
    }

    public function esic_code_update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('esic_code', $data);
        return $this->db->affected_rows() > 0;
    }

    
    public function pf_code_update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('pf_code', $data);
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

    public function banks_delete($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('banks')) {
            return true;
        }
        return false;
    }

    public function client_services_delete($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('client_services')) {
            return true;
        }
        return false;
    }

    public function lwf_delete($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('lwf')) {
            return true;
        }
        return false;
    }

    public function master_gst_delete($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('master_gst')) {
            return true;
        }
        return false;
    }

    public function esic_code_delete($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('esic_code')) {
            return true;
        }
        return false;
    }

    public function pf_code_delete($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('pf_code')) {
            return true;
        }
        return false;
    }
}
