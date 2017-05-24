<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::auth();

Route::get('register', [ 'as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('register/user', [ 'as' => 'register/user', 'uses' => 'Auth\AuthController@postRegister']);
Route::get('login', [ 'as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('login/user', [ 'as' => 'login/user', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('logout', [ 'as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

Route::get('/home', 'HomeController@index');

Route::get('perfil', [ 'as' => 'perfil', 'uses' => 'UserController@showPerfil']);
Route::post('perfil/actualizar', [ 'as' => 'perfil/actualizar', 'uses' => 'UserController@actualizarPerfil']);
