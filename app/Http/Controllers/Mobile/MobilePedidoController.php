<?php
namespace App\Http\Controllers\Mobile;
/**
 * Created by PhpStorm.
 * User: maykon
 * Date: 14/05/16
 * Time: 21:22
 */

use App\Http\Controllers\Controller;
use App\Pedido;
use App\Usuario;
use Auth;
use Mockery\CountValidator\Exception;
use Symfony\Component\HttpFoundation\Request;

class MobilePedidoController extends Controller
{
    /* @var $variable Pedido */
    private $pedido;

    /* @var $variable Usuario */
    private $usuario;

    public function __construct(Pedido $pedido, Usuario $usuario)
    {
        $this->pedido = $pedido;
        $this->usuario = $usuario;
    }

    public function obterPedidosDoEscritorio(Request $request)
    {

        try {
            $idUsuario = $request->input('idusuario');

            $usuario = $this->usuario->find($idUsuario);

            if($usuario)
            {
                $pedidos = $this->pedido->with('diligencias')
                    ->with('andamentos')
                    ->with('candidatos')
                    ->with('avaliacoes')
                    ->with('cidade')
                    ->where('idusuario_cadastro',$idUsuario)->get();

                foreach($pedidos as $p){
                    $response[] = [
                        'id' => (int) $p->id,
                        'status' => $p->status,
                        'valor_minimo' => $p->valor_minimo,
                        'valor_maximo' => $p->valor_maximo,
                        'descricao' => $p->descricao,
                        'idcidade' => $p->idcidade,
                        'idusuario_cadastro' => $p->idusuario_cadastro,
                        'nome_empresa' => $p->usuarioCadastrouPedido->nome,
                        'finalizado' => $p->finalizado,
                        'tipo_pagamento' => $p->tipo_pagamento,
                        'diligencias' => $p->diligencias,
                        'andamentos' => $p->andamentos,
                        'candidatos' => $p->candidatos
                    ];
                }

                return  response()->json(array('status' => 1,
                    'pedidos' => $response,
                    'debug'=>"ok",
                    'msg' => ''))
                    ->header('Content-Type','application/json');
            }
            else
            {
                return  response()->json(array('status' => 0,
                    'debug'=>"id do usuário é inválido",
                    'msg' => 'Falha na comunicação com o servidor'))
                    ->header('Content-Type','application/json');
            }
        } catch (Exception $e) {
            return response()->json(array('status' => 0,
                'debug'=>$e->getMessage(),
                'msg' => 'Falha na conexão com o banco de dados'))
                ->header('Content-Type','application/json');
        }
    }


    public function aprovarPedido(Request $request)
    {


        try {
            $idUsuario = $request->input('idusuario');
            $idPedido = $request->input('pedidoId');

            $this->pedido->where('idusuario_cadastro',$idUsuario)
                ->where('id',$idPedido)
                ->update(['status' => 2]);

            return  response()->json(array('status' => 1,
                'debug'=>"ok",
                'msg' => 'Pedido aprovado com sucesso!'))
                ->header('Content-Type','application/json');

        } catch (Exception $e) {
            return response()->json(array('status' => 0,
                'debug'=>$e->getMessage(),
                'msg' => 'Falha na conexão com o banco de dados'))
                ->header('Content-Type','application/json');
        }
    }

    public function deletarPedido(Request $request)
    {

        try {
            $idUsuario = $request->input('idusuario');
            $idPedido = $request->input('pedidoId');

           // echo ' idpedido: '.$idPedido;
           // echo ' id usuario: '.$idUsuario;
           $results =  $this->pedido->where('idusuario_cadastro',$idUsuario)
                ->where('id',$idPedido)
                ->delete();
           // dd($results);

            return  response()->json(array('status' => 1,
                'debug'=>"ok",
                'msg' => 'Pedido apagado com sucesso!'))
                ->header('Content-Type','application/json');

        } catch (Exception $e) {
            return response()->json(array('status' => 0,
                'debug'=>$e->getMessage(),
                'msg' => 'Falha na conexão com o banco de dados'))
                ->header('Content-Type','application/json');
        }
    }

    public function registrar(Request $request)
    {
        try{
            $aDados = $request->all();

            $usuario = \App\Usuario::find($aDados['idusuario_cadastro']);

            if($usuario->tipo != 3){
                $pedido = $this->pedido->where('idusuario_cadastro','=',$aDados['idusuario_cadastro'])
                            ->where('finalizado', '=', '0')
                            ->take(1)->get();
                if(isset($pedido[0])){
                    return  response()->json(array('success' => false, 'msg' => "Você já possui um pedido em aberto, vá na página inicial em \"Pedido\" e finalize seus pedidos em aberto.", 200));
                }
            }

            if(is_array($aDados['idcidade']) && $aDados['idcidade'] != null)
                $aDados['idcidade'] = $aDados['idcidade']['id'];
            $aDados['finalizado'] = false;
            if(!isset($aDados['status']))
                $aDados['status'] = 2;
            $aDados['tipo_pagamento'] = 0;
            $aDados['idusuario_cadastro'] = $aDados['idusuario_cadastro'];
            $aDados['idusuario_alteracao'] = $aDados['idusuario_cadastro'];

            $pedido = $this->pedido->create($aDados);
            if(isset($aDados['diligencia'])){
                if(str_contains($aDados['diligencia'], ","))
                    $aDiligencias = explode(",", $aDados['diligencia']);
                else
                    $aDiligencias[] = $aDados['diligencia'];
                $pedido->diligencias()->sync($aDiligencias);
            }
            $pedido->save();

            return  response()->json(array('success' => true,'retorno' => $pedido->toArray(), 200));
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }
    }

    public function diligencia()
    {
        $response = null;
        try{
            $statusCode = 200;

            $diligencias = \App\Diligencia::where('status','=','1')->get();

            foreach($diligencias as $model){

                $response[] = [
                    'id' => (int) $model->id,
                    'nome' => $model->nome
                ];
            }

        }catch (Exception $e){
            $statusCode = 400;
        }finally{
            return response()->json($response, $statusCode);
        }
    }
}
