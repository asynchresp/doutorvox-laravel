<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{

    protected $fillable =  ['nome','email','password','cpf_cpnj','telefone',
    'comercial','celular','tipo','logradouro','bairro','idcidade','idestado','cep'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }

    public function assinaturas()
    {
        return $this->hasMany('App\Assinatura','idusuario');
    }

    public function andamentos()
    {
        return $this->hasMany('App\Andamento','idusuario');
    }

    public function diligencias()
    {
        return $this->belongsToMany('App\Diligencia','usuarios_diligencias');
    }

    public function pagamentos()
    {
        return $this->hasMany('App\Pagamento','idusuario');
    }

    public function avaliacoes()
    {
        return $this->hasMany('App\Avaliacao','idusuario');
    }

    public function candidatos()
    {
        return $this->hasMany('App\Candidato','idusuario');
    }

    public function cidade()
    {
        return $this->belongsTo('App\Cidade','idcidade');
    }

    public function pedidosCadastrados()
    {
        return $this->hasMany('App\Pedido','idusuario_cadastro');
    }
    public function pedidosAlterados()
    {
        return $this->hasMany('App\Pedido','idusuario_alteracao');
    }
    public function noticias()
    {
        return $this->hasMany('App\Noticia','idusuario');
    }
}
