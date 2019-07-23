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

Route::any('/admin/login', 'Admin\LoginController@login');
Route::get('/admin/code', 'Admin\LoginController@code');
Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>['web', 'admin.login']],function() {
    Route::get('/index', 'IndexController@index');
    Route::get('/info', 'IndexController@info');
    Route::get('/quit', 'IndexController@quit');
    Route::any('/pass', 'IndexController@pass');
    Route::post('/cate/changeOrder', 'CategoryController@changeOrder');


    Route::resource('/category', 'CategoryController');
    Route::resource('/article', 'ArticleController');

    Route::any('/upload', 'CommonController@upload');
});
Route::any('mail/send', 'MailController@send');


