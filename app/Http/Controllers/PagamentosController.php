<?php

namespace App\Http\Controllers;

use App\Pagamento;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagamentosController extends Controller
{
    private $pagamento;

    public function __construct(Pagamento $pagamento)
    {
        $this->pagamento = $pagamento;
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

            $data = $this->pagamento->orderBy('id','desc')->get();

            foreach($data as $model){

                $response[] = [
                    'id' => (int) $model->id,
                    'usuario' => $model->usuario,
                    'dtvencimento' => $model->dtvencimento,
                    'dtpagamento' => $model->dtpagamento,
                    'valor' => $model->valor,
                    'status' => $model->status,
                    'metodo_pagamento' => $model->metodo_pagamento
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
            return  response()->json(array('success' => true,'retorno' => $this->pagamento->create($request->all())->toArray()), 200);
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
            $model = $this->pagamento->find($id);
            $statusCode = 200;
            $response = [ "noticia" => [
                'id' => (int) $model->id,
                'usuario' => $model->usuario,
                'dtvencimento' => $model->dtvencimento,
                'dtpagamento' => $model->dtpagamento,
                'valor' => $model->valor,
                'status' => $model->status,
                'metodo_pagamento' => $model->metodo_pagamento
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
            $this->pagamento->find($id)->update($request->all());
            return  response()->json(array('success' => true, 'retorno' => $this->pagamento->find($id)->toArray()), 200);
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
            $this->pagamento->find($id)->delete();
            return  response()->json(array('success' => true), 200);
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }
    }
}
