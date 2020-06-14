@extends("layouts.admin")
@section("content")

    <div class="row mt-4 d-flex justify-content-center">
        <h2>Todos los pedidos</h2>
    </div>
    <div class="row mt-4 ml-2 mr-2">
        @if (count($pedidos) == 0)
            <h5 class="font-weight-bold text-center col-md-12">Todavia no hay ningun pedido realizado</h5>
        @else
            <table class="table col-md-12 text-center">
                <thead>
                    <tr class="d-flex">
                        <th class="col-1">Numero de pedido</th>
                        <th class=col-3>Productos</th>
                        <th class="col-1">Precio Total</th>
                        <th class="col-1">Estado</th>
                        <th class="col-2">Cliente</th>
                        <th class="col-3">Direccion de envio</th>
                        <th class="col-1">Opcion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr class="d-flex">
                            <td class="col-1">{{$pedido->id}}</td>
                            <td class=col-3> <b>|</b>
                                @php
                                    $lineaspedido = DB::table('lineaspedido')->where('pedidos_id','=',$pedido->id)->get();
                                @endphp
                                @foreach ($lineaspedido as $linea)
                                    @php
                                        $producto = DB::table('productos')->where('id','=',$linea->productos_id)->get();
                                    @endphp
                                    {{$producto[0]->nombre}} -
                                    @if ($linea->unidades == 1) 
                                        {{$linea->unidades}} Unidad
                                    @else
                                        {{$linea->unidades}} Unidades
                                    @endif
                                    @if ($linea->talla != "0") 
                                        - Talla {{$linea->talla}}
                                    @endif
                                    <b>|</b>
                                @endforeach
                            </td>
                            <td class="col-1">{{$pedido->coste}} €</td>
                            <td class="col-1">{{$pedido->estado}}</td>
                            @php
                                $usuario = DB::table('users')->where('id','=',$pedido->usuarios_id)->get();
                            @endphp
                            <td class="col-2">{{ $usuario[0]->name }} {{ $usuario[0]->apellidos }}</td>
                            <td class="col-3">{{ $usuario[0]->pais }}, {{  $usuario[0]->ciudad }}, {{  $usuario[0]->direccion }}</td>
                            <td class="col-1"><a href="{{action('PedidosController@formeditar' , ['id'=>$pedido->id])}}" class="btn bg-purple text-white py-2">Cambiar Estado</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection