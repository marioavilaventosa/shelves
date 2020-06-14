<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Facades\Route;
$previousPath = url()->previous();
$previousPath = explode("/", $previousPath);
$previousPath = $previousPath[sizeof($previousPath)-1];


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(){
        $user = Auth::user();
        if($user->rol == "admin"){
            return redirect("/admin/panel-administracion");
        }else if($user->rol == "editor"){
            return redirect("/editor/panel-administracion");
        }else{
            return redirect("/");
        }
    }
}
