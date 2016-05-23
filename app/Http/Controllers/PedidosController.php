<?php

namespace App\Http\Controllers;

use App\Pedido;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PedidosController extends Controller
{
    private $pedido;

    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = null;
        try{
            $statusCode = 200;

            $data = $this->pedido->orderBy('id','desc')->get();

            foreach($data as $model){

                $response[] = [
                    'id' => (int) $model->id,
                    'status' => $model->status,
                    'finalizado' => $model->finalizado,
                    'tipo_pagamento' => $model->tipo_pagamento,
                    'valor_minimo' => $model->valor_minimo,
                    'valor_maximo' => $model->valor_maximo,
                    'cidade' => $model->cidade,
                    'usuario_cadastro' => $model->usuarioCadastrouPedido,
                    'usuario_alteracao' => $model->usuarioAlterouPedido,
                    'diligencias' => $model->diligencias,
                    'avaliacoes' => $model->avaliacoes,
                    'candidatos' => $model->candidatos,
                    'andamentos' => $model->andamentos
                ];
            }

        }catch (Exception $e){
            $statusCode = 400;
        }finally{
            return response()->json($response, $statusCode);
        }
    }

    public function pedidoDashboard()
    {
        $response = null;
        try{
            $statusCode = 200;
            $response = [
                'pedidos'  => []
            ];

            $data = $this->pedido->orderBy('id','desc')->get()->take(20);

            foreach($data as $model){

                $response['pedidos'][] = [
                    'id' => (int) $model->id,
                    'status' => $model->status,
                    'finalizado' => $model->finalizado,
                    'tipo_pagamento' => $model->tipo_pagamento,
                    'valor_minimo' => $model->valor_minimo,
                    'valor_maximo' => $model->valor_maximo,
                    'cidade' => $model->cidade,
                    'usuario_cadastro' => $model->usuarioCadastrouPedido,
                    'usuario_alteracao' => $model->usuarioAlterouPedido,
                    'diligencias' => $model->diligencias,
                    'avaliacoes' => $model->avaliacoes,
                    'candidatos' => $model->candidatos,
                    'andamentos' => $model->andamentos
                ];
            }

        }catch (Exception $e){
            $statusCode = 400;
        }finally{
            return response()->json($response, $statusCode);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $aDados = $request->all();
            if(is_array($aDados['idcidade']) && $aDados['idcidade'] != null)
                $aDados['idcidade'] = $aDados['idcidade']['id'];
            $aDados['finalizado'] = false;
            $aDados['tipo_pagamento'] = 0;
            $aDados['idusuario_cadastro'] = Auth::user()->id;
            $aDados['idusuario_alteracao'] = Auth::user()->id;
            $pedido = $this->pedido->create($aDados);
            $diligencias = $request->input('diligencias');
            $aDiligencias = array();
            foreach($diligencias as $diligenciaId)
            {
                if(is_array($diligenciaId))
                    $aDiligencias[] = $diligenciaId['id'];
                else
                    $aDiligencias[] = $diligenciaId;
            }
            $pedido->diligencias()->sync($aDiligencias);
            $pedido->save();

            return  response()->json(array('success' => true,'retorno' => $pedido->toArray(), 200));
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = null;
        try{
            $model = $this->pedido->find($id);
            $statusCode = 200;
            $response =  [
                'id' => (int) $model->id,
                'status' => $model->status,
                'finalizado' => $model->finalizado,
                'tipo_pagamento' => $model->tipo_pagamento,
                'valor_minimo' => $model->valor_minimo,
                'valor_maximo' => $model->valor_maximo,
                //'cidade' => $model->cidade,
                'usuario_cadastro' => $model->usuarioCadastrouPedido,
                'usuario_alteracao' => $model->usuarioAlterouPedido,
                //'diligencias' => $model->diligencias,
                'avaliacoes' => $model->avaliacoes,
                //'candidatos' => $model->candidatos,
                //'andamentos' => $model->andamentos
            ];

            $aDiligencias = array();
            foreach ($model->diligencias as $diligencia){
                $aDiligencias[] = $diligencia->id;
            }
            if(count($aDiligencias)>0)
                $response['diligencias'] = join(",", $aDiligencias);
            else
                $response['diligencias'] = "";

            if($model->cidade)
                $response['idcidade'] = $model->cidade->id;
            else
                $response['idcidade'] = "";

            if(count($model->andamentos) > 0 ){
                foreach ($model->andamentos as $andamento){
                    $usuario = \App\Usuario::find($andamento->idusuario);
                    $response['andamentos'][] = [
                        'comentario' => $andamento->comentario,
                        'status' => $andamento->status ,
                        'usuario' => $usuario,
                        'created_at' => $this->dateTimeFormatBr($andamento->created_at)
                    ];
                }
            }

            if(count($model->candidatos) > 0 ){
                foreach ($model->candidatos as $candidato){
                    $usuario = \App\Usuario::find($candidato->idusuario);
                    $response['candidatos'][] = [
                        'id' => $candidato->id,
                        'idusuario' => $candidato->idusuario,
                        'idpedido' => $candidato->idpedido ,
                        'dhproposta' => $candidato->dhproposta ,
                        'valor_proposta' => $candidato->valor_proposta ,
                        'aprovado' => $candidato->aprovado ,
                        'usuario' => $usuario,
                        'dhproposta' => $this->dateTimeFormatBr($candidato->dhproposta)
                    ];
                }
            }


        }catch(Exception $e){
            $response = [
                "error" => "data doesn`t exists"
            ];
            $statusCode = 400;
        }finally{
            return  response()->json($response, $statusCode);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        try{
            $pedido = $this->pedido->find($id);
            $aDados = $request->all();
            $aDados['idusuario_alteracao'] = $request->user()->id;
            if(is_array($aDados['idcidade']) && $aDados['idcidade'] != null)
                $aDados['idcidade'] = $aDados['idcidade']['id'];
            $aDados['idusuario_alteracao'] = Auth::user()->id;
            $pedido->update($aDados);
            $diligencias = $request->input('diligencias');
            $aDiligencias = array();
            foreach($diligencias as $diligenciaId)
            {
                if(is_array($diligenciaId))
                    $aDiligencias[] = $diligenciaId['id'];
                else
                    $aDiligencias[] = $diligenciaId;
            }
            $pedido->diligencias()->sync($aDiligencias);
            $pedido->save();


            return  response()->json(array('success' => true, 'retorno' => $pedido->toArray()), 200);
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $this->pedido->find($id)->delete();
            return  response()->json(array('success' => true), 200);
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }
    }

    function dateTimeFormatBr($pDate){
        if(!$pDate)
            return null;
        list($date, $time) = explode(' ', $pDate);
        $aux = explode('-', $date);
        $data = $aux[2].'/'.$aux[1].'/'.$aux[0].' '.$time;
        return $data ;
    }
}
