@extends("layouts.app")
@section("content")

    <div class="row mt-4 d-flex justify-content-center {{$colorSecundario}}">
        <h2>Mi Carrito</h2>
    </div>
    @if(session()->has('message'))
        <div class="alert alert-danger m-3">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row mt-4 d-flex justify-content-center">
        <div class="col-md-10 mx-auto">
            @if (Session::get("carro") != null)
                <table class="table">
                    <tbody>
                        @php
                            $subtotal = 0;
                        @endphp
                        @foreach($productos as $producto)
                            <tr>
                            @php
                                $elementos = DB::table('productos')->where('id','=',$producto[0])->get();
                            @endphp
                            @foreach ($elementos as $elemento)
                                @if ($elemento->imagen == "")
                                    <td><img src="{{url('/img/default.png')}}" alt="Sin imagen" height="150rem"><br></td>
                                @else
                                    <td><img height="150rem" src="{{asset('/img')}}/{{$elemento->imagen}}" alt="{{$elemento->imagen}}"></td>
                                @endif
                                <td class="align-middle"><a class="{{$colorSecundario}} font-weight-bold" href="{{action('ProductosController@detalle' , ['id'=>$elemento->id])}}">{{$elemento->nombre}}</a></td>
                                @if ($producto[3] != null) 
                                    <td class="align-middle {{$colorSecundario}}"><span class="ml-3">Talla: {{$producto[3]}}</span></td>
                                @else
                                    <td class="align-middle {{$colorSecundario}}"><span class="ml-3">Sin talla</span></td>
                                @endif
                                <td class="align-middle {{$colorSecundario}}"><span class="ml-3">Cantidad: {{$producto[1]}}</span></td>
                                <td class="align-middle {{$colorSecundario}}">Precio: {{$producto[2]}}€</td>
                            @endforeach
                            @php
                                $subtotal += $producto[1]*$producto[2]
                            @endphp
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h5 class="text-right mr-5 {{$colorSecundario}}">Total: {{$subtotal}}€</h5>
                <div class="row mt-5 d-flex justify-content-between">
                    <a class="btn {{$botondos}} {{$color}} px-4 py-3" href="{{ action('ProductosController@vaciarCarrito') }}">Vaciar Carrito</a>
                    @if (Auth::user())
                        <a class="btn {{$botonuno}} {{$color}} px-4 py-3" href="{{ action('PedidosController@hacerPedido') }}">Hacer Pedido</a>
                    @else
                        <h5 class="font-weight-bold {{$colorSecundario}}">Inicia sesion para<br>poder hacer un pedido</h5>
                    @endif
                </div>
            @else
                <h5 class="font-weight-bold text-center {{$colorSecundario}}">Tu cesta esta vacía. Solo tienes que añadir productos</h5>
            @endif
        </div>
    </div>
@endsection