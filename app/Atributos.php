<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Atributos extends Model
{
    protected $table='atributos';

    public function productosatributos(){
        return $this->hasMany('App\Productosatributos');
    }

}
