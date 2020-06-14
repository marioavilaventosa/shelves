<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table='pedidos';

    public function usuarios(){
        return $this->belongsTo('App\User', 'usuarioId');
    }

    public function lineaspedidos(){
        return $this->hasMany('App\Lineaspedido');
    }
}
