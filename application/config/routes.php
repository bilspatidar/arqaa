<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'admin/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//API 
//$route['media'] = 'api/Media';
//$route['media/(:any)'] = 'api/Media/$1';
//$route['media/(:num)']['PUT'] = 'api/Media/$1';
//$route['media/(:num)']['DELETE'] = 'api/Media/$1';
$route['series'] = 'api/Media/series';
$route['series/(:any)'] = 'api/Media/series/$i';
$route['topic'] = 'api/Media/topic';
$route['suscribe'] = 'api/Media/suscribe';
$route['topic/(:any)'] = 'api/Media/topic/$i';
$route['medias'] = 'api/Media/medias';
$route['streaming'] = 'api/Media/streaming';
$route['home'] = 'api/Media/home';
$route['medias/(:any)'] = 'api/Media/medias/$i';
$route['register'] = 'api/User/register';
$route['signup'] = 'api/User/signup';
$route['company_signup'] = 'api/user/company_signup';
$route['company_size'] = 'api/User/company_size';



$route['login'] = 'api/User/login';
$route['logout'] = 'api/User/logout';
$route['reGenToken'] = 'api/Token/reGenToken';

$route['admin'] = 'admin/login';