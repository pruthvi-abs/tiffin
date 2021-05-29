<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/', function () { return view('welcome'); });

Route::get('/', 'HomeController@index')->name('index');
// 404 Page Start
//Route::get('/404','HomeController@notfound');
Route::get('pagenotfound', ['as' => 'notfound', 'uses' => 'HomeController@pagenotfound']);
// 404 Page END
// CMS Pages START
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/thankyou', 'HomeController@thankyou')->name('thankyou');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::post('/submitgetintouch', 'HomeController@submitgetintouch')->name('submitgetintouch');
Route::get('/termscondition', 'HomeController@termscondition')->name('termscondition');
Route::get('/disclaimer', 'HomeController@disclaimer')->name('disclaimer');
// CMS Pages END
// Product Menu START
Route::get('/letseat', 'HomeController@menu');
Route::get('/catering', 'HomeController@catering');
Route::get('/tiffin', 'HomeController@tiffin');
// Product Menu END
///// Cart Area /////////
Route::post('/addToCartajax','CartController@addToCartajax')->name('addToCartajax');
Route::post('/addToCateringajax','CartController@addToCateringajax')->name('addToCateringajax');
Route::post('/addToCart','CartController@addToCart')->name('addToCart');
Route::get('/viewcart','CartController@index');
Route::get('/cart/deleteItem/{id}','CartController@deleteItem');
Route::get('/cart/deleteItemajax/{id}','CartController@deleteItemajax');
Route::get('/cart/update-quantity/{id}/{quantity}','CartController@updateQuantity');
Route::get('/cart/update-quantityajax/{id}/{quantity}','CartController@updateQuantityajax');
/// Apply catering qty
Route::post('/apply-cateringqty','CartController@applycateringqty');
/// Apply Coupon Code
Route::post('/apply-coupon','CouponController@applycoupon');
///START Simple User Login /////
Route::get('/userlogin','UsersController@index');
Route::get('/userregister','UsersController@reg');
Route::post('/userregister','UsersController@register');
Route::post('/userlogin','UsersController@login');
Route::get('/userlogout','UsersController@logout');
///END Simple User Login /////
//START Social login
Route::get('/userlogin/{social}','Auth\LoginController@socialLogin')->where('social', 'twitter|facebook|linkedin|google|github');
Route::get('/userlogin/{social}/{callback}','Auth\LoginController@handleProviderCallback')->where('social', 'twitter|facebook|linkedin|google|github');
//END Social login

////// User Authentications ///////////
Route::group(['middleware'=>'FrontLogin_middleware'],function (){
Route::get('/userdashboard','UsersController@userdashboard');
Route::get('/myaccount','UsersController@account');
Route::put('/update-profile/{id}','UsersController@updateprofile');
Route::get('/userupdatepassword','UsersController@userupdatepassword');
Route::put('/update-password/{id}','UsersController@updatepassword');
Route::get('/myorder','UsersController@myorder');
Route::get('/myvieworder/{id}','UsersController@myvieworder');
Route::post('/myvieworderdatepdf', 'UsersController@myvieworderdatepdf')->name('myvieworderdatepdf');

Route::get('/mycancelorder/{id}','UsersController@mycancelorder');
});
///

Route::get('/check-out','CheckOutController@index');
//Route::post('/submit-checkout','CheckOutController@submitcheckout');
// Order checkout ( all users )
Route::get('/order-review','OrdersController@index');
Route::post('/submit-order','OrdersController@order');
Route::get('/cod','OrdersController@cod');
Route::get('/paypal','OrdersController@paypal');


