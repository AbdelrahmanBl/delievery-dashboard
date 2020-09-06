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

/*        Start Main View Controller         */
Route::get('','mainViewController@login');
Route::get('login','mainViewController@login');
Route::get('register','mainViewController@register');
Route::get('forgot','mainViewController@forgot');
/*        End Main View Controller          */ 

/*        Start Admin View Controller         */
Route::get('dashboard','adminViewController@dashboard');
Route::get('orders','adminViewController@orders');
Route::get('categories','adminViewController@categories');
Route::get('delieveryOrders','adminViewController@delieveryOrders');
Route::get('categorySearch','adminViewController@categorySearch');
Route::get('wordSearch','adminViewController@wordSearch');
Route::get('users','adminViewController@users');
Route::get('providers','adminViewController@providers');
Route::get('providers/{id}','adminViewController@getProvider');
Route::get('chats/{id}','adminViewController@chats');
Route::get('partners','adminViewController@partners');
Route::get('clients','adminViewController@clients');
Route::get('document','adminViewController@documents');
Route::get('services','adminViewController@services');
Route::get('promocodes','adminViewController@promocodes');
Route::get('payroll','adminViewController@payroll');
Route::get('settings','adminViewController@settings');
/*        End Admin View Controller         */

/*        Start Fleet View Controller         */
Route::get('dashboardF','fleetViewController@dashboard');
Route::get('ordersF','fleetViewController@orders');
Route::get('usersF','fleetViewController@users');
Route::get('providersF','fleetViewController@providers');
Route::get('partnersF','fleetViewController@partners');
Route::get('documentsF','fleetViewController@documents');
Route::get('servicesF','fleetViewController@services');
Route::get('promocodesF','fleetViewController@promocodes');
Route::get('payrollF','fleetViewController@payroll');
Route::get('settingsF','fleetViewController@settings');
/*        End Fleet View Controller         */

Route::get('logout','mainMethodsController@logout');
Route::view('/{id}','404');

/*        Start Main Methods Controller         */
Route::post('login','mainMethodsController@login');
Route::post('register','mainMethodsController@register');
Route::post('forgot','mainMethodsController@forgot');
/*        End Main Methods Controller          */ 

/*          Start Admin Methods Controller         */	
Route::post('addDoc','adminMethodsController@addDoc');
Route::post('deleteDoc','adminMethodsController@deleteDoc');
Route::post('addService','adminMethodsController@addService');
Route::post('deleteService','adminMethodsController@deleteService');
Route::post('addPromocode','adminMethodsController@addPromocode');
Route::post('deletePromocode','adminMethodsController@deletePromocode');
Route::post('addSetting','adminMethodsController@addSetting');
Route::post('deleteSetting','adminMethodsController@deleteSetting');
Route::post('deleteProviderDocument','adminMethodsController@deleteProviderDocument');
Route::post('changeSmartService','adminMethodsController@changeSmartService');
Route::post('updateService','adminMethodsController@updateService');
Route::post('blockProvider','adminMethodsController@blockProvider');
Route::post('updateExpiry','adminMethodsController@updateExpiry');
Route::post('loadWalletUser','adminMethodsController@loadWalletUser');
Route::post('loadWalletProvider','adminMethodsController@loadWalletProvider');
Route::post('loadWalletMarkerter','adminMethodsController@loadWalletMarkerter');
Route::post('updateMarkerterStatus','adminMethodsController@updateMarkerterStatus');
Route::post('approveProvider','adminMethodsController@approveProvider'); 
Route::post('resetService','adminMethodsController@resetService');
Route::post('updatePromocode','adminMethodsController@updatePromocode');
Route::post('showInvoice','adminMethodsController@showInvoice');
Route::post('addCategorySearch','adminMethodsController@addCategorySearch');
Route::post('deleteCategorySearch','adminMethodsController@deleteCategorySearch');
Route::post('addWordSearch','adminMethodsController@addWordSearch');
Route::post('deleteWordSearch','adminMethodsController@deleteWordSearch');
Route::post('addCategory','adminMethodsController@addCategory');
Route::post('addSubCategory','adminMethodsController@addSubCategory');
Route::post('getCategorySub','adminMethodsController@getCategorySub');
Route::post('XMLCategory','adminMethodsController@XMLCategory');
Route::post('XMLWord','adminMethodsController@XMLWord');
Route::post('loadOrderDetails','adminMethodsController@loadOrderDetails');
/*          End Admin Methods Controller         */	
 

