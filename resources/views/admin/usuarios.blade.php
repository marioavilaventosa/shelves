@extends('layouts.admin')
@section('content')

    <div class="row mb-3">
        <h2 class="col-md-12 text-center">Usuarios</h2>
    </div>
    @if (count($usuarios) == 0)
            <h5 class="font-weight-bold text-center col-md-12">Todavia no hay ningun usuario.</h5>
    @else
        <table class="table border-top-0">
            <thead>
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Email</th>
                <th scope="col">Rol</th>
                <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $key => $usuario)
                    <tr>
                        <td class="col-md-2">{{$usuario->name}}</td>
                        <td class="col-md-3">{{$usuario->apellidos}}</td>
                        <td class="col-md-3">{{$usuario->email}}</td>
                        <td class="col-md-2">{{$usuario->rol}}</td>
                        <td class="col-md-2">
                        <a href="{{action('UsuariosController@eliminarusuario' , ['id'=>$usuario->id])}}" class="btn btn-danger text-white">Eliminar</a>
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection