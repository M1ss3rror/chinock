<?php

use Illuminate\Support\Facades\Route;

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

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//Rutas de media typesBD
Route::get("media-types/insert", "MediaTypeController@showmass");
Route::post("media-types/store", "MediaTypeController@storemass");

//Ruta prueba MasterPage
Route::get("masterpage" , function(){
    return view('layouts.masterpage');
});
//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Rutas resource
Route::resource('imagenes', 'ImageController');

//rutas prefijo: imagen

Route::prefix('Imagenes')->group(function(){
    Route::get('crear','ImageController@create');
    Route::post('guardar', 'ImageController@store');
});

//Ruta PDF
Route::get('PDF', "PDFController@index");