<?php

use Illuminate\Support\Facades\Route;
use Siba\dev2\controllers\Login;

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

Route::get('', function(){
	return \Redirect::to('/home');
});
Route::get('/', function(){
	return \Redirect::to('/home');
});
Route::controller(Login::class)->group(function () {
    Route::get('/login', 'getIndex')->name('login');
    Route::post('/login', 'postUser');
});
#Route::controller('/login','\Siba\dev2\controllers\Login');
Route::get('/salir',function(){
	Auth::logout();
	return \Redirect::to('/');
});


Route::get('/reportecarga/','\Siba\loadstd\controllers\ApiReporteController@buscar')->middleware('auth');
/* Se crea la ruta para el controlador de la plantilla Reporte Carga Masiva */
Route::get('/reportecargamasiva','\Siba\dev2\controllers\ReporteCargaMasiva@index')->middleware('auth');
Route::get('/reportecargamasiva/ajax','\Siba\dev2\controllers\ReporteCargaMasiva@queryAjax')->middleware('auth');
Route::get('/home','\Siba\dev2\controllers\Home@home')->middleware('auth');
Route::get('/home/ajax','\Siba\dev2\controllers\Home@queryAjax')->middleware('auth');
Route::get('/programa/{id}',function($id=null){
	$prg = \Siba\Dev2\Models\Programa::find($id);
	print_r($prg);
})->middleware('auth');














