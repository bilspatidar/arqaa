<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/


$hook['pre_controller'][] = array(
    'class'    => 'LanguageLoader',      // Class name
    'function' => 'load_language',       // Method name
    'filename' => 'LanguageLoader.php',  // Filename of the hook class
    'filepath' => 'hooks',               // Path to the hooks directory
    'params'   => array()                // No parameters for now
);

