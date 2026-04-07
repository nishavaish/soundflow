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

$route['default_controller'] = 'pages/landing';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Public routes
$route['/'] = 'pages/landing';
$route['landing'] = 'pages/landing';
$route['login']    = 'auth/login';
$route['register'] = 'auth/register';
$route['logout']   = 'auth/logout';
$route['pricing'] = 'pages/pricing';

// Dashboard / protected
$route['dashboard'] = 'dashboard/index';

// Upload routes
$route['upload'] = 'upload/select';
$route['upload/select'] = 'upload/select';
$route['upload/single'] = 'upload/single';
$route['upload/single/stores-platforms'] = 'upload/stores_platforms_single';
$route['upload/single/track-details'] = 'upload/track_details_single';
$route['upload/single/artwork'] = 'upload/art_work_single';


$route['my-releases'] = 'UploadSingle/listing';
$route['my-releases/edit/(:any)'] = 'UploadSingle/edit/$1';

$route['my-releases/edit/step-1/(:any)'] = 'UploadSingle/edit_step1/$1';
$route['my-releases/edit/step-2/(:any)'] = 'UploadSingle/edit_step2/$1';
$route['my-releases/edit/step-3/(:any)'] = 'UploadSingle/edit_step3/$1';
$route['my-releases/edit/step-4/(:any)'] = 'UploadSingle/edit_step4/$1';

$route['my-releases/view/(:any)'] = 'UploadSingle/view/$1';
$route['my-releases/delete/(:any)'] = 'UploadSingle/delete/$1';


// ALBUM LIST PAGE (Spotify-style grid/list)
$route['my-albums'] = 'MyAlbums/list';
$route['my-albums/list'] = 'MyAlbums/list';

// VIEW SINGLE ALBUM
$route['my-albums/view/(:num)'] = 'MyAlbums/view/$1';
// CREATE — STEP 1
$route['UploadAlbum/step1'] = 'UploadAlbum/step1';

// CREATE — STEP 2
$route['UploadAlbum/step2'] = 'UploadAlbum/step2';

// CREATE — STEP 3 (tracks)
$route['UploadAlbum/step3'] = 'UploadAlbum/step3';

// CREATE — STEP 4 (artwork)
$route['UploadAlbum/step4'] = 'UploadAlbum/step4';

// REVIEW PAGE
$route['UploadAlbum/review'] = 'UploadAlbum/review';

// FINAL SUBMIT
$route['UploadAlbum/submit'] = 'UploadAlbum/submit';

// SUCCESS PAGE
$route['UploadAlbum/success/(:num)'] = 'UploadAlbum/success/$1';


$route['UploadAlbum/edit/(:num)/(:num)'] = 'UploadAlbum/edit/$1/$2';



// EDIT — STEP 1
$route['my-albums/edit/step-1/(:num)'] = 'UploadAlbum/edit_step1/$1';

// EDIT — STEP 2
$route['my-albums/edit/step-2/(:num)'] = 'UploadAlbum/edit_step2/$1';

// EDIT — STEP 3 (track editor)
$route['my-albums/edit/step-3/(:num)'] = 'UploadAlbum/edit_step3/$1';

// EDIT — STEP 4 (artwork)
$route['my-albums/edit/step-4/(:num)'] = 'UploadAlbum/edit_step4/$1';

// EDIT REVIEW
$route['my-albums/edit/review/(:num)'] = 'UploadAlbum/edit_review/$1';

// UPDATE SUBMIT
$route['my-albums/edit/submit/(:num)'] = 'UploadAlbum/update/$1';
// AJAX Delete Album (called from detail page)
$route['UploadAlbum/delete/(:num)'] = 'UploadAlbum/delete/$1';

// Non-AJAX Delete (fallback)
$route['my-albums/delete/(:num)'] = 'MyAlbums/delete/$1';
// DELETE A TRACK (AJAX)
$route['my-albums/delete-track/(:num)'] = 'UploadAlbum/delete_track/$1';

