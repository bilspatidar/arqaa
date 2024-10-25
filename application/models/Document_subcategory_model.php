<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Document_subcategory_model extends CI_Model {

    protected $table      = 'document_subcategory';
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
        $response = $this->db->update($this->table, $data, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    public function get($isCount = '',$id='',$limit='',$page = '',$filterData='')  {
        $this->db->select("$this->table.*,(document_category.name) as category_name");
        $this->db->from($this->table);
		$this->db->join('document_category',"document_category.id=$this->table.document_category_id");
        if(!empty($id)) {
            $this->db->where($this->table.'.'.$this->primaryKey, $id);
        }
		if(isset($filterData['name']) && !empty($filterData['name'])){
			$this->db->like($this->table.'.'.'name',$filterData['name']);
		}
		if(isset($filterData['document_category_id']) && !empty($filterData['document_category_id'])){
			$this->db->where($this->table.'.'.'document_category_id',$filterData['document_category_id']);
		}
		if(isset($filterData['status']) && !empty($filterData['status'])){
			$this->db->where($this->table.'.'.'status',$filterData['status']);
		}
		$this->db->order_by($this->table.'.'.$this->primaryKey,'desc');
        
        if($isCount=='yes'){
            $all_res = $this->db->get();
            return $all_res->num_rows();
                
           }
           else{
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
           }
    }
	public function document_subcategory_parent($id='') {
		$this->db->select("$this->table.*,(document_category.name) as category_name");
        $this->db->from($this->table);
		$this->db->join('document_category',"document_category.id=$this->table.document_category_id");
        if(!empty($id)) {
            $this->db->where($this->table.'.'.'document_category_id', $id);
        }
		$this->db->order_by($this->table.'.'.$this->primaryKey,'desc');
        return $this->db->get()->result();
    }
}
