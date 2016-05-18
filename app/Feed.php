<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{

    protected $fillable =  ['nome','url','status'];

    public function noticias()
    {
        return $this->hasMany('App\Noticia','idfeed');
    }

}
