<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table='productos';

    public function categorias(){
        return $this->belongsTo('App\Categoria', 'categoriaId');
    }

    public function lineaspedidos(){
        return $this->hasMany('App\Lineaspedido');
    }

    public function productosatributos(){
        return $this->hasMany('App\Productosatributos');
    }
}
