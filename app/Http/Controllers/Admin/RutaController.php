<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruta;

class RutaController extends Controller
{
    //
    public function index(){
        $rutas = Ruta::all();
        return view("admin.ruta.index", compact("rutas"));
    }
}
