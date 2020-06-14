@extends('layouts.admin')
@section('content')

    <div class="row">
        <h2 class="col-md-10 text-center">Productos</h2>
    </div>
    <div class="row">
        <p class="col-md-10">
            <span class="font-weight-bold">Filtrar por:</span>
        @if (empty($categoria_actual))
            <span>Todos</span>
        @else
            <a href="{{ action('ProductosController@index' , ['id'=>0]) }}">Todos</a>
        @endif
        @foreach ($categorias as $categoria)
            @if (!empty($categoria_actual) && $categoria_actual->nombre == $categoria->nombre)
                <span>- {{$categoria->nombre}}</span>
            @else
                - <a href="{{ action('ProductosController@index' , ['id'=>$categoria->id]) }}">{{$categoria->nombre}}</a>
            @endif
        @endforeach
        </p>
        <a href="{{ action('ProductosController@formanadir') }}" class="text-center text-white btn bg-green ml-5 pt-2 mb-4">Añadir Producto</a>
    </div>
    @if (count($productos) == 0)
            <h5 class="font-weight-bold text-center col-md-10">Todavia no hay ningun producto creado</h5>
    @else
        <table class="table border-top-0">
            <thead>
                <tr>
                <th class="col-md-2">Nombre</th>
                <th class="col-md-1">Categoria</th>
                <th class="col-md-1">Precio</th>
                <th class="col-md-1">Stock</th>
                <th class="col-md-1" style="padding-left: 0 !important; padding-right: 0 !important">Oferta</th>
                <th class="col-md-2" style="padding-left: 0 !important;">Imagen</th>
                <th class="col-md-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
            @foreach($productos as $key => $producto)
                <tr>
                    <td class="col-md-2 align-middle">{{$producto->nombre}}</td>
                    @php
                        $nombreCategorias = DB::table('categorias')->where('id','=',$producto->categorias_id)->get();
                    @endphp
                    <td class="col-md-1 align-middle">{{$nombreCategorias[0]->nombre}}</td>
                    <td class="col-md-1 align-middle">{{$producto->precio}}</td>
                    <td class="col-md-1 align-middle">
                    @foreach(explode('/',$producto->stock) as $row)
                        {{ $row }}
                        @break
                    @endforeach
                    </td>
                    <td class="col-md-1 align-middle" style="padding-left: 0 !important; padding-right: 0 !important">{{$producto->oferta}}</td>
                    @if ($producto->imagen == "")
                        <td class="col-md-2" style="padding-left: 0 !important;"><img src="{{url('/img/default.png')}}" alt="Sin imagen" class="img-fluid" width="100px" height="50px"></td>
                    @else
                        <td class="col-md-2" style="padding-left: 0 !important;"><img src="{{asset('/img')}}/{{$producto->imagen}}" alt="{{$producto->imagen}}" class="img-fluid" width="100px" height="50px"></td>
                    @endif
                    <td class="col-md-3 align-middle"><a href="{{ action('ProductosController@formeditar' , ['id'=>$producto->id]) }}" class="btn bg-purple text-white mb-3 mr-5">Modificar</a> 
                    <a href="{{ action('ProductosController@eliminar' , ['id'=>$producto->id]) }}" class="btn btn-danger text-white">Eliminar</a></td>
                </tr>
            @endforeach
    @endif

    </tbody>
    </table>
@endsection