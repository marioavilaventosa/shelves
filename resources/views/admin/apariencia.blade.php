@extends('layouts.admin')
@section('content')

    <div class="row">
        <h2 class="col-md-12 text-center">Editar Apariencia</h2>
    </div>
    @if(session()->has('message'))
        <div class="alert alert-success mr-3 mt-2 col-md-12">
            {{ session()->get('message') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="alert alert-danger mr-3 mt-2 col-md-12">
            {{ session()->get('error') }}
        </div>
    @endif
    <form method="POST" action="{{action('ConfiguracionesController@editarapariencia')}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <label for="titulo" class="pt-3">Titulo de la web: </label><br>
        <input type="text" name="titulo" id="titulo" value="{{$titulo->valor}}" max="40" required><br>

        <label for="logoactual" class="pt-3">Logo Actual: </label><br>
        @if ($logo->valor == null)
            <span class="font-weight-bold">Sin Logo</span><br>
        @else
            <img src="{{asset('/img')}}/{{$logo->valor}}" alt="{{$logo->valor}}" class="img-fluid" width="100px" height="50px"><br>
        @endif
        <input type="file" name="logo" id="logo" class="pt-3"><br>
        <a href="{{action('ConfiguracionesController@eliminarlogo')}}" class="text-white btn btn-danger mt-4">Eliminar Logo</a><br>

        <label for="tema" class="pt-4">Tema: </label><br>
        <div class="row justify-content-center">
            <label for="clasico" class="col-md-2">Clasico</label>
            <label for="oscuro" class="col-md-2">Oscuro</label>
            <label for="neon" class="col-md-2">Neon</label>
            <label for="anagrama" class="col-md-2">Anagrama</label>
            <label for="pantera" class="col-md-2">Pantera</label>
        </div>
        <div class="row ml-4">
            @php
                $tema = DB::table('configuraciones')->where('nombre','=','colores')->get()[0]->valor;  
            @endphp
            @if ($tema == "clasico")
                <input checked type="radio" id="clasico" name="tema" value="clasico" class="col-md-2">
            @else
                <input type="radio" id="clasico" name="tema" value="clasico" class="col-md-2">
            @endif
            @if ($tema == "oscuro")
                <input checked type="radio" id="oscuro" name="tema" value="oscuro" class="col-md-2 ml-2">
            @else
                <input type="radio" id="oscuro" name="tema" value="oscuro" class="col-md-2 ml-2">
            @endif
            @if ($tema == "neon")
                <input checked type="radio" id="neon" name="tema" value="neon" class="col-md-2">
            @else
                <input type="radio" id="neon" name="tema" value="neon" class="col-md-2">
            @endif
            @if ($tema == "anagrama")
                <input checked type="radio" id="anagrama" name="tema" value="anagrama" class="col-md-2 ml-4">
            @else
                <input type="radio" id="anagrama" name="tema" value="anagrama" class="col-md-2 ml-4">
            @endif
            @if ($tema == "pantera")
                <input checked type="radio" id="pantera" name="tema" value="pantera" class="col-md-2">
            @else
                <input type="radio" id="pantera" name="tema" value="pantera" class="col-md-2">
            @endif
        </div>
        <div class="row ml-4 mt-4">
            <img src="{{url('/img/clasico.png')}}" alt="Sin imagen" class="img-fluid col-md-2" width="200px">
            <img src="{{url('/img/oscuro.png')}}" alt="Sin imagen" class="img-fluid col-md-2 ml-2" width="200px">
            <img src="{{url('/img/neon.png')}}" alt="Sin imagen" class="img-fluid col-md-2" width="200px">
            <img src="{{url('/img/anagrama.png')}}" alt="Sin imagen" class="img-fluid col-md-2 ml-4" width="200px">
            <img src="{{url('/img/pantera.png')}}" alt="Sin imagen" class="img-fluid col-md-2" width="200px">
        </div>
        <input type="submit" value="Editar Apariencia" class="btn bg-purple text-white mt-5">
    </form>

@endsection