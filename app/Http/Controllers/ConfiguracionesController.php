<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Configuraciones;

class ConfiguracionesController extends Controller
{
    public function index() {
        return view('admin.editarmisdatos', ['usuario'=>Auth::user(),'usuariopaypal'=>env('PAYPAL_SANDBOX_API_USERNAME', ''),'passwordpaypal'=>env('PAYPAL_SANDBOX_API_PASSWORD', ''),'apisecret'=>env('PAYPAL_SANDBOX_API_SECRET', ''),'mode'=>env('PAYPAL_MODE', '')]);
    }

    public function editardatos(Request $request) {
        $usuario = Auth::user();
        $usuario->name = $request->input('nombre');
        $usuario->apellidos = $request->input('apellidos');
        $usuario->email = $request->input('email');
        $usuario->save();

        $reading = fopen('../.env', 'r');
        $writing = fopen('../.env.tmp', 'w');

        $replaced = false;

        while (!feof($reading)) {
            $line = fgets($reading);
            if (stristr($line,'PAYPAL_MODE')) {
                $input = $request->input('mode');
                $line =  "PAYPAL_MODE=$input\n";
                $replaced = true;
            }else if (stristr($line,'PAYPAL_SANDBOX_API_USERNAME')) {
                $input = $request->input('usuariopaypal');
                $line =  "PAYPAL_SANDBOX_API_USERNAME=$input\n";
                $replaced = true;
            }else if (stristr($line,'PAYPAL_SANDBOX_API_PASSWORD')) {
                $input = $request->input('passwordpaypal');
                $line =  "PAYPAL_SANDBOX_API_PASSWORD=$input\n";
                $replaced = true;
            }else if (stristr($line,'PAYPAL_SANDBOX_API_SECRET')) {
                $input = $request->input('apisecret');
                $line =  "PAYPAL_SANDBOX_API_SECRET=$input\n";
                $replaced = true;
            }
            fputs($writing, $line);
            }
            fclose($reading); 
            fclose($writing);

            if ($replaced) 
            {
            rename('../.env.tmp', '../.env');
            } else {
            unlink('../.env.tmp');
                }
    
        return redirect('/admin/micuenta')->with('message','Datos modificados');
    }

    public function apariencia() {
        $titulo = Configuraciones::where('nombre','=','titulo')->get()[0];
        $logo = Configuraciones::where('nombre','=','logo')->get()[0];
        return view('admin.apariencia',['titulo'=>$titulo,'logo'=>$logo]);
    }

    public function eliminarlogo() {
        $logo = Configuraciones::where('nombre','=','logo')->get()[0];
        $logo->valor = null;
        $logo->save();
        return redirect('/admin/apariencia');
    }

    public function editarapariencia(Request $request) {
        $titulo = Configuraciones::where('nombre','=','titulo')->get()[0];
        $titulo->valor = $request->input('titulo');
        $titulo->save();

        $logo = Configuraciones::where('nombre','=','logo')->get()[0];

        $image_path = $request->file('logo');
        $imagen = $_FILES['logo'];
        if($request->hasFile('logo')) {
            $extension =$image_path->getClientOriginalExtension();
            if ($extension != "jpg" && $extension != "png"){
                return redirect()->back()->with('error', 'La imagen debe ser jpg o png');
            }
            $image_path_name = time().$image_path->getClientOriginalName();
            move_uploaded_file($imagen['tmp_name'],'img/'.$image_path_name);
            $logo->valor = $image_path_name;
            $logo->save();
        }

        $tema = Configuraciones::where('nombre','=','colores')->get()[0];
        $tema->valor = $request->input('tema');
        $tema->save();

        return redirect('/admin/apariencia')->with('message','Datos modificados');

    }
}
