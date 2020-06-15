@extends("layouts.app")
@section("content")


    @if(session()->has('message'))
        <div class="alert alert-success text-center">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="row mt-4 d-flex justify-content-center {{$colorSecundario}}">
        @if ($productos->imagen == "")
            <img src="{{url('/img/default.png')}}" alt="Sin imagen" class="img-fluid col-md-3 mr-5"><br>
        @else
            <img class="img-fluid col-md-3 mr-5" src="{{asset('/img')}}/{{$productos->imagen}}" alt="{{$productos->imagen}}">
        @endif
        <div class="col-md-4 ml-4">
            <div class="row">
                <h5>{{$productos->nombre}}</h5>
            </div>
            <div class="row">
                <p class="font-weigth-bold font-weight-bold">{{$productos->precio}}€</p>
            </div>
            <div class="row">
                <p>{{$productos->descripcion}}</p>
            </div>
            <div class="row">
                <form method="POST" action="{{action('ProductosController@anadirCarrito')}}" enctype="multipart/form-data"> 
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id" value="{{$productos->id}}">
                    <label for="tallas">Talla:</label>
                    <select id="tallas" name="tallas" class="form-control form-control-sm mb-4">
                    </select>
                    <label for="cantidad">Unidades: </label>
                    <select id="cantidad" name="cantidad" class="form-control form-control-sm mb-4">
                    </select>
                    <script>
                        var tallas = "";
                        var stock = {!! json_encode($productos->stock) !!};
                        var stockSinTotal = stock.substring(stock.indexOf('/')+1)
                        stockSinTotal = stockSinTotal.split("/")
                        for (i=0;i<stockSinTotal.length;i++) {
                            var tallaCantidad = stockSinTotal[i].split("-")
                            if (tallaCantidad[0] == 'XS') {
                                tallas += '<option value="XS">XS</option>';
                            }
                            if (tallaCantidad[0] == 'S') {
                                tallas += '<option value="S">S</option>';
                            }
                            if (tallaCantidad[0] == 'M') {
                                tallas += '<option value="M">M</option>';
                            }
                            if (tallaCantidad[0] == 'L') {
                                tallas += '<option value="L">L</option>';
                            }
                            if (tallaCantidad[0] == 'XL') {
                                tallas += '<option value="XL">XL</option>';
                            }
                            if (tallaCantidad[0] == 'XXL') {
                                tallas += '<option value="XXL">XXL</option>';
                            }
                            if (tallaCantidad[0] == 'XXXL') {
                                tallas += '<option value="XXXL">XXXL</option>';
                            }
                            if (tallaCantidad[0] =='36t') {
                                tallas += '<option value="36">36</option>';
                            }
                            if (tallaCantidad[0] =='37t') {
                                tallas += '<option value="37">37</option>';
                            }
                            if (tallaCantidad[0] =='38t') {
                                tallas += '<option value="38">38</option>';
                            }
                            if (tallaCantidad[0] =='39t') {
                                tallas += '<option value="39">39</option>';
                            }
                            if (tallaCantidad[0] =='40t') {
                                tallas += '<option value="40">40</option>';
                            }
                            if (tallaCantidad[0] =='41t') {
                                tallas += '<option value="41">41</option>';
                            }
                            if (tallaCantidad[0] =='42t') {
                                tallas += '<option value="42">42</option>';
                            }
                            if (tallaCantidad[0] =='43t') {
                                tallas += '<option value="43">43</option>';
                            }
                            if (tallaCantidad[0] =='44t') {
                                tallas += '<option value="44">44</option>';
                            }
                            if (tallaCantidad[0] =='45t') {
                                tallas += '<option value="45">45</option>';
                            }
                            if (tallaCantidad[0] =='46t') {
                                tallas += '<option value="46">46</option>';
                            }
                            if (tallaCantidad[0] =='47t') {
                                tallas += '<option value="47">47</option>';
                            }
                            if (tallaCantidad[0] =='48t') {
                                tallas += '<option value="48">48</option>';
                            }
                        }
                        $('select#tallas').html(tallas);    
                        var unidades = ""
                        if (stock.split("/").length >= 2 && stock.split("/")[1] != "") {
                            var primeraOpcion = $("select#tallas").find("option:first-child").val()
                            stockSinTotal = stock.substring(stock.indexOf('/')+1)
                            stockTalla = stock.substring(stock.indexOf(primeraOpcion)+1)
                            if (stockTalla.includes("/")) {
                                stockTalla = stockTalla.substring(stockTalla.indexOf('-'))
                                stockTalla = stockTalla.substring(1)
                                if(stockTalla.split("/").length !=1 ) {
                                    stockTalla = stockTalla.substring(0,stockTalla.indexOf('/'))
                                }
                            }else {
                                stockTalla = stockTalla.substring(1)
                            }
                            for (i = 1; i <= stockTalla; i++) {
                                unidades += "<option value='"+ i + "'>" + i + "</option>"
                            }
                            $('select#cantidad').html(unidades);
                        }else {
                            for (i = 1; i <= stock.substring(0,stock.length-1); i++) {
                                unidades += "<option value='"+ i + "'>" + i + "</option>"
                            }
                            $('select#cantidad').html(unidades);
                        }
                        $( document ).ready(function() {
                            if ($('select#tallas option').length == 0) {
                                $("label[for='tallas']").remove();
                                $('select#tallas').remove();
                            }
                            if ($('select#cantidad option').length == 0) {
                                $("label[for='cantidad']").remove();
                                $('select#cantidad').remove();
                            }
                            $('select#tallas').on('change', function() {
                                var unidades = ""
                                if (stock.split("/").length >= 2 && stock.split("/")[1] != "") {
                                    var primeraOpcion = this.value
                                    if (primeraOpcion != "XS" && primeraOpcion != "S" && primeraOpcion != "M" && primeraOpcion != "L" && primeraOpcion != "XL" && primeraOpcion != "XXL" && primeraOpcion != "XXXL"){
                                        primeraOpcion += "t" 
                                    }
                                    var stockSinTotal = stock.substring(stock.indexOf('/')+1)
                                    var stockSinTotal = stockSinTotal.split("/")
                                    var cantidadTotal = 0;
                                    for (i=0;i<stockSinTotal.length;i++) {
                                        var tallaCantidad = stockSinTotal[i].split("-")
                                        if (tallaCantidad[0] == primeraOpcion) {
                                            cantidadTotal = tallaCantidad[1]
                                        }
                                    }
                                    for (i = 1; i <= cantidadTotal; i++) {
                                        unidades += "<option value='"+ i + "'>" + i + "</option>"
                                    }
                                    $('select#cantidad').html(unidades);
                                }else {
                                    for (i = 1; i <= stock.substring(0,stock.length-1); i++) {
                                        unidades += "<option value='"+ i + "'>" + i + "</option>"
                                    }
                                    $('select#cantidad').html(unidades);
                                }
                            })
                        })
                    </script>
                    @if ($productos->oferta > 0) 
                        <h5 class="{{$colorSecundario}} font-weight-bold">¡¡¡ {{$productos->oferta}}% de descuento !!!</h5><br>
                    @endif
                    @if ($productos->stock == 0)
                        <h4 href="" class="text-danger px-5 mt-2">Producto Agotado</h4>
                    @elseif ($productos->stock <= 5)
                        <span class="text-danger font-weight-bold">¡Quedan pocos!</span><br>
                        <input type="submit" value="Comprar" class="btn {{$botonuno}} {{$color}} px-5 mt-2">
                    @else
                        <input type="submit" value="Comprar" class="btn {{$botonuno}} {{$color}} px-5 mt-2">
                    @endif
                </form>
            </div>
        </div>
    </div>

@endsection
