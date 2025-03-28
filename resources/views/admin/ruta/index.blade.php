@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('admin.submenu')
        <div class="col-sm-10">
            <a href="{{ route('ruta.create') }}" class="btn btn-success">NUEVO</a>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Orden</th>
                        <th>Imagen</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ruta as $item)
                        <tr>
                            <td>{{ $item->orden }}</td>
                            <td><img src="/img/ruta/{{ $item->urlfoto }}" width="300"></td>
                            <td>
                                <a href="{{ route('ruta.edit', $item->id) }}" class="btn btn-success">EDITAR</a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['ruta.destroy', $item->id], 'style' => 'display: inline']) !!}
                                    {!! Form::submit('ELIMINAR', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("¿ESTÁ SEGURO DE ELIMINAR?")']) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No hay elementos en el ruta.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection