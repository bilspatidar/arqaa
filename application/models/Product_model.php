<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * @extends CI_Model
 */
class Product_model extends CI_Model {

	protected $table      = 'product';
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

	public function update($data, $id)
    {
        $response = $this->db->update($this->table, $data, array($this->primaryKey=>$id));
		return $this->db->affected_rows();
    }
	
	public function delete($id)
    {
        $this->db->delete($this->table, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }
	
	public function get($isCount = '',$id='',$limit='',$page = '',$filterData=''){
		$this->db->select("$this->table.*,(category.name) as category_name,(sub_category.name) as subcategory_name,(unit.name) as unit_name,(brand.name) as brand_name");
        $this->db->from($this->table);
		$this->db->join('category',"category.id=$this->table.category_id",'left');
		$this->db->join('sub_category',"sub_category.id=$this->table.subcategory_id",'left');
		$this->db->join('unit',"unit.id=$this->table.unit_id",'left');
		$this->db->join('brand',"brand.id=$this->table.brand_id",'left');
		if(!empty($id)){
			$this->db->where($this->table.'.'.$this->primaryKey,$id);
		}
		if(isset($filterData['name']) && !empty($filterData['name'])){
			$this->db->like("$this->table.name",$filterData['name']);
			$this->db->or_like("$this->table.short_name",$filterData['name']);
		}
		if(isset($filterData['type']) && !empty($filterData['type'])){
			$this->db->like("$this->table.type",$filterData['type']);
		}
		if(isset($filterData['barcode']) && !empty($filterData['barcode'])){
			$this->db->like("$this->table.barcode",$filterData['barcode']);
		}
		if(isset($filterData['category_id']) && !empty($filterData['category_id'])){
			$this->db->where("$this->table.category_id",$filterData['category_id']);
		}
		if(isset($filterData['subcategory_id']) && !empty($filterData['subcategory_id'])){
			$this->db->where("$this->table.subcategory_id",$filterData['subcategory_id']);
		}
		if(isset($filterData['brand_id']) && !empty($filterData['brand_id'])){
			$this->db->where("$this->table.brand_id",$filterData['brand_id']);
		}
		if(isset($filterData['unit_id']) && !empty($filterData['unit_id'])){
			$this->db->where("$this->table.unit_id",$filterData['unit_id']);
		}
		if(isset($filterData['status']) && !empty($filterData['status'])){
			$this->db->where("$this->table.status",$filterData['status']);
		}
		if(isset($filterData['from_date']) && !empty($filterData['from_date'])){
			$from_date = date('Y-m-d',strtotime($filterData['from_date']));
			$this->db->where("CAST($this->table.added AS DATE)>=",$from_date);
		}
		if(isset($filterData['to_date']) && !empty($filterData['to_date'])){
			$to_date = date('Y-m-d',strtotime($filterData['to_date']));
			$this->db->where("CAST($this->table.added AS DATE)<=",$to_date);
		}
		$this->db->order_by($this->table.'.'.$this->primaryKey,'desc');
		//return $this->db->get()->result();
		if($isCount=='yes'){
			$all_res = $this->db->get();
			return $all_res->num_rows();
				
		   }
		   else{
			$this->db->limit($limit, $page);
			return $this->db->get()->result();
		   }
		
	}
}
