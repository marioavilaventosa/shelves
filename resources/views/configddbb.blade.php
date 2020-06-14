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

        <form method="POST" action="{{action('HomeController@configurarbbdd')}}" enctype="multipart/form-data" class="bg-white col-md-6 m-auto"> 
            {{ csrf_field() }}

            <h3 class="font-weight-bold pt-3">¿Estas seguro que estos son tus datos?</h3>

            <div class="form-group">
            <label for="nombre" class="pt-5">Nombre de la base de datos: </label>
            <span class="mr-3 text-dark font-weight-bold">{{$nombre}}</span>
            <input type="hidden" name="nombre" id="nombre" max="50" value="{{$nombre}}" class="mr-3 text-dark">
            </div>

            <div class="form-group">
            <label for="usuario" class="pt-3">Nombre de usuario: </label>
            <span class="mr-3 text-dark font-weight-bold">{{$usuario}}</span>
            <input type="hidden" name="usuario" id="usuario" max="50" value="{{$usuario}}" class="mr-3 text-dark">
            </div>

            <div class="form-group">
            <label for="password" class="pt-3">Contraseña: </label>
            <span class="mr-3 text-dark font-weight-bold">{{$password}}</span>
            <input type="hidden" name="password" id="password" max="50" value="{{$password}}" class="mr-3 text-dark">
            </div>

            <div class="form-group">
            <label for="servidor" class="pt-3">Servidor: </label>
            <span class="mr-3 text-dark font-weight-bold">{{$servidor}}</span>
            <input type="hidden" name="servidor" id="servidor" value="localhost" max="50" value="{{$servidor}}" class="mr-3 text-dark">
            </div>

            <div class="form-group">
            <label for="puerto" class="pt-3">Puerto: </label>
            <span class="mr-3 text-dark font-weight-bold">{{$puerto}}</span>
            <input type="hidden" name="puerto" id="puerto" min="1" max="65535" value="{{$puerto}}" class="mr-3 text-dark">
            </div>

            <div class="form-group">
            <label for="web" class="pt-3">Nombre de la web: </label>
            <span class="mr-3 text-dark font-weight-bold">{{$web}}</span>
            <input type="hidden" name="web" id="web" max="50" value="{{$web}}" class="mr-3 text-dark">
            </div>

            <div class="form-group">
            <label for="name" class="pt-3">Nombre: </label>
            <span class="mr-3 text-dark font-weight-bold">{{$name}}</span>
            <input type="hidden" name="name" id="name" max="50" value="{{$name}}" class="mr-3 text-dark">
            </div>

            <div class="form-group">
            <label for="apellidos" class="pt-3">Apellidos: </label>
            <span class="mr-3 text-dark font-weight-bold">{{$apellidos}}</span>
            <input type="hidden" name="apellidos" id="apellidos" max="50" value="{{$apellidos}}" class="mr-3 text-dark">
            </div>

            <div class="form-group">
            <label for="passwordweb" class="pt-3">Contraseña web: </label>
            <span class="mr-3 text-dark font-weight-bold">{{$passwordweb}}</span>
            <input type="hidden" name="passwordweb" id="passwordweb" max="50" value="{{$passwordweb}}" class="mr-3 text-dark">
            </div>

            <div class="form-group">
            <label for="email" class="pt-3">Email: </label>
            <span class="mr-3 text-dark font-weight-bold">{{$email}}</span>
            <input type="hidden" name="email" id="email" max="50" value="{{$email}}" class="mr-3 text-dark">
            </div>
            
            <input type="submit" value="Enviar" class="btn bg-purple text-white mt-3 mb-3">
        </form>
    </div>
</body>
</html>