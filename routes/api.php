<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Siba\apirest\controllers;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* API MICRO SERVICIOS PARA STD-QA-BACKEND */

/*
Route::group(array('prefix'=>'ingresos','before'=>'dsc.auth'),function(){

	Route::get("/eventos/{id}/",array ('as' => 'ingresos', 'uses' => 'Ingresos@index'));
	Route::get("/agregar",array ('as' => 'ingresos.agregar', 'uses' => 'Ingresos@create'));
	Route::post("/agregar",array ('as' => 'ingresos.store', 'uses' => 'Ingresos@store'));
	Route::get("/{id}",array ('as' => 'ingresos.show', 'uses' => 'Ingresos@show'));
	Route::get("/{id}/edit",array ('as' => 'ingresos.update', 'uses' => 'Ingresos@update'));

});
*/

/* Rutas para gestionar el ENDPOINT para eventos */

Route::get("/events",array ('as' => 'events', 'uses' => '\Siba\apirest\controllers\EventsApi@index'));
Route::get("/events/{id}",array ('as' => 'events', 'uses' => '\Siba\apirest\controllers\EventsApi@show'));
Route::post("/events",array ('as' => 'events', 'uses' => '\Siba\apirest\controllers\EventsApi@store'));
Route::put("/events/{id}",array ('as' => 'events', 'uses' => '\Siba\apirest\controllers\EventsApi@update'));
Route::delete("/events/{id}",array ('as' => 'events', 'uses' => '\Siba\apirest\controllers\EventsApi@destroy'));


/* Rutas para gestionar el ENDPOINT para Canales */

Route::get("/channels",array ('as' => 'channels', 'uses' => '\Siba\apirest\controllers\ChannelsApi@index'));
Route::get("/channels/{id}",array ('as' => 'channels', 'uses' => '\Siba\apirest\controllers\ChannelsApi@show'));
Route::get("/channels/{id}/events",array ('as' => 'channels', 'uses' => '\Siba\apirest\controllers\ChannelsApi@showEventsInChannel'));
Route::post("/channels",array ('as' => 'channels', 'uses' => '\Siba\apirest\controllers\ChannelsApi@store'));
Route::put("/channels/{id}",array ('as' => 'channels', 'uses' => '\Siba\apirest\controllers\ChannelsApi@update'));
Route::delete("/channels/{id}",array ('as' => 'channels', 'uses' => '\Siba\apirest\controllers\ChannelsApi@destroy'));


/* Rutas para gestionar el ENDPOINT para Clientes */

Route::get("/clients",array ('as' => 'clients', 'uses' => '\Siba\apirest\controllers\ClientsApi@index'));
Route::get("/clients/{id}",array ('as' => 'clients', 'uses' => '\Siba\apirest\controllers\ClientsApi@show'));
Route::get("/clients/{id}/channels",array ('as' => 'clients', 'uses' => '\Siba\apirest\controllers\ClientsApi@searchClientsChannels'));
Route::post("/clients",array ('as' => 'clients', 'uses' => '\Siba\apirest\controllers\ClientsApi@store'));
Route::put("/clients/{id}",array ('as' => 'clients', 'uses' => '\Siba\apirest\controllers\ClientsApi@update'));
Route::delete("/clients/{id}",array ('as' => 'clients', 'uses' => '\Siba\apirest\controllers\ClientsApi@destroy'));



/* Rutas para gestionar el ENDPOINT para Ratings */

Route::get("/ratings",array ('as' => 'ratings', 'uses' => '\Siba\apirest\controllers\RatingsApi@index'));
Route::get("/ratings/{id}",array ('as' => 'ratings', 'uses' => '\Siba\apirest\controllers\RatingsApi@show'));
Route::get("/ratings/{id}/events",array ('as' => 'ratings', 'uses' => '\Siba\apirest\controllers\RatingsApi@showEventsInChannel'));
Route::post("/ratings",array ('as' => 'ratings', 'uses' => '\Siba\apirest\controllers\RatingsApi@store'));
Route::put("/ratings/{id}",array ('as' => 'ratings', 'uses' => '\Siba\apirest\controllers\RatingsApi@update'));
Route::delete("/ratings/{id}",array ('as' => 'ratings', 'uses' => '\Siba\apirest\controllers\RatingsApi@destroy'));
