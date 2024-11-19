<?php
class Company_size_model extends CI_Model {

public function __construct() {
    parent::__construct();
}

// Fetch all company sizes
public function company_sizes() {
    // Fetch data from the company_size table
    $this->db->select('id, size_name');
    $this->db->from('company_size');
    $query = $this->db->get();

    // Return the result as an associative array
    if ($query->num_rows() > 0) {
        return $query->result_array(); 
    } else {
        return false; // No data found
    }
}
}
