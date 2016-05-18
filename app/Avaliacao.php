<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Avaliacao extends Model
{
    protected $fillable =  ['idusuario','idpedido','nota'];

    protected $table = 'avaliacoes';

    public function usuario()
    {
        return $this->belongsTo('App\Usuario','idusuario');
    }
    public function pedido()
    {
        return $this->belongsTo('App\Pedido','idpedido');
    }
}
