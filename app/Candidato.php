<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    protected $fillable =  ['idusuario','idpedido', 'dhproposta','valor_proposta','aprovado'];


    public function usuario()
    {
        return $this->belongsTo('App\Usuario','idusuario');
    }

    public function pedido()
    {
        return $this->belongsTo('App\Pedido','idpedido');
    }
}
