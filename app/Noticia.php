<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{

    protected $fillable =  ['idfeed', 'idusuario', 'titulo', 'resumo', 'dtnoticia', 'descricao'];

    protected $hidden = [
        'idfeed', 'idusuario','created_at','update_at'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class,'idusuario');
    }
    public function feed()
    {
        return $this->belongsTo('App\Feed','idfeed');
    }
}
