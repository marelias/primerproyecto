<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruta;
use App\Models\Imagen;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;
use illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
class RutaController extends Controller
{
    public function index(){
        $rutas = Ruta::all();
        return view("admin.ruta.index", compact("rutas"));
    }

    public function create()
    {
        return view('admin.ruta.create');
    }

    public function store(Request $request)
    {
        // Crear instancia de Ruta y asignar datos
        $ruta = new Ruta();
        $ruta->nombre = $request->nombre;
        $ruta->descripcion = $request->descripcion;

        if ($request->hasFile('urlfoto')) {
            $imagen = $request->file('urlfoto');
            $nuevonombre = "ruta_" . time() . "." . $imagen->guessExtension();

            // Instanciar ImageManager correctamente
            $manager = new ImageManager(new Driver());

            // Leer la imagen y redimensionarla
            $image = $manager->read($imagen->getRealPath());
            $image->cover(900, 450); // Redimensiona la imagen

            // Asegurar que la carpeta 'img/ruta' existe
            $path = public_path('img/ruta');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            // Guardar la imagen en la carpeta
            $image->toJpeg()->save($path . '/' . $nuevonombre);

            // Asignar el nuevo nombre al modelo
            $ruta->urlfoto = $nuevonombre;
        }
        // Generar un slug único
        $slug = Str::slug($request->nombre);
        $contador = 1;

        // Verificar si el slug ya existe
        while (Ruta::where('slug', $slug)->exists()) {
            $slug = Str::slug($request->nombre) . '-' . $contador;
            $contador++;
        }

        $ruta->slug = $slug; // Asigna el slug único
        // Guardar la ruta en la base de datos
        $ruta->title = $request->title;
        $ruta->description = $request->description ?? 'Descripción por defecto';

        $ruta->save();

        return redirect()->route('admin.ruta.index')->with('success', 'Ruta creada exitosamente');
    }
    public function edit($id)
    {
        $ruta = Ruta::findOrFail($id);
        return view('admin.ruta.edit', compact('ruta'));
    }

    public function update(Request $request, $id)
    {
        $ruta = Ruta::findOrFail($id);
        $ruta->nombre = $request->nombre;
        $ruta->descripcion = $request->descripcion;

        if ($request->hasFile('urlfoto')) {
            // Eliminar la imagen anterior si existe
            if ($ruta->urlfoto && File::exists(public_path('img/ruta/' . $ruta->urlfoto))) {
                File::delete(public_path('img/ruta/' . $ruta->urlfoto));
            }

            $imagen = $request->file('urlfoto');
            $nuevonombre = "ruta_" . time() . "." . $imagen->guessExtension();

            // Instanciar ImageManager correctamente
            $manager = new ImageManager(new Driver());

            // Leer la imagen y redimensionarla
            $image = $manager->read($imagen->getRealPath());
            $image->cover(900, 450); // Redimensiona la imagen

            // Asegurar que la carpeta 'img/ruta' existe
            $path = public_path('img/ruta');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            // Guardar la imagen en la carpeta
            $image->toJpeg()->save($path . '/' . $nuevonombre);

            // Asignar el nuevo nombre al modelo
            $ruta->urlfoto = $nuevonombre;
        }

        // Generar un slug único
        $slug = Str::slug($request->nombre);
        $contador = 1;

        // Verificar si el slug ya existe
        while (Ruta::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = Str::slug($request->nombre) . '-' . $contador;
            $contador++;
        }

        $ruta->slug = $slug; // Asigna el slug único
        // Guardar la ruta en la base de datos
        $ruta->title = $request->title;

        $ruta->save();

        return redirect()->route('admin.ruta.index')->with('success', 'Ruta actualizada exitosamente');
    }
    public function destroy($id)
    {
        $ruta = Ruta::findOrFail($id);

        // Eliminar la imagen de la carpeta si existe
        if ($ruta->urlfoto && File::exists(public_path('img/ruta/' . $ruta->urlfoto))) {
            File::delete(public_path('img/ruta/' . $ruta->urlfoto));
        }

        // Eliminar la ruta de la base de datos
        $ruta->delete();

        return redirect()->route('admin.ruta.index')->with('success', 'Ruta eliminada exitosamente');
    }
    public function show($id)
    {
        $ruta = Ruta::findOrFail($id);
        return view('admin.ruta.show', compact('ruta'));
    }
}