Auth::routes();
Route::group(['middleware' => 'auth'], function(){
  //Route::get('/showuserprofile', function () {return 'Hello World';});
  Route::POST('/changePassword', 'Auth\LoginController@changePassword');
  Route::get('/showuserprofile','AdminUsersController@ShowUserProfile');
  Route::get('/edituserprofile/{id}','AdminUsersController@EditUserProfile')->name('edituserprofile');

  Route::resource('/order','OrderController');
  Route::get('getOrder', 'OrderController@getOrder')->name('getOrder');
  Route::post('orderreject/{id}', 'OrderController@orderreject')->name('orderreject');
  //Route::get('orderaccept/{id}', 'OrderController@orderaccept')->name('orderaccept');
  Route::post('orderpaid/{id}', 'OrderController@orderpaid')->name('orderpaid');
  Route::post('orderrefund/{id}', 'OrderController@orderrefund')->name('orderrefund');
  Route::post('orderpaidedit/{id}', 'OrderController@orderpaidedit')->name('orderpaidedit');
  Route::post('orderpaidadd', 'OrderController@orderpaidadd')->name('orderpaidadd');
  Route::post('orderpick/{id}', 'OrderController@orderpick')->name('orderpick');
  Route::post('order/datepdf', 'OrderController@datepdf')->name('order.datepdf');
  Route::post('order/sendmail', 'OrderController@sendmail')->name('order.sendmail');


  Route::post('backaddtiffinproduct', 'OrderController@backaddtiffinproduct')->name('backaddtiffinproduct');
  Route::post('backaddmenuproduct', 'OrderController@backaddmenuproduct')->name('backaddmenuproduct');
  Route::post('backaddcateringproduct', 'OrderController@backaddcateringproduct')->name('backaddcateringproduct');

  Route::post('deleteorderpayments/{id}', 'OrderController@deleteorderpayments')->name('deleteorderpayments');
  Route::post('deleteorderproduct/{id}', 'OrderController@deleteorderproduct')->name('deleteorderproduct');
  Route::post('editorderproduct/{id}', 'OrderController@editorderproduct')->name('editorderproduct');
  Route::post('editorderproductcatering', 'OrderController@editorderproductcatering')->name('editorderproductcatering');
  Route::post('refundorderpaid', 'OrderController@refundorderpaid')->name('refundorderpaid');

  Route::get('todayorder', 'OrderController@todayorder')->name('todayorder');
  Route::get('getTodayOrder', 'OrderController@getTodayOrder')->name('getTodayOrder');
  Route::get('tomorroworder', 'OrderController@tomorroworder')->name('tomorroworder');
  Route::get('getTomorrowOrder', 'OrderController@getTomorrowOrder')->name('getTomorrowOrder');
  Route::get('nextweekorder', 'OrderController@nextweekorder')->name('nextweekorder');
  Route::get('getNextWeekOrder', 'OrderController@getNextWeekOrder')->name('getNextWeekOrder');
  Route::get('nextmonthorder', 'OrderController@nextmonthorder')->name('nextmonthorder');
  Route::get('getNextmonthOrder', 'OrderController@getNextmonthOrder')->name('getNextmonthOrder');

  /*
  Route::resource('/report','ReportController');
  Route::get('getReport', 'ReportController@getReport')->name('getReport');
  */
  Route::post('report', 'ReportController@index')->name('report');
  Route::post('report/datepdf', 'ReportController@datepdf')->name('report.datepdf');
  Route::post('report/dateexcel', 'ReportController@dateexcel')->name('report.dateexcel');


  Route::resource('/category','CategoryController');
  Route::get('getCategory', 'CategoryController@getCategory')->name('getCategory');

  Route::resource('/product','ProductController');
  Route::get('getProduct', 'ProductController@getProduct')->name('getProduct');

  Route::get('productall', 'ProductController@productall')->name('productall');
  Route::get('getProductall', 'ProductController@getProductall')->name('getProductall');

  Route::get('producthide', 'ProductController@producthide')->name('producthide');
  Route::get('getProducthide', 'ProductController@getProducthide')->name('getProducthide');

  Route::post('productvisibility/{id}', 'ProductController@productvisibility')->name('productvisibility');
  Route::post('productisfeatured/{id}', 'ProductController@productisfeatured')->name('productisfeatured');

  Route::resource('/tiffinproduct','TiffinproductController');
  Route::get('getTiffinproduct', 'TiffinproductController@getTiffinproduct')->name('getTiffinproduct');
  Route::post('tiffinvisibility/{id}', 'TiffinproductController@tiffinvisibility')->name('tiffinvisibility');

  Route::resource('/cateringproduct','CateringproductController');
  Route::get('getCateringproduct', 'CateringproductController@getCateringproduct')->name('getCateringproduct');
  Route::post('cateringvisibility/{id}', 'CateringproductController@cateringvisibility')->name('cateringvisibility');

  Route::get('cateringproductall', 'CateringproductController@cateringproductall')->name('cateringproductall');
  Route::get('getCateringproductall', 'CateringproductController@getCateringproductall')->name('getCateringproductall');
  Route::get('cateringproducthide', 'CateringproductController@cateringproducthide')->name('cateringproducthide');
  Route::get('getCateringproducthide', 'CateringproductController@getCateringproducthide')->name('getCateringproducthide');

  Route::get('/getcateringdata', 'CounterdashboardController@getcateringdata')->name('getcateringdata');

  Route::get('/counterdashboard', 'CounterdashboardController@index');
  Route::get('/gettiffindata', 'CounterdashboardController@gettiffindata')->name('gettiffindata');
  Route::get('/getmenudata', 'CounterdashboardController@getmenudata')->name('getmenudata');
});

