<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/  
Route::group(['middleware' => 'AuthKey'], function () {
    Route::group(['middleware' => 'AdminAuth'], function () {
//--------------------------------------------------------------------------//
    /*        Start Admin View Controller         */
    Route::get('get_dashboard','Api\adminViewController@dashboard');
    Route::get('get_orders','Api\adminViewController@orders');
    Route::get('delievery_orders','Api\adminViewController@delieveryOrders');
    Route::get('category_search','Api\adminViewController@categorySearch');
    Route::get('word_search','Api\adminViewController@wordSearch');
    Route::get('get_users','Api\adminViewController@users');
    Route::get('get_providers','Api\adminViewController@providers');
    Route::get('get_partners','Api\adminViewController@partners');
    Route::get('get_documents','Api\adminViewController@documents');
    Route::get('get_services','Api\adminViewController@services');
    Route::get('get_subMain_filters','Api\adminViewController@subMain_filters');
    Route::get('get_categories','Api\adminViewController@categories');
    Route::get('get_promocodes','Api\adminViewController@promocodes');
    Route::get('get_settings','Api\adminViewController@settings');
    Route::get('get_provider/{id}','Api\adminViewController@getProvider'); 
    Route::get('get_main','Api\adminViewController@main');
    Route::get('get_payments','Api\adminViewController@payments');
    Route::get('get_wallet','Api\adminViewController@wallet');
    Route::get('get_payments_total','Api\adminViewController@payments_total');
    Route::get('get_sellers','Api\adminViewController@sellers');
    Route::get('select_sellers','Api\adminViewController@select_sellers');
    Route::get('get_managers','Api\adminViewController@managers');
    Route::get('get_uniqueID','Api\adminViewController@uniqueID');
    Route::get('get_rules','Api\adminViewController@rules');
    Route::get('get_advs','Api\adminViewController@ads');
    Route::get('get_offers','Api\adminViewController@offers');
    Route::get('get_offers_search','Api\adminViewController@offers_search');
    Route::get('get_profile','Api\adminViewController@profile');
    /*        End Admin View Controller         */
//--------------------------------------------------------------------------//
    /*          Start Admin Methods Controller         */  
    Route::get('logout_admin','Api\adminMethodsController@logout'); 
    Route::post('approve_manager','Api\adminMethodsController@approve_manager'); 
    Route::post('add_manager','Api\adminMethodsController@add_manager'); 
    Route::post('update_manager','Api\adminMethodsController@update_manager'); 
    Route::post('delete_manager','Api\adminMethodsController@delete_manager'); 
    Route::post('add_sellers_manager','Api\adminMethodsController@add_sellers_manager'); 
    Route::post('update_profile','Api\adminMethodsController@updateProfile'); 
    Route::post('update_image','Api\adminMethodsController@updateImage'); 
    Route::post('update_password','Api\adminMethodsController@updatePassword'); 
    Route::post('add_offer','Api\adminMethodsController@addOffer'); 
    Route::post('update_offer','Api\adminMethodsController@updateOffer'); 
    Route::post('update_offer_image','Api\adminMethodsController@updateOfferImage'); 
    Route::post('delete_offer','Api\adminMethodsController@deleteOffer'); 
    Route::post('add_ad','Api\adminMethodsController@addAd'); 
    Route::post('update_ad_image','Api\adminMethodsController@updateAdImage'); 
    Route::post('update_ad','Api\adminMethodsController@updateAd'); 
    Route::post('delete_ad','Api\adminMethodsController@deleteAd'); 
    Route::post('approve_provider','Api\adminMethodsController@approveProvider'); 
    Route::post('block_provider','Api\adminMethodsController@blockProvider'); 
    Route::post('update_provider_doc_expiry','Api\adminMethodsController@updateProviderDocExpiry');
    Route::post('delete_provider_document','Api\adminMethodsController@deleteProviderDocument'); 
    Route::post('update_provider_service','Api\adminMethodsController@updateProviderService'); 

    Route::post('add_document','Api\adminMethodsController@addDocument'); 
    Route::post('update_document','Api\adminMethodsController@updateDocument'); 
    Route::post('delete_document','Api\adminMethodsController@deleteDocument');
    Route::post('add_service','Api\adminMethodsController@addService'); 
    Route::post('update_service_image','Api\adminMethodsController@updateServiceImage'); 
    Route::post('update_service','Api\adminMethodsController@updateService'); 
    Route::post('delete_service','Api\adminMethodsController@deleteService'); 
    Route::post('add_setting','Api\adminMethodsController@addSetting');
    Route::post('update_setting','Api\adminMethodsController@updateSetting');
    // Route::post('add_promocode','Api\adminMethodsController@addPromocode');

    Route::post('delete_user','Api\adminMethodsController@deleteUser'); 
    Route::post('delete_markerter','Api\adminMethodsController@deleteMarkerter'); 
    Route::post('delete_provider','Api\adminMethodsController@deleteProvider'); 
    Route::post('add_category','Api\adminMethodsController@addCategory');
    Route::post('add_category_search','Api\adminMethodsController@addCategorySearch');
    Route::post('add_main','Api\adminMethodsController@addMain');
    Route::post('add_seller','Api\adminMethodsController@addSeller');
    // Route::get('get_sub_categories','Api\adminMethodsController@getSubCategories');
    Route::post('update_category','Api\adminMethodsController@updateCategory');
    Route::post('add_subCategory','Api\adminMethodsController@addSubCategory');
    Route::post('update_subCategory','Api\adminMethodsController@updateSubCategory');
    Route::post('delete_subCategory','Api\adminMethodsController@deleteSubCategory');
    // Route::post('update_category_search','Api\adminMethodsController@updateCategorySearch');
    Route::post('update_main','Api\adminMethodsController@updateMain');
    Route::post('delete_is_scheduled_main','Api\adminMethodsController@deleteIsScheduledMain');
    Route::post('update_main_icon','Api\adminMethodsController@updateMainIcon');
    Route::post('add_subMain','Api\adminMethodsController@addSubMain');
    Route::post('update_subMain','Api\adminMethodsController@updateSubMain');
    Route::post('delete_subMain','Api\adminMethodsController@deleteSubMain');
    Route::post('update_seller','Api\adminMethodsController@updateSeller');
    Route::post('update_seller_icon','Api\adminMethodsController@updateSellerIcon');
    // Route::post('update_seller_location','Api\adminMethodsController@updateSellerLocation');
    Route::post('delete_category','Api\adminMethodsController@deleteCategory');
    Route::post('delete_category_search','Api\adminMethodsController@deleteCategorySearch');
    Route::post('delete_main','Api\adminMethodsController@deleteMain');
    Route::post('delete_seller','Api\adminMethodsController@deleteSeller');
    Route::post('disable_main_product','Api\adminMethodsController@disableMainProduct');
    Route::post('disable_sellers_product','Api\adminMethodsController@disableSellersProduct');
    Route::post('delievery_us','Api\adminMethodsController@delieveryUs');
    Route::post('create_subMain_filters','Api\adminMethodsController@createSubMainFilters');
    Route::post('update_subMain_filters','Api\adminMethodsController@updateSubMainFilters');
    Route::post('update_subMain_filters_image','Api\adminMethodsController@updateSubMainFiltersImage');
    Route::post('add_subMain_filters_condition','Api\adminMethodsController@addSubMainFiltersCondition');
    Route::post('update_subMain_filters_condition','Api\adminMethodsController@updateSubMainFiltersCondition');
    Route::post('delete_subMain_filters_condition','Api\adminMethodsController@deleteSubMainFiltersCondition');
    Route::post('delete_subMain_filters','Api\adminMethodsController@deleteSubMainFilters');
    Route::post('payroll','Api\adminMethodsController@payroll');
    /*          End Admin Methods Controller         */ 
//--------------------------------------------------------------------------//
    });
    Route::group(['middleware' => 'SellerAuth'], function () {
//--------------------------------------------------------------------------//
    /*          Start Seller View Controller         */ 
    Route::get('/seller/get_profile','Api\sellerViewController@getProfile');
    Route::get('/seller/get_rates','Api\sellerViewController@getRates');
    Route::get('/seller/get_sub_sellers','Api\sellerViewController@getSubSellers');
    Route::get('/seller/get_categories','Api\sellerViewController@categories');
    Route::get('/seller/get_products','Api\sellerViewController@products');
    Route::get('/seller/search_for_bundle_products','Api\sellerViewController@searchForBundleProducts');
    Route::get('/seller/get_bundle_products','Api\sellerViewController@bundleProducts');
    Route::get('/seller/get_some_products','Api\sellerViewController@bundleSomeProducts');
    Route::get('/seller/get_dashboard','Api\sellerViewController@dashboard');
    Route::get('/seller/get_current_orders','Api\sellerViewController@currentOrders');
    Route::get('/seller/get_sales','Api\sellerViewController@sales');
    Route::get('/seller/get_wallet','Api\sellerViewController@wallet');
    Route::get('/seller/get_paystack_payments','Api\sellerViewController@paystackPayments');
    Route::get('/seller/view_order_details','Api\sellerViewController@viewOrderDetails');
    Route::get('/seller/view_provider_details','Api\sellerViewController@viewProviderDetails');
    Route::get('/seller/view_products_details','Api\sellerViewController@viewProductsDetails');
    Route::get('/seller/get_brands','Api\sellerViewController@getBrands'); 
    Route::get('/seller/get_subMain_filters_seller','Api\sellerViewController@subMain_filters');
    /*          End Seller View Controller         */ 
//--------------------------------------------------------------------------//    
    /*          Start Seller Methods Controller         */  
    Route::get('/seller/logout','Api\sellerMethodsController@logout'); 
    Route::post('/seller/subscribe_subMain_filters','Api\sellerMethodsController@subscribeSubMainFilters'); 
    Route::post('/seller/update_picture','Api\sellerMethodsController@updatePicture');
    Route::post('/seller/update_profile','Api\sellerMethodsController@updateProfile');
    Route::post('/seller/update_password','Api\sellerMethodsController@updatePassword');
    Route::post('/seller/busy_unbusy','Api\sellerMethodsController@busyUnbusy');
    Route::post('/seller/open_close','Api\sellerMethodsController@openClose');
    Route::post('/seller/add_discount','Api\sellerMethodsController@addDiscount');
    Route::post('/seller/update_order','Api\sellerMethodsController@updateOrder');
    Route::post('/seller/snooze_order','Api\sellerMethodsController@snoozeOrder');
    Route::post('/seller/cancel_order','Api\sellerMethodsController@cancelOrder');
    Route::post('/seller/call_driver','Api\sellerMethodsController@callDriver');
    Route::post('/seller/add_product','Api\sellerMethodsController@addProduct');
    Route::post('/seller/add_brand','Api\sellerMethodsController@addBrand');
    Route::post('/seller/update_brand','Api\sellerMethodsController@updateBrand');
    Route::post('/seller/delete_brand','Api\sellerMethodsController@deleteBrand');

    Route::post('/seller/update_product','Api\sellerMethodsController@updateProduct');
    Route::post('/seller/update_product_image','Api\sellerMethodsController@updateProductImage');//
    Route::post('/seller/update_product_images','Api\sellerMethodsController@updateProductImages');//
    Route::post('/seller/delete_product','Api\sellerMethodsController@deleteProduct');
    Route::post('/seller/change_product_stock','Api\sellerMethodsController@changeProductStock');

    Route::post('/seller/add_product_options','Api\sellerMethodsController@addProductOptions');
    Route::post('/seller/update_product_options','Api\sellerMethodsController@updateProductOptions');
    Route::post('/seller/delete_product_options','Api\sellerMethodsController@deleteProductOptions');

    Route::post('/seller/update_bundle_products','Api\sellerMethodsController@updateBundleProducts');

    Route::post('/seller/add_category','Api\adminMethodsController@addCategory');
    Route::post('/seller/update_category','Api\adminMethodsController@updateCategory');
    Route::post('/seller/add_subCategory','Api\adminMethodsController@addSubCategory');
    Route::post('/seller/update_subCategory','Api\adminMethodsController@updateSubCategory');
    Route::post('/seller/delete_subCategory','Api\adminMethodsController@deleteSubCategory');
    Route::post('/seller/delete_category','Api\adminMethodsController@deleteCategory');

    Route::post('/seller/add_sub_seller','Api\sellerMethodsController@addSubSeller');
    Route::post('/seller/change_sub_seller_password','Api\sellerMethodsController@changeSubSellerPassword');
    Route::post('/seller/delete_sub_seller','Api\sellerMethodsController@deleteSubSeller');
    /*        End Seller Methods Controller         */
//--------------------------------------------------------------------------//
    });
    Route::group(['middleware' => 'ManagerAuth'], function () {
//--------------------------------------------------------------------------//
    /*          Start Seller View Controller         */ 
    Route::get('/manager/get_profile','Api\managerController@getProfile');
    Route::get('/manager/get_rates','Api\sellerViewController@getRates');
    Route::get('/manager/get_sub_sellers','Api\sellerViewController@getSubSellers');
    Route::get('/manager/get_categories','Api\sellerViewController@categories');
    Route::get('/manager/get_products','Api\sellerViewController@products');
    Route::get('/manager/search_for_bundle_products','Api\sellerViewController@searchForBundleProducts');
    Route::get('/manager/get_bundle_products','Api\sellerViewController@bundleProducts');
    Route::get('/manager/get_some_products','Api\sellerViewController@bundleSomeProducts');
    Route::get('/manager/get_dashboard','Api\sellerViewController@dashboard');
    Route::get('/manager/get_current_orders','Api\sellerViewController@currentOrders');
    Route::get('/manager/get_sales','Api\sellerViewController@sales');
    Route::get('/manager/get_wallet','Api\sellerViewController@wallet');
    Route::get('/manager/get_paystack_payments','Api\sellerViewController@paystackPayments');
    Route::get('/manager/view_order_details','Api\sellerViewController@viewOrderDetails');
    Route::get('/manager/view_provider_details','Api\sellerViewController@viewProviderDetails');
    Route::get('/manager/view_products_details','Api\sellerViewController@viewProductsDetails');
    Route::get('/manager/get_brands','Api\sellerViewController@getBrands'); 
    Route::get('/manager/get_subMain_filters_seller','Api\sellerViewController@subMain_filters');
    /*          End Seller View Controller         */ 
//--------------------------------------------------------------------------//    
    /*          Start Seller Methods Controller         */  
    Route::get('/manager/logout','Api\sellerMethodsController@logout'); 
    Route::post('/manager/upload_contract','Api\managerController@upload_contract');
    Route::post('/manager/subscribe_subMain_filters','Api\sellerMethodsController@subscribeSubMainFilters'); 
    Route::post('/manager/update_picture','Api\sellerMethodsController@updatePicture');
    Route::post('/manager/update_profile','Api\sellerMethodsController@updateProfile');
    Route::post('/manager/update_password','Api\sellerMethodsController@updatePassword');
    Route::post('/manager/busy_unbusy','Api\sellerMethodsController@busyUnbusy');
    Route::post('/manager/open_close','Api\sellerMethodsController@openClose');
    Route::post('/manager/add_discount','Api\sellerMethodsController@addDiscount');
    Route::post('/manager/update_order','Api\sellerMethodsController@updateOrder');
    Route::post('/manager/snooze_order','Api\sellerMethodsController@snoozeOrder');
    Route::post('/manager/cancel_order','Api\sellerMethodsController@cancelOrder');
    Route::post('/manager/call_driver','Api\sellerMethodsController@callDriver');
    Route::post('/manager/add_product','Api\sellerMethodsController@addProduct');
    Route::post('/manager/add_brand','Api\sellerMethodsController@addBrand');
    Route::post('/manager/update_brand','Api\sellerMethodsController@updateBrand');
    Route::post('/manager/delete_brand','Api\sellerMethodsController@deleteBrand');

    Route::post('/manager/update_product','Api\sellerMethodsController@updateProduct');
    Route::post('/manager/update_product_image','Api\sellerMethodsController@updateProductImage');//
    Route::post('/manager/update_product_images','Api\sellerMethodsController@updateProductImages');//
    Route::post('/manager/delete_product','Api\sellerMethodsController@deleteProduct');
    Route::post('/manager/change_product_stock','Api\sellerMethodsController@changeProductStock');

    Route::post('/manager/add_product_options','Api\sellerMethodsController@addProductOptions');
    Route::post('/manager/update_product_options','Api\sellerMethodsController@updateProductOptions');
    Route::post('/manager/delete_product_options','Api\sellerMethodsController@deleteProductOptions');

    Route::post('/manager/update_bundle_products','Api\sellerMethodsController@updateBundleProducts');

    Route::post('/manager/add_category','Api\adminMethodsController@addCategory');
    Route::post('/manager/update_category','Api\adminMethodsController@updateCategory');
    Route::post('/manager/add_subCategory','Api\adminMethodsController@addSubCategory');
    Route::post('/manager/update_subCategory','Api\adminMethodsController@updateSubCategory');
    Route::post('/manager/delete_subCategory','Api\adminMethodsController@deleteSubCategory');
    Route::post('/manager/delete_category','Api\adminMethodsController@deleteCategory');

    Route::post('/manager/add_sub_seller','Api\sellerMethodsController@addSubSeller');
    Route::post('/manager/change_sub_seller_password','Api\sellerMethodsController@changeSubSellerPassword');
    Route::post('/manager/delete_sub_seller','Api\sellerMethodsController@deleteSubSeller');
    /*        End Seller Methods Controller         */
//--------------------------------------------------------------------------//
    });
    Route::group(['middleware' => 'SubSellerAuth'], function () {
        Route::get('get_sub_seller_profile','Api\sellerViewController@getSubSellerProfile');
        Route::get('get_current_orders_sub_seller','Api\sellerViewController@currentOrders');
        Route::get('view_provider_details_sub_seller','Api\sellerViewController@viewProviderDetails');

        Route::post('update_seller_order_sub_seller','Api\sellerMethodsController@updateOrder');
        Route::post('snooze_seller_order_sub_seller','Api\sellerMethodsController@snoozeOrder');
        Route::post('cancel_seller_order_sub_seller','Api\sellerMethodsController@cancelOrder');
        Route::post('call_driver_sub_seller','Api\sellerMethodsController@callDriver');
    });
    Route::post('login','Api\mainMethodsController@login');
    Route::post('register','Api\mainMethodsController@register');
    Route::get('get_modules','Api\adminViewController@modules');
    Route::get('get_cancel_reasons','Api\sellerViewController@getCancelReasons');

    Route::post('send_email','Api\mainMethodsController@send_email');
    Route::get('get_website','Api\mainMethodsController@get_website');
}); 
Route::get('connection','Api\mainMethodsController@connection');
Route::post('excel','Api\mainMethodsController@excel');