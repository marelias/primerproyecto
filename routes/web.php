<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'admin', 'middleware' => ['auth','role:admin'], 'as' => 'admin.'], function(){
    // Agregar prefijo de nombres "admin."
    Route::resource('ruta', App\Http\Controllers\Admin\RutaController::class);
    Route::resource('post', App\Http\Controllers\Admin\PostController::class);});




