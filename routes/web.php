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

Auth::routes();
Route::group(['middleware' => 'web'], function () {



    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/UnauthorizedPage', 'HomeController@unauthorized')->name('unauthorized');
    Route::group(['middleware' => ['auth', 'acl']], function () {

        Route::get('/', function () {
            return view('welcome');
        })->name('welcome');
        Route::get('/admin', [
            'as' => 'admin.index',
            'uses' => function () {
                return view('admin.index');
            }
        ]);
        Route::get('pdfview',array('as'=>'pdfview','uses'=>'ReportController@pdfview'));
        Route::get('index/pdfview','ReportController@index')->name('reportsindex');
        Route::get('freezer/{id}/frRetPrint', 'FreezerController@ReturnPrint')->name('freezer.returnPrint');
        Route::get('freezer/{id}/frTranPrint', 'FreezerController@transferPrint')->name('freezer.transferPrint');
        Route::get('freezer/{id}/gpOutPrint', 'FreezerController@gatePassOutPrint')->name('freezer.gateOutPrint');
        Route::get('freezer/{id}/gpInPrint', 'FreezerController@gatePassInPrint')->name('freezer.gateInPrint');
        Route::get('freezer/return', 'FreezerController@createReturn')->name('freezer.return');
        Route::get('freezer/return/{id}/edit', 'FreezerController@returnedit')->name('freezer.return.edit');
        Route::get('dispatch/return/{id}', 'DispatchController@returnDispatch')->name('returnDispatch');
        Route::get('admin/users', 'AdminController@users')->name('showusers');
        Route::get('admin/{id}/user', 'AdminController@useredit')->name('useredit');
        Route::post('admin/{id}/user', 'AdminController@updateuser')->name('userupdate');
        Route::delete('admin/{id}/user', 'AdminController@destroyUser')->name('deleteuser');
        Route::get('transfer/transit','TransferController@transit')->name('transit');
        Route::get('transfer/Byuser/{id}','TransferController@shipByUser')->name('shipByUser');
        Route::post('transfer/{id}/transit','TransferController@transferReceived')->name('transferreceived');
        Route::resource('admin', 'AdminController');
//        Route::resource('/admin/user', 'UserController');
        Route::resource('/admin/user/userpermission', 'UserPermissionController');
        Route::get('Reports/TotalStock','ReportController@all')->name('stockreport');

        // Creating through Excel
        Route::get('Region/createExcel','RegionController@excel')->name('CreateRegion_Excel');
        Route::post('Region/createExcel','RegionController@import')->name('CreateRegion_Excel');
        Route::get('Customer/createExcel','CustomerController@excel')->name('CreateCustomer_Excel');
        Route::post('Customer/createExcel','CustomerController@import')->name('CreateCustomer_Excel');
        Route::get('City/createExcel','CityController@excel')->name('CreateCity_Excel');
        Route::post('City/createExcel','CityController@import')->name('CreateCity_Excel');
        Route::get('Faculty/createExcel','FacultyController@excel')->name('CreateFaculty_Excel');
        Route::post('Faculty/createExcel','FacultyController@import')->name('CreateFaculty_Excel');

        //Resource Routes
        Route::resource('permission', 'PermissionController');
        Route::resource('useritem', 'UserItemController');
        Route::resource('category', 'CategoryController');
        Route::resource('city', 'CityController');
        Route::resource('region', 'RegionController');
        Route::resource('customer', 'CustomerController');
        Route::resource('item', 'ItemController');
        Route::resource('dispatch', 'DispatchController');
        Route::resource('returns', 'ReturnController');
        Route::resource('freezer', 'FreezerController');
        Route::resource('transfer', 'TransferController');
        Route::resource('purchase', 'PurchaseController');
        Route::resource('faculty', 'FacultyController');
    });
});
//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
