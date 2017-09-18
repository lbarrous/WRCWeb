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

Route::get('mail', 'HomeController@mail');

Route::get('register', [ 'as' => 'register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('register/user', [ 'as' => 'register/user', 'uses' => 'Auth\AuthController@postRegister']);
Route::get('login', [ 'as' => 'login', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('login/user', [ 'as' => 'login/user', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('logout', [ 'as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);

Route::get('/home', 'HomeController@index');

Route::get('perfil', [ 'as' => 'perfil', 'uses' => 'UserController@showPerfil']);
Route::post('perfil/actualizar', [ 'as' => 'perfil/actualizar', 'uses' => 'UserController@actualizarPerfil']);

Route::get('listaRallies', [ 'as' => 'listaRallies', 'uses' => 'RallyController@showListaRallies']);
Route::get('verTramos/{codRally}', 'RallyController@verTramos');
Route::get('verCochePiloto/{codCoche}', 'PilotoController@verCochePiloto');
Route::get('editaRally/{codRally}', 'RallyController@editaRally');
Route::get('editaPiloto/{codPiloto}', 'PilotoController@editaPiloto');
Route::get('editaCoche/{codCoche}', 'CocheController@editaCoche');
Route::post('addTramo', [ 'as' => 'addTramo', 'uses' => 'RallyController@addTramo']);
Route::post('eliminarTramo', [ 'as' => 'eliminarTramo', 'uses' => 'RallyController@eliminarTramo']);
Route::post('eliminarRally', [ 'as' => 'eliminarRally', 'uses' => 'RallyController@eliminarRally']);
Route::post('eliminarPiloto', [ 'as' => 'eliminarPiloto', 'uses' => 'PilotoController@eliminarPiloto']);
Route::post('eliminarCoche', [ 'as' => 'eliminarCoche', 'uses' => 'CocheController@eliminarCoche']);
Route::post('eliminarResultado', [ 'as' => 'eliminarResultado', 'uses' => 'ResultadosController@eliminarResultado']);
Route::post('eliminarTiempo', [ 'as' => 'eliminarTiempo', 'uses' => 'TiemposController@eliminarTiempo']);
Route::post('saveCambiosRally', [ 'as' => 'saveCambiosRally', 'uses' => 'RallyController@saveCambiosRally']);
Route::post('saveCambiosPiloto', [ 'as' => 'saveCambiosPiloto', 'uses' => 'PilotoController@saveCambiosPiloto']);
Route::post('saveCambiosCoche', [ 'as' => 'saveCambiosCoche', 'uses' => 'CocheController@saveCambiosCoche']);
Route::post('saveCambiosResultados', [ 'as' => 'saveCambiosResultados', 'uses' => 'ResultadosController@saveCambiosResultados']);
Route::post('saveCambiosTiempos', [ 'as' => 'saveCambiosTiempos', 'uses' => 'TiemposController@saveCambiosTiempos']);
Route::post('nuevoRally', [ 'as' => 'nuevoRally', 'uses' => 'RallyController@nuevoRally']);
Route::post('nuevoPiloto', [ 'as' => 'nuevoPiloto', 'uses' => 'PilotoController@nuevoPiloto']);
Route::post('nuevoCoche', [ 'as' => 'nuevoCoche', 'uses' => 'CocheController@nuevoCoche']);
Route::post('nuevoResultado', [ 'as' => 'nuevoResultado', 'uses' => 'ResultadosController@nuevoResultado']);
Route::post('nuevoTiempo', [ 'as' => 'nuevoTiempo', 'uses' => 'TiemposController@nuevoTiempo']);
//Route::get('', [ 'as' => 'editaRally/{$codRally}', 'uses' => 'RallyController@editaRally']);
Route::get('listaPilotos', [ 'as' => 'listaPilotos', 'uses' => 'PilotoController@showListaPilotos']);
Route::get('listaCoches', [ 'as' => 'listaCoches', 'uses' => 'CocheController@showListaCoches']);
Route::get('listaResultados', [ 'as' => 'listaResultados', 'uses' => 'ResultadosController@showListaResultados']);
Route::get('listaTiempos', [ 'as' => 'listaTiempos', 'uses' => 'TiemposController@showListaTiempos']);
Route::get('dimeSiPuedoCrearPilotos', [ 'as' => 'dimeSiPuedoCrearPilotos', 'uses' => 'PilotoController@dimeSiPuedoCrearPilotos']);
