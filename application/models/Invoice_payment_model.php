<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Invoice_payment_model extends CI_Model {

    protected $table      = 'invoice_payment';
    protected $parentTable= 'invoice';
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
	public function insert_invoice_items($data) {
        $this->db->insert($this->parentTable, $data);
        return $this->db->insert_id(); 
    }

    public function update($data, $id) {
        $response = $this->db->update($this->table, $data, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->db->delete($this->table, array($this->primaryKey=>$id));
        return $this->db->affected_rows();
    }

    public function get($id='',$filterData='') {
        $this->db->select("$this->table.*,(payment_mode.name) as payment_mode_name");
        $this->db->from($this->table);
		$this->db->join('payment_mode',"payment_mode.id=$this->table.payment_mode_id",'left');
        if(!empty($id)) {
            $this->db->where($this->table.'.'.$this->primaryKey, $id);
        }
		if(isset($filterData['title']) && !empty($filterData['title'])){
			$this->db->like("$this->table.title",$filterData['title']);
		}
		if(isset($filterData['payment_mode_id']) && !empty($filterData['payment_mode_id'])){
			$this->db->where("$this->table.payment_mode_id",$filterData['payment_mode_id']);
		}
		if(isset($filterData['invoice_id']) && !empty($filterData['invoice_id'])){
			$this->db->where("$this->table.invoice_id",$filterData['invoice_id']);
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
        return $this->db->get()->result();
    }
	
}
