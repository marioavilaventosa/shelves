@extends('layouts.admin')
@section('content')

    <div class="row">
        <h2 class="col-md-12 text-center">Editar Mis Datos</h2>
    </div>
    @if(session()->has('message'))
        <div class="alert alert-success mr-3 mt-2 col-md-12">
            {{ session()->get('message') }}
        </div>
    @endif
    <form method="POST" action="{{action('ConfiguracionesController@editardatos')}}">
        {{ csrf_field() }}
        <label for="nombre" class="pt-3">Nombre: </label>
        <input type="text" name="nombre" id="nombre" value="{{$usuario->name}}" max="40" required><br>

        <label for="apellidos" class="pt-3 mr-2">Apellidos: </label>
        <input type="text" name="apellidos" id="apellidos" value="{{$usuario->apellidos}}" max="255" required class="w-25"><br>

        <label for="email" class="pt-3 mr-2">Correo: </label>
        <input type="text" name="email" id="email" value="{{$usuario->email}}" max="255" required class="w-25"><br>

        <label for="mode" class="pt-3 mr-2">Mode PayPal API: </label>
        <select name="mode" id="mode">
            @if ($mode == "sandbox")
                <option selected value="sandbox">Sandbox</option>
            @else
                <option value="sandbox">Sandbox</option>
            @endif
            @if ($mode == "live")
                <option selected value="live">Live</option>
            @else
                <option value="live">Live</option>  
            @endif
        </select><br>

        <label for="usuariopaypal" class="pt-3 mr-2">Usuario PayPal API: </label>
        <input type="text" name="usuariopaypal" id="usuariopaypal" value="{{$usuariopaypal}}" max="255" required class="w-25"><br>

        <label for="passwordpaypal" class="pt-3 mr-2">Contraseña PayPal API: </label>
        <input type="text" name="passwordpaypal" id="passwordpaypal" value="{{$passwordpaypal}}" max="255" required class="w-25"><br>

        <label for="apisecret" class="pt-3 mr-2">Secret PayPal API: </label>
        <input type="text" name="apisecret" id="apisecret" value="{{$apisecret}}" max="255" required class="w-50"><br>

        <input type="submit" value="Editar Mis Datos" class="btn bg-purple text-white mt-3">
    </form>

@endsection