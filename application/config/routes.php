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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'Home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// customer pages
$route['login'] = 'auth';
$route['dashboard'] = 'home';
$route['edit_profile'] = 'profile/edit';
$route['view_order/(:num)'] = 'orders/detail/$1';
$route['cart'] = 'cart/index';
$route['checkout'] = 'cart/checkout';
$route['invoice/(:num)'] = 'invoice/index/$1';
$route['index'] = 'auth';

// admin pages
$route['admin_login'] = 'admin/auth';
$route['admin_orders'] = 'admin/orders';
$route['admin_products'] = 'admin/product';
$route['admin_cat'] = 'admin/categories';
$route['admin_user'] = 'admin/user';
$route['dashboard'] = 'admin/dashboard';

// kasir pages
$route['kasir_orders'] = 'kasir/orders';
$route['kasir_orders/detail/(:num)'] = 'kasir/orders/detail/$1';

// kurir pages
$route['kurir_orders'] = 'kurir/orders';
$route['kurir_orders/sendOrder/(:num)'] = 'kurir/orders/sendOrder/$1';
$route['kurir_orders/detail/(:num)'] = 'kurir/orders/detail/$1';
