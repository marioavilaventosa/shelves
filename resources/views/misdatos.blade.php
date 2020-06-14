@extends('layouts.app')
@section('content')

    <div class="row">
        <h2 class="col-md-12 text-center {{$colorSecundario}}">Editar mis datos</h2>
    </div>
    <div class="row">
        @if(session()->has('message'))
            <div class="alert alert-success m-3 col-12 text-center">
                {{ session()->get('message') }}
            </div>
        @endif
    </div>
    <form method="POST" action="{{action('UsuariosController@misdatos')}}" class="text-center {{$colorSecundario}}">
        {{ csrf_field() }}
        <label for="nombre" class="pt-3 mr-2">Nombre: </label>
        <input type="text" name="nombre" id="nombre" value="{{$usuario->name}}" max="255" required class="w-25"><br>

        <label for="apellidos" class="pt-3 mr-2">Apellidos: </label>
        <input type="text" name="apellidos" id="apellidos" value="{{$usuario->apellidos}}" max="255" required class="w-25"><br>

        <label for="ciudad" class="pt-3 mr-2">Ciudad: </label>
        <input type="text" name="ciudad" id="ciudad" value="{{$usuario->ciudad}}" max="255" required class="w-25"><br>

        <label for="pais" class="pt-3 mr-2">Pais: </label>
        <input type="text" name="pais" id="pais" value="{{$usuario->pais}}" max="255" required class="w-25"><br>

        <label for="direccion" class="pt-3 mr-2">Direccion: </label>
        <input type="text" name="direccion" id="direccion" value="{{$usuario->direccion}}" max="255" required class="w-25"><br>

        <label for="email" class="pt-3 mr-2">Correo: </label>
        <input type="text" name="email" id="email" value="{{$usuario->email}}" max="255" required class="w-25"><br>

        <input type="submit" value="Editar Mis Datos" class="btn bg-purple text-white mt-3">
    </form>

@endsection