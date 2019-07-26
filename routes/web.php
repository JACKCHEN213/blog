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

Route::get('/', 'Home\IndexController@index');
Route::get('/a/{art_id}', 'Home\IndexController@article');
Route::get('/cate/{cate_id}', 'Home\IndexController@cate');

Route::any('/admin/login', 'Admin\LoginController@login');
Route::get('/admin/code', 'Admin\LoginController@code');
Route::group(['prefix'=>'admin', 'namespace'=>'Admin', 'middleware'=>['web', 'admin.login']],function() {
    Route::get('/', 'IndexController@index');
    Route::get('/element', function(){
        return view('admin.element');
    });
    Route::get('/info', 'IndexController@info');
    Route::get('/quit', 'IndexController@quit');
    Route::any('/pass', 'IndexController@pass');

    Route::post('/category/changeOrder', 'CategoryController@changeOrder');
    Route::resource('/category', 'CategoryController');

    Route::resource('/article', 'ArticleController');

    Route::post('/links/changeOrder', 'LinksController@changeOrder');
    Route::resource('/links', 'LinksController');

    Route::post('/navs/changeOrder', 'NavsController@changeOrder');
    Route::resource('/navs', 'NavsController');

    Route::resource('/config', 'ConfigController');
    Route::post('/config/changeOrder', 'ConfigController@changeOrder');
    Route::post('/config/changeContent', 'ConfigController@changeContent');

    Route::any('/upload', 'CommonController@upload');
});
Route::any('test', 'MailController@test');


