<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    protected $table='categorias';

    public function productos(){
        return $this->hasMany('App\Productos');
    }
}
