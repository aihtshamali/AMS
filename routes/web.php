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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware'=>['auth','acl']],function(){
    Route::get('/admin',[
      'as'=>'admin.index',
      'uses'=>function(){
        return view('admin.index');
      }
    ]);
    Route::get('freezer/return','FreezerController@createReturn')->name('return');
//    Route::post('freezer/return','FreezerController@storeReturn')->name('return');
    Route::resource('role','RoleController');
    Route::resource('category','CategoryController');
    Route::resource('city','CityController');
    Route::resource('region','RegionController');
    Route::resource('customer','CustomerController');
    Route::resource('item','ItemController');
    Route::resource('dispatch','DispatchController');
    Route::resource('returns','ReturnController');
    Route::resource('freezer','FreezerController');
    Route::resource('transfer','TransferController');
    Route::resource('purchase','PurchaseController');

});
