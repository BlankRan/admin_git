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
/*
Route::get('/', function () {
    return view('index');
});

Route::get('user/login', function () {
    return view('user.login');
});
Route::get('apps/application', function () {
    return view('apps.application');
});
*/

Route::get('/login',function (){
    return view('user.login');
});
Route::get('user/admin',function (){
    return view('user.admin');
});
Route::get('user/adminform',function (){
    return view('user.adminform');
});
Route::post('user/add','AdminController@add');
Route::post('user/json/admin','AdminController@json');
Route::post('admin/del','AdminController@del');
//Route::middleware(['checkLogin'])->group(function ()
//{
    Route::get('/', function () {
        return view('index');
    });
//});

