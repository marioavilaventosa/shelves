@extends('layouts.admin')
@section('content')

    <div class="row">
        <h2 class="col-md-12 text-center">Añadir producto</h2>
    </div>
    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
    <form method="POST" action="{{action('ProductosController@anadir')}}" enctype="multipart/form-data"> 
        {{ csrf_field() }}
        <input type="hidden" name="id" id="id">
        <label for="nombre" class="pt-3">Nombre: </label><br>
        <input type="text" name="nombre" id="nombre" max="100" required><br>
        <label for="categoria" class="pt-3">Categoria: </label><br>
        @php
            $categorias = DB::table('categorias')->get();
        @endphp
        <select class="form-control form-control-sm w-15" name="categoria" id="categoria">
            @foreach ($categorias as $categoria)
                <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
            @endforeach
        </select>
        <label for="descripcion" class="pt-3">Descripción: </label><br>
        <textarea name="descripcion" id="descripcion" cols="50" rows="5" max="500" required></textarea><br>
        <label for="precio" class="pt-3">Precio: </label><br>
        <input type="number" name="precio" id="precio" step=".01" min="0" max="9999999" required><br>
        <label for="stock" class="pt-3">Stock: </label><br>
        <input type="number" name="stock" id="stock" min="1" max="99999999999" required><br>
        <label for="tallas" class="pt-3">Tallas: </label><br>
        <select name="tallas" id="tallas">
            <option value="-">-</option>
            <option value="ropa">Ropa</option>
            <option value="zapatos">Zapatos</option>
        </select>
        <div class="tallas">
        </div>
        <script>
            $('select').on('change', function() {
                if ( this.value == "ropa" ){
                    $( "div.tallas" ).html('<label for="unidades" class="pt-3">Unidades :</label><br></label><label for="xs" class="pt-3 ml-2 mr-2 font-weight-bold">XS</label><input type="number" name="xs" min="0" id="xs" value="0" class="col-1"><label for="s" class="pt-3 ml-2 mr-2 font-weight-bold">S</label><input type="number" name="s" min="0" id="s" value="0" class="col-1"><label for="m" class="pt-3 ml-2 mr-2 font-weight-bold">M</label><input type="number" name="m" min="0" id="m" value="0" class="col-1"><label for="l" class="pt-3 ml-2 mr-2 font-weight-bold">L</label><input type="number" name="l" min="0" id="l" value="0" class="col-1"><label for="xl" class="pt-3 ml-2 mr-2 font-weight-bold">XL</label><input type="number" name="xl" min="0" id="xl" value="0" class="col-1"><label for="xxl" class="pt-3 ml-2 mr-2 font-weight-bold">XXL</label><input type="number" name="xxl" min="0" id="xxl" value="0" class="col-1"><label for="xxxl" class="pt-3 ml-2 mr-2 font-weight-bold">XXXL</label><input type="number" name="xxxl" min="0" id="xxxl" value="0" class="col-1"><br><span class="text-dark" style="font-size: 12px">La cantidad de stock debe de ser igual que la suma de todas las tallas.</span>')
                }else if(this.value =="zapatos") {
                    $("div.tallas").html('<label for="unidades" class="pt-3">Unidades :</label><br><label for="36" class="pt-3 ml-2 mr-2 font-weight-bold">36</label><input type="number" name="36" min="0" id="36" value="0" class="col-1"><label for="37" class="pt-3 ml-2 mr-2 font-weight-bold">37</label><input type="number" name="37" min="0" id="37" value="0" class="col-1"><label for="38" class="pt-3 ml-2 mr-2 font-weight-bold">38</label><input type="number" name="38" min="0" id="38" value="0" class="col-1"><label for="39" class="pt-3 ml-2 mr-2 font-weight-bold">39</label><input type="number" name="39" min="0" id="39" value="0" class="col-1"><label for="40" class="pt-3 ml-2 mr-2 font-weight-bold">40</label><input type="number" name="40" min="0" id="40" value="0" class="col-1"><label for="41" class="pt-3 ml-2 mr-2 font-weight-bold">41</label><input type="number" name="41" min="0" id="41" value="0" class="col-1"><label for="42" class="pt-3 ml-2 mr-2 font-weight-bold">42</label><input type="number" name="42" min="0" id="42" value="0" class="col-1"><label for="43" class="pt-3 ml-2 mr-2 font-weight-bold">43</label><input type="number" name="43" min="0" id="43" value="0" class="col-1"><label for="44" class="pt-3 ml-2 mr-2 font-weight-bold">44</label><input type="number" name="44" min="0" id="44" value="0" class="col-1"><label for="45" class="pt-3 ml-2 mr-2 font-weight-bold">45</label><input type="number" name="45" min="0" id="45" value="0" class="col-1"><label for="46" class="pt-3 ml-2 mr-2 font-weight-bold">46</label><input type="number" name="46" min="0" id="46" value="0" class="col-1"><label for="47" class="pt-3 ml-2 mr-2 font-weight-bold">47</label><input type="number" name="47" min="0" id="47" value="0" class="col-1"><label for="48" class="pt-3 ml-2 mr-2 font-weight-bold">48</label><input type="number" name="48" min="0" id="48" value="0" class="col-1"><br><span class="text-dark" style="font-size: 12px">La cantidad de stock debe de ser igual que la suma de todas las tallas.</span>');
                }else {
                    $( "div.tallas" ).html("")
                }
            })
        </script>
        <label for="oferta" class="pt-3">Oferta: </label><br>
        <input type="number" name="oferta" id="oferta"  min="0" max="100" required><br>
        <span class="text-secondary" style="font-size: 12px">Si tiene un porcentaje de oferta introduce el precio con la oferta ya aplicada.</span><br>
        <label for="imagen" class="pt-3">Imagen:</label><br>
        <input type="file" name="imagen" id="imagen" class="pt-3"><br>
        <input type="submit" value="Añadir Producto" class="btn bg-purple text-white mt-3 mb-3">
    </form>

@endsection