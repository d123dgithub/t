<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['uses'=>'TuijianrenController@index',
    'as'=>'index',]
);
//Route::get('/',function(){
//    return view('welcome');
//});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware'=>['web','tislogin']],function(){
    Route::any('tuijianren/add',['uses'=>'TuijianrenController@add_beituijianren',]);
    Route::get('tuijianren/tuijianren',['uses'=>'TuijianrenController@tuijianren',]);
    Route::any('tuijianren/exit',['uses'=>'TuijianrenController@user_exit',]);
    Route::any('tuijianren/edit/{id}',['uses'=>'TuijianrenController@edit_beituijianren',]);
    Route::get('tuijianren/beituijianren_exist',['uses'=>'TuijianrenController@beituijianren_exist', 'as'=>'beituijianren_exist',]);
    Route::get('tuijianren/del/{id}',['uses'=>'TuijianrenController@del_beituijianren',]);
    Route::get('tuijianren/szm/{id}',['uses'=>'TuijianrenController@szm',]);
});
Route::group(['middleware'=>['web','aislogin']],function(){
    Route::get('home',['uses'=>'AdminController@home',]);
    Route::get('admin/exit',['uses'=>'AdminController@admin_exit',]);
    Route::any('dj',['uses'=>'AdminController@dj',]);
    Route::get('szm/list/{id?}/{who?}',['uses'=>'AdminController@szm_list',]);
    Route::get('search_tuijianren',['uses'=>'AdminController@search_tuijianren',]);
    Route::get('admin/tuijianren',['uses'=>'AdminController@tuijianren',]);
    Route::any('shop/add',['uses'=>'AdminController@shop_add',]);
    Route::get('shop/list',['uses'=>'AdminController@shop_list',]);
    Route::get('admin_exist',['uses'=>'AdminController@phone_exist', 'as'=>'admin_exist']);
    Route::get('doorno_exist',['uses'=>'AdminController@doorno_exist',]);
    Route::get('admin_tjr_delete/{id}',['uses'=>'AdminController@admin_tjr_delete',]);
    Route::get('admin_sj_delete/{id}',['uses'=>'AdminController@admin_sj_delete',]);
    Route::any('admin_sj_edit/{id}',['uses'=>'AdminController@admin_sj_edit',]);
    Route::get('js/{id}',['uses'=>'AdminController@js',]);
    Route::get('many_js/{ids}',['uses'=>'AdminController@many_js',]);
    Route::get('tjr_btjr/{id}',['uses'=>'AdminController@tjr_btjr',]);
    Route::any('huodong_add',['uses'=>'AdminController@huodong_add',]);
    Route::get('huodong',['uses'=>'AdminController@huodong',]);
    Route::get('huodong/detail/{id}',['uses'=>'AdminController@huodong_detail',]);
    Route::get('huodong/delete/{id}',['uses'=>'AdminController@huodong_delete',]);
    Route::any('huodong/eidt/{id}',['uses'=>'AdminController@huodong_eidt',]);
});

Route::group(['middleware' => ['web']], function () {
    Route::get('index',['uses'=>'TuijianrenController@index', 'as'=>'index',]);
    Route::any('tuijianren/register',['uses'=>'TuijianrenController@register', 'as'=>'reg']);
    Route::any('tuijianren/login',['uses'=>'TuijianrenController@login', 'as'=>'login']);
    Route::get('tuijianren/phone_exist',['uses'=>'TuijianrenController@phone_exist', 'as'=>'exist']);
    Route::any('tuiguangadmin',['uses'=>'AdminController@index', 'as'=>'admin',]);
    Route::any('tuiguangadmin/create',['uses'=>'AdminController@create',]);
    Route::get('admin_index',['uses'=>'AdminController@admin_index',]);
    Route::any('invite/{id}',['uses'=>'TuijianrenController@addself',]);
    Route::get('kit/captcha/{tmp}', 'KitController@captcha');
});



