<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="jquery-3.5.1.min.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    @php
        $titulo = DB::table('configuraciones')->where('nombre','=','titulo')->get()[0]->valor;
        $logo = DB::table('configuraciones')->where('nombre','=','logo')->get()[0]->valor;
        $categorias = DB::table('categorias')->get();
    @endphp
</head>
<body class="{{$fondo}}">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light {{$bgSecundario}} shadow-sm d-flex justify-content-center">
            <a class="navbar-brand d-flex" href="{{ url('/') }}">
                @if ($logo != null && $logo != "")
                    <img src="{{asset('/img')}}/{{$logo}}" alt="{{$logo}}" class=" mr-3" width="50px" height="50px">
                @endif        
                <h1 class="mt-2">{{$titulo}}</h1>
            </a>
        </nav>
        <div class="container-fluid">
            <div class="row {{$bg}} {{$color}}">
                <nav class="navbar navbar-expand-md {{$bg}} col-md-10 mt-2 pl-5">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            @foreach ($categorias as $categoria)
                                @php
                                    $categoriassuperiores = DB::table('categorias')->where('catsuperior','=',$categoria->id)->get();
                                @endphp
                                @if ($categoria->catsuperior == "" && count($categoriassuperiores) == 0)
                                    <li class="nav-item active ml-4 mr-4">
                                        <a class="nav-link {{$colorTerciario}}" href="{{action('ProductosController@porcategoria' , ['id'=>$categoria->id])}}">{{$categoria->nombre}}</a>
                                    </li>
                                @elseif (count($categoriassuperiores) != 0)
                                    <li class="nav-item dropdown ml-4 mr-4">
                                        <a class="nav-link dropdown-toggle active {{$colorTerciario}}" href="{{action('ProductosController@porcategoria' , ['id'=>$categoria->id])}}" id="navbarDropdownMenuLink">{{$categoria->nombre}}</a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                            @foreach ($categoriassuperiores as $categoriasuperior)
                                                <li><a class="dropdown-item text-dark" href="{{action('ProductosController@porcategoria' , ['id'=>$categoriasuperior->id])}}">{{$categoriasuperior->nombre}}</a></li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif                       
                            @endforeach
                        </ul>
                    </div>
                </nav>
                <ul class="col-md-2 list-inline pl-10 opciones pt-3">
                    @guest
                        <li class="nav-item dropdown list-inline-item mr-0 w-25">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle {{$color}} pr-0 ml-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if ($bgSecundario == "bg-dark")
                                    <img src="{{url('/img/usuarioDark.png')}}" alt="" class="img-fluid" width="100%">
                                @else
                                    <img src="{{url('/img/usuario.png')}}" alt="" class="img-fluid" width="100%">
                                @endif 
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a>
                                @if (Route::has('register'))
                                    <a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            </div>
                        </li>
                    @else
                        <li class="nav-item dropdown list-inline-item mr-0 w-25">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle {{$color}} pr-0 ml-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @if ($bgSecundario == "bg-dark")
                                    <img src="{{url('/img/usuarioDark.png')}}" alt="" class="img-fluid" width="100%">
                                @else
                                    <img src="{{url('/img/usuario.png')}}" alt="" class="img-fluid" width="100%">
                                @endif 
                            </a>

                            <div class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="navbarDropdown">
                                <span class="font-weight-bold font-italic">Bienvenido {{ Auth::user()->name }}</span>
                                <a class="dropdown-item" href="{{ action('PedidosController@mispedidos') }}">Mis pedidos</a>
                                <a class="dropdown-item" href="{{ action('UsuariosController@misdatosform') }}">Mis datos</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                    <li class="nav-item dropdown list-inline-item mr-0 w-25">
                        <a id="navbarDropdown {{$bgSecundario}}" class="nav-link dropdown-toggle {{$color}} pr-0 ml-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @if ($bgSecundario == "bg-dark")
                                <img src="{{url('/img/carritoDark.png')}}" alt="" class="" width="120%">
                            @else
                                <img src="{{url('/img/carrito.png')}}" alt="" class="" width="120%">
                            @endif
                        </a>
                        @if (Session::get('carro') == null)
                            <div class="dropdown-menu dropdown-menu-right text-center pt-4 pb-4" aria-labelledby="navbarDropdown">
                                <span class="font-weight-bold">Cesta vacia</span>
                            </div>
                        @else
                            <div class="dropdown-menu dropdown-menu-right text-center" style="width: 20rem !important " aria-labelledby="navbarDropdown">
                                @php
                                    $subtotal = 0;
                                @endphp
                                @foreach (Session::get('carro') as $id)
                                    @php
                                        $productos = DB::table('productos')->where('id','=',$id)->get();
                                    @endphp
                                    @foreach ($productos as $producto)
                                        <div class="row pt-3">
                                            @if ($producto->imagen == "")
                                                <img src="{{url('/img/default.png')}}" alt="Sin imagen" class="col-md-6 h-25 w-25"><br>
                                            @else
                                                <img class="col-md-6 h-25 w-25" src="{{asset('/img')}}/{{$producto->imagen}}" alt="{{$producto->imagen}}">
                                            @endif
                                            <div class="col-md-6 m-auto">
                                                <div class="d-flex flex-column text-center">
                                                    <a class="text-dark font-size-13" style="text-decoration: none" href="">{{$producto->nombre}}</a>
                                                    @if ($id[3] != null) 
                                                        <span class="font-size-10 pt-2 font-weight-bold">Talla: {{$id[3]}}</span>
                                                    @endif
                                                    <span class="font-size-10 pt-2 font-weight-bold">Cantidad: {{$id[1]}}</span>
                                                    @if ($id[3] == null )
                                                        <a class="text-right mr-3" href="{{ action('ProductosController@eliminarCarrito' , ['producto'=>$producto->id,'talla'=>0]) }}"><img src="{{url('/img/basura.png')}}" alt="Borrar producto" height="15rem" width="15rem"></a>
                                                    @else
                                                        <a class="text-right mr-3" href="{{ action('ProductosController@eliminarCarrito' , ['producto'=>$producto->id,'talla'=>$id[3]]) }}"><img src="{{url('/img/basura.png')}}" alt="Borrar producto" height="15rem" width="15rem"></a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $subtotal += $id[1]*$id[2];
                                        @endphp
                                    @endforeach
                                @endforeach
                                @if (Session::get('carro') != null)
                                <div class="row mt-3 py-2 mx-2">
                                        <span class="col-md-12">Subtotal: {{$subtotal}}€</span>
                                    </div>
                                    <div class="row mt-3 py-2 mx-2">
                                        <a href="{{ action('ProductosController@carrito') }}" class="col-md-12 btn {{$botonuno}} {{$color}}">Hacer pedido</a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </li>
                </ul>
            </div>
        </div>

        <main class="py-4 mr-5 ml-5">
            @yield('content')
        </main>
    </div>
</body>
</html>
