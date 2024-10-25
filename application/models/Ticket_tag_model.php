<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket_tag_model extends CI_Model {

    protected $table = 'ticket_tag';
    protected $primaryKey = 'id';

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
        $this->db->update($this->table, $data, array($this->primaryKey => $id));
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey => $id));
        return $this->db->affected_rows();
    }

    public function get($isCount = '', $id = '', $limit = '', $page = '', $filterData = '') {
        //$this->db->select("$this->table.*, ticket.id");
		$this->db->select("*");
        $this->db->from($this->table);
        //$this->db->join('ticket', "ticket.id = $this->table.ticket_id");
        if (!empty($id)) {
            $this->db->where($this->table . '.' . $this->primaryKey, $id);
        }
		
		 if(isset($filterData['ticket_id']) && !empty($filterData['ticket_id'])){
            $this->db->like($this->table . '.' . 'ticket_id', $filterData['ticket_id']);
        }
		
        if(isset($filterData['title']) && !empty($filterData['title'])){
            $this->db->like($this->table . '.' . 'title', $filterData['title']);
        }

        if(isset($filterData['assign_id']) && !empty($filterData['assign_id'])){
            $this->db->where($this->table . '.' . 'assign_id', $filterData['assign_id']);
        }

        if(isset($filterData['details']) && !empty($filterData['details'])){
            $this->db->like($this->table . '.' . 'details', $filterData['details']);
        }

        if(isset($filterData['from_date']) && !empty($filterData['from_date'])){
            $from_date = date('Y-m-d', strtotime($filterData['from_date']));
            $this->db->where('CAST(' . $this->table . '.' . 'added AS DATE)>=', $from_date);
        }

        if(isset($filterData['to_date']) && !empty($filterData['to_date'])){
            $to_date = date('Y-m-d', strtotime($filterData['to_date']));
            $this->db->where('CAST(' . $this->table . '.' . 'added AS DATE)<=', $to_date);
        }

        $this->db->order_by($this->table . '.' . $this->primaryKey, 'desc');
        if($isCount == 'yes'){
            $all_res = $this->db->get();
            return $all_res->num_rows();                
        } else {
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
        }
        
        if (!$query) {
            die("Database error: " . $this->db->error()['message'] . "\nSQL Query: " . $this->db->last_query());
        }

        return $query->result();
    }
	
	
}
?>
