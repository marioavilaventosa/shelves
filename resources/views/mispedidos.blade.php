@extends("layouts.app")
@section("content")

    <div class="row mt-4 d-flex justify-content-center {{$colorSecundario}}">
        <h2>Mis pedidos</h2>
    </div>
    @if(session()->has('message'))
        <div class="alert alert-success m-3">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row mt-4">
        @if (count($pedidos) == 0)
            <h5 class="font-weight-bold text-center col-md-12 {{$colorSecundario}}">Todavia no has hecho ningún pedido. ¿A qué esperas?</h5>
        @else
            <table class="table col-md-12 text-center {{$colorSecundario}}">
                <thead>
                    <tr>
                        <th>Numero de pedido</th>
                        <th>Productos</th>
                        <th>Precio Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr>
                            <td>{{$pedido->id}}</td>
                            <td> <b>|</b>
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
                            <td>{{$pedido->coste}} €</td>
                            <td>{{$pedido->estado}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection