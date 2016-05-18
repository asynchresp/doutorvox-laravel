<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    protected $fillable =  ['idusuario','tipo_assinatura','dtvencimento','dtadesao'];

    public function usuario()
    {
        return $this->belongsTo('App\Usuario','idusuario');
    }
}
