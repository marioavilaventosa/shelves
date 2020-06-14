@extends('layouts.admin')
@section('content')

    <div class="row">
        <h2 class="col-md-12 text-center">Editar pedido</h2>
    </div>
    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
    <form method="POST" action="{{action('PedidosController@editar')}}" enctype="multipart/form-data" class="col-md-12"> 
        {{ csrf_field() }}
        <label for="id" class="pt-3 font-weight-bold">Nº de pedido: {{$pedidos->id}}</label><br>
        <input type="hidden" name="id" id="id" value="{{$pedidos->id}}">

        <label for="estado" class="pt-3">Estado: </label>
        <select class="form-control form-control-sm w-15" name="estado" id="estado">
            @if ($pedidos->estado == "Pendiente")
                <option selected value="{{$pedidos->estado}}">{{$pedidos->estado}}</option>
            @else
                <option value="Pendiente">Pendiente</option>
            @endif
            @if ($pedidos->estado == "Entregado")
                <option selected value="{{$pedidos->estado}}">{{$pedidos->estado}}</option>
            @else
                <option value="Entregado">Entregado</option>
            @endif
            @if ($pedidos->estado == "En transporte")
                <option selected value="{{$pedidos->estado}}">{{$pedidos->estado}}</option>
            @else
                <option value="En transporte">En transporte</option>
            @endif
            @if ($pedidos->estado == "Cancelado")
                <option selected value="{{$pedidos->estado}}">{{$pedidos->estado}}</option>
            @else
                <option value="Cancelado">Cancelado</option>
            @endif
        </select>
    
        <input type="submit" value="Editar Pedido" class="btn bg-purple text-white mt-4 mb-3">
    </form>


@endsection