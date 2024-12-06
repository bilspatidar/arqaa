<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_purchasing_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database(); // Make sure the database is loaded
    }

    /**
     * Create a new user purchasing record
     *
     * @param array $data The data to insert
     * @return int|bool The inserted record ID or false on failure
     */
    public function create($data) {
        // Insert data into the `user_purchasing` table
        $this->db->insert('user_purchasing', $data);
        
        // Return the inserted record's ID
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * Get a user purchasing record by ID
     *
     * @param int $id The record ID
     * @return array|null The record data or null if not found
     */
    public function get($id) {
        // Fetch the record from `user_purchasing` table by ID
        $query = $this->db->get_where('user_purchasing', ['id' => $id]);
        
        // Return the row data if found, otherwise null
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return null;
        }
    }

    /**
     * Update an existing user purchasing record
     *
     * @param int $id The record ID
     * @param array $data The data to update
     * @return bool Whether the update was successful
     */
    public function update($id, $data) {
        // Update the record in the `user_purchasing` table
        $this->db->where('id', $id);
        return $this->db->update('user_purchasing', $data);
    }

    

}
