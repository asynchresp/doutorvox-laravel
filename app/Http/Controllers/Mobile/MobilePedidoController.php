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

            // andamento pode ser 1 ou 0, se for 0, buscar pedidos novos, senao pedidos em andamento(1)
            $statusPedido = $request->input('andamento');

            $usuario = $this->usuario->find($idUsuario);


            if($usuario)
            {
                $pedidos = $this->pedido->with('diligencias')
                    ->with('andamentos')
                    ->with('candidatos')
                    ->with('avaliacoes')
                    ->with('cidade')
                    ->where('idusuario_cadastro',$idUsuario)
                    ->where('status',$statusPedido)->get();
                return  response()->json(array('status' => 1,
                    'pedidos' => $pedidos,
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
}
