<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use App\Pedidos;
use App\Productos;
use App\LineasPedido;

class PedidosController extends Controller
{
    
    public function hacerPedido(){
        if (Auth::user() && Session::get("carro") != null) {
            return view('pedido');
        } else{
            return redirect('/');
        }
    }

    public function pedido(Request $request){
        if (Auth::user() && Session::get("carro") != null) {
            Auth::user()->ciudad = $request->input('ciudad');
            Auth::user()->pais = $request->input('pais');
            Auth::user()->direccion = $request->input('direccion');
            Auth::user()->save();
            return redirect('payment');
        } else {
            return redirect('/');
        }
    } 

    public function mispedidos(){
        if (Auth::user()) {
            $pedidos = Pedidos::all()->where('usuarios_id','=',Auth::user()->id)->reverse()->values();
            return view("mispedidos", ["pedidos"=>$pedidos]);
        } else{
            return redirect('/');
        }
    }

    public function todospedidos(){
        $pedidos = Pedidos::all()->reverse()->values();
        return view("admin.pedidos", ["pedidos"=>$pedidos]);
    }

    public function formeditar($id){
        $pedidos = Pedidos::findOrFail($id);
        return view("admin.editarpedidos", ["pedidos"=>$pedidos]);
    }

    public function editar(Request $request){
        $pedidos = Pedidos::findOrFail($request->input('id'));
        $pedidos->estado = $request->input('estado');
        $pedidos->save();
        return redirect("/todospedidos");
    }

}
