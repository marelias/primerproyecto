@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('admin.menu')
        <div class="col-sm-10">
            <form action="{{ route('admin.ruta.update', $ruta->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="jumbotron">
                    <div class="form-group">
                        <label for="title">Ingrese el título</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $ruta->title) }}" class="form-control" maxlength="67" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Ingrese la descripción breve</label>
                        <input type="text" name="description" id="description" value="{{ old('description', $ruta->description) }}" class="form-control" maxlength="155">
                    </div>

                    <div class="form-group">
                        <label for="nombre">Ingrese el nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $ruta->nombre) }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Ingrese la descripción detallada</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" rows="4">{{ old('descripcion', $ruta->descripcion) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="orden">Ingrese el orden</label>
                        <input type="number" name="orden" id="orden" value="{{ old('orden', $ruta->orden) }}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="urlfoto">Ingrese la imagen</label><br>
                        <img src="{{ asset('img/ruta/'.$ruta->urlfoto) }}" alt="Imagen de referencia" width="200">
                        <input type="file" name="urlfoto" id="urlfoto" class="form-control-file">
                    </div>

                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