// UPDATE TRACK ORDER
$route['my-albums/reorder-track'] = 'UploadAlbum/reorder_track';



//$route['library'] = 'UploadAlbum/list';
//$route['my-albums'] = 'UploadAlbum/list';



$route['my-assets'] = 'user/Assets/library';
$route['assets/create_project'] = 'user/Assets/create_project';
$route['assets/project/(:any)'] = 'user/Assets/project/$1';
$route['assets/upload_asset'] = 'user/Assets/upload_asset';
$route['assets/update_asset'] = 'user/Assets/update_asset';
$route['assets/delete_asset'] = 'user/Assets/delete_asset';


$route['Assets/testUpload'] = 'user/Assets/uploadImage';
$route['Assets/uploadFileS3'] = 'user/Assets/uploadFileS3';



/// analytics routes
$route['analytics'] = 'Analytics/index';
$route['analytics/data/(:any)/(:any)'] = 'Analytics/get_data/$1/$2';


// application/config/routes.php
$route['profile'] = 'Profile/index';
$route['profile/update_bank'] = 'Profile/update_bank';
$route['profile/update_bank_ajax'] = 'Profile/update_bank_ajax';

$route['profile/upload_invoice'] = 'Profile/upload_invoice';
$route['profile/upload_invoice_ajax'] = 'Profile/upload_invoice_ajax';

$route['profile/delete_invoice'] = 'Profile/delete_invoice';
$route['invoices'] = 'Invoices/index';




// Add any other routes your React app used here...
$route['pwd'] = 'admin/AdminAuth/passwordEnc';
$route['admin'] = 'admin/AdminAuth/login';
$route['admin/login'] = 'admin/AdminAuth/login';
$route['admin/logout'] = 'admin/AdminAuth/logout';

$route['admin/dashboard'] = 'admin/Dashboard';
$route['admin/users'] = 'admin/Users';


$route['admin/releases'] = 'admin/Releases';
$route['admin/releases/delete/(:num)'] = 'admin/Releases/delete/$1';
$route['admin/releases/toggle/(:num)'] = 'admin/Releases/toggle/$1';
$route['admin/releases/streams/(:num)'] = 'admin/Releases/streams/$1';
$route['admin/releases/streams_by_month/(:num)/(:any)'] = 'admin/Releases/streams_by_month/$1/$2';
$route['admin/releases/save_isrc'] = 'admin/Releases/save_isrc';


$route['admin/albums'] = 'admin/Albums';
$route['admin/albums/delete/(:num)'] = 'admin/Albums/delete/$1';
$route['admin/albums/toggle/(:num)'] = 'admin/Albums/toggle/$1';
$route['admin/albums/update_isrc'] = 'admin/Albums/update_isrc';

$route['admin/albums/track/streams/(:num)'] = 'admin/Albums/streams/$1';
$route['admin/albums/track/streams_by_month/(:num)']= 'admin/Albums/streams_by_month/$1';
$route['admin/albums/track/streams_by_month/(:num)/(:any)'] = 'admin/Albums/streams_by_month/$1/$2';



$route['admin/streaming-links'] = 'admin/StreamingLinks';
$route['admin/streaming-links/(:any)/(:num)'] = 'admin/StreamingLinks/manage/$1/$2';
$route['admin/streaminglinks/add'] = 'admin/StreamingLinks/add';
$route['admin/streaminglinks/delete/(:num)'] = 'admin/StreamingLinks/delete/$1';
$route['admin/streaminglinks/toggle/(:num)'] = 'admin/StreamingLinks/toggle/$1';



$route['admin/plans/'] = 'admin/plans/index';
$route['admin/plans/delete/(:num)'] = 'admin/plans/delete/$1';
$route['admin/plans/toggle_status'] = 'admin/plans/toggle_status';

