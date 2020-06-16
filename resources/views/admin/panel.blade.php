@extends('layouts.admin')
@section('content')

   <div class="row text-center">
      <h2 class="col-md-12">Panel de administración</h2>
   </div>
   @if (!$paypal)
        <div class="alert alert-danger mr-3 mt-2 col-md-12">
            No tienes configurado tu cuenta de Paypal, sin esto los usuarios no podrán hacer compras. Ve a "Mi Cuenta" y agrega tu cuenta.
        </div>
    @endif

   @if (count($productos) == 0)
      <div class="alert alert-warning mr-3 mt-2 col-md-12">
            No tienes ningún producto creado, tus clientes no podrán comprar nada. Ve a "Productos" y crealos.
      </div>
   @endif

   @if (count($categorias) == 0)
      <div class="alert alert-warning mr-3 mt-2 col-md-12">
            No tienes ninguna categoria creada. Ve a "Categorias" y crealas.
      </div>
   @endif
   @if (count($editores) == 0)
      <div class="alert alert-warning mr-3 mt-2 col-md-12">
            No tienes ningun editor. Ve a "Editores" y añadelos. Estos sirven para hacer acciones con los productos.
      </div>
   @endif
   @if (!$logo)
      <div class="alert alert-warning mr-3 mt-2 col-md-12">
            No tienes agregado un logo. Ve a "Apariencia" y añadelo.
      </div>
   @endif

@endsection
