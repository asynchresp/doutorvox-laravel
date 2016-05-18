<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $fillable =  ['nome','uf','ativo'];

    public function usuarios()
    {
        return $this->hasMany('App\Usuario','idestado');
    }
}
