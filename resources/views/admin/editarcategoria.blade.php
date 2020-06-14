@extends('layouts.admin')
@section('content')

    <div class="row">
        <h2 class="col-md-12 text-center">Editar categoria</h2>
    </div>
    @if(session()->has('message'))
        <div class="alert alert-danger m-3">
            {{ session()->get('message') }}
        </div>
    @endif
    <form method="POST" action="{{action('CategoriasController@editar')}}">
        {{ csrf_field() }}
        <input type="hidden" name="id" id="id" value="{{$categorias->id}}">
        <label for="nombre" class="pt-3">Nombre: </label><br>
        <input type="text" name="nombre" id="nombre" value="{{$categorias->nombre}}" max="40" required><br>
        <label for="catsuperior" class="pt-3">Categoria Superior: </label><br>
        @php
        $nombreCategorias = DB::table('categorias')->select('id','nombre')->where('id','not like',$categorias->id)->get();
        @endphp

        <select class="form-control form-control-sm w-15" id="catsuperior" name="catsuperior">
            @if ($categorias->id == "")
                <option selected="selected" value="0">-</option>        
            @else
                <option value="0">-</option>    
            @endif
            @foreach ($nombreCategorias as $categoria)
                @if ($categorias->catsuperior == $categoria->id)
                    <option selected="selected" value="{{$categoria->id}}">{{$categoria->nombre}}</option>        
                @else
                    <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>        
                @endif
            @endforeach
        </select><br>

        <input type="submit" value="Editar Categoria" class="btn bg-purple text-white mt-3">
    </form>

@endsection