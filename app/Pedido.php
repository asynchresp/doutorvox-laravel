<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{

    protected $fillable =  ['status','valor_minimo','valor_maximo','idcidade',
        'idusuario_cadastro','idusuario_alteracao','finalizado','tipo_pagamento'];

    public function usuarioCadastrouPedido()
    {
        return $this->belongsTo('App\Usuario','idusuario_cadastro');
    }
    public function usuarioAlterouPedido()
    {
        return $this->belongsTo('App\Usuario','idusuario_alteracao');
    }
    public function cidade()
    {
        return $this->belongsTo('App\Cidade','idcidade');
    }
    public function andamentos()
    {
        return $this->hasMany('App\Andamento','idpedido');
    }
    public function candidatos()
    {
        return $this->hasMany('App\Candidato', 'idpedido');
    }
    public function avaliacoes()
    {
        return $this->hasMany('App\Avaliacao', 'idpedido');
    }
    public function diligencias()
    {
        return $this->belongsToMany('App\Diligencia','pedidos_diligencias','idpedido','iddiligencia');
    }

}
