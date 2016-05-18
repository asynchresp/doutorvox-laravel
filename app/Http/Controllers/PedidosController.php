<?php

namespace App\Http\Controllers;

use App\Pedido;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        try{
            $statusCode = 200;
            $response = [
                'pedidos'  => []
            ];

            $data = $this->pedido->orderBy('id','desc')->get();

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
            $pedido = $this->pedido->create($request->all());

            $diligencias = $request->input('diligencias');
            foreach($diligencias as $diligenciaId)
            {
                $pedido->diligencias()->attach($diligenciaId);
            }
            $pedido->save();

            return  response()->json(array('success' => true,'pedido' => $pedido->toArray(), 200));
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
        try{
            $model = $this->pedido->find($id);
            $statusCode = 200;
            $response = [ "pedido" => [
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
            ]];

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
            $pedido->update($request->all());
            $diligencias = $request->input('diligencias');
            $pedido->diligencias()->sync($diligencias);
            $pedido->save();


            return  response()->json(array('success' => true, 'pedido' => $pedido->toArray()), 200);
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
}
