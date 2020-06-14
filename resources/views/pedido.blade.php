@extends("layouts.app")
@section("content")

    <div class="row mt-4 d-flex justify-content-center {{$colorSecundario}}">
        <h2>Datos de envío</h2>
    </div>
    <div class="row d-flex justify-content-center {{$colorSecundario}}">
        <form method="POST" action="{{action('PedidosController@pedido')}}" enctype="multipart/form-data" class="text-center"> 
            {{ csrf_field() }}
            <label for="pais" class="pt-3">País: </label><br>
            @if (Auth::user()->pais != null)
                <input type="text" value="{{Auth::user()->pais}}" style="width: 20rem;" name="pais" id="pais" max="255" required><br>
            @else
                <input type="text" style="width: 20rem;" name="pais" id="pais" max="255" required><br>
            @endif
            <label for="ciudad" class="pt-3">Ciudad: </label><br>
            @if (Auth::user()->ciudad != null)
                <input type="text" value="{{Auth::user()->ciudad}}" style="width: 20rem;" name="ciudad" id="ciudad" max="255" required><br>
            @else
                <input type="text" style="width: 20rem;" name="ciudad" id="ciudad" max="255" required><br>
            @endif
            <label for="direccion" class="pt-3">Dirección: </label><br>
            @if (Auth::user()->direccion != null)
                <input type="text" value="{{Auth::user()->direccion}}" style="width: 20rem;" name="direccion" id="direccion" max="255" required><br>
            @else
                <input type="text" style="width: 20rem;" name="direccion" id="direccion" max="255" required><br>
            @endif
            <input type="submit" value="Hacer pedido" class="btn {{$botonuno}} {{$color}} mt-4">
        </form>
    </div>
@endsection