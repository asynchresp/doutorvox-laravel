<?php

namespace App\Http\Controllers;

use App\Avaliacao;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AvaliacoesController extends Controller
{
    private $avaliacao;

    public function __construct(Avaliacao $avaliacao)
    {
        $this->avaliacao = $avaliacao;
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
                'avaliacoes'  => []
            ];

            $data = $this->avaliacao->orderBy('id','desc')->get();

            foreach($data as $model){

                $response['avaliacoes'][] = [
                    'id' => (int) $model->id,
                    'usuario' => $model->usuario,
                    'pedido' => $model->pedido,
                    'nota' => $model->nota
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
            return  response()->json(array('success' => true,'avaliacao' => $this->avaliacao->create($request->all())->toArray()), 200);
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
            $model = $this->avaliacao->find($id);
            $statusCode = 200;
            $response = [ "avaliacao" => [
                'id' => (int) $model->id,
                'usuario' => $model->usuario,
                'pedido' => $model->pedido,
                'nota' => $model->nota
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
            $this->avaliacao->find($id)->update($request->all());
            return  response()->json(array('success' => true, 'avaliacao' => $this->avaliacao->find($id)->toArray()), 200);
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
            $this->avaliacao->find($id)->delete();
            return  response()->json(array('success' => true), 200);
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }
    }
}
