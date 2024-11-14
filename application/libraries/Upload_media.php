<?php

class Upload_media {

    protected $CI;

    public function __construct() {
        $this->CI = &get_instance();
    }

    public function upload_and_save($base64_image, $quality = 90, $radioConfig = [], $upload_folder = '') {
        // Split base64 data into parts
        $image_parts = explode(";base64,", $base64_image);
        
        if (count($image_parts) != 2) {
            log_message('error', 'Invalid base64 image format.');
            return "errr"; 
        }
    
        // Extract the image type and the base64 data
        $image_type_aux = explode("image/", $image_parts[0]);
        if (count($image_type_aux) != 2) {
            log_message('error', 'Invalid image type in base64 data.');
            return "errr";
        }
    
        $image_type = $image_type_aux[1]; // Get image extension (e.g., jpg, png, gif)
        $image_base64 = base64_decode($image_parts[1]);
    
        // Validate base64 data
        if (!$image_type || !$image_base64) {
            log_message('error', 'Invalid image type or base64 data.');
            return "errr";
        }
    
        // Encrypt file name (you should already have a method for this)
        $file_name = $this->encryptFileName($image_type);
    
        // Define the upload path
        $upload_path = 'uploads/'.$upload_folder.'/';
    
        // Create directory if not exists
        if (!file_exists($upload_path)) {
            mkdir($upload_path, 0777, true);  
            chmod($upload_path, 0777);  // Set appropriate permissions
        }
    
        // Save base64 image data directly into a file
        file_put_contents($upload_path . $file_name, $image_base64);
    
        // Get the link to the uploaded image
        $image_link = base_url($upload_path . $file_name);
    
        // Return the image link
        return $image_link;
    }
    

    private function encryptFileName($image_type) {
        $encryptionKey = "o4zyByNy92lzmxw8NJDbH1C6h8WyKlPu"; // Replace with your encryption key
        $file_name = uniqid().'.'.$image_type;
        return rtrim(strtr(base64_encode(
            openssl_encrypt($file_name, 'aes-128-cbc', $encryptionKey, 0, substr($encryptionKey, 0, 16))
        ), '+/', '-_'), '=').'.'.$image_type;
    }

    // New function as requested
    public function extractImageType($base64_image) {
        $image_parts = explode(";base64,", $base64_image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        return $image_type;
    }
}

?>