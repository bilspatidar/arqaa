<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Business_hrs_model extends CI_Model {

    // Table name
    private $table = 'business_hrs';  // Adjust this to your actual table name

    // Add business hours to the database
    public function add($data) {
        $existing_data = $this->db->get_where($this->table,array('user_id'=>$data['user_id'],'day'=>$data['day']));
        if($existing_data->num_rows()>0){
        $this->db->where('id',$existing_data->row()->id);
        return $this->db->update($this->table, $data);
        }
        else{
         return $this->db->insert($this->table, $data);
        }
    }



    // Get business hours for a user with pagination
    public function get_business_hours($user_id, $limit, $offset) {
        // Get the business hours for the given user id with limit and offset
        $this->db->where('user_id', $user_id);
        $this->db->limit($limit, $offset);
        $query = $this->db->get($this->table);

        // Get total records for pagination
        $this->db->where('user_id', $user_id);
        $totalRecords = $this->db->count_all_results($this->table);

        return [
            'data' => $query->result(),
            'totalRecords' => $totalRecords
        ];
    }

    // Delete business hours by id (optional method if needed)
    public function delete($id) {
        // Delete a record based on id
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
