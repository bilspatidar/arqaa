<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Httprequest {

    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
    }

    public function request($url, $method = 'POST', $data = array()) {
        // Implement your HTTP request logic here, you can use cURL or CodeIgniter HTTP client


        // Adjust this based on your API requirements
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if($method=='POST'){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS,json_encode($data));
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 0);
        $return = curl_exec($curl);
		$reponse_code = curl_getinfo($curl,CURLINFO_HTTP_CODE);
		if($return == NULL) {
			return curl_errno($curl);
		}else if($reponse_code != 200) {
			return $reponse_code;
		}
		curl_close($curl);
		return $return;
    }

    // Other methods if applicable
}
