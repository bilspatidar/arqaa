<?php 

class EditApiCurl{

    protected $ci;
    protected $apiToken;

    public function __construct() {
        $this->CI =& get_instance();
        $this->apiToken =  $this->CI->session->userdata('user_details')['access_token'];
    }

    public function getTableDetails($id='', $show_endpoint='') {
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => $show_endpoint.'?id=' . $id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Token: ' . $this->apiToken
            ),
        ));
    
        $response = curl_exec($curl);
        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // Get HTTP status code
        $error = curl_error($curl); // Get cURL error message
    
        curl_close($curl);
    
        // Check if there was an error during the cURL request
        if ($error) {
            // Return the error message along with the HTTP status code as an array
            return array('status' => 'error', 'message' => 'Error: ' . $error . ', HTTP status code ' . $httpStatusCode);
        }
    
        // Check if the status code is 200
        if ($httpStatusCode === 200) {
            // Return the response along with the HTTP status code as an array
            return array('status' => 'ok', 'data' => $response, 'http_status_code' => $httpStatusCode);
        } else {
            // Return an error message along with the HTTP status code as an array
            return array('status' => 'error', 'message' => 'Error: HTTP status code ' . $httpStatusCode);
        }
    }
    
    
    
    

}

?>