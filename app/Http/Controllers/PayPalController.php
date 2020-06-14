<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;
use Auth;
use DB;
use Session;
use App\Pedidos;
use App\Productos;
use App\LineasPedido;
   
class PayPalController extends Controller
{

    public function payment()
    {
        if (Auth::user() && Session::get("carro") != null) {
            $carro = Session::get("carro");
            $total = 0;
            $descripcion = "";

            foreach ($carro as $producto) {
                $total += $producto[1] * $producto[2];
                $productos = Productos::findOrFail($producto[0]);
                $descripcion .= $productos->nombre . " - ";
                if ($producto[3] != "0") {
                    $descripcion .= "Talla " . $producto[3] . " - ";
                }
                $descripcion .= $producto[1] . " Unidades | ";
            }

            $data = [];
            $data['items'] = [
                [
                    'name' => 'Suscripcion', //Nombre del producto
                    'price' => $total, //Precio
                    'desc'  => $descripcion, //Descripcion
                    'qty' => 1 //Cantidad
                ]
            ];
    
            $data['invoice_id'] = 1;
            $data['invoice_description'] = $descripcion;
            $data['return_url'] = route('payment.success'); //si se hace bien el pago
            $data['cancel_url'] = route('payment.cancel'); // si se cancela el pago
            $data['total'] = $total;
    
            $provider = new ExpressCheckout;
            $response = $provider->setExpressCheckout($data);
            $response = $provider->setExpressCheckout($data, true);

            return redirect($response['paypal_link']);
        } else {
            return redirect('/');
        }

    }
   
    public function cancelPayment()
    {
        return redirect('/carrito')->with('message','Has cancelado el pago, vuelve a hacer el pedido para comprar con nosotros');
    }
  

    public function successPayment(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);
  
        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            $carro = Session::get("carro");
            $total = 0;
            $contador = 0;

            foreach ($carro as $producto) {
                $total += $producto[1] * $producto[2];
            }

            $pedidos = new Pedidos();
            $pedidos->usuarios_id = Auth::user()->id;
            $pedidos->ciudad = Auth::user()->ciudad;
            $pedidos->pais = Auth::user()->pais;
            $pedidos->direccion = Auth::user()->direccion;
            $pedidos->coste = $total;
            $pedidos->estado = "Pendiente";
            $pedidos->save();

            foreach ($carro as $producto) {
                $lineapedido = new LineasPedido();
                $lineapedido->pedidos_id = DB::table('pedidos')->where('usuarios_id','=',Auth::user()->id)->orderBy('id', 'DESC')->first()->id;
                $lineapedido->productos_id = $producto[0];
                $lineapedido->unidades = $producto[1];
                $lineapedido->talla = $producto[3];
                $lineapedido->save();
                $productos = Productos::findOrFail($producto[0]);
                $total = (int)explode("/",$productos->stock)[0];
                $total = $total - (int)$producto[1];
                $nuevoStock = "";
                $total = strval($total);
                $nuevoStock .= $total . "/";
                if (explode("/",$productos->stock)[1] != "") {
                    $tallas = explode("/",$productos->stock);
                    array_splice($tallas, 0, 1);
                    $nuevoArray = array();
                    foreach ($tallas as $talla) {
                        $nuevasTallas = explode("-",$talla);
                        if ($nuevasTallas[0] == $producto[3]) {
                            $valor = $nuevasTallas[1] - $producto[1];
                            $nuevo = array($nuevasTallas[0],$valor);
                            $nuevasTallas = $nuevo;
                        }
                        if ($nuevasTallas[1] != 0) {
                            array_push($nuevoArray,$nuevasTallas);
                        }
                        if ($nuevasTallas[1] < 0) {
                            $sesion = Session::get("carro");
                            array_splice($sesion, $contador, 1);
                            Session::forget("carro");
                            Session::put("carro",$sesion);
                            $pedidos = Pedidos::all()->where('usuarios_id','=',Auth::user()->id)->reverse()->values();
                            $pedidos[0]->delete();
                            if (Session::get("carro") != null) {
                                return redirect('/carrito')->with('message','Estas intentando comprar mas unidades de las que hay del articulo "'.$productos->nombre.'". Este ha sido eliminado del carrito');
                            } else {
                                return redirect('/')->with('message','Estas intentando comprar mas unidades de las que hay del articulo "'.$productos->nombre.'". Este ha sido eliminado del carrito');
                            }
                        }
                    }
                    foreach ($nuevoArray as $productoArray) {
                        $addStock = "";
                        foreach($productoArray as $tallaArray) {
                            $addStock .= $tallaArray . "-";
                        }
                        $addStock = substr($addStock, 0, -1);
                        $addStock .= "/";
                        $nuevoStock .= $addStock;
                    }
                    $nuevoStock = substr($nuevoStock, 0, -1);
                }else {    
                    if ($total < 0) {
                        $sesion = Session::get("carro");
                        array_splice($sesion, $contador, 1);
                        Session::forget("carro");
                        Session::put("carro",$sesion);
                        $pedidos = Pedidos::all()->where('usuarios_id','=',Auth::user()->id)->reverse()->values();
                        $pedidos[0]->delete();
                        if (Session::get("carro") != null) {
                            return redirect('/carrito')->with('message','Estas intentando comprar mas unidades de las que hay del articulo "'.$productos->nombre.'". Este ha sido eliminado del carrito');
                        } else {
                            return redirect('/')->with('message','Estas intentando comprar mas unidades de las que hay del articulo "'.$productos->nombre.'". Este ha sido eliminado del carrito');
                        }
                    }
                }
                $productos->stock = $nuevoStock;
                $productos->save();
                $contador++;
            }

        Session::forget("carro");
        return redirect('mispedidos')->with('message','Tu pedido ha sido realizado con exito');

        }else{
            return redirect('/carrito')->with('message','Ha habido un error con el pago vuelva a intentarlo');
        }
    }

}