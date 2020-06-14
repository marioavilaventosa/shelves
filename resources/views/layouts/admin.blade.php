<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shelves</title>

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
</head>
<body>
    <div class="container-fluid h-100">
        <div class="row pt-3 pb-3 bg-purple text-white">
            <div class="col-md-4">
                <a href="{{ url('/') }}" class="ml-4 text-white">Ver la página</a>
            </div>
            <div class="col-md-4 text-center">
                <h4><a href="{{action('HomeController@panel')}}" class="text-white"><img src="{{url('/img/logo.png')}}" alt="" class="img-fluid logo">Shelves</a></h4>
            </div>
            <div class="col-md-4 text-right">
                <a href="{{ url('/logout') }}" class="mr-4 text-white">Salir</a>
            </div>
        </div>      
        <div class="row h-100">
            <div class="col-md-2 border-right border-dark pt-4">
                <h3 class="border-bottom border-dark">Gestión</h3>
                <a href="{{ action('PedidosController@todospedidos') }}" class="d-block text-dark">Pedidos</a>
                <a href="{{ action('CategoriasController@index') }}" class="d-block text-dark">Categorías</a>
                <a href="{{ action('ProductosController@index', ['id'=>0]) }}" class="d-block text-dark">Productos</a>
                <a href="{{ action('UsuariosController@editores') }}" class="d-block text-dark">Editores</a>
                <a href="{{ action('UsuariosController@index') }}" class="d-block text-dark">Usuarios</a>
                <h3 class="border-bottom border-dark pt-2">Configuración</h3>
                <a href="{{ action('ConfiguracionesController@apariencia') }}" class="d-block text-dark">Apariencia</a>
                <a href="{{ action('ConfiguracionesController@index') }}" class="d-block text-dark">Mi cuenta</a>
            </div>
            <div class="col-md-10 pt-4">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
