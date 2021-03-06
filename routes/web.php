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


Route::post('/checkLogin','LoginController@check');
Route::get('/logout','LoginController@logout');


Route::group(['namespace'=>'Apps','middleware' => ['checkLogin']],function (){
    Route::get('/', 'AdminController@index');
    Route::get('user/admin',function (){
        return view('user.admin');
    });
    Route::get('user/adminform',function (){
        return view('user.adminform');
    });
    Route::get('application/addform',function (){
        return view('apps.create');
    });

    Route::post('user/add','AdminController@add');
    Route::post('user/json/admin','AdminController@json');
    Route::post('admin/del','AdminController@del');
    Route::get('admin/edit/{id}','AdminController@edit');
    Route::post('user/status','AdminController@status');
    Route::get('apps/application',function (){
        return view('apps.application');
    });

    //应用管理
    Route::post('application/add','ApplicationController@save');
    Route::post('json/application','ApplicationController@json');
    Route::post('application/del','ApplicationController@del');
    Route::get('application/edit/{id}','ApplicationController@edit');
//    Route::get('json/push_manage','ApplicationController@pushJson');
    Route::get('apps/publish','ApplicationPublishController@list');
    Route::post('json/publish','ApplicationPublishController@json');

    Route::post('publish/log','ApplicationPublishController@log');
    Route::post('publish/rollback','ApplicationPublishController@rollback');
    Route::post('publish/release','ApplicationPublishController@release');
    Route::post('publish/quick','ApplicationPublishController@quick');

});



