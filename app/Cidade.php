<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{

    protected $fillable =  ['nome','ativo'];

    public function usuarios()
    {
        return $this->hasMany('App\Usuario','idcidade');
    }
}
