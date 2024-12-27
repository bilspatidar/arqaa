
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services_model extends CI_Model {

    protected $table      = 'services';
    protected $primaryKey = 'id';

    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();        
    }

    /**
     * Create a new service record.
     *
     * @param array $data
     * @return int
     */
    public function create($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id(); 
    }

    public function create_service_status($data) {
        // Insert data into the `user_purchasing` table
        $this->db->insert('service_status', $data);
        
        // Return the inserted record's ID
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    /**
     * Show service details by ID.
     *
     * @param int $id
     * @return array
     */
    public function show($id) {
        $this->db->select("*");
        $this->db->from($this->table);
        if (!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }
        return $this->db->get()->result();
    }

    /**
     * Update service record.
     *
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id) {
        $response = $this->db->update($this->table, $data, array($this->primaryKey => $id));
        return $this->db->affected_rows();
    }

    /**
     * Delete service record by ID.
     *
     * @param int $id
     * @return int
     */
    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey => $id));
        return $this->db->affected_rows();
    }

    /**
     * Get services list with pagination and filtering.
     *
     * @param string $isCount
     * @param int $id
     * @param int $limit
     * @param int $page
     * @param array $filterData
     * @return mixed
     */
    public function get($isCount = '', $id = '', $limit = 10, $page = 1, $filterData = '') {
        $this->db->select("
        {$this->table}.*, 
        users.name as added_by_name, 
        users.profile_pic as added_by_image, 
        category.name as category_name, 
        sub_category.name as subcategory_name
    ");

        $this->db->from($this->table);

        // Join with users table on the addedBy field
        $this->db->join('users', "{$this->table}.addedBy = users.id", 'left');

       // Join with category table on category_id field
       $this->db->join('category', "{$this->table}.category_id = category.id", 'left');

       // Join with sub_category table on subcategory_id field
      $this->db->join('sub_category', "{$this->table}.subcategory_id = sub_category.id", 'left');

      // Add any necessary WHERE conditions or ORDER BY clauses
    if ($id > 0) {
      $this->db->where("{$this->table}.id", $id);
    }
       // Filter by ID if provided
        if (!empty($id)) {
            $this->db->where($this->primaryKey, $id);
        }

        // Filter by title
        if (isset($filterData['name']) && !empty($filterData['name'])) {
            $this->db->where('title', $filterData['name']);
        }

        if (isset($filterData['user_id']) && !empty($filterData['user_id'])) {
            $this->db->where("{$this->table}.addedBy", $filterData['user_id']);
        }

        // Filter by status
        if (isset($filterData['status']) && !empty($filterData['status'])) {
            $this->db->where('status', $filterData['status']);
        }

        // Filter by category_id
        if (isset($filterData['category_id']) && !empty($filterData['category_id'])) {
            $this->db->where("{$this->table}.category_id", $filterData['category_id']);
        }

        // Filter by sub_category_id
        if (isset($filterData['sub_category_id']) && !empty($filterData['sub_category_id'])) {
            $this->db->where("{$this->table}.sub_category_id", $filterData['sub_category_id']);
        }

        // Order by primary key in descending order
        $this->db->order_by($this->primaryKey, 'desc');

        // Return count of records if requested
        if ($isCount == 'yes') {
            return $this->db->count_all_results();
        } else {
            // Apply pagination
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
        }
    }
    
    public function get_service_status($count, $id = 0, $service_id = 0, $limit = 10, $offset = 0, $filterData = []) {
        $this->db->select('*');
        $this->db->from('service_status');
    
        // Filter by 'id' if provided
        if ($id > 0) {
            $this->db->where('id', $id);
        }
    
        // Filter by 'service_id' if provided
        if ($service_id > 0) {
            $this->db->where('service_id', $service_id);
        }
    
        // Add any additional filters from $filterData
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
    

    public function get_all_services($count, $id = 0, $limit = 10, $offset = 0, $filterData = []) {
         $this->db->select("
        {$this->table}.*, 
        users.name as added_by_name, 
        users.profile_pic as added_by_image, 
        category.name as category_name, 
        sub_category.name as subcategory_name
    ");

        $this->db->from($this->table);

        // Join with users table on the addedBy field
        $this->db->join('users', "{$this->table}.addedBy = users.id", 'left');

       // Join with category table on category_id field
       $this->db->join('category', "{$this->table}.category_id = category.id", 'left');

       // Join with sub_category table on subcategory_id field
      $this->db->join('sub_category', "{$this->table}.subcategory_id = sub_category.id", 'left');

          // Add any necessary WHERE conditions or ORDER BY clauses
        if ($id > 0) {
          $this->db->where("{$this->table}.id", $id);
        }
       

        // Filter by title
        if (isset($filterData['name']) && !empty($filterData['name'])) {
            $this->db->where('title', $filterData['name']);
        }

        if (isset($filterData['user_id']) && !empty($filterData['user_id'])) {
            $this->db->where("{$this->table}.addedBy", $filterData['user_id']);
        }

        // Filter by status
        if (isset($filterData['status']) && !empty($filterData['status'])) {
            $this->db->where('status', $filterData['status']);
        }

        // Filter by category_id
        if (isset($filterData['category_id']) && !empty($filterData['category_id'])) {
            $this->db->where("{$this->table}.category_id", $filterData['category_id']);
        }

        // Filter by sub_category_id
        if (isset($filterData['sub_category_id']) && !empty($filterData['sub_category_id'])) {
            $this->db->where("{$this->table}.sub_category_id", $filterData['sub_category_id']);
        }

        // Order by primary key in descending order
        $this->db->order_by($this->primaryKey, 'desc');

        // Return count of records if requested
        if ($isCount == 'yes') {
            return $this->db->count_all_results();
        } else {
            // Apply pagination
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
        }
    }
}


