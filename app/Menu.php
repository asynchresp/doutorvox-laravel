<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable =  ['idpai', 'nome', 'icone', 'ordem', 'link'];

    public function menuPai()
    {
        return $this->belongsTo('App\Menu', 'idpai');
    }

    public function menusFilhos()
    {
        return $this->hasMany('App\Menu', 'idpai');
    }
}
