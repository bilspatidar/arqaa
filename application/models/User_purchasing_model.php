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
        $this->db->insert('advertisment_banner_data', $data);
        
        // Return the inserted record's ID
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
     

    public function create_boost_profile_data($data) {
        // Insert data into the `user_purchasing` table
        $this->db->insert('boost_profile_data', $data);
        
        // Return the inserted record's ID
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function create_cv_resume_data($data) {
        // Insert data into the `user_purchasing` table
        $this->db->insert('cv_resume_data', $data);
        
        // Return the inserted record's ID
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function create_multiple_service_data($data) {
        // Insert data into the `user_purchasing` table
        $this->db->insert('multiple_service_data', $data);
        
        // Return the inserted record's ID
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function create_review_rating($data) {
        // Insert data into the `user_purchasing` table
        $this->db->insert('review_rating', $data);
        
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
    
    public function get($count, $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        // Debugging: Log the inputs to check if they're correct
        log_message('debug', 'id: ' . $id . ' limit: ' . $limit . ' offset: ' . $offset);
        
        // Your query logic here, ensure that it's correct
        $this->db->select('*');
        $this->db->from('advertisment_banner_data');
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        // Add any filters from $filterData
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        // Apply limit and offset
        $this->db->limit($limit, $offset);
        
        if ($count == 'yes') {
            $query = $this->db->get();
            return $query->num_rows(); // Return the total count of records
        } else {
            $query = $this->db->get();
            return $query->result_array(); // Return the actual data
        }
    }
    
     public function get_multiple_service_data($count, $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        // Debugging: Log the inputs to check if they're correct
        log_message('debug', 'id: ' . $id . ' limit: ' . $limit . ' offset: ' . $offset);
        
        // Your query logic here, ensure that it's correct
        $this->db->select('*');
        $this->db->from('multiple_service_data');
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        // Add any filters from $filterData
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        // Apply limit and offset
        $this->db->limit($limit, $offset);
        
        if ($count == 'yes') {
            $query = $this->db->get();
            return $query->num_rows(); // Return the total count of records
        } else {
            $query = $this->db->get();
            return $query->result_array(); // Return the actual data
        }
    }


    public function get_boost_profile_data($count, $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        // Debugging: Log the inputs to check if they're correct
        log_message('debug', 'id: ' . $id . ' limit: ' . $limit . ' offset: ' . $offset);
        
        // Your query logic here, ensure that it's correct
        $this->db->select('*');
        $this->db->from('boost_profile_data');
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        // Add any filters from $filterData
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        // Apply limit and offset
        $this->db->limit($limit, $offset);
        
        if ($count == 'yes') {
            $query = $this->db->get();
            return $query->num_rows(); // Return the total count of records
        } else {
            $query = $this->db->get();
            return $query->result_array(); // Return the actual data
        }
    }

   public function get_cv_resume_data($count, $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        // Debugging: Log the inputs to check if they're correct
        log_message('debug', 'id: ' . $id . ' limit: ' . $limit . ' offset: ' . $offset);
        
        // Your query logic here, ensure that it's correct
        $this->db->select('*');
        $this->db->from('cv_resume_data');
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        // Add any filters from $filterData
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        // Apply limit and offset
        $this->db->limit($limit, $offset);
        
        if ($count == 'yes') {
            $query = $this->db->get();
            return $query->num_rows(); // Return the total count of records
        } else {
            $query = $this->db->get();
            return $query->result_array(); // Return the actual data
        }
    }

    public function get_multiple_sevice_data($count, $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        // Debugging: Log the inputs to check if they're correct
        log_message('debug', 'id: ' . $id . ' limit: ' . $limit . ' offset: ' . $offset);
        
        // Your query logic here, ensure that it's correct
        $this->db->select('*');
        $this->db->from('multiple_service_data');
        if ($id > 0) {
            $this->db->where('id', $id);
        }
        // Add any filters from $filterData
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        // Apply limit and offset
        $this->db->limit($limit, $offset);
        
        if ($count == 'yes') {
            $query = $this->db->get();
            return $query->num_rows(); // Return the total count of records
        } else {
            $query = $this->db->get();
            return $query->result_array(); // Return the actual data
        }
    }

    public function get_review_rating($count, $id = 0, $limit = 10, $offset = 0, $filterData = []) {
        
       // Select columns, including users' full name and profile picture
       $this->db->select("
         review_rating.*, 
         users.name as added_by_name, 
         users.profile_pic as added_by_image, 
         user.name as user_name, 
         user.profile_pic as user_image
        ");

        // From the review_rating table
        $this->db->from('review_rating');

        // Join with users table based on addedBy field
        $this->db->join('users', 'review_rating.addedBy = users.id', 'left');

        // Add another join with users table based on user_id field
        $this->db->join('users as user', 'review_rating.user_id = user.id', 'left');

        
        // If a specific review rating ID is provided, filter by it
        if ($id > 0) {
            $this->db->where('review_rating.id', $id);
        }
        // Add any filters from $filterData
        if (!empty($filterData)) {
            foreach ($filterData as $key => $value) {
                $this->db->where($key, $value);
            }
        }
        
        // Apply limit and offset for pagination
        $this->db->limit($limit, $offset);
    
        // Execute the query based on count or actual data
        if ($count == 'yes') {
            $query = $this->db->get();
            return $query->num_rows(); // Return the total count of records
        } else {
            $query = $this->db->get();
            return $query->result_array(); // Return the actual data
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
        return $this->db->update('advertisment_banner_data', $data);
    }

    /**
     * Delete a user purchasing record
     *
     * @param int $id The record ID
     * @return bool Whether the delete was successful
     */
    public function delete($id) {
        // Delete the record from the `user_purchasing` table
        $this->db->where('id', $id);
        return $this->db->delete('advertisment_banner_data');
    }

}
