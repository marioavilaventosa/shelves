<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lineaspedido extends Model
{
    protected $table='lineaspedido';

    public function productos(){
        return $this->belongsTo('App\Productos', 'productoId');
    }

    public function pedidos(){
        return $this->belongsTo('App\Pedidos', 'pedidoId');
    }

}
