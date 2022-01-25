<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

   /* Auth::routes([
        'register' => false, // Registration Routes...
        'reset' => false, // Password Reset Routes...
        'verify' => false, // Email Verification Routes...
    ]);*/

Auth::routes();
    Route::get('/', function () {
        return view('home');
    })->middleware('auth')->name('start');



    //open for all logged in user
    Route::middleware('auth')->group(function (){
        Route::get('/home', 'HomeController@index')->name('home');
        Route::get('/home/profile', 'ProfileController@index')->name('home.profile');
        Route::get('/home/profile/change-password', 'ProfileController@changePassword')->name('home.profile.change-password');
        Route::post('/home/profile/update-password', 'ProfileController@updatePassword')->name('home.profile.update-password');

    });
    //open for all logged in user

    //administrative module
    Route::group(['as' => 'admin.','prefix' => 'admin','namespace' => 'Admin','middleware' => ['auth']] , function(){
        Route::post('unit/get-conv-setup','UnitController@unitConvSetupList')->name('unit.get-conv-setup');
        Route::post('unit/get-conv-rate','UnitController@conversionRate')->name('unit.get-conv-rate');
        Route::post('delivery-location/get-contact-list','DeliveryLocationController@contactPersonList')->name('delivery-location.get-contact-list');
     });

    Route::group(['as' => 'admin.','prefix' => 'admin','namespace' => 'Admin','middleware' => ['auth','administrator','restoreuser']] , function(){
        Route::get('historical-user','UserController@historicalUser')->name('historical-user');
    });


    Route::group(['as' => 'admin.','prefix' => 'admin','namespace' => 'Admin','middleware' => ['auth','administrator','createuser']] , function(){
        Route::post('user/save','UserController@saveUser')->name('user.save');
        Route::get('user/new','UserController@newUser')->name('user.new');
    });

    Route::group(['as' => 'admin.','prefix' => 'admin','namespace' => 'Admin','middleware' => ['auth','administrator','updateuser']] , function(){
        Route::post('user/update','UserController@updateUser')->name('user.update');
        Route::get('user/edit/{id}','UserController@editUser')->name('user.edit');
    });

    Route::group(['as' => 'admin.','prefix' => 'admin','namespace' => 'Admin','middleware' => ['auth','administrator','resetpassword']] , function(){
        Route::post('user/password/update','UserController@updatePassword')->name('user.password.update');
        Route::get('user/password/reset/{id}','UserController@resetPassword')->name('user.password.reset');
    });

    Route::group(['as' => 'admin.','prefix' => 'admin','namespace' => 'Admin','middleware' => ['auth','administrator']] , function(){
        //dashboard
        //Route::get('home','AdminController@index')->name('home');
        Route::delete('lpd/reset-po','BookingController@resetLPDPO')->name('lpd.reset-po');

        Route::get('user','UserController@index')->name('user');
        Route::get('user/detail/{id}','UserController@detail')->name('user.detail');

        Route::delete('user/delete','UserController@softDelete')->name('user.delete');
        Route::delete('user/restore','UserController@restore')->name('user.restore');
        Route::delete('user/remove','UserController@fullDelete')->name('user.remove');
        Route::delete('user/access/block','UserController@blockAccess')->name('user.access.block');
        Route::delete('user/access/provide','UserController@provideAccess')->name('user.access.provide');

        //Route::delete('full-delete-user','UserController@fullDelete')->name('full-delete-user');
        //Route::get('user/detail/{id}','UserController@detail')->name('user.detail');

        Route::delete('block-approval-access','UserController@blockApprovalAccess')->name('block-approval-access');
        Route::delete('user.provide-approval-access','UserController@provideApprovalAccess')->name('provide-approval-access');

        //user role management
        Route::post('user.apply-role', 'UserController@applyRole')->name('user.apply-role');

        //Route::get('user.apply-role/{role_id}/{user_id}', 'UserController@applyRole')->name('user.apply-role');
        //Route::get('user.delete-role/{role_id}/{user_id}', 'UserController@deleteRole')->name('user.delete-role');
        //user role management

        //role group
        Route::get('user/role','RoleController@index')->name('user.role');
        Route::post('user/role/save','RoleController@saveRole')->name('user.role.save');
        Route::post('user/role/edit','RoleController@updateRole')->name('user.role.edit');
        //role group

        //role task group
        Route::get('user/task','TaskController@index')->name('user.task');
        Route::post('user/task/save','TaskController@saveTask')->name('user.task.save');
        Route::post('user/task/edit','TaskController@updateTask')->name('user.task.edit');
        //role task group

        //delivery location setup
        Route::get('delivery-location','DeliveryLocationController@index')->name('delivery-location');
        Route::post('save-delivery-location','DeliveryLocationController@savefactory')->name('save-delivery-location');
        Route::post('edit-delivery-location','DeliveryLocationController@updatefactory')->name('edit-delivery-location');
        Route::delete('delete-delivery-location','DeliveryLocationController@deleteLocation')->name('delete-delivery-location');


        Route::get('delivery-location/detail/{id}','DeliveryLocationController@detail')->name('delivery-location.detail');
        Route::post('save-delivery-location-detail','DeliveryLocationController@saveDetail')->name('save-delivery-location-detail');
        Route::post('edit-delivery-location-detail','DeliveryLocationController@updateDetail')->name('edit-delivery-location-detail');
        //delivery location setup

        //department setup
        Route::get('department','DepartmentController@index')->name('department');
        Route::post('save-department','DepartmentController@saveDepartment')->name('save-department');
        Route::post('edit-department','DepartmentController@updateDepartment')->name('edit-department');
        //department setup

        //buyer setup
        Route::get('buyer','BuyerController@index')->name('buyer');
        Route::post('save-buyer','BuyerController@saveBuyer')->name('save-buyer');
        Route::post('edit-buyer','BuyerController@updateBuyer')->name('edit-buyer');
        Route::delete('delete-buyer','BuyerController@deleteBuyer')->name('delete-buyer');
        Route::delete('activate-buyer','BuyerController@activateBuyer')->name('activate-buyer');
        Route::delete('de-activate-buyer','BuyerController@deActivateBuyer')->name('de-activate-buyer');
        //buyer setup

        //store setup
        Route::get('store','StoreController@index')->name('store');
        Route::post('save-store','StoreController@saveStore')->name('save-store');
        Route::post('edit-store','StoreController@updateStore')->name('edit-store');
        Route::delete('delete-store','StoreController@deleteStore')->name('delete-store');
        Route::delete('activate-store','StoreController@activateStore')->name('activate-store');
        Route::delete('de-activate-store','StoreController@deActivateStore')->name('de-activate-store');
        //store setup

        //supplier setupSub
        Route::get('supplier','SupplierController@index')->name('supplier');
        Route::post('save-supplier','SupplierController@saveSupplier')->name('save-supplier');
        Route::post('edit-supplier','SupplierController@updateSupplier')->name('edit-supplier');
        Route::delete('activate-supplier','SupplierController@activate')->name('activate-supplier');
        Route::delete('in-activate-supplier','SupplierController@inActivate')->name('in-activate-supplier');
        Route::delete('black-list-supplier','SupplierController@blackList')->name('black-list-supplier');
        Route::delete('delete-supplier','SupplierController@fullDelete')->name('delete-supplier');
        Route::post('apply-supplier-group-access','SupplierController@applyGroupAccess')->name('apply-supplier-group-access');
        //supplier setup


        //unit setup
        Route::get('unit','UnitController@index')->name('unit');
        Route::get('unit-detail/{id}','UnitController@detail')->name('unit-detail');
        Route::post('save-unit','UnitController@saveUnit')->name('save-unit');
        Route::post('save-unit-conversion','UnitController@saveUnitConversion')->name('save-unit-conversion');
        Route::post('edit-unit-conversion','UnitController@editConversionRate')->name('edit-unit-conversion');
        Route::post('edit-unit','UnitController@updateUnit')->name('edit-unit');
        Route::delete('delete-unit','UnitController@fullDelete')->name('delete-unit');
        //unit setup

        //product group setup
        Route::get('product-group','ProductGroupController@index')->name('product-group');
        Route::post('product-group/save','ProductGroupController@saveGroup')->name('product-group.save');
        Route::post('product-group/edit','ProductGroupController@updateGroup')->name('product-group.edit');
        //Route::delete('delete-buyer','ProductGroupController@deleteBuyer')->name('delete-buyer');
        //Route::delete('activate-buyer','ProductGroupController@activateBuyer')->name('activate-buyer');
        //Route::delete('de-activate-buyer','ProductGroupController@deActivateBuyer')->name('de-activate-buyer');
        //buyer setup

        //currency setup
        Route::get('currency','CurrencyController@index')->name('currency');
        Route::post('currency/save','CurrencyController@saveCurrency')->name('currency.save');
        Route::post('currency/edit','CurrencyController@updateCurrency')->name('currency.edit');
        //currency setup
    });
    //administrative module

    //cartoon & board
    Route::group(['as' => 'cartoon.','prefix' => 'cartoon','namespace' => 'Cartoon','middleware' => ['auth','cartoon']] , function(){
        //booking
        Route::get('booking/recent','BookingController@recent')->name('booking.recent');
        Route::get('booking/active','BookingController@active')->name('booking.active');
        Route::get('booking/delivery-complete','BookingController@deliveryComplete')->name('booking.delivery-complete');
        Route::get('booking/search','BookingController@search')->name('booking.search');
        Route::post('booking/search-booking','BookingController@searchBooking')->name('booking.search-booking');
        Route::get('booking/report','BookingController@report')->name('booking.report');
        Route::post('booking/report-result','BookingController@reportResult')->name('booking.report-result');
        Route::get('booking/detail/{id}','BookingController@detail')->name('booking.detail');

        Route::get('booking/detail/pdf/{id}','BookingController@pdf')->name('booking.detail.pdf');
        Route::post('booking/detail/save','BookingController@saveDetail')->name('booking.detail.save');
        Route::delete('booking/detail/delete','BookingController@deleteDetail')->name('booking.detail.delete');
        Route::delete('booking/delete','BookingController@delete')->name('booking.delete');
        Route::delete('booking/urgent','BookingController@makeUrgent')->name('booking.urgent');
        Route::delete('booking/revise','BookingController@makeRevise')->name('booking.revise');
        Route::delete('booking/return-active','BookingController@returnActive')->name('booking.return-active');
        //booking

        //product setup
        Route::get('product','ProductSetupController@index')->name('product');
        Route::post('product/save','ProductSetupController@saveProduct')->name('product.save');
        Route::post('product/edit','ProductSetupController@updateProduct')->name('product.edit');
        Route::post('product/delete','ProductSetupController@deleteProduct')->name('product.delete');
        Route::get('product/detail/{id}','ProductSetupController@detail')->name('product.detail');
        Route::post('product/save-price-setup','ProductSetupController@savePriceSetup')->name('product.save-price-setup');
        Route::post('product/get-price','ProductSetupController@getPriceSetup')->name('product.get-price');
        Route::post('product/get-measurement-detail-list','ProductSetupController@getMeasurementDetailList')->name('product.get-measurement-detail-list');
        //product setup
    });
    Route::group(['as' => 'cartoon.','prefix' => 'cartoon','namespace' => 'Cartoon','middleware' => ['auth','cartoon', 'createcb']] , function(){
        //booking
        Route::get('booking/new','BookingController@newBooking')->name('booking.new');
        Route::post('booking/save','BookingController@saveBooking')->name('booking.save');
        //booking
    });
    Route::group(['as' => 'cartoon.','prefix' => 'cartoon','namespace' => 'Cartoon','middleware' => ['auth','cartoon', 'updatecbmaster']] , function(){
    //booking
    Route::get('booking/edit/{id}','BookingController@edit')->name('booking.edit');
    Route::post('booking/update','BookingController@updateBooking')->name('booking.update');
    //booking
});
    //cartoon & board

    //Elastic
    Route::group(['as' => 'elastic.','prefix' => 'elastic','namespace' => 'Elastic','middleware' => ['auth','elastic']] , function(){
        //booking
        Route::get('booking/recent','BookingController@recent')->name('booking.recent');
        Route::get('booking/active','BookingController@active')->name('booking.active');
        Route::get('booking/delivery-complete','BookingController@deliveryComplete')->name('booking.delivery-complete');
        Route::get('booking/search','BookingController@search')->name('booking.search');
        Route::post('booking/search-booking','BookingController@searchBooking')->name('booking.search-booking');
        Route::get('booking/report','BookingController@report')->name('booking.report');
        Route::post('booking/report-result','BookingController@reportResult')->name('booking.report-result');
        Route::get('booking/detail/{id}','BookingController@detail')->name('booking.detail');

        Route::get('booking/detail/pdf/{id}','BookingController@pdf')->name('booking.detail.pdf');
        Route::post('booking/detail/save','BookingController@saveDetail')->name('booking.detail.save');
        Route::delete('booking/detail/delete','BookingController@deleteDetail')->name('booking.detail.delete');
        Route::delete('booking/delete','BookingController@delete')->name('booking.delete');
        Route::delete('booking/urgent','BookingController@makeUrgent')->name('booking.urgent');
        Route::delete('booking/revise','BookingController@makeRevise')->name('booking.revise');
        Route::delete('booking/return-active','BookingController@returnActive')->name('booking.return-active');
        //booking

        //product setup
        Route::get('product','ProductSetupController@index')->name('product');
        Route::post('product/save','ProductSetupController@saveProduct')->name('product.save');
        Route::post('product/edit','ProductSetupController@updateProduct')->name('product.edit');
        Route::post('product/delete','ProductSetupController@deleteProduct')->name('product.delete');
        Route::get('product/detail/{id}','ProductSetupController@detail')->name('product.detail');
        Route::post('product/save-price-setup','ProductSetupController@savePriceSetup')->name('product.save-price-setup');
        Route::post('product/get-price','ProductSetupController@getPriceSetup')->name('product.get-price');
        //product setup
    });
    Route::group(['as' => 'elastic.','prefix' => 'elastic','namespace' => 'Elastic','middleware' => ['auth','elastic','createe']] , function(){
        //booking
        Route::get('booking/new','BookingController@newBooking')->name('booking.new');
        Route::post('booking/save','BookingController@saveBooking')->name('booking.save');
        //booking
    });
    Route::group(['as' => 'elastic.','prefix' => 'elastic','namespace' => 'Elastic','middleware' => ['auth','elastic', 'updateemaster']] , function(){
        //booking
        Route::get('booking/edit/{id}','BookingController@edit')->name('booking.edit');
        Route::post('booking/update','BookingController@updateBooking')->name('booking.update');
        //booking
    });
    //Elastic

    //Fabric
    Route::group(['as' => 'fabric.','prefix' => 'fabric','namespace' => 'Fabric','middleware' => ['auth','fabric']] , function(){
        //booking
        Route::get('booking/recent','BookingController@recent')->name('booking.recent');
        Route::get('booking/active','BookingController@active')->name('booking.active');
        Route::get('booking/delivery-complete','BookingController@deliveryComplete')->name('booking.delivery-complete');
        Route::get('booking/search','BookingController@search')->name('booking.search');
        Route::post('booking/search-booking','BookingController@searchBooking')->name('booking.search-booking');
        Route::get('booking/report','BookingController@report')->name('booking.report');
        Route::post('booking/report-result','BookingController@reportResult')->name('booking.report-result');
        Route::get('booking/detail/{id}','BookingController@detail')->name('booking.detail');

        Route::get('booking/detail/pdf/{id}','BookingController@pdf')->name('booking.detail.pdf');
        Route::post('booking/detail/save','BookingController@saveDetail')->name('booking.detail.save');
        Route::delete('booking/detail/delete','BookingController@deleteDetail')->name('booking.detail.delete');
        Route::delete('booking/delete','BookingController@delete')->name('booking.delete');
        Route::delete('booking/urgent','BookingController@makeUrgent')->name('booking.urgent');
        Route::delete('booking/revise','BookingController@makeRevise')->name('booking.revise');
        Route::delete('booking/return-active','BookingController@returnActive')->name('booking.return-active');
        //booking

        //product setup
        Route::get('product','ProductSetupController@index')->name('product');
        Route::post('product/save','ProductSetupController@saveProduct')->name('product.save');
        Route::post('product/edit','ProductSetupController@updateProduct')->name('product.edit');
        Route::post('product/delete','ProductSetupController@deleteProduct')->name('product.delete');
        Route::get('product/detail/{id}','ProductSetupController@detail')->name('product.detail');
        Route::post('product/save-price-setup','ProductSetupController@savePriceSetup')->name('product.save-price-setup');
        Route::post('product/get-price','ProductSetupController@getPriceSetup')->name('product.get-price');
        //product setup
    });
    Route::group(['as' => 'fabric.','prefix' => 'fabric','namespace' => 'Fabric','middleware' => ['auth','fabric','createf']] , function(){
        //booking
        Route::get('booking/new','BookingController@newBooking')->name('booking.new');
        Route::post('booking/save','BookingController@saveBooking')->name('booking.save');
        //booking
    });
    Route::group(['as' => 'fabric.','prefix' => 'fabric','namespace' => 'Fabric','middleware' => ['auth','fabric', 'updatefmaster']] , function(){
        //booking
        Route::get('booking/edit/{id}','BookingController@edit')->name('booking.edit');
        Route::post('booking/update','BookingController@updateBooking')->name('booking.update');
        //booking
    });
    //Fabric

    //Tissue
    Route::group(['as' => 'tissue.','prefix' => 'tissue','namespace' => 'Tissue','middleware' => ['auth','tissue']] , function(){
        //booking
        Route::get('booking/recent','BookingController@recent')->name('booking.recent');
        Route::get('booking/active','BookingController@active')->name('booking.active');
        Route::get('booking/delivery-complete','BookingController@deliveryComplete')->name('booking.delivery-complete');
        Route::get('booking/search','BookingController@search')->name('booking.search');
        Route::post('booking/search-booking','BookingController@searchBooking')->name('booking.search-booking');
        Route::get('booking/report','BookingController@report')->name('booking.report');
        Route::post('booking/report-result','BookingController@reportResult')->name('booking.report-result');
        Route::get('booking/detail/{id}','BookingController@detail')->name('booking.detail');

        Route::get('booking/detail/pdf/{id}','BookingController@pdf')->name('booking.detail.pdf');
        Route::post('booking/detail/save','BookingController@saveDetail')->name('booking.detail.save');
        Route::delete('booking/detail/delete','BookingController@deleteDetail')->name('booking.detail.delete');
        Route::delete('booking/delete','BookingController@delete')->name('booking.delete');
        Route::delete('booking/urgent','BookingController@makeUrgent')->name('booking.urgent');
        Route::delete('booking/revise','BookingController@makeRevise')->name('booking.revise');
        Route::delete('booking/return-active','BookingController@returnActive')->name('booking.return-active');
        //booking

        //product setup
        Route::get('product','ProductSetupController@index')->name('product');
        Route::post('product/save','ProductSetupController@saveProduct')->name('product.save');
        Route::post('product/edit','ProductSetupController@updateProduct')->name('product.edit');
        Route::post('product/delete','ProductSetupController@deleteProduct')->name('product.delete');
        Route::get('product/detail/{id}','ProductSetupController@detail')->name('product.detail');
        Route::post('product/save-price-setup','ProductSetupController@savePriceSetup')->name('product.save-price-setup');
        Route::post('product/get-price','ProductSetupController@getPriceSetup')->name('product.get-price');
        //product setup
    });
    Route::group(['as' => 'tissue.','prefix' => 'tissue','namespace' => 'Tissue','middleware' => ['auth','tissue','createt']] , function(){
        //booking
        Route::get('booking/new','BookingController@newBooking')->name('booking.new');
        Route::post('booking/save','BookingController@saveBooking')->name('booking.save');
        //booking
    });
    Route::group(['as' => 'tissue.','prefix' => 'tissue','namespace' => 'Tissue','middleware' => ['auth','tissue', 'updatetmaster']] , function(){
        //booking
        Route::get('booking/edit/{id}','BookingController@edit')->name('booking.edit');
        Route::post('booking/update','BookingController@updateBooking')->name('booking.update');
        //booking
    });
    //Tissue

    //Interlining
    Route::group(['as' => 'interlining.','prefix' => 'interlining','namespace' => 'Interlining','middleware' => ['auth','interlining']] , function(){
        //booking
        Route::get('booking/recent','BookingController@recent')->name('booking.recent');
        Route::get('booking/active','BookingController@active')->name('booking.active');
        Route::get('booking/delivery-complete','BookingController@deliveryComplete')->name('booking.delivery-complete');
        Route::get('booking/search','BookingController@search')->name('booking.search');
        Route::post('booking/search-booking','BookingController@searchBooking')->name('booking.search-booking');
        Route::get('booking/report','BookingController@report')->name('booking.report');
        Route::post('booking/report-result','BookingController@reportResult')->name('booking.report-result');
        Route::get('booking/detail/{id}','BookingController@detail')->name('booking.detail');

        Route::get('booking/detail/pdf/{id}','BookingController@pdf')->name('booking.detail.pdf');
        Route::post('booking/detail/save','BookingController@saveDetail')->name('booking.detail.save');
        Route::delete('booking/detail/delete','BookingController@deleteDetail')->name('booking.detail.delete');
        Route::delete('booking/delete','BookingController@delete')->name('booking.delete');
        Route::delete('booking/urgent','BookingController@makeUrgent')->name('booking.urgent');
        Route::delete('booking/revise','BookingController@makeRevise')->name('booking.revise');
        Route::delete('booking/return-active','BookingController@returnActive')->name('booking.return-active');
        //booking

        //product setup
        Route::get('product','ProductSetupController@index')->name('product');
        Route::post('product/save','ProductSetupController@saveProduct')->name('product.save');
        Route::post('product/edit','ProductSetupController@updateProduct')->name('product.edit');
        Route::post('product/delete','ProductSetupController@deleteProduct')->name('product.delete');
        Route::get('product/detail/{id}','ProductSetupController@detail')->name('product.detail');
        Route::post('product/save-price-setup','ProductSetupController@savePriceSetup')->name('product.save-price-setup');
        Route::post('product/edit-price-setup','ProductSetupController@updateProductPriceSetup')->name('product.edit-price-setup');
        Route::delete('product/delete-price-setup','ProductSetupController@deleteProductPriceSetup')->name('product.delete-price-setup');
        Route::post('product/get-article-list','ProductSetupController@getArticleList')->name('product.get-article-list');
        Route::post('product/get-price','ProductSetupController@getPriceSetup')->name('product.get-price');
        //product setup
    });
    Route::group(['as' => 'interlining.','prefix' => 'interlining','namespace' => 'Interlining','middleware' => ['auth','interlining','createi']] , function(){
        //booking
        Route::get('booking/new','BookingController@newBooking')->name('booking.new');
        Route::post('booking/save','BookingController@saveBooking')->name('booking.save');
        //booking
    });
    Route::group(['as' => 'interlining.','prefix' => 'interlining','namespace' => 'Interlining','middleware' => ['auth','interlining', 'updateimaster']] , function(){
        //booking
        Route::get('booking/edit/{id}','BookingController@edit')->name('booking.edit');
        Route::post('booking/update','BookingController@updateBooking')->name('booking.update');
        //booking
    });

    //Interlining

    //qc sticker
    Route::group(['as' => 'qcsticker.','prefix' => 'qcsticker','namespace' => 'QCSticker','middleware' => ['auth','qcsticker']] , function(){
        //booking
        Route::get('booking/recent','BookingController@recent')->name('booking.recent');
        Route::get('booking/active','BookingController@active')->name('booking.active');
        Route::get('booking/delivery-complete','BookingController@deliveryComplete')->name('booking.delivery-complete');
        Route::get('booking/search','BookingController@search')->name('booking.search');
        Route::post('booking/search-booking','BookingController@searchBooking')->name('booking.search-booking');
        Route::get('booking/report','BookingController@report')->name('booking.report');
        Route::post('booking/report-result','BookingController@reportResult')->name('booking.report-result');
        Route::get('booking/detail/{id}','BookingController@detail')->name('booking.detail');

        Route::get('booking/detail/pdf/{id}','BookingController@pdf')->name('booking.detail.pdf');
        Route::post('booking/detail/save','BookingController@saveDetail')->name('booking.detail.save');
        Route::delete('booking/detail/delete','BookingController@deleteDetail')->name('booking.detail.delete');
        Route::delete('booking/delete','BookingController@delete')->name('booking.delete');
        Route::delete('booking/urgent','BookingController@makeUrgent')->name('booking.urgent');
        Route::delete('booking/revise','BookingController@makeRevise')->name('booking.revise');
        Route::delete('booking/return-active','BookingController@returnActive')->name('booking.return-active');
        //booking

        //product setup
        Route::get('product','ProductSetupController@index')->name('product');
        Route::post('product/save','ProductSetupController@saveProduct')->name('product.save');
        Route::post('product/edit','ProductSetupController@updateProduct')->name('product.edit');
        Route::post('product/delete','ProductSetupController@deleteProduct')->name('product.delete');
        Route::get('product/detail/{id}','ProductSetupController@detail')->name('product.detail');
        Route::post('product/save-price-setup','ProductSetupController@savePriceSetup')->name('product.save-price-setup');
        Route::post('product/edit-price-setup','ProductSetupController@updateProductPriceSetup')->name('product.edit-price-setup');
        Route::delete('product/delete-price-setup','ProductSetupController@deleteProductPriceSetup')->name('product.delete-price-setup');
        Route::post('product/get-article-list','ProductSetupController@getArticleList')->name('product.get-article-list');
        Route::post('product/get-price','ProductSetupController@getPriceSetup')->name('product.get-price');
        //product setup
    });
    Route::group(['as' => 'qcsticker.','prefix' => 'qcsticker','namespace' => 'QCSticker','middleware' => ['auth','qcsticker','createqcs']] , function(){
        //booking
        Route::get('booking/new','BookingController@newBooking')->name('booking.new');
        Route::post('booking/save','BookingController@saveBooking')->name('booking.save');
        //booking
    });
    Route::group(['as' => 'qcsticker.','prefix' => 'qcsticker','namespace' => 'QCSticker','middleware' => ['auth','qcsticker', 'updateqcsmaster']] , function(){
        //booking
        Route::get('booking/edit/{id}','BookingController@edit')->name('booking.edit');
        Route::post('booking/update','BookingController@updateBooking')->name('booking.update');
        //booking
    });

    //qc sticker

    //arrow sticker
    Route::group(['as' => 'asticker.','prefix' => 'asticker','namespace' => 'ArrowSticker','middleware' => ['auth','arrowsticker']] , function(){
        //booking
        Route::get('booking/recent','BookingController@recent')->name('booking.recent');
        Route::get('booking/active','BookingController@active')->name('booking.active');
        Route::get('booking/delivery-complete','BookingController@deliveryComplete')->name('booking.delivery-complete');
        Route::get('booking/search','BookingController@search')->name('booking.search');
        Route::post('booking/search-booking','BookingController@searchBooking')->name('booking.search-booking');
        Route::get('booking/report','BookingController@report')->name('booking.report');
        Route::post('booking/report-result','BookingController@reportResult')->name('booking.report-result');
        Route::get('booking/detail/{id}','BookingController@detail')->name('booking.detail');

        Route::get('booking/detail/pdf/{id}','BookingController@pdf')->name('booking.detail.pdf');
        Route::post('booking/detail/save','BookingController@saveDetail')->name('booking.detail.save');
        Route::delete('booking/detail/delete','BookingController@deleteDetail')->name('booking.detail.delete');
        Route::delete('booking/delete','BookingController@delete')->name('booking.delete');
        Route::delete('booking/urgent','BookingController@makeUrgent')->name('booking.urgent');
        Route::delete('booking/revise','BookingController@makeRevise')->name('booking.revise');
        Route::delete('booking/return-active','BookingController@returnActive')->name('booking.return-active');
        //booking

        //product setup
        Route::get('product','ProductSetupController@index')->name('product');
        Route::post('product/save','ProductSetupController@saveProduct')->name('product.save');
        Route::post('product/edit','ProductSetupController@updateProduct')->name('product.edit');
        Route::post('product/delete','ProductSetupController@deleteProduct')->name('product.delete');
        Route::get('product/detail/{id}','ProductSetupController@detail')->name('product.detail');
        Route::post('product/save-price-setup','ProductSetupController@savePriceSetup')->name('product.save-price-setup');
        Route::post('product/edit-price-setup','ProductSetupController@updateProductPriceSetup')->name('product.edit-price-setup');
        Route::delete('product/delete-price-setup','ProductSetupController@deleteProductPriceSetup')->name('product.delete-price-setup');
        Route::post('product/get-article-list','ProductSetupController@getArticleList')->name('product.get-article-list');
        Route::post('product/get-price','ProductSetupController@getPriceSetup')->name('product.get-price');
        //product setup
    });
    Route::group(['as' => 'asticker.','prefix' => 'asticker','namespace' => 'ArrowSticker','middleware' => ['auth','arrowsticker','createas']] , function(){
        //booking
        Route::get('booking/new','BookingController@newBooking')->name('booking.new');
        Route::post('booking/save','BookingController@saveBooking')->name('booking.save');
        //booking
    });
    Route::group(['as' => 'asticker.','prefix' => 'asticker','namespace' => 'ArrowSticker','middleware' => ['auth','arrowsticker', 'updateasmaster']] , function(){
        //booking
        Route::get('booking/edit/{id}','BookingController@edit')->name('booking.edit');
        Route::post('booking/update','BookingController@updateBooking')->name('booking.update');
        //booking
    });
    //arrow sticker

    //gum tape
    Route::group(['as' => 'gumtape.','prefix' => 'gumtape','namespace' => 'GumTape','middleware' => ['auth','gumtape']] , function(){
        //booking
        Route::get('booking/recent','BookingController@recent')->name('booking.recent');
        Route::get('booking/active','BookingController@active')->name('booking.active');
        Route::get('booking/delivery-complete','BookingController@deliveryComplete')->name('booking.delivery-complete');
        Route::get('booking/search','BookingController@search')->name('booking.search');
        Route::post('booking/search-booking','BookingController@searchBooking')->name('booking.search-booking');
        Route::get('booking/report','BookingController@report')->name('booking.report');
        Route::post('booking/report-result','BookingController@reportResult')->name('booking.report-result');
        Route::get('booking/detail/{id}','BookingController@detail')->name('booking.detail');

        Route::get('booking/detail/pdf/{id}','BookingController@pdf')->name('booking.detail.pdf');
        Route::post('booking/detail/save','BookingController@saveDetail')->name('booking.detail.save');
        Route::delete('booking/detail/delete','BookingController@deleteDetail')->name('booking.detail.delete');
        Route::delete('booking/delete','BookingController@delete')->name('booking.delete');
        Route::delete('booking/urgent','BookingController@makeUrgent')->name('booking.urgent');
        Route::delete('booking/revise','BookingController@makeRevise')->name('booking.revise');
        Route::delete('booking/return-active','BookingController@returnActive')->name('booking.return-active');
        //booking

        //product setup
        Route::get('product','ProductSetupController@index')->name('product');
        Route::post('product/save','ProductSetupController@saveProduct')->name('product.save');
        Route::post('product/edit','ProductSetupController@updateProduct')->name('product.edit');
        Route::post('product/delete','ProductSetupController@deleteProduct')->name('product.delete');
        Route::get('product/detail/{id}','ProductSetupController@detail')->name('product.detail');
        Route::post('product/save-price-setup','ProductSetupController@savePriceSetup')->name('product.save-price-setup');
        Route::post('product/edit-price-setup','ProductSetupController@updateProductPriceSetup')->name('product.edit-price-setup');
        Route::delete('product/delete-price-setup','ProductSetupController@deleteProductPriceSetup')->name('product.delete-price-setup');
        Route::post('product/get-article-list','ProductSetupController@getArticleList')->name('product.get-article-list');
        Route::post('product/get-price','ProductSetupController@getPriceSetup')->name('product.get-price');
        //product setup
    });
    Route::group(['as' => 'gumtape.','prefix' => 'gumtape','namespace' => 'GumTape','middleware' => ['auth','gumtape','creategt']] , function(){
        //booking
        Route::get('booking/new','BookingController@newBooking')->name('booking.new');
        Route::post('booking/save','BookingController@saveBooking')->name('booking.save');
        //booking
    });
    Route::group(['as' => 'gumtape.','prefix' => 'gumtape','namespace' => 'GumTape','middleware' => ['auth','gumtape', 'updategtmaster']] , function(){
        //booking
        Route::get('booking/edit/{id}','BookingController@edit')->name('booking.edit');
        Route::post('booking/update','BookingController@updateBooking')->name('booking.update');
        //booking
    });

    //gum tape

    //thread
    Route::group(['as' => 'thread.','prefix' => 'thread','namespace' => 'Thread','middleware' => ['auth','thread']] , function(){
        //booking
        Route::get('booking/recent','BookingController@recent')->name('booking.recent');
        Route::get('booking/active','BookingController@active')->name('booking.active');
        Route::get('booking/delivery-complete','BookingController@deliveryComplete')->name('booking.delivery-complete');
        Route::get('booking/search','BookingController@search')->name('booking.search');
        Route::post('booking/search-booking','BookingController@searchBooking')->name('booking.search-booking');
        Route::get('booking/report','BookingController@report')->name('booking.report');
        Route::post('booking/report-result','BookingController@reportResult')->name('booking.report-result');
        Route::get('booking/detail/{id}','BookingController@detail')->name('booking.detail');

        Route::get('booking/detail/pdf/{id}','BookingController@pdf')->name('booking.detail.pdf');
        Route::post('booking/detail/save','BookingController@saveDetail')->name('booking.detail.save');
        Route::delete('booking/detail/delete','BookingController@deleteDetail')->name('booking.detail.delete');
        Route::delete('booking/delete','BookingController@delete')->name('booking.delete');
        Route::delete('booking/urgent','BookingController@makeUrgent')->name('booking.urgent');
        Route::delete('booking/revise','BookingController@makeRevise')->name('booking.revise');
        Route::delete('booking/return-active','BookingController@returnActive')->name('booking.return-active');
        //booking

        //product setup
        Route::get('product','ProductSetupController@index')->name('product');
        Route::post('product/save','ProductSetupController@saveProduct')->name('product.save');
        Route::post('product/edit','ProductSetupController@updateProduct')->name('product.edit');
        Route::post('product/delete','ProductSetupController@deleteProduct')->name('product.delete');
        Route::get('product/detail/{id}','ProductSetupController@detail')->name('product.detail');
        Route::post('product/save-price-setup','ProductSetupController@savePriceSetup')->name('product.save-price-setup');
        Route::post('product/edit-price-setup','ProductSetupController@updateProductPriceSetup')->name('product.edit-price-setup');
        Route::delete('product/delete-price-setup','ProductSetupController@deleteProductPriceSetup')->name('product.delete-price-setup');
        Route::post('product/get-article-list','ProductSetupController@getArticleList')->name('product.get-article-list');
        Route::post('product/get-price','ProductSetupController@getPriceSetup')->name('product.get-price');
        //product setup
    });
    Route::group(['as' => 'thread.','prefix' => 'thread','namespace' => 'Thread','middleware' => ['auth','thread','createtd']] , function(){
        //booking
        Route::get('booking/new','BookingController@newBooking')->name('booking.new');
        Route::post('booking/save','BookingController@saveBooking')->name('booking.save');
        //booking
    });
    Route::group(['as' => 'thread.','prefix' => 'thread','namespace' => 'Thread','middleware' => ['auth','thread', 'updatetdmaster']] , function(){
        //booking
        Route::get('booking/edit/{id}','BookingController@edit')->name('booking.edit');
        Route::post('booking/update','BookingController@updateBooking')->name('booking.update');
        //booking
    });

    //thread

    //poly
    Route::group(['as' => 'poly.','prefix' => 'poly','namespace' => 'Poly','middleware' => ['auth','poly']] , function(){
        //booking
        Route::get('booking/recent','BookingController@recent')->name('booking.recent');
        Route::get('booking/active','BookingController@active')->name('booking.active');
        Route::get('booking/delivery-complete','BookingController@deliveryComplete')->name('booking.delivery-complete');
        Route::get('booking/search','BookingController@search')->name('booking.search');
        Route::post('booking/search-booking','BookingController@searchBooking')->name('booking.search-booking');
        Route::get('booking/report','BookingController@report')->name('booking.report');
        Route::post('booking/report-result','BookingController@reportResult')->name('booking.report-result');
        Route::get('booking/detail/{id}','BookingController@detail')->name('booking.detail');

        Route::get('booking/detail/pdf/{id}','BookingController@pdf')->name('booking.detail.pdf');
        Route::post('booking/detail/save','BookingController@saveDetail')->name('booking.detail.save');
        Route::delete('booking/detail/delete','BookingController@deleteDetail')->name('booking.detail.delete');
        Route::delete('booking/delete','BookingController@delete')->name('booking.delete');
        Route::delete('booking/urgent','BookingController@makeUrgent')->name('booking.urgent');
        Route::delete('booking/revise','BookingController@makeRevise')->name('booking.revise');
        Route::delete('booking/return-active','BookingController@returnActive')->name('booking.return-active');
        //booking

        //product setup
        Route::get('product','ProductSetupController@index')->name('product');
        Route::post('product/save','ProductSetupController@saveProduct')->name('product.save');
        Route::post('product/edit','ProductSetupController@updateProduct')->name('product.edit');
        Route::post('product/delete','ProductSetupController@deleteProduct')->name('product.delete');
        Route::get('product/detail/{id}','ProductSetupController@detail')->name('product.detail');
        Route::post('product/save-price-setup','ProductSetupController@savePriceSetup')->name('product.save-price-setup');
        Route::post('product/edit-price-setup','ProductSetupController@updateProductPriceSetup')->name('product.edit-price-setup');
        Route::delete('product/delete-price-setup','ProductSetupController@deleteProductPriceSetup')->name('product.delete-price-setup');
        Route::post('product/get-article-list','ProductSetupController@getArticleList')->name('product.get-article-list');
        Route::post('product/get-price','ProductSetupController@getPriceSetup')->name('product.get-price');
        //product setup
    });
    Route::group(['as' => 'poly.','prefix' => 'poly','namespace' => 'Poly','middleware' => ['auth','poly','createp']] , function(){
        //booking
        Route::get('booking/new','BookingController@newBooking')->name('booking.new');
        Route::post('booking/save','BookingController@saveBooking')->name('booking.save');
        //booking
    });
    Route::group(['as' => 'poly.','prefix' => 'poly','namespace' => 'Poly','middleware' => ['auth','poly', 'updatepmaster']] , function(){
        //booking
        Route::get('booking/edit/{id}','BookingController@edit')->name('booking.edit');
        Route::post('booking/update','BookingController@updateBooking')->name('booking.update');
        //booking
    });
    //poly

    //General Item
    Route::group(['as' => 'generalitem.','prefix' => 'generalitem','namespace' => 'GeneralItem','middleware' => ['auth','generalitem']] , function(){
        //booking
        Route::get('booking/recent','BookingController@recent')->name('booking.recent');
        Route::get('booking/active','BookingController@active')->name('booking.active');
        Route::get('booking/delivery-complete','BookingController@deliveryComplete')->name('booking.delivery-complete');
        Route::get('booking/search','BookingController@search')->name('booking.search');
        Route::post('booking/search-booking','BookingController@searchBooking')->name('booking.search-booking');
        Route::get('booking/report','BookingController@report')->name('booking.report');
        Route::post('booking/report-result','BookingController@reportResult')->name('booking.report-result');
        Route::get('booking/detail/{id}','BookingController@detail')->name('booking.detail');

        Route::get('booking/detail/pdf/{id}','BookingController@pdf')->name('booking.detail.pdf');
        Route::post('booking/detail/save','BookingController@saveDetail')->name('booking.detail.save');
        Route::delete('booking/detail/delete','BookingController@deleteDetail')->name('booking.detail.delete');
        Route::delete('booking/delete','BookingController@delete')->name('booking.delete');
        Route::delete('booking/urgent','BookingController@makeUrgent')->name('booking.urgent');
        Route::delete('booking/revise','BookingController@makeRevise')->name('booking.revise');
        Route::delete('booking/return-active','BookingController@returnActive')->name('booking.return-active');
        //booking

        //product setup
        Route::get('product','ProductSetupController@index')->name('product');
        Route::post('product/save','ProductSetupController@saveProduct')->name('product.save');
        Route::post('product/edit','ProductSetupController@updateProduct')->name('product.edit');
        Route::post('product/delete','ProductSetupController@deleteProduct')->name('product.delete');
        Route::get('product/detail/{id}','ProductSetupController@detail')->name('product.detail');
        Route::post('product/save-price-setup','ProductSetupController@savePriceSetup')->name('product.save-price-setup');
        Route::post('product/edit-price-setup','ProductSetupController@updateProductPriceSetup')->name('product.edit-price-setup');
        Route::delete('product/delete-price-setup','ProductSetupController@deleteProductPriceSetup')->name('product.delete-price-setup');
        Route::post('product/get-article-list','ProductSetupController@getArticleList')->name('product.get-article-list');
        Route::post('product/get-price','ProductSetupController@getPriceSetup')->name('product.get-price');
        //product setup
    });
    Route::group(['as' => 'generalitem.','prefix' => 'generalitem','namespace' => 'GeneralItem','middleware' => ['auth','generalitem','creategi']] , function(){
        //booking
        Route::get('booking/new','BookingController@newBooking')->name('booking.new');
        Route::post('booking/save','BookingController@saveBooking')->name('booking.save');
        //booking
    });
    Route::group(['as' => 'generalitem.','prefix' => 'generalitem','namespace' => 'GeneralItem','middleware' => ['auth','generalitem', 'updategimaster']] , function(){
        //booking
        Route::get('booking/edit/{id}','BookingController@edit')->name('booking.edit');
        Route::post('booking/update','BookingController@updateBooking')->name('booking.update');
        //booking
    });

    //General Item

    Route::group(['as' => 'merchandising.','prefix' => 'merchandising','namespace' => 'Merchandising','middleware' => ['auth','merchandising']] , function(){
        Route::get('booking/report','BookingController@report')->name('booking.report');
        Route::post('booking/report-result','BookingController@reportResult')->name('booking.report-result');
    });


/*Route::get('/home', 'HomeController@index')->name('home');
    Auth::routes();
    Route::get('/', function () {
        return view('home');
    })-*/
