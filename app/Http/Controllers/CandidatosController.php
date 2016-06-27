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
        /**
         * idpedido
         * idusuario
         * valor_proposta = "R$ 365,32"
         */
        try{
            $aDados = $request->all();
            $aDados['valor_proposta'] = \App\Http\Controllers\PedidosController::formataValor($aDados['valor_proposta']);
            $aDados['dhproposta'] = date("d/m/Y H:m:s");
            $idproposta = $this->candidato->where(array('idpedido'=>$aDados['idpedido'], 'idusuario' => $aDados['idusuario']))->value('id');
            if($idproposta > 0)
                return  response()->json(array('success' => false,'message' => 'Você já possui uma proposta para este pedido.'), 200);

            $this->candidato->create($aDados)->toArray();

            return  response()->json(array('success' => true), 200);
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
            $aData = $request->all();
            unset($aData['dhproposta']);
            unset($aData['valor_proposta']);
            $model->update($aData);

            $response = [
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
