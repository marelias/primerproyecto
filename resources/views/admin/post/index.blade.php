@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.menu')

            <div class="col-sm-10">
                <a href="{{ route('admin.post.create') }}" class="btn btn-success mb-3">NUEVo PUBLICACION</a>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Orden</th>
                            <th>Nombre</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $item)
                            <tr>
                                <td>{{ $item->orden }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>
                                    <a href="{{ route('admin.post.edit', $item->id) }}" class="btn btn-success">EDITAR</a>
                                    
                                    <form action="{{ route('admin.post.destroy', $item->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('¿ESTÁS SEGURO DE ELIMINAR?')">ELIMINAR</button>
                                    </form>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No hay posts registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
