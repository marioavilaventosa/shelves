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

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <h1 class="col-md-12 text-center mt-3">Shelves</h1>

        @if(session()->has('message'))
            <div class="alert alert-danger col-md-6 mx-auto my-3">
                {{ session()->get('message') }}
            </div>
        @endif

        <form method="POST" action="{{action('HomeController@configurar')}}" enctype="multipart/form-data" class="bg-white col-md-6 m-auto"> 
            {{ csrf_field() }}

            <div class="form-group">
            <label for="nombre" class="pt-5">Nombre de la base de datos: </label>
            <input type="text" name="nombre" id="nombre" max="50" required class="mr-3">
            <label for="nombre" class="pt-3">El nombre de la base de datos que vas a usar para Shelves</label><br>
            </div>

            <div class="form-group">
            <label for="usuario" class="pt-3">Nombre de usuario: </label>
            <input type="text" name="usuario" id="usuario" max="50" required class="mr-3">
            <label for="usuario" class="pt-3">El nombre de usuario de la base de datos</label><br>
            </div>

            <div class="form-group">
            <label for="password" class="pt-3">Contraseña: </label>
            <input type="text" name="password" id="password" max="50" required class="mr-3">
            <label for="password" class="pt-3">La contraseña de la base de datos</label><br>
            </div>

            <div class="form-group">
            <label for="servidor" class="pt-3">Servidor: </label>
            <input type="text" name="servidor" id="servidor" value="localhost" max="50" required class="mr-3">
            <label for="servidor" class="pt-3">Servidor de la base de datos</label><br>
            </div>

            <div class="form-group">
            <label for="puerto" class="pt-3">Puerto: </label>
            <input type="number" name="puerto" id="puerto" min="1" max="65535" required class="mr-3">
            <label for="puerto" class="pt-3">Puerto de la base de datos</label><br>
            </div>

            <div class="form-group">
            <label for="web" class="pt-3">Nombre de la web: </label>
            <input type="text" name="web" id="web" max="50" required class="mr-3">
            <label for="web" class="pt-3">Nombre del sitio web</label><br>
            </div>

            <div class="form-group">
            <label for="name" class="pt-3">Nombre: </label>
            <input type="text" name="name" id="name" max="50" required class="mr-3">
            <label for="name" class="pt-3">Su nombre</label><br>
            </div>

            <div class="form-group">
            <label for="apellidos" class="pt-3">Apellidos: </label>
            <input type="text" name="apellidos" id="apellidos" max="50" required class="mr-3">
            <label for="apellidos" class="pt-3">Sus apellidos</label><br>
            </div>

            <div class="form-group">
            <label for="passwordweb" class="pt-3">Contraseña web: </label>
            <input type="text" name="passwordweb" id="passwordweb" max="50" required class="mr-3">
            <label for="passwordweb" class="pt-3">La contraseña de la web</label><br>
            </div>

            <div class="form-group">
            <label for="email" class="pt-3">Email: </label>
            <input type="email" name="email" id="email" max="50" required class="mr-3">
            <label for="email" class="pt-3">Correo para la web</label><br>
            </div>
            
            <input type="submit" value="Enviar" class="btn bg-purple text-white mt-3 mb-3">
        </form>
    </div>
</body>
</html>