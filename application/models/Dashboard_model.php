<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

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
    }
	
	 public function todayTransactions($today,$merchant_id='',$currency=''){
     
        $this->db->select("ROUND(SUM(amount + merchant_fee)) as Amount");
        $this->db->from($this->table);
        if(!empty($merchant_id)){
            $this->db->where('merchant_id',$merchant_id);
        }
		if(!empty($currency)){
            $this->db->where('currency',$currency);
        }
        $this->db->where('status','Success');
        $this->db->where("CAST(transaction_datetime AS date) >= ",$today);
		$this->db->where("CAST(transaction_datetime AS date) <= ",$today);
        $data = $this->db->get();
        if($data->num_rows()>0){
            return number_format($data->row()->Amount,2);
        }else{
            return 0;
        }
    }
	public function monthTransactions($month,$merchant_id='',$currency='',$fromDate='',$toDate=''){
    $Month = date('m',strtotime($month));
    $Year = date('Y',strtotime($month));
        
        //$this->db->select_sum('amount');
        $this->db->select("ROUND(SUM(amount + merchant_fee)) as Amount");
        $this->db->from($this->table);
        if(!empty($merchant_id)){
            $this->db->where('merchant_id',$merchant_id);
        }
		if(!empty($currency)){
            $this->db->where('currency',$currency);
        }
        if(!empty($fromDate)){
			$this->db->where('CAST(transaction_datetime AS DATE) >=',$fromDate);
		}
		if(!empty($toDate)){
			$this->db->where('CAST(transaction_datetime AS DATE) <=',$toDate);
		}
        $this->db->where('status','Success');
        $this->db->where('MONTH(transaction_datetime)', $Month);
        $this->db->where('YEAR(transaction_datetime)', $Year );
        $data = $this->db->get();
        if($data->num_rows()>0){
            return number_format($data->row()->Amount,2);
        }else{
            return 0;
        }
    }
	
	public function totalTransactions($merchant_id='',$currency=''){
     
       $this->db->select("ROUND(SUM(amount + merchant_fee)) as Amount");
        $this->db->from($this->table);
        if(!empty($merchant_id)){
            $this->db->where('merchant_id',$merchant_id);
        }
		if(!empty($currency)){
            $this->db->where('currency',$currency);
        }
        $this->db->where('status','Success');
        $data = $this->db->get();
        if($data->num_rows()>0){
            return number_format($data->row()->Amount,2);
        }else{
            return 0;
        }
    }
	public function recentTransactions($merchant_id='',$filterData='') {
        $this->db->select("$this->table.id,$this->table.amount,$this->table.merchant_fee,$this->table.currency,$this->table.merchant_id,$this->table.mid,$this->table.payment_transaction_id,$this->table.merchant_transaction_id,$this->table.status,$this->table.message,(users.name) as merchant_name");
        $this->db->from($this->table);
		$this->db->join('users',"users.users_id=$this->table.merchant_id",'left');
		if(!empty($merchant_id)) {
            $this->db->where($this->table.'.merchant_id',$merchant_id);
        }

        if(isset($filterData['currency']) && !empty($filterData['currency'])){
			$this->db->where($this->table.'.currency',$filterData['currency']);
		}
		if(isset($filterData['from_date']) && !empty($filterData['from_date'])){
			$from_date = date('Y-m-d',strtotime($filterData['from_date']));
			$this->db->where('CAST('.$this->table.'.'.'transaction_datetime AS DATE)>=',$from_date);
		}
		if(isset($filterData['to_date']) && !empty($filterData['to_date'])){
			$to_date = date('Y-m-d',strtotime($filterData['to_date']));
			$this->db->where('CAST('.$this->table.'.'.'transaction_datetime AS DATE)<=',$to_date);
		}
        if(isset($filterData['status']) && !empty($filterData['status'])){
			$this->db->where($this->table.'.status',$filterData['status']);
		}
		$this->db->order_by($this->table.'.'.$this->primaryKey,'desc');
        return $this->db->get()->result();
    }
	public function transactionStatus($merchant_id='',$filterData=''){
        $this->db->select('amount');
        $this->db->from($this->table);
        if(!empty($merchant_id)){
            $this->db->where('merchant_id',$merchant_id);
        }
		if(isset($filterData['currency']) && !empty($filterData['currency'])){
			$this->db->where('currency',$filterData['currency']);
		}
		if(isset($filterData['from_date']) && !empty($filterData['from_date'])){
			$from_date = date('Y-m-d',strtotime($filterData['from_date']));
			$this->db->where('CAST(transaction_datetime AS DATE)>=',$from_date);
		}
		if(isset($filterData['to_date']) && !empty($filterData['to_date'])){
			$to_date = date('Y-m-d',strtotime($filterData['to_date']));
			$this->db->where('CAST(transaction_datetime AS DATE)<=',$to_date);
		}
		if(isset($filterData['status']) && !empty($filterData['status'])){
			$this->db->where('status',$filterData['status']);
		}
        $this->db->where('amount>',0);
        $data = $this->db->get();
        return $data->num_rows();
         
    }
	
	public function transactionCurrency($merchant_id=''){
        $this->db->select('currency');
        $this->db->from($this->table);
		if(!empty($merchant_id)){
			$this->db->where('merchant_id',$merchant_id);
		}
		$this->db->group_by('currency');
        return $this->db->get()->result();
    
    }
	
}
