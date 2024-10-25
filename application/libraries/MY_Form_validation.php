<?php

class MY_Form_validation extends CI_Form_validation{


    function get_error_array()
		{
			return $this->_error_array;
		}
		
	
    public function edit_unique000($str, $field)
    {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'users_id !=' => $id))->num_rows() === 0)
            : FALSE;
    }
    
       public function edit_unique($str, $field)
    {
        sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field, $columnIdName, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, $columnIdName .'!=' => $id))->num_rows() === 0)
            : FALSE;
    
    }
	
	public function edit_uniqueclass($str,$field)
    {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'class_id !=' =>$id))->num_rows() === 0)
            : FALSE;
    }
    
	
	public function edit_uniquecustomermobile($str,$field)
    {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'customerId !=' =>$id))->num_rows() === 0)
            : FALSE;
    }
	
	public function edit_uniqueusermobile($str,$field)
    {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'users_id !=' =>$id))->num_rows() === 0)
            : FALSE;
    }
	
	
	
	public function edit_uniquecategory($str,$field)
    {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'id !=' =>$id))->num_rows() === 0)
            : FALSE;
    }
	
	
	
	public function edit_feetype($str,$field)
    {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'fee_type_id !=' =>$id))->num_rows() === 0)
            : FALSE;
    }
    
	
	
    
	
	public function edit_unique_td($str,$field)
    {
        sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'id !=' =>$id))->num_rows() === 0)
            : FALSE;
    }
    

}