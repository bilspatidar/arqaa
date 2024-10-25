<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/**
* for mail function library
**/
/**
defined('NAME_EMAIL')          OR define('NAME_EMAIL', ''); //user name
defined('SMTP_EMAIL')          OR define('SMTP_EMAIL', ''); //user name
defined('HOST')                OR define('HOST', ''); //host
defined('PORT')                OR define('PORT', ''); //port
defined('SMTP_SECURE')         OR define('SMTP_SECURE', '');//SMTPSecure
defined('SMTP_PASSWORD')       OR define('SMTP_PASSWORD', '');//password

****/


define('RAZOR_KEY_ID','rzp_test_qPUq1WuYyKrLFq');
define('RAZOR_KEY_SECRET','CKFaIu9VhG3GC76E5kLgMT83');
	


// define('RAZOR_KEY_ID','rzp_live_m13E5Ds7X1t6A6');
// define('RAZOR_KEY_SECRET','FkXtXKDc9pxlExfbBGKoFVQW');
define('WP_BALANCE',1000);
define('WinpriceMul',7);
define('REFERAMT',50);
define('WELCOMEBONUS',50);


//PayUMoney Configurations
define('MERCHANT_KEY', 'pvKnwsxh'); //rjQUPktU (test) , pvKnwsxh(live)
define('SALT', 'xHfAKkAxzE'); //e5iIg1jwi8 (test) ,xHfAKkAxzE(live)
// define('PAYU_BASE_URL', 'https://test.payu.in/_payment');    //Testing url 
 define('PAYU_BASE_URL', 'https://secure.payu.in/_payment');  //actual URL


define('GOOGLE_CLIENT_ID','1055328938764-c4l90e79rref7d2r7k8934lsfk2baamh.apps.googleusercontent.com');    //add complete url 
define('GOOGLE_CLIENT_SALT','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');    //add complete url 

define('YOUTUBE_API_KEY','AIzaSyA_f-h_wY-3d0lZ7oMxrsYF9wKaxrycxA0');    //GET YOUTUBE DATA API KEY
define('YOUTUBE_CHANNEL_ID','UCEGn98XMC2mFsPNznBMEs1w'); //GET YOUTUBE DATA CHANNEL ID


define('BRAND_NAME','ARQAA'); 
define('BRAND_TITLE','ARQAA');

define('ADMIN_EMAIL','bils@gmail.in'); 
define('CONTACT_SUBJECT','You have new contact enquiry.'); 

define('CURRENCY','₹');
define('SHIPPINGCHARGE','200');

define('VENDOR_FEE','944');

define('OFFICE_START','10:00');
define('OFFICE_END','19:00');

define('VOUCHER_SRNO','10000');
define('GST_SRNO','10000');
define('ROW_PER_PAGE',2);
//define('API_DOMAIN','http://localhost/new/');
define('API_DOMAIN', 'https://new.arqaa.nl/');