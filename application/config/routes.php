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

$route['default_controller'] = 'auth/login';
$route['404_override'] = 'error_404';
$route['translate_uri_dashes'] = FALSE;


$route['login'] = 'auth/login';
$route['signup'] = 'auth/signup';

$route['dashboard'] = 'dashboard/index';

$route['csv/create'] = 'csv/create';
$route['csv/upload'] = 'csv/upload_csv';
$route['csv/set-header-name'] = 'csv/set_csv_header_name';
$route['schedule/fill'] = 'schedule/fill_from_csv';
$route['csv/update_csv_schedule'] = 'csv/update_csv_schedule';

$route['schedule'] = 'schedule/index';
$route['schedule/create'] = 'schedule/create';

$route['schedulelist/delete_scheduled_product'] = 'schedulelist/delete_scheduled_product';
$route['schedulelist/product_update'] = 'schedulelist/product_update';

$route['address'] = 'address/index';
$route['address/create'] = 'address/create';
$route['address/(:num)/edit'] = 'address/edit/$1';
$route['address/(:num)/delete'] = 'address/delete/$1';
$route['address/update'] = 'address/update';

$route['management'] = 'management/selling_schedule';
$route['management-schedule'] = 'management/schedule';
$route['management/schedule/upload-photos'] = 'management/upload_photos';
$route['management/schedule/save-measure'] = 'management/save_measure';
$route['management/schedule/check'] = 'management/update_checkbox_status';
$route['management/schedule/complete'] = 'management/complete_schedule';
$route['management-enquiry'] = 'management/enquiry';
$route['management-selling-schedule'] = 'management/selling_schedule';
$route['management/download-schedules'] = 'management/download_schedules';
$route['management-billing'] = 'management/billing';

$route['product/get-last-consecutive-number'] = 'management/get_last_product_consecutive_number';

$route['photos'] = 'photos/index';
$route['photos/download'] = 'photos/free_download';

$route['stock'] = 'stock/index';
$route['stock/product_update'] = 'stock/product_update';
$route['stock/order'] = 'stock/sale_order';
$route['stock/csv-in-stock'] = 'stock/downloadCsv_in_stock';
$route['stock/order-status'] = 'stock/order_status_change';
// $route['stock/order/product-detail'] = 'stock/get_product_images_and_measure';

$route['enquiry'] = 'enquiry/index';
$route['admin-enquiry'] = 'enquiry/admin_index';
$route['enquiry/create'] = 'enquiry/create';
$route['enquiry/reply'] = 'enquiry/reply';
$route['enquiry/close'] = 'enquiry/close';
$route['enquiry/open-child'] = 'enquiry/get_replies';

$route['domestic'] = 'domestic/index';
$route['domestic/sent'] = 'domestic/orders_sent';

$route['invoice'] = 'invoice/index';
$route['d-invoice'] = 'invoice/get_invoice_pdf';
$route['d-membership-invoice'] = 'invoice/get_membership_invoice_pdf';
$route['d-invoice-csv'] = 'invoice/get_invoice_csv';

$route['cuser'] = 'users/create';
$route['uuser'] = 'users/update';
$route['users'] = 'users/index';
/* End of file routes.php */
/* Location: ./application/config/routes.php */
