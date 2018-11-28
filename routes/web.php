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

/*------------------FrontEnd---------------------*/
Route::group(['middleware'=>'checkMiddleware'],function(){

	Route::get('/','FrontendContrller@index');
	Route::get('/contact','FrontendContrller@contact');
	Route::get('/terms','FrontendContrller@terms');
	Route::get('/details/{id}','FrontendContrller@details');
	Route::get('/category_blog/{id}','FrontendContrller@category_blog');
	Route::post('/save-comments','FrontendContrller@save_comments');
	Route::post('/search','FrontendContrller@search');
	Route::get('/login','FrontendContrller@login');
	Route::get('/register','FrontendContrller@register');
	Route::post('/user-register','FrontendContrller@user_register');
	Route::get('/user-logout','FrontendContrller@user_logout');
	Route::post('/login-user','FrontendContrller@user_login');
});

/*------------------FrontEnd---------------------*/


/*------------------BackEnd---------------------*/
Auth::routes();
Route::get('/dashbord', 'HomeController@index')->name('home');
Route::group(['middleware'=>'AuthinticationMiddleware'],function(){

	Route::get('/category','BackendController@category');
	Route::get('/showcategory','BackendController@showcategory');
	Route::post('/save_category','BackendController@save_category');
	Route::get('/editcategory','BackendController@editcategory');
	Route::get('/deletecategory','BackendController@deletecategory');
	Route::get('/add_blog','BackendController@add_blog');
	Route::post('/save_blog','BackendController@save_blog');
	Route::get('/show_blog','BackendController@show_blog');
	Route::get('/comments','BackendController@comments');
	Route::get('/comments-published/{id}','BackendController@comments_published');
	Route::get('/comments-unpublished/{id}','BackendController@comments_unpublished');
	Route::get('/comments-delete/{id}','BackendController@comments_delete');
});

/*------------------BackEnd---------------------*/