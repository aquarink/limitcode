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
$route['default_controller'] = 'front';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['signin'] = 'User/signin';
$route['signin/f'] = 'User/signinFacebook';
$route['signup'] = 'User/signup';
$route['forgotpass'] = 'User/forgotpass';
$route['newpassword/(:any)'] = 'User/newpassword';
$route['verify/(:any)'] = 'User/verify/$1';
$route['reqverify/(:any)'] = 'User/reqverify/$1';
$route['getnotif'] = 'User/notif';

$route['language/(:any)'] = 'User/language/$1';

$route['article/new'] = 'Article/newarticle';
$route['article/new/(:num)'] = 'Article/newarticle';
$route['article/deldraf/(:num)'] = 'Article/deleteDraf';
$route['article/list'] = 'Article/listarticle';
$route['article/list/(:num)'] = 'Article/listarticle';
$route['article/uploadimage'] = 'Article/uploadimage';
$route['article/preview/(:num)'] = 'Article/preview';
$route['article/edit/(:num)'] = 'Article/edit';
$route['article/impressview'] = 'Article/impressview';
$route['article/impressbounce'] = 'Article/impressbounce';
$route['u'] = 'Article/redirecturl';

$route['gallery/new'] = 'Gallery/newgallery';
$route['gallery/newalbum'] = 'Gallery/newalbum';
$route['gallery/list'] = 'Gallery/listgallery';

$route['video/new'] = 'Video/newvideo';
$route['video/list'] = 'Video/listvideo';
$route['video/list/(:num)'] = 'Video/listvideo';
$route['video/preview'] = 'Video/preview';
$route['video/edit'] = 'Video/edit';
$route['fileupload'] = 'Video/fileupload';
$route['video/insvid'] = 'Video/insertvideo';

$route['approval/waiting'] = 'Approval/waitapproval';
$route['approval/waiting/(:num)'] = 'Approval/waitapproval';
$route['approval/approved'] = 'Approval/contentapproved';
$route['approval/approved/(:num)'] = 'Approval/contentapproved';
$route['approval/blocked'] = 'Approval/contentblock';
$route['approval/blocked/(:num)'] = 'Approval/contentblock';
$route['approval/preview/(:num)'] = 'Approval/preview';
$route['approval/unblocked/(:num)'] = 'Approval/unblock';
$route['approval/blocked/(:num)'] = 'Approval/blocked';
$route['approval/publish/(:num)'] = 'Approval/unblock';
$route['approval/reject'] = 'Approval/reject';

$route['menu/new'] = 'Menu/newmenu';
$route['menu/list'] = 'Menu/listmenu';
$route['menu/edit'] = 'Menu/editmenu';

$route['banner/new'] = 'Banner/newbanner';
$route['banner/list'] = 'Banner/listbanner';
$route['banner/list/(:num)'] = 'Banner/listbanner';
$route['banner/active/(:num)'] = 'Banner/banneraction';
$route['banner/delete/(:num)'] = 'Banner/banneraction';
$route['banner/disable/(:num)'] = 'Banner/banneraction';

$route['admin/new'] = 'Admin/newadmin';
$route['admin/list'] = 'Admin/listadmin';
$route['dashboard'] = 'Admin/dashboard';
$route['dashboard/(:num)'] = 'Admin/dashboard';
$route['editprofile'] = 'Admin/editprofile';
$route['signout'] = 'Admin/signout';

$route['contributor/waiting'] = 'Contributor/waiting';
$route['contributor/approved'] = 'Contributor/approved';
$route['contributor/verify'] = 'Contributor/verify';

//SHORT URL
$route['home'] = 'Front';


// FRONT
$route['home'] = 'Front';
$route['q/(:any)'] = 'Front/contentMenu';
$route['q/(:any)/(:num)'] = 'Front/contentMenu';
$route['q/(:any)/(:any)'] = 'Front/contentMenuSub';
$route['user/(:num)'] = 'Front/contentUser';
$route['user/(:num)/(:num)'] = 'Front/contentUser';
$route['tag/(:any)'] = 'Front/contentTag';
$route['tag/(:any)/(:any)'] = 'Front/contentTag';
$route['articles/(:any)'] = 'Front/contentDetail';
$route['videos/(:any)'] = 'Front/contentDetailVideo';

$route['short'] = 'Front/shorturl';
$route['getshort'] = 'Front/shortUrlGenerate';
$route['r/(:any)'] = 'Front/redirShortUrl';


$route['get-update'] = 'Telegram/getUpdate';
$route['paste'] = 'Front/screnShootCapture';
$route['paste/(:any)'] = 'Front/showScrenShootCapture';
$route['showsecurepaste'] = 'Front/screnShootCapture';
$route['showsecurepaste/(:any)'] = 'Front/showSecureScrenShootCapture';
$route['sendpaste'] = 'Front/getScreenCapture';


// API's
$route['api'] = 'Api';
$route['api/contents'] = 'Api/getContents';
$route['api/content/(:num)'] = 'Api/getContentById';