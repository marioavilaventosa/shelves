<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Configuraciones;
use App\User;
use App\Productos;
use App\Categorias;
use Artisan;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function panel()
    {
        $reading = fopen('../.env', 'r');
        $writing = fopen('../.env.tmp', 'w');

        $paypal = true;
        $logo = true;
        $usuario = "";
        $password = "";
        $secret = "";
    
        while (!feof($reading)) {
            $line = fgets($reading);
            if (stristr($line,'PAYPAL_SANDBOX_API_USERNAME')) {
                $usuario = explode("=", $line)[1];
            }else if(stristr($line,'PAYPAL_SANDBOX_API_PASSWORD')) {
                $password = explode("=", $line)[1];
            }else if(stristr($line,'PAYPAL_SANDBOX_API_SECRET')) {
                $secret = explode("=", $line)[1];
            }
        }
        fclose($reading); 
        fclose($writing);   
        
        $usuario = str_replace("\n", "", $usuario);
        $password = str_replace("\n", "", $password);
        $secret = str_replace("\n", "", $secret);
        
        if ($usuario == "" || $password == "" || $secret == ""){
            $paypal = false;
        }

        $productos = Productos::all();
        $categorias = Categorias::all();
        $editores = User::all()->where('rol','=','editor');
        $configLogo = Configuraciones::where('nombre','=','logo')->get()[0];
        if ($configLogo == "" || $configLogo != null) {
            $logo = false;
        }


        return view('admin.panel', ['paypal'=>$paypal,'productos'=>$productos,'categorias'=>$categorias,'editores'=>$editores,'logo'=>$logo]);
    }

    public function config(){
        try {
            DB::connection()->getPdo();
            return redirect('/');
        } catch (\Exception $e) {
            return view('configuracion');
        }
    }

    public function configurar(Request $request){
        try {
            DB::connection()->getPdo();
            return redirect('/');
        } catch (\Exception $e) {
            if (Session::get("config") == null) {
                //REMPLAZO LOS DATOS DEL ENVIROMENT PARA LA BBDD
                $reading = fopen('../.env', 'r');
                $writing = fopen('../.env.tmp', 'w');
    
                $replaced = false;
    
                while (!feof($reading)) {
                    $line = fgets($reading);
                    if (stristr($line,'DB_DATABASE')) {
                        $input = $request->input('nombre');
                        $line =  "DB_DATABASE=$input\n";
                        $replaced = true;
                    }else if (stristr($line,'DB_HOST')) {
                        $input = $request->input('servidor');
                        $line =  "DB_HOST=$input\n";
                        $replaced = true;
                    }else if (stristr($line,'DB_PASSWORD')) {
                        $input = $request->input('password');
                        $line =  "DB_PASSWORD=$input\n";
                        $replaced = true;
                    }else if (stristr($line,'DB_USERNAME')) {
                        $input = $request->input('usuario');
                        $line =  "DB_USERNAME=$input\n";
                        $replaced = true;
                    }else if (stristr($line,'DB_PORT')) {
                        $input = $request->input('puerto');
                        $line =  "DB_PORT=$input\n";
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
    
                return view('configddbb', ['nombre'=>$request->input('nombre'),'servidor'=>$request->input('servidor'),'password'=>$request->input('password'),'puerto'=>$request->input('puerto'),'usuario'=>$request->input('usuario'),'web'=>$request->input('web'),'name'=>$request->input('name'),'apellidos'=>$request->input('apellidos'),'email'=>$request->input('email'),'passwordweb'=>$request->input('passwordweb')]);
            }
            return redirect('/');
        }

    }

    public function configurarbbdd(Request $request){
        try {
            DB::connection()->getPdo();
            
            Artisan::call('migrate', [
                '--force' => true,
            ]);        
            
            //INSERTO LOS DATOS EN LA BBDD PARA LAS CONFIGURACIONES
            $titulo = new Configuraciones();
            $titulo->nombre = "titulo";
            $titulo->valor = $request->input('web');
            $titulo->save();
            
            $logo = new Configuraciones();
            $logo->nombre = "logo";
            $logo->save();
            
            $colores = new Configuraciones();
            $colores->nombre = "colores";
            $colores->valor = "clasico";
            $colores->save();
            
            //CREO EL USER ADMIN
            
            $user = new User();
            $user->name = $request->input('name');
            $user->apellidos = $request->input('apellidos');
            $user->rol = "admin";
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('passwordweb'));
            $user->save();
                

            $fp = fopen('../routes/web.php', 'w');
            fwrite($fp, "<?php\n/*\n|--------------------------------------------------------------------------\n| Web Routes\n|--------------------------------------------------------------------------\n|\n| Here is where you can register web routes for your application. These\n| routes are loaded by the RouteServiceProvider within a group which\n| contains the web middleware group. Now create something great!\n|\n*/\nAuth::routes();\n\n// ------------- Panel de administracion -----------------\n\nRoute::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');\n\nRoute::get('/admin', function () { if (!Auth::check()){return view('Auth.login');}else{return redirect('/admin/panel-administracion');} });\nRoute::get('/editor', function () { if (!Auth::check()){return view('Auth.login');}else{return redirect('/admin/panel-administracion');} });\n\n// Solo se permite el acceso a usuarios autenticados y que sean administradores\nRoute::group(['middleware' => 'admin'], function() {\nRoute::get('/admin/panel-administracion', 'HomeController@panel');\n//Categorias\nRoute::get('/admin/categorias', 'CategoriasController@index');\nRoute::get('/admin/categorias/eliminar/{id}', 'CategoriasController@eliminar');\nRoute::get('/admin/categorias/formulario-editar/{id}', 'CategoriasController@formeditar');\nRoute::post('/admin/categorias/editar', 'CategoriasController@editar');\nRoute::post('/admin/categorias/anadir', 'CategoriasController@anadir');\n//Usuarios\nRoute::get('/admin/usuarios', 'UsuariosController@index');\nRoute::get('/admin/usuarios/eliminar/{id}', 'UsuariosController@eliminarusuario');\n//Editores\nRoute::get('/admin/editores', 'UsuariosController@editores');\nRoute::get('/admin/editores/eliminar/{id}', 'UsuariosController@eliminareditor');\nRoute::get('/admin/usuarios/formulario-anadir-editor', 'UsuariosController@formanadir');\nRoute::post('/admin/usuarios/anadir-editor', 'UsuariosController@anadir');\nRoute::get('/admin/usuarios/convertir-en-usuario/{id}', 'UsuariosController@convertirUsuario');\n//Productos\nRoute::get('/admin/productos/{id}', 'ProductosController@index');\nRoute::get('/admin/productos/eliminar/{id}', 'ProductosController@eliminar');\nRoute::get('/admin/productos/formulario-editar/{id}', 'ProductosController@formeditar');\nRoute::post('/admin/productos/editar', 'ProductosController@editar');\nRoute::get('/admin/producto/formulario-anadir', 'ProductosController@formanadir');\nRoute::post('/admin/productos/anadir', 'ProductosController@anadir');\n//Pedidos\nRoute::get('/todospedidos', 'PedidosController@todospedidos');\nRoute::get('/admin/pedido/formulario-editar/{id}', 'PedidosController@formeditar');\nRoute::post('/admin/pedido/editar', 'PedidosController@editar');\n//Configuracion\nRoute::get('/admin/micuenta', 'ConfiguracionesController@index');\nRoute::post('/admin/micuenta/editardatos', 'ConfiguracionesController@editardatos');\nRoute::get('/admin/apariencia', 'ConfiguracionesController@apariencia');\nRoute::get('/admin/eliminarlogo', 'ConfiguracionesController@eliminarlogo');\nRoute::post('/admin/apariencia/editarapariencia', 'ConfiguracionesController@editarapariencia');\n});\n//Links para usuarios normales\nRoute::get('/', 'ProductosController@all');\nRoute::get('/categoria/{id}', 'ProductosController@porcategoria');\nRoute::get('/producto/{id}', 'ProductosController@detalle');\nRoute::post('/anadircarrito', 'ProductosController@anadirCarrito');\nRoute::get('/eliminarcarrito/{id}/{talla}', 'ProductosController@eliminarCarrito');\nRoute::get('/vaciarcarrito', 'ProductosController@vaciarCarrito');\nRoute::get('/carrito', 'ProductosController@carrito');\nRoute::get('/hacerpedido', 'PedidosController@hacerPedido');\nRoute::post('/pedido', 'PedidosController@pedido');\nRoute::get('/mispedidos', 'PedidosController@mispedidos');\nRoute::get('/editarmisdatos', 'UsuariosController@misdatosform');\nRoute::post('/misdatos', 'UsuariosController@misdatos');\n\nRoute::get('payment', 'PayPalController@payment')->name('payment');\nRoute::get('cancel', 'PayPalController@cancelPayment')->name('payment.cancel');\nRoute::get('payment/success', 'PayPalController@successPayment')->name('payment.success');\n");
            fclose($fp);

            return redirect("/admin");
            
        } catch (\Exception $e) {
            return redirect('/')->with("message","Conexion con la base de datos fallida. Compruebe todos los campos");
        }
       
    }
}
