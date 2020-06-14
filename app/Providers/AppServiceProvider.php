<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            DB::connection()->getPdo();
            $colores = DB::table('configuraciones')->where('nombre','=','colores')->get()[0]->valor;
            if ($colores == "clasico") {
                view()->share('fondo', 'bg-white');
                view()->share('bg', 'bg-dark');
                view()->share('bgSecundario', 'bg-white');
                view()->share('color', 'text-white');
                view()->share('colorSecundario', 'text-dark');
                view()->share('colorTerciario', 'text-white');
                view()->share('botonuno', 'bg-success');
                view()->share('botondos', 'bg-danger');
            }else if ($colores == "oscuro") {
                view()->share('fondo', 'bg-dark');
                view()->share('bg', 'bg-white');
                view()->share('bgSecundario', 'bg-dark');
                view()->share('color', 'text-white');
                view()->share('colorTerciario', 'text-dark');
                view()->share('colorSecundario', 'text-white');
                view()->share('botonuno', 'bg-oscuro');
                view()->share('botondos', 'bg-secondary');
            }else if ($colores == "neon") {
                view()->share('fondo', 'bg-white');
                view()->share('bg', 'bg-neon');
                view()->share('bgSecundario', 'bg-white');
                view()->share('color', 'text-white');
                view()->share('colorTerciario', 'text-white');
                view()->share('colorSecundario', 'text-neon');
                view()->share('botonuno', 'btn-neon');
                view()->share('botondos', 'btndos-neon');
            }else if ($colores == "anagrama") {
                view()->share('fondo', 'bg-white');
                view()->share('bg', 'bg-anagrama');
                view()->share('bgSecundario', 'bg-white');
                view()->share('color', 'text-white');
                view()->share('colorTerciario', 'text-white');
                view()->share('colorSecundario', 'text-anagrama');
                view()->share('botonuno', 'btn-anagrama');
                view()->share('botondos', 'btndos-anagrama');
            }else if ($colores == "pantera") {
                view()->share('fondo', 'bg-white');
                view()->share('bg', 'bg-pantera');
                view()->share('bgSecundario', 'bg-white');
                view()->share('color', 'text-white');
                view()->share('colorTerciario', 'text-white');
                view()->share('colorSecundario', 'text-pantera');
                view()->share('botonuno', 'btn-pantera');
                view()->share('botondos', 'btndos-pantera');
            }else{
                view()->share('fondo', 'bg-white');
                view()->share('bg', 'bg-dark');
                view()->share('bgSecundario', 'bg-white');
                view()->share('color', 'text-white');
                view()->share('colorTerciario', 'text-white');
                view()->share('colorSecundario', 'text-dark');
                view()->share('botonuno', 'bg-success');
                view()->share('botondos', 'bg-danger');
            }
        } catch (\Exception $e) {
            return redirect('/config');
        }
    }
}
