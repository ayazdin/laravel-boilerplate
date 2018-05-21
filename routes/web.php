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



// Authentication Routes...
Route::get('admin/login', [
  'as' => 'admin/login',
  'uses' => 'Auth\LoginController@showAdminLoginForm'
]);
/*Route::post('login', [
  'as' => 'login',
  'uses' => 'Auth\LoginController@login'
]);*/
/*Route::post('logout', [
  'as' => 'logout',
  'uses' => 'Auth\LoginController@logout'
]);*/

// Password Reset Routes...
/*Route::post('password/email', [
  'as' => 'password.email',
  'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
]);
Route::get('password/reset', [
  'as' => 'password.request',
  'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
]);
Route::post('password/reset', [
  'as' => '',
  'uses' => 'Auth\ResetPasswordController@reset'
]);
Route::get('password/reset/{token}', [
  'as' => 'password.reset',
  'uses' => 'Auth\ResetPasswordController@showResetForm'
]);

// Registration Routes...
Route::get('register', [
  'as' => 'register',
  'uses' => 'Auth\RegisterController@showRegistrationForm'
]);
Route::post('register', [
  'as' => '',
  'uses' => 'Auth\RegisterController@register'
]);*/




Route::get('/dashboard', 'HomeController@index')->name('dashboard');



Route::group(['prefix' => 'admin/page/'], function () {
  Route::get('list', ['uses' => 'Posts\PageController@indexPage'])->middleware('admin');
  Route::get('add', ['uses' => 'Posts\PageController@createPage'])->middleware('admin');
  Route::post('store', ['uses' => 'Posts\PageController@store'])->middleware('admin');
});

Route::group(['prefix' => 'admin/post/'], function () {
  Route::get('list', ['uses' => 'Posts\PostsController@indexPosts'])->middleware('admin');
  Route::get('add', ['uses' => 'Posts\PostsController@createPosts'])->middleware('admin');
  Route::post('store', ['uses' => 'Posts\PostsController@store'])->middleware('admin');
  Route::post('category', ['uses' => 'Posts\PostsController@indexCategory'])->middleware('admin');
});
