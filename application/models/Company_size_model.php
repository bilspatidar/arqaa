<?php
class Company_size_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Fetch distinct company sizes from the user table
    public function company_sizes() {
        $this->db->distinct();
        $this->db->select('company_size_id, company_size_name'); // Adjust fields as necessary
        $this->db->from('users'); // Use the user table
        $query = $this->db->get();

        if ($query === false) {
            log_message('error', 'Database Error: ' . $this->db->error()['message']);
            log_message('error', 'Last Query: ' . $this->db->last_query());
            return false;
        }

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return []; // Return an empty array if no data found
        }
    }
}
