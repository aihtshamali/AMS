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

Route::get('/', function () {
    return view('welcome');
});
Route::group(['middleware' => 'web'], function () {

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');
    Route::group(['middleware' => ['auth', 'acl']], function () {
        Route::get('/admin', [
            'as' => 'admin.index',
            'uses' => function () {
                return view('admin.index');
            }
        ]);

        Route::get('freezer/{id}/frRetPrint', 'FreezerController@ReturnPrint')->name('freezer.ReturnPrint');
        Route::get('freezer/{id}/frTranPrint', 'FreezerController@transferPrint')->name('freezer.transferPrint');
        Route::get('freezer/{id}/gpOutPrint', 'FreezerController@gatePassOutPrint')->name('freezer.GateOutPrint');
        Route::get('freezer/{id}/gpInPrint', 'FreezerController@gatePassInPrint')->name('freezer.GateInPrint');
        Route::get('freezer/return', 'FreezerController@createReturn')->name('freezer.return');
        Route::get('admin/users', 'AdminController@users')->name('showusers');
        Route::get('admin/{id}/user', 'AdminController@useredit')->name('useredit');
        Route::post('admin/{id}/user', 'AdminController@updateuser')->name('userupdate');

        Route::resource('admin', 'AdminController');
        Route::resource('/admin/user', 'UserController');
        Route::resource('/admin/user/userpermission', 'UserPermissionController');

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
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
