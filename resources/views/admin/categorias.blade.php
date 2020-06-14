@extends('layouts.admin')
@section('content')

    <div class="row">
        <h2 class="col-md-12 text-center">Categorias</h2>
    </div>
        <form class="form-inline pb-4 pt-3" method="POST" action="{{action('CategoriasController@anadir')}}">
            {{ csrf_field() }}
            <label for="nombre" class="mr-2">Nombre: </label>
            <input type="text" name="nombre" id="nombre" max="40" required><br>
            @php
                $nombreCategorias = DB::table('categorias')->select('id','nombre')->get();
            @endphp
            <label for="catsuperior" class="ml-4 mr-2">Categoria superior: </label>
            <select id="catsuperior" name="catsuperior" class="form-control form-control-sm">
                <option selected="selected" value="0">-</option>
                @foreach ($nombreCategorias as $categoria)
                    <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>        
                @endforeach
            </select>
            <input type="submit" value="Crear Categoria" class="btn bg-green text-white ml-5">
        </form>
        <span class="text-secondary text-dark ml-3" style="font-size: 12px">* Las categorias pueden tener como maximo dos niveles *</span>
        @if(session()->has('message'))
            <div class="alert alert-danger m-3">
                {{ session()->get('message') }}
            </div>
        @endif
    @if (count($categorias) == 0)
        <h5 class="font-weight-bold text-center col-md-12 mt-2">Todavia no hay ninguna categoria creada</h5>
    @else
        <table class="table border-top-0 mt-3">
            <thead>
                <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Categoria superior</th>
                <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($categorias as $key => $categoria)
                <tr>
                    <td class="col-md-4">{{$categoria->nombre}}</td>
                    @if ($categoria->catsuperior == "")
                    <td class="col-md-4">-</td>
                    @else
                    @php
                    $categorias = DB::table('categorias')->select('categorias.nombre')->where('id', $categoria->catsuperior)->get();
                    @endphp
                    <td class="col-md-4">{{$categorias[0]->nombre}}</td>
                    @endif
                    <td class="col-md-4"><a href="{{action('CategoriasController@formeditar' , ['id'=>$categoria->id])}}" class="btn bg-purple text-white">Modificar</a> 
                    <a href="{{action('CategoriasController@eliminar' , ['id'=>$categoria->id])}}" class="btn btn-danger text-white">Eliminar</a></td>
                </tr>
            @endforeach

        </tbody>
        </table>
    @endif
@endsection