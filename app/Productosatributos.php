<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productosatributos extends Model
{
    protected $table='productosatributos';

    public function productos(){
        return $this->belongsTo('App\Productos', 'productoId');
    }

    public function atributos(){
        return $this->belongsTo('App\Atributos', 'atributoId');
    }

}
