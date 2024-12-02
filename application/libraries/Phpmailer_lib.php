<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *
 * @category    Libraries
 * @author      CodexWorld
 * @link        https://www.codexworld.com
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class PHPMailer_Lib
{
    public function __construct(){
        log_message('Debug', 'PHPMailer class is loaded.');
    }

    public function load(){
        // Include PHPMailer library files
    define("SMTP_HOST", "smtp.gmail.com"); //mail.ebusinessmart.in    Hostname of the mail server
    define("SMTP_PORT", "587"); //Port of the SMTP like to be 25, 80, 465 or 587
    define("SMTP_UNAME", "Arqaatest@gmail.com"); //Username for SMTP authentication any valid email created in your domain
    define("SMTP_PWORD", "jwbc anfw czze zqwh"); //Password for SMTP authentication
    define("SMTP_SECURE",'true');
    define("SET_FROM", "Arqaatest@gmail.com");
    define("SET_FROM_PARA", "ARQAA");

        require_once APPPATH.'third_party/PHPMailer/src/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/src/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/src/SMTP.php';
        
        $mail = new PHPMailer;
        return $mail;
    }
}