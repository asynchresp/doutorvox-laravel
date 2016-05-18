<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Andamento extends Model
{
    protected $fillable =  ['idusuario','idpedido','comentario','status'];


    public function usuario()
    {
        return $this->belongsTo('App\Usuario','idusuario');
    }
    public function pedido()
    {
        return $this->belongsTo('App\Pedido','idpedido');
    }

}
