<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diligencia extends Model
{
    protected $fillable =  ['nome','status'];

    public function usuarios()
    {
        return $this->belongsToMany('App\Usuario','usuarios_diligencias');
    }
    public function pedidos()
    {
        return $this->belongsToMany('App\Pedido','pedidos_diligencias','iddiligencia','idpedido');
    }

}
