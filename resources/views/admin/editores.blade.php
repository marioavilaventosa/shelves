@extends('layouts.admin')
@section('content')

    <div class="row mb-3">
        <h2 class="col-md-10 text-center">Editores</h2>
        <a href="{{ action('UsuariosController@formanadir') }}" class="text-center text-white btn bg-green ml-5 pt-2">Añadir Editor</a>
    </div>
    @if (count($usuarios) == 0)
            <h5 class="font-weight-bold text-center col-md-10">Todavia no hay ningun editor.</h5>
    @else
        <table class="table border-top-0">
            <thead>
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Email</th>
                <th scope="col">Rol</th>
                <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $key => $usuario)
                    <tr>
                        <td class="col-md-3">{{$usuario->name}}</td>
                        <td class="col-md-3">{{$usuario->email}}</td>
                        <td class="col-md-3">{{$usuario->rol}}</td>
                        <td class="col-md-3">
                        <a href="{{action('UsuariosController@convertirUsuario' , ['id'=>$usuario->id])}}" class="btn bg-purple text-white">Convertir en usuario</a>
                        <a href="{{action('UsuariosController@eliminareditor' , ['id'=>$usuario->id])}}" class="btn btn-danger text-white">Eliminar</a>
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection