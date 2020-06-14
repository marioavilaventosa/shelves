<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Productos;
use App\Categorias;
use App\Pedidos;
use App\LineasPedido;
use Session;
use Auth;
use DB;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id){
        $categoria_actual = "";
        $productos = Productos::all();
        if($id != 0){
            $categoria_actual = Categorias::findOrFail($id);
            $productos = $categoria_actual->productos;
        }
        $categorias = Categorias::all();
        return view('admin.productos', ['productos'=>$productos,'categorias'=>$categorias,'categoria_actual'=>$categoria_actual]);
    }

    public function all(){
        $productosQuery = Productos::all();
        $productos = array();
        foreach($productosQuery as $producto){
            array_push($productos, $producto);
        }
        shuffle($productos);
        return view('productos', ['productos'=>$productos]);
    }

    public function porcategoria($id){
        $categorias = Categorias::all()->where('catsuperior','=',$id);
        $productos = array();
        if(count($categorias) != 0){
            foreach($categorias as $categoria){
                foreach($categoria->productos as $producto){
                    array_push($productos, $producto);
                }
            }
        }
        $productosprincipal = Categorias::findOrFail($id)->productos;
        foreach($productosprincipal as $producto){
            array_push($productos, $producto);
        }
        shuffle($productos);
        $categoria =  Categorias::findOrFail($id);
        return view('productos', ['productos'=>$productos,'categoria'=>$categoria,'categorias'=>$categorias]);
    }

    public function detalle($id){
        $productos = Productos::findOrFail($id);
        return view('detalleproducto', ['productos'=>$productos]);
    }    

    public function eliminar($id){
        $productos = Productos::findOrFail($id);
        $productos->delete();
        return redirect()->back();
    }

    public function formeditar($id){
        $productos = Productos::findOrFail($id);
        return view('admin.editarproducto', ['productos'=>$productos]);
    }

    public function editar(Request $request){
        $productos = Productos::findOrFail($request->input('id'));
        $productos->categorias_id = $request->input('categoria');
        $productos->nombre = $request->input('nombre');
        $productos->descripcion = $request->input('descripcion');
        $productos->precio = $request->input('precio');

        $opciontallas = $request->input('tallas');
        $stock = "";

        $suma = 0;
        if ($opciontallas == "ropa") {
            $suma += $request->input('xs');
            $suma += $request->input('s');
            $suma += $request->input('m');
            $suma += $request->input('l');
            $suma += $request->input('xl');
            $suma += $request->input('xxl');
            $suma += $request->input('xxxl');
            if ($suma != $request->input('stock')) {
                return redirect()->back()->with("message","La cantidad de stock debe de ser igual que la suma de las unidades de todas las tallas.");
            }
            $stock .= $request->input('stock');
            if ($request->input('xs') != 0) {
                $stock .= "/XS-" . $request->input('xs');
            }
            if ($request->input('s') != 0) {
                $stock .= "/S-" . $request->input('s');
            }
            if ($request->input('m') != 0) {
                $stock .= "/M-" . $request->input('m');
            }
            if ($request->input('l') != 0) {
                $stock .= "/L-" . $request->input('l');
            }
            if ($request->input('xl') != 0) {
                $stock .= "/XL-" . $request->input('xl');
            }
            if ($request->input('xxl') != 0) {
                $stock .= "/XXL-" . $request->input('xxl');
            }
            if ($request->input('xxxl') != 0) {
                $stock .= "/XXXL-" . $request->input('xxxl');
            }
        }else if ($opciontallas == "zapatos") {
            $suma += $request->input('36');
            $suma += $request->input('37');
            $suma += $request->input('38');
            $suma += $request->input('39');
            $suma += $request->input('40');
            $suma += $request->input('41');
            $suma += $request->input('42');
            $suma += $request->input('43');
            $suma += $request->input('44');
            $suma += $request->input('45');
            $suma += $request->input('46');
            $suma += $request->input('47');
            $suma += $request->input('48');
            if ($suma != $request->input('stock')) {
                return redirect()->back()->with("message","La cantidad de stock debe de ser igual que la suma de las unidades de todas las tallas.");
            }
            $stock .= $request->input('stock');
            if ($request->input('36') != 0) {
                $stock .= "/36t-" . $request->input('36');
            }
            if ($request->input('37') != 0) {
                $stock .= "/37t-" . $request->input('37');
            }
            if ($request->input('38') != 0) {
                $stock .= "/38t-" . $request->input('38');
            }
            if ($request->input('39') != 0) {
                $stock .= "/39t-" . $request->input('39');
            }
            if ($request->input('40') != 0) {
                $stock .= "/40t-" . $request->input('40');
            }
            if ($request->input('41') != 0) {
                $stock .= "/41t-" . $request->input('41');
            }
            if ($request->input('42') != 0) {
                $stock .= "/42t-" . $request->input('42');
            }
            if ($request->input('43') != 0) {
                $stock .= "/43t-" . $request->input('43');
            }
            if ($request->input('44') != 0) {
                $stock .= "/44t-" . $request->input('44');
            }
            if ($request->input('45') != 0) {
                $stock .= "/45t-" . $request->input('45');
            }
            if ($request->input('46') != 0) {
                $stock .= "/46t-" . $request->input('46');
            }
            if ($request->input('47') != 0) {
                $stock .= "/47t-" . $request->input('47');
            }
            if ($request->input('48') != 0) {
                $stock .= "/48t-" . $request->input('48');
            }
        } else {
            $stock .= $request->input('stock');
            $stock .= "/";
        }

        $productos->stock = $stock;
        $productos->oferta = $request->input('oferta');

        $image_path = $request->file('imagen');
        $imagen = $_FILES['imagen'];
        if($request->hasFile('imagen')) {
            $extension =$image_path->getClientOriginalExtension();
            if ($extension != "jpg" && $extension != "png"){
                return redirect()->back()->with('message', 'La imagen debe ser jpg o png');
            }
            $image_path_name = time().$image_path->getClientOriginalName();
            move_uploaded_file($imagen['tmp_name'],'img/'.$image_path_name);
            $productos->imagen = $image_path_name;
        }

        $productos->save();

        return redirect('admin/productos/0');
    }

    public function formanadir(){
        return view('admin.anadirproducto');
    }

    public function anadir(Request $request){
        $productos = new Productos();
        $productos->categorias_id = $request->input('categoria');
        $productos->nombre = $request->input('nombre');
        $productos->descripcion = $request->input('descripcion');
        $productos->precio = $request->input('precio');

        $opciontallas = $request->input('tallas');
        $stock = "";

        $suma = 0;
        if ($opciontallas == "ropa") {
            $suma += $request->input('xs');
            $suma += $request->input('s');
            $suma += $request->input('m');
            $suma += $request->input('l');
            $suma += $request->input('xl');
            $suma += $request->input('xxl');
            $suma += $request->input('xxxl');
            if ($suma != $request->input('stock')) {
                return redirect()->back()->with("message","La cantidad de stock debe de ser igual que la suma de las unidades de todas las tallas.");
            }
            $stock .= $request->input('stock');
            if ($request->input('xs') != 0) {
                $stock .= "/XS-" . $request->input('xs');
            }
            if ($request->input('s') != 0) {
                $stock .= "/S-" . $request->input('s');
            }
            if ($request->input('m') != 0) {
                $stock .= "/M-" . $request->input('m');
            }
            if ($request->input('l') != 0) {
                $stock .= "/L-" . $request->input('l');
            }
            if ($request->input('xl') != 0) {
                $stock .= "/XL-" . $request->input('xl');
            }
            if ($request->input('xxl') != 0) {
                $stock .= "/XXL-" . $request->input('xxl');
            }
            if ($request->input('xxxl') != 0) {
                $stock .= "/XXXL-" . $request->input('xxxl');
            }
        }else if ($opciontallas == "zapatos") {
            $suma += $request->input('36');
            $suma += $request->input('37');
            $suma += $request->input('38');
            $suma += $request->input('39');
            $suma += $request->input('40');
            $suma += $request->input('41');
            $suma += $request->input('42');
            $suma += $request->input('43');
            $suma += $request->input('44');
            $suma += $request->input('45');
            $suma += $request->input('46');
            $suma += $request->input('47');
            $suma += $request->input('48');
            if ($suma != $request->input('stock')) {
                return redirect()->back()->with("message","La cantidad de stock debe de ser igual que la suma de las unidades de todas las tallas.");
            }
            $stock .= $request->input('stock');
            if ($request->input('36') != 0) {
                $stock .= "/36t-" . $request->input('36');
            }
            if ($request->input('37') != 0) {
                $stock .= "/37t-" . $request->input('37');
            }
            if ($request->input('38') != 0) {
                $stock .= "/38t-" . $request->input('38');
            }
            if ($request->input('39') != 0) {
                $stock .= "/39t-" . $request->input('39');
            }
            if ($request->input('40') != 0) {
                $stock .= "/40t-" . $request->input('40');
            }
            if ($request->input('41') != 0) {
                $stock .= "/41t-" . $request->input('41');
            }
            if ($request->input('42') != 0) {
                $stock .= "/42t-" . $request->input('42');
            }
            if ($request->input('43') != 0) {
                $stock .= "/43t-" . $request->input('43');
            }
            if ($request->input('44') != 0) {
                $stock .= "/44t-" . $request->input('44');
            }
            if ($request->input('45') != 0) {
                $stock .= "/45t-" . $request->input('45');
            }
            if ($request->input('46') != 0) {
                $stock .= "/46t-" . $request->input('46');
            }
            if ($request->input('47') != 0) {
                $stock .= "/47t-" . $request->input('47');
            }
            if ($request->input('48') != 0) {
                $stock .= "/48t-" . $request->input('48');
            }
        } else {
            $stock .= $request->input('stock');
            $stock .= "/";
        }

        $productos->stock = $stock;
        $productos->oferta = $request->input('oferta');
        $productos->fecha =  date('Y-m-d');

        $image_path = $request->file('imagen');
        $imagen = $_FILES['imagen'];
        if($request->hasFile('imagen')) {
            $extension =$image_path->getClientOriginalExtension();
            if ($extension != "jpg" && $extension != "png"){
                return redirect()->back()->with('message', 'La imagen debe ser jpg o png');
            }
            $image_path_name = time().$image_path->getClientOriginalName();
            move_uploaded_file($imagen['tmp_name'],'img/'.$image_path_name);
            $productos->imagen = $image_path_name;
        }else{
            $productos->imagen = "default.png";
        }

        $productos->save();

        return redirect('admin/productos/0');
    }

    public function anadirCarrito(Request $request){
        $productos = Productos::findOrFail($request->input('id'));
        $contador = 0;
        $sesion = null;
        $existe_flag = false;
        $talla = 0;
        if ($request->has('tallas')) {
            $talla = $request->input('tallas');
        }
        if (Session::get("carro") != null) {
            foreach (Session::get("carro") as $producto){
                if ($producto[0] == $request->input('id') && $producto[3] == $request->input('tallas')){
                    $existe_flag = true;
                    break;
                }
                $contador++;
            }
            if ($existe_flag == true){
                $sesion = Session::get("carro");
                $sesion[$contador][1] += $request->input('cantidad');
                Session::forget("carro");
                Session::put("carro",$sesion);
            } else {
                Session::push("carro",[$request->input('id'),$request->input('cantidad'),$productos->precio,$talla]);
            }
        } else {
            Session::push("carro",[$request->input('id'),$request->input('cantidad'),$productos->precio,$talla]);
        }
        
        return redirect()->back()->with('message','Producto añadido al carro satisfactoriamente');
    }

    public function eliminarCarrito($id,$talla){
        $sesion = null;
        $contador = 0;
        $tallaFinal = $talla;
        if (Session::get("carro") != null) {
            if (count(Session::get("carro")) == 1) {
                Session::forget("carro");
            } else{
                foreach (Session::get("carro") as $producto){
                    if ($producto[0] == $id && $producto[3] == $tallaFinal){
                        $sesion = Session::get("carro");
                        array_splice($sesion, $contador, 1);
                        Session::forget("carro");
                        Session::put("carro",$sesion);
                    }
                    $contador++;
                }
            }
        }
        return redirect()->back();
    }

    public function vaciarCarrito(){
        Session::forget("carro");
        return redirect("carrito");
    }

    public function carrito(){
        if (Session::get("carro") != null) {
            return view('carrito', ['productos'=>Session::get("carro")]);
        } else{
            return redirect('/');
        }
    }
}
