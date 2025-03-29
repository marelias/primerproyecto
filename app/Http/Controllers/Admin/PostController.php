<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Imagen;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;
use illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view("admin.post.index", compact("posts"));
    }

    public function create()
    {
        return view('admin.post.create');
    }

    public function store(Request $request)
    {
        // Crear instancia de Post y asignar datos
        $post = new Post();
        $post->nombre = $request->nombre;
        $post->descripcion = $request->descripcion;

        if ($request->hasFile('urlfoto')) {
            $imagen = $request->file('urlfoto');
            $nuevonombre = "post_" . time() . "." . $imagen->guessExtension();

            // Instanciar ImageManager correctamente
            $manager = new ImageManager(new Driver());

            // Leer la imagen y redimensionarla
            $image = $manager->read($imagen->getRealPath());
            $image->cover(900, 450); // Redimensiona la imagen

            // Asegurar que la carpeta 'img/post' existe
            $path = public_path('img/post');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            // Guardar la imagen en la carpeta
            $image->toJpeg()->save($path . '/' . $nuevonombre);

            // Asignar el nuevo nombre al modelo
            $post->urlfoto = $nuevonombre;
        }
        // Generar un slug único
        $slug = Str::slug($request->nombre);
        $contador = 1;

        // Verificar si el slug ya existe
        while (Post::where('slug', $slug)->exists()) {
            $slug = Str::slug($request->nombre) . '-' . $contador;
            $contador++;
        }

        $post->slug = $slug; // Asigna el slug único
        // Guardar la post en la base de datos
        $post->title = $request->title;
        $post->description = $request->description ?? 'Descripción por defecto';

        $post->save();

        return redirect()->route('admin.post.index')->with('success', 'Post creada exitosamente');
    }
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.post.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->nombre = $request->nombre;
        $post->descripcion = $request->descripcion;

        if ($request->hasFile('urlfoto')) {
            // Eliminar la imagen anterior si existe
            if ($post->urlfoto && File::exists(public_path('img/post/' . $post->urlfoto))) {
                File::delete(public_path('img/post/' . $post->urlfoto));
            }

            $imagen = $request->file('urlfoto');
            $nuevonombre = "post_" . time() . "." . $imagen->guessExtension();

            // Instanciar ImageManager correctamente
            $manager = new ImageManager(new Driver());

            // Leer la imagen y redimensionarla
            $image = $manager->read($imagen->getRealPath());
            $image->cover(900, 450); // Redimensiona la imagen

            // Asegurar que la carpeta 'img/post' existe
            $path = public_path('img/post');
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            // Guardar la imagen en la carpeta
            $image->toJpeg()->save($path . '/' . $nuevonombre);

            // Asignar el nuevo nombre al modelo
            $post->urlfoto = $nuevonombre;
        }

        // Generar un slug único
        $slug = Str::slug($request->nombre);
        $contador = 1;

        // Verificar si el slug ya existe
        while (Post::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = Str::slug($request->nombre) . '-' . $contador;
            $contador++;
        }

        $post->slug = $slug; // Asigna el slug único
        // Guardar la post en la base de datos
        $post->title = $request->title;

        $post->save();

        return redirect()->route('admin.post.index')->with('success', 'Post actualizada exitosamente');
    }
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // Eliminar la imagen de la carpeta si existe
        if ($post->urlfoto && File::exists(public_path('img/post/' . $post->urlfoto))) {
            File::delete(public_path('img/post/' . $post->urlfoto));
        }

        // Eliminar la post de la base de datos
        $post->delete();

        return redirect()->route('admin.post.index')->with('success', 'Post eliminada exitosamente');
    }
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return view('admin.post.show', compact('post'));
    }
}
