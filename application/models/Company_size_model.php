<?php
class Company_size_model extends CI_Model {
     protected $table      = 'company_size';
     protected $primaryKey = 'id';

    public function __construct() {
        parent::__construct();

    }

    // Fetch distinct company sizes from the user table
    public function company_sizes() {
        $this->db->select("*");
        $this->db->from($this->table);
        if(!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        return $this->db->get()->result();
    }
}
