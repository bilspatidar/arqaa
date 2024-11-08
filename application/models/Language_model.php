<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Language_model extends CI_Model {

    protected $table = 'languages'; // Your table name
    protected $primaryKey = 'id'; // Your primary key field name

    // This method retrieves all countries with their languages
    public function get_all_languages($limit = 10, $offset = 0) {
        // Count total records
        $totalRecords = $this->db->count_all($this->table);

        // Fetch the records with pagination
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->limit($limit, $offset);
        $query = $this->db->get();

        return [
            'data' => $query->result(), // Return the result as an array of objects
            'totalRecords' => $totalRecords // Return total record count
        ];
    }
}
