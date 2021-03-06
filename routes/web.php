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

Route::get("/", "HomesController@index")->name('root');

Route::resource("articles", "ArticlesController", ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::post('upload_image', 'ArticlesController@uploadImage')->name('articles.upload_image');
Route::get('articles/{article}/{slug?}', 'ArticlesController@show')->name('articles.show');

Route::get('categories/{category}', 'CategoriesController@show')->name('categories.show');


Route::post('tags', 'TagsController@store')->name('tags.store')->middleware('auth');
// 用户身份验证相关的路由
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
