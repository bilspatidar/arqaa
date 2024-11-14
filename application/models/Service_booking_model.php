<?php
class Service_booking_model extends CI_Model {

    // Constructor
    public function __construct() {
        parent::__construct();
    }

    /**
     * GET | Retrieve service booking data (list or specific)
     */
    public function get($total = 'no', $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        if ($total == 'yes') {
            // Get total count of records
            $this->db->select('COUNT(id) as total');
            $this->db->from('service_booking');
            if ($id != 0) {
                $this->db->where('id', $id);
            }
            $query = $this->db->get();
            return $query->row()->total;
        } else {
            // Get service booking data
            $this->db->select('*');
            $this->db->from('service_booking');
            if ($id != 0) {
                $this->db->where('id', $id);
            }
            if (!empty($filterData)) {
                // Apply filters (Example: filtering by status or date)
                if (isset($filterData['status'])) {
                    $this->db->where('status', $filterData['status']);
                }
                if (isset($filterData['service_date'])) {
                    $this->db->where('service_date', $filterData['service_date']);
                }
            }
            $this->db->limit($limit, $offset);
            $query = $this->db->get();
            return $query->result_array();
        }
    }

    /**
     * SHOW | Get details of a single service booking by ID
     */
    public function show($id) {
        $this->db->select('*');
        $this->db->from('service_booking');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->row_array(); // Return single row as array
    }

    /**
     * CREATE | Insert a new service booking record
     */
    public function create($data) {
        $this->db->insert('service_booking', $data);
        return $this->db->insert_id(); // Return last inserted ID
    }

    /**
     * UPDATE | Update an existing service booking record
     */
    public function update($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('service_booking', $data);
        return $this->db->affected_rows(); // Return number of affected rows
    }

    /**
     * DELETE | Delete a service booking record
     */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('service_booking');
        return $this->db->affected_rows(); // Return number of affected rows
    }
}
