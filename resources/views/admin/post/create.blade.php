@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        @include('admin.menu')
        <div class="col-sm-10">
            <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Ingrese el título</label>
                    <input type="text" id="title" name="title" class="form-control" maxlength="67" required>
                </div>

                <div class="form-group">
                    <label for="description">Ingrese la descripción breve</label>
                    <input type="text" id="description" name="description" class="form-control" maxlength="155">
                </div>

                <div class="form-group">
                    <label for="nombre">Ingrese el nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>

                <div class="jumbotron">
                    <div class="form-group">
                        <label for="descripcion">Ingrese la descripción detallada</label>
                        <textarea id="descripcion" name="descripcion" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="orden">Ingrese el orden</label>
                        <input type="number" id="orden" name="orden" class="form-control">
                    </div>

                    <div class="form-group">
                            <label for="urlvideo">Ingrese el video</label>
                        <br>
                        <video width="320" height="240" controls>
                        <source src="{{ asset('videos/post/video.mp4') }}" type="video/mp4">
                        Tu navegador no soporta la reproducción de videos.
                        </video>
                        <input type="file" id="urlvideo" name="urlvideo" class="form-control-file" accept="video/*">
                    </div>
                    
                    <div class="form-group">
                        <label for="urlfoto">Ingrese la imagen</label>
                        <br>
                        <img src="{{ asset('img/post/foto.jpg') }}" alt="Imagen de referencia" width="200">
                        <input type="file" id="urlfoto" name="urlfoto" class="form-control-file">
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection
