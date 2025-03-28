<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix'=>'admin','middleware' => ['auth','role:admin']], function(){
    //ruta de administracion
   Route::resource('/ruta', App\Http\Controllers\Admin\RutaController::class
);
});
