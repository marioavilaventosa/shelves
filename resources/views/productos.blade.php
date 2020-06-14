@extends("layouts.app")
@section("content")

    @if(session()->has('message'))
        <div class="alert alert-danger m-3">
            {{ session()->get('message') }}
        </div>
    @endif
    @isset ($categoria)
    <div class="row mt-1 pb-3 border-bottom">
        <h5 class="col-md-12 text-center font-weight-bold {{$colorSecundario}}">{{$categoria->nombre}}</h5>
        @isset ($categorias)
            @if (count($categorias) != 0)
                <div class="col-md-12 text-center">
                    @foreach ($categorias as $subcategoria)
                        <span class="badge badge-pill badge-secondary ml-3 mt-3 mr-3 {{$bg}}"><a href="{{action('ProductosController@porcategoria' , ['id'=>$subcategoria->id])}}" class="text-white">{{$subcategoria->nombre}}</a></span>
                    @endforeach 
                </div>
            @endif
        @endisset
    </div>
    @endisset

    <div class="row mt-4">
        @foreach($productos as $producto)
            <div class="card mr-5 ml-5 mb-5 border-0 bg-transparent" style="width: 18rem">
                @if ($producto->imagen == "")
                    <a href="{{action('ProductosController@detalle' , ['id'=>$producto->id])}}"><img src="{{url('/img/default.png')}}" alt="Sin imagen" class="card-img-top"><br></a>
                @else
                    <a href="{{action('ProductosController@detalle' , ['id'=>$producto->id])}}"><img class="card-img-top" src="{{asset('/img')}}/{{$producto->imagen}}" alt="{{$producto->imagen}}"></a>
                @endif
                <div class="card-body pb-0">
                    <h5 class="card-text"><a href="{{action('ProductosController@detalle' , ['id'=>$producto->id])}}" class="{{$colorSecundario}}">{{$producto->nombre}}</a></h5>
                    @if ($producto->stock == 0)
                        <h5 class="card-text font-weight-bold">{{$producto->precio}} € <span class="text-danger px-1">Producto Agotado</span></h5>
                    @elseif ($producto->stock <= 5)
                        <h5 class="card-text font-weight-bold {{$colorSecundario}}">{{$producto->precio}} € <span class="text-danger px-1">¡Quedan pocos!</span></h5>
                    @else
                        <h5 class="card-text font-weight-bold {{$colorSecundario}}">{{$producto->precio}} €</h5>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

@endsection