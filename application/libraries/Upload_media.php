<?php

class Upload_media {

    protected $CI;

    public function __construct() {
        $this->CI = &get_instance();
    }

    public function upload_and_save($base64_image, $quality = 90, $radioConfig = [], $upload_folder = '') {
		
		
        $image_parts = explode(";base64,", $base64_image);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        // Validate image type and base64 data
        if (!$image_type || !$image_base64) {
            // Log error for invalid image data
            log_message('error', 'Invalid image type or base64 data.');
            return "errr";//$base64_image;
        }

        // Create image resource
        $image = imagecreatefromstring($image_base64);

        if (!$image) {
            // Log error for image creation failure
            log_message('error', 'Failed to create image from base64 data.');
            return false;
        }

        // Apply configuration (if any)
        // Your existing configuration logic here...

        // Encrypt file name
        $file_name = $this->encryptFileName($image_type);

        $upload_path = 'uploads/'.$upload_folder.'/'; // Use the provided upload folder name
        if(!file_exists($upload_path)) {
            mkdir($upload_path, 0777, true);  // Create directory if not exist
            // Set appropriate permissions for the directory
            chmod($upload_path, 0777);
        }

        // Save the image with specified quality (if applicable)
        switch ($image_type) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($image, $upload_path . $file_name, $quality);
                break;
            case 'png':
                imagepng($image, $upload_path . $file_name, floor($quality / 10));
                break;
            case 'gif':
                imagegif($image, $upload_path . $file_name);
                break;
            default:
                // Handle unsupported image type
                break;
        }

        // Free up memory
        imagedestroy($image);

        $image_link = base_url($upload_path . $file_name);

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