Route::group(['middleware' => 'admin'], function(){
  Route::get('/dashboard', 'DashboardController@index');

  Route::post('yearlydashboard', 'DashboardController@yearlydashboard')->name('yearlydashboard');

  Route::resource('/roles','RoleController');
  Route::get('getRoles', 'RoleController@getRoles')->name('getRoles');
  Route::resource('/country','CountryController');
  Route::get('getCountry', 'CountryController@getCountry')->name('getCountry');
  Route::resource('users', 'AdminUsersController');
  Route::get('getUsers', 'AdminUsersController@getUsers')->name('getUsers');
  Route::resource('frontusers', 'FrontUsersController');
  Route::get('getFrontusers', 'FrontUsersController@getFrontusers')->name('getFrontusers');
  //Route::get('/showuserprofile','AdminUsersController@ShowUserProfile');
  //Route::get('/edituserprofile/{id}','AdminUsersController@EditUserProfile')->name('edituserprofile');
  Route::get('/showconfig','ThemesettingController@ShowConfig')->name('showconfig');
  Route::get('/editconfig/{id}','ThemesettingController@EditConfig')->name('editconfig');
  Route::get('/testmail','ThemesettingController@Testmail')->name('testmail');
  Route::resource('/audit','AuditController');
  Route::get('getAudit', 'AuditController@getAudit')->name('getAudit');
  Route::resource('/maincategory','MaincategoryController');
  Route::get('getMaincategory', 'MaincategoryController@getMaincategory')->name('getMaincategory');



  Route::resource('/coupon','CouponController');
  Route::get('getCoupon', 'CouponController@getCoupon')->name('getCoupon');
  Route::resource('/frontslider','SliderController');
  Route::get('getFrontslider', 'SliderController@getFrontslider')->name('getFrontslider');

  //Route::get('delete-category/{id}','CategoryController@destroy');
  //Route::get('/check_category_name','CategoryController@checkCateName');
});

Route::group(['middleware' => 'salesuser'], function(){
  Route::get('/salesdashboard', 'CompanydashboardController@index');
});
Route::group(['middleware' => 'kitchenuser'], function(){
  Route::get('/kitchendashboard', 'KitchendashboardController@index');
});
Route::group(['middleware' => 'counteruser'], function(){
  /*
  Route::get('/counterdashboard', 'CounterdashboardController@index');
  Route::get('/gettiffindata', 'CounterdashboardController@gettiffindata')->name('gettiffindata');
  Route::get('/getmenudata', 'CounterdashboardController@getmenudata')->name('getmenudata');
  */
});
