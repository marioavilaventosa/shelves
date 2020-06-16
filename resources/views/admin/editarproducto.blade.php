@extends('layouts.admin')
@section('content')

    <div class="row">
        <h2 class="col-md-12 text-center">Editar producto</h2>
    </div>
    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif
    <form method="POST" action="{{action('ProductosController@editar')}}" enctype="multipart/form-data"> 
        {{ csrf_field() }}
        <input type="hidden" name="id" id="id" value="{{$productos->id}}">
        <label for="nombre" class="pt-3">Nombre: </label><br>
        <input type="text" name="nombre" id="nombre" value="{{$productos->nombre}}" max="100" required><br>
        <label for="categoria" class="pt-3">Categoria: </label><br>
        @php
            $nombreCategoria = DB::table('categorias')->where('id','=',$productos->categorias_id)->get();
            $categorias = DB::table('categorias')->get();
        @endphp
        <select class="form-control form-control-sm w-15" name="categoria" id="categoria">
            @foreach ($categorias as $categoria)
                @if ($categoria->nombre == $nombreCategoria[0]->nombre)
                    <option selected value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                @else
                    <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                @endif
            @endforeach
        </select>
        <label for="descripcion" class="pt-3">Descripción: </label><br>
        <textarea name="descripcion" id="descripcion" cols="50" rows="5" max="500" required>{{$productos->descripcion}}</textarea><br>
        <label for="precio" class="pt-3">Precio: </label><br>
        <input type="number" name="precio" id="precio" value="{{$productos->precio}}" step=".01" min="0" max="9999999" required><br>
        <label for="stock" class="pt-3">Stock: </label><br>
        <input type="number" name="stock" id="stock" value="{{explode('/',$productos->stock)[0]}}" min="0" max="99999999999" required><br>
        <label for="tallas" class="pt-3">Tallas: </label><br>
        <select name="tallas" id="tallas">
            <option value="-">-</option>
            @if (strpos($productos->stock, 'XS') !== false || strpos($productos->stock, 'S') !== false || strpos($productos->stock, 'M') !== false || strpos($productos->stock, 'L') !== false || strpos($productos->stock, 'XL') !== false || strpos($productos->stock, 'XXL') !== false || strpos($productos->stock, 'XXXL') !== false)
                <option selected value="ropa">Ropa</option>
            @else 
                <option value="ropa">Ropa</option>
            @endif
            @if (strpos($productos->stock, '36') !== false || strpos($productos->stock, '37') !== false || strpos($productos->stock, '38') !== false || strpos($productos->stock, '39') !== false || strpos($productos->stock, '40') !== false || strpos($productos->stock, '41') !== false || strpos($productos->stock, '42') !== false || strpos($productos->stock, '43') !== false || strpos($productos->stock, '44') !== false || strpos($productos->stock, '45') !== false || strpos($productos->stock, '46') !== false || strpos($productos->stock, '47') !== false || strpos($productos->stock, '48') !== false)
                <option selected value="zapatos">Zapatos</option>
            @else
                <option value="zapatos">Zapatos</option>
            @endif
        </select>
        <div class="tallas">
            @if (strpos($productos->stock, 'XS') !== false || strpos($productos->stock, 'S') !== false || strpos($productos->stock, 'M') !== false || strpos($productos->stock, 'L') !== false || strpos($productos->stock, 'XL') !== false || strpos($productos->stock, 'XXL') !== false || strpos($productos->stock, 'XXXL') !== false)
                <label for="unidades" class="pt-3">Unidades :</label><br>
                <label for="xs" class="pt-3 ml-2 mr-2 font-weight-bold">XS</label>
                @if (strpos($productos->stock, 'XS') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "XS")
                            <input type="number" name="xs" min="0" id="xs" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="xs" min="0" id="xs" value="0" class="col-1">
                @endif
                <label for="s" class="pt-3 ml-2 mr-2 font-weight-bold">S</label>
                @if (strpos($productos->stock, 'S') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "S")
                            <input type="number" name="s" min="0" id="s" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="s" min="0" id="s" value="0" class="col-1">
                @endif
                <label for="m" class="pt-3 ml-2 mr-2 font-weight-bold">M</label>
                @if (strpos($productos->stock, 'M') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "M")
                            <input type="number" name="m" min="0" id="m" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="m" min="0" id="m" value="0" class="col-1">
                @endif
                <label for="l" class="pt-3 ml-2 mr-2 font-weight-bold">L</label>
                @if (strpos($productos->stock, 'L') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "L")
                            <input type="number" name="l" min="0" id="l" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="l" min="0" id="l" value="0" class="col-1">
                @endif
                <label for="xl" class="pt-3 ml-2 mr-2 font-weight-bold">XL</label>
                @if (strpos($productos->stock, 'XL') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "XL")
                            <input type="number" name="xl" min="0" id="xl" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="xl" min="0" id="xl" value="0" class="col-1">
                @endif
                <label for="xxl" class="pt-3 ml-2 mr-2 font-weight-bold">XXL</label>
                @if (strpos($productos->stock, 'XXL') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "XXL")
                            <input type="number" name="xxl" min="0" id="xxl" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="xxl" min="0" id="xxl" value="0" class="col-1">
                @endif
                <label for="xxxl" class="pt-3 ml-2 mr-2 font-weight-bold">XXXL</label>
                @if (strpos($productos->stock, 'XXXL') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "XXXL")
                            <input type="number" name="xxxl" min="0" id="xxxl" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="xxxl" min="0" id="xxxl" value="0" class="col-1">
                @endif
                <br><span class="text-dark" style="font-size: 12px">La cantidad de stock debe de ser igual que la suma de todas las tallas.</span>
            @endif 
            @if (strpos($productos->stock, '36t') !== false || strpos($productos->stock, '37t') !== false || strpos($productos->stock, '38t') !== false || strpos($productos->stock, '39t') !== false || strpos($productos->stock, '40t') !== false || strpos($productos->stock, '41t') !== false || strpos($productos->stock, '42t') !== false || strpos($productos->stock, '43t') !== false || strpos($productos->stock, '44t') !== false || strpos($productos->stock, '45t') !== false || strpos($productos->stock, '46t') !== false || strpos($productos->stock, '47t') !== false || strpos($productos->stock, '48t') !== false)
                <label for="unidades" class="pt-3">Unidades :</label><br>
                <label for="36" class="pt-3 ml-2 mr-2 font-weight-bold">36</label>
                @if (strpos($productos->stock, '36t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "36t")
                            <input type="number" name="36" min="0" id="36" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="36" min="0" id="36" value="0" class="col-1">
                @endif
                <label for="37" class="pt-3 ml-2 mr-2 font-weight-bold">37</label>
                @if (strpos($productos->stock, '37t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "37t")
                            <input type="number" name="37" min="0" id="37" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="37" min="0" id="37" value="0" class="col-1">
                @endif
                <label for="38" class="pt-3 ml-2 mr-2 font-weight-bold">38</label>
                @if (strpos($productos->stock, '38t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "38t")
                            <input type="number" name="38" min="0" id="38" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="38" min="0" id="38" value="0" class="col-1">
                @endif
                <label for="39" class="pt-3 ml-2 mr-2 font-weight-bold">39</label>
                @if (strpos($productos->stock, '39t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "39t")
                            <input type="number" name="39" min="0" id="39" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="39" min="0" id="39" value="0" class="col-1">
                @endif
                <label for="40" class="pt-3 ml-2 mr-2 font-weight-bold">40</label>
                @if (strpos($productos->stock, '40t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "40t")
                            <input type="number" name="40" min="0" id="40" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="40" min="0" id="40" value="0" class="col-1">
                @endif
                <label for="41" class="pt-3 ml-2 mr-2 font-weight-bold">41</label>
                @if (strpos($productos->stock, '41t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "41t")
                            <input type="number" name="41" min="0" id="41" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="41" min="0" id="41" value="0" class="col-1">
                @endif
                <label for="42" class="pt-3 ml-2 mr-2 font-weight-bold">42</label>
                @if (strpos($productos->stock, '42t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "42t")
                            <input type="number" name="42" min="0" id="42" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="42" min="0" id="42" value="0" class="col-1">
                @endif
                <label for="43" class="pt-3 ml-2 mr-2 font-weight-bold">43</label>
                @if (strpos($productos->stock, '43t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "43t")
                            <input type="number" name="43" min="0" id="43" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="43" min="0" id="43" value="0" class="col-1">
                @endif
                <label for="44" class="pt-3 ml-2 mr-2 font-weight-bold">44</label>
                @if (strpos($productos->stock, '44t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "44t")
                            <input type="number" name="44" min="0" id="44" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="44" min="0" id="44" value="0" class="col-1">
                @endif
                <label for="45" class="pt-3 ml-2 mr-2 font-weight-bold">45</label>
                @if (strpos($productos->stock, '45t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "45t")
                            <input type="number" name="45" min="0" id="45" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="45" min="0" id="45" value="0" class="col-1">
                @endif
                <label for="46" class="pt-3 ml-2 mr-2 font-weight-bold">46</label>
                @if (strpos($productos->stock, '46t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "46t")
                            <input type="number" name="46" min="0" id="46" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="46" min="0" id="46" value="0" class="col-1">
                @endif
                <label for="47" class="pt-3 ml-2 mr-2 font-weight-bold">47</label>
                @if (strpos($productos->stock, '47t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "47t")
                            <input type="number" name="47" min="0" id="47" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="47" min="0" id="47" value="0" class="col-1">
                @endif
                <label for="48" class="pt-3 ml-2 mr-2 font-weight-bold">48</label>
                @if (strpos($productos->stock, '48t') !== false)
                    @foreach (explode('/',$productos->stock) as $talla)
                        @if (strpos($talla, '-') !== false && explode('-',$talla)[0] == "48t")
                            <input type="number" name="48" min="0" id="48" value="{{explode('-',$talla)[1]}}" class="col-1">
                        @endif
                    @endforeach
                @else
                    <input type="number" name="48" min="0" id="48" value="0" class="col-1">
                @endif
                <br><span class="text-dark" style="font-size: 12px">La cantidad de stock debe de ser igual que la suma de todas las tallas.</span>
            @endif
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
        <input type="number" name="oferta" id="oferta" value="{{$productos->oferta}}" min="0" max="99999999999" required><br>
        <span class="text-secondary" style="font-size: 12px">Si tiene un porcentaje de oferta introduce el precio con la oferta ya aplicada.</span><br>
        <label for="imagen" class="pt-3">Imagen actual:</label><br>
        @if ($productos->imagen == "")
            <img src="{{url('/img/default.png')}}" alt="Sin imagen" class="img-fluid" width="200px"><br>
        @else
            <img src="{{asset('/img')}}/{{$productos->imagen}}" alt="{{$productos->imagen}}" class="img-fluid" width="200px"><br>
        @endif
        <input type="file" name="imagen" id="imagen" class="pt-3"><br>
        <input type="submit" value="Editar Producto" class="btn bg-purple text-white mt-3 mb-3">
    </form>

@endsection
