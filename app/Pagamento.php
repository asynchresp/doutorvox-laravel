<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    protected $fillable =  ['idusuario', 'dtvencimento', 'dtpagamento', 'valor', 'status', 'metodo_pagamento'];

    public function usuario()
    {
        return $this->belongsTo('App\Usuario','idusuario');
    }
}
