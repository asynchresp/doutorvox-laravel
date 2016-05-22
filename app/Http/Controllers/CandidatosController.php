<?php

namespace App\Http\Controllers;

use App\Candidato;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CandidatosController extends Controller
{
    private $candidato;

    public function __construct(Candidato $candidato)
    {
        $this->candidato = $candidato;
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
                'candidatos'  => []
            ];

            $data = $this->candidato->orderBy('id','desc')->get();

            foreach($data as $model){

                $response['candidatos'][] = [
                    'id' => (int) $model->id,
                    'usuario' => $model->usuario,
                    'pedido' => $model->pedido,
                    'dhproposta' => $model->dhproposta,
                    'valor_proposta' => $model->valor_proposta,
                    'aprovado' => $model->aprovado
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
            $this->candidato->create($request->all())->toArray();
            $usuario = \App\Usuario::find($this->candidato->idusuario);
            $response = [
                'id' => (int) $this->candidato->id,
                'usuario' => $usuario,
                'idusuario' => $this->candidato->idusuario,
                'idpedido' => $this->candidato->idpedido,
                'dhproposta' => $this->candidato->dhproposta,
                'aprovado' => $this->candidato->aprovado
            ];

            return  response()->json(array('success' => true,'retorno' => $response), 200);
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
            $model = $this->candidato->find($id);
            $statusCode = 200;
            $response = [ "candidato" => [
                'id' => (int) $model->id,
                'usuario' => $model->usuario,
                'pedido' => $model->pedido,
                'dhproposta' => $model->dhproposta,
                'valor_proposta' => $model->valor_proposta,
                'aprovado' => $model->aprovado
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
            $model = $this->candidato->find($id);
            $model->update($request->all());
            $usuario = \App\Usuario::find($this->candidato->idusuario);
            $response = [
                'id' => (int) $model->id,
                'usuario' => $usuario,
                'idusuario' => $model->idusuario,
                'idpedido' => $model->idpedido,
                'dhproposta' => $model->dhproposta,
                'aprovado' => $model->aprovado
            ];

            return  response()->json(array('success' => true, 'candidato' => $response), 200);
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
            $this->candidato->find($id)->delete();
            return  response()->json(array('success' => true), 200);
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }
    }

    function dateTimeFormatEn($pDate){
        if(!$pDate)
            return null;
        list($date, $time) = explode(' ', $pDate);
        $aux = explode('/', $date);
        $data = $aux[2].'-'.$aux[1].'-'.$aux[0].' '.$time;
        return $data ;
    }
}
