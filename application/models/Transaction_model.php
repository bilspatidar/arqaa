<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_model extends CI_Model {

    protected $table      = 'transaction';
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
		$this->load->model('v2_model');		
    }

    public function getTransactionById($filterData='') {
        // Your logic to fetch details for a specific transaction ID
        $this->db->select("$this->table.*");
        $this->db->from($this->table);
        $this->db->join('transaction_payment_gateway', 'transaction_payment_gateway.transaction_id = transaction.id', 'left');
		if(isset($filterData['id']) && !empty($filterData['id'])){
			$this->db->where($this->table.'.id',$filterData['id']);
		}
        $query = $this->db->get();
    
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    
    

    public function get($isCount = '', $id = '', $limit = '', $page = '', $filterData = '') {
        $this->db->select("$this->table.*,(users.name) as merchant_name,(payment_gateway.name) as payment_gateway_name");
        $this->db->from($this->table);
		$this->db->join('users',"users.users_id=$this->table.merchant_id",'left');
		$this->db->join('payment_gateway',"payment_gateway.id=$this->table.payment_id",'left');

		 if(isset($filterData['transaction_id']) && !empty($filterData['transaction_id'])){
			$this->db->like($this->table.'.payment_transaction_id',$filterData['transaction_id']);
			$this->db->or_like($this->table.'.merchant_transaction_id',$filterData['transaction_id']);
		}
		
        if(isset($filterData['merchant_id']) && !empty($filterData['merchant_id'])){
			$this->db->where($this->table.'.merchant_id',$filterData['merchant_id']);
		}
		if(isset($filterData['mid']) && !empty($filterData['mid'])){
			$this->db->where($this->table.'.mid',$filterData['mid']);
		}
		if(isset($filterData['currency']) && !empty($filterData['currency'])){
			$this->db->where($this->table.'.currency',$filterData['currency']);
		}
		if(isset($filterData['cardType']) && !empty($filterData['cardType'])){
			$this->db->where($this->table.'.cardType',$filterData['cardType']);
		}
		if(isset($filterData['from_date']) && !empty($filterData['from_date'])){
			$from_date = date('Y-m-d',strtotime($filterData['from_date']));
			$this->db->where('CAST('.$this->table.'.'.'transaction_datetime AS DATE)>=',$from_date);
		}
		if(isset($filterData['to_date']) && !empty($filterData['to_date'])){
			$to_date = date('Y-m-d',strtotime($filterData['to_date']));
			$this->db->where('CAST('.$this->table.'.'.'transaction_datetime AS DATE)<=',$to_date);
		}
        if(isset($filterData['payment_id']) && !empty($filterData['payment_id'])){
			$this->db->where($this->table.'.payment_id',$filterData['payment_id']);
		}
        if(isset($filterData['status']) && !empty($filterData['status'])){
			$this->db->where($this->table.'.status',$filterData['status']);
		}
		$this->db->order_by($this->table.'.'.$this->primaryKey,'desc');
        if($isCount == 'yes'){
            $all_res = $this->db->get();
            return $all_res->num_rows();                
        } else {
            $this->db->limit($limit, $page);
            return $this->db->get()->result();
        }
    }

	 public function send_webhook($id) {
        // Your logic to fetch details for a specific transaction ID
        $this->db->select("token");
        $this->db->from($this->table);
		$this->db->where('id',$id);
        $query = $this->db->get();
        if ($query->num_rows()>0) {
            $token = $query->row()->token;
			return $this->v2_model->sendWebhook($token);
        } else {
            return false;
        }
    }
}
