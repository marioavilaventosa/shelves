<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Auth;


class UsuariosController extends Controller
{
    public function index(){
        $usuarios = User::all()->where('rol','=','usuario');
        return view('admin.usuarios', ['usuarios'=>$usuarios]);
    }

    public function editores(){
        $usuarios = User::all()->where('rol','=','editor');
        return view('admin.editores', ['usuarios'=>$usuarios]);
    }

    public function convertirUsuario($id){
        $usuarios = User::findOrFail($id);
        $usuarios->rol = "usuario";
        $usuarios->save();
        return redirect('admin/usuarios');
    }

    public function eliminarusuario($id){
        $usuarios = User::findOrFail($id);
        $usuarios->delete();
        return redirect('admin/usuarios');
    }

    public function eliminareditor($id){
        $usuarios = User::findOrFail($id);
        $usuarios->delete();
        return redirect('admin/editores');
    }

    public function formanadir(){
        return view('admin.anadirusuario');
    }

    public function anadir(Request $request){
        $usuarios = new User();
        $usuarios->name = $request->input('name');
        $usuarios->apellidos = $request->input('apellidos');
        $usuarios->email = $request->input('email');
        $usuarios->rol = "editor";
        $usuarios->password = Hash::make($request->input('password'));
        $usuarios->save();

        return redirect('admin/editores');
    }

    public function misdatosform(){
        if (Auth::user()) {
            return view('misdatos', ['usuario'=>Auth::user()]);
        }else {
            return redirect('/');
        }
    }   

    public function misdatos(Request $request){
        if (Auth::user()) {
            Auth::user()->name = $request->input('nombre');
            Auth::user()->apellidos = $request->input('apellidos');
            Auth::user()->ciudad = $request->input('ciudad');
            Auth::user()->pais = $request->input('pais');
            Auth::user()->direccion = $request->input('direccion');
            Auth::user()->email = $request->input('email');
            Auth::user()->save();
            return redirect("/editarmisdatos")->with('message', 'Datos actualizados');
        }else {
            return redirect('/');
        }
    }  
    
}
