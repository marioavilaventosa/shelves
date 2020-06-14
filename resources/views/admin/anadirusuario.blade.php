@extends('layouts.admin')
@section('content')


    <div class="row pb-4">
        <h2 class="col-md-12 text-center">Añadir editor</h2>
    </div>

    <form class="pr-5" method="POST" action="{{ action('UsuariosController@anadir') }}">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
            </div>
        </div>

        <div class="form-group row">
            <label for="apellidos" class="col-md-4 col-form-label text-md-right">{{ __('Apellidos') }}</label>
            <div class="col-md-6">
                <input id="apellidos" type="text" class="form-control @error('name') is-invalid @enderror" name="apellidos" value="{{ old('name') }}" required autocomplete="name" autofocus>
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
            <div class="col-md-6">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">
                <span class="text-secondary" style="font-size: 12px">La contraseña debe tener como mínimo 8 caracteres, mayúsculas, minúsculas y numero o caracter especial.</span>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn bg-green text-white">Crear editor</button>
            </div>
        </div>
    </form>

@endsection