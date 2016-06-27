<?php

namespace App\Http\Controllers;

use App\Andamento;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AndamentosController extends Controller
{
    private $andamento;

    public function __construct(Andamento $andamento)
    {
        $this->andamento = $andamento;
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
                'andamentos'  => []
            ];

            $data = $this->andamento->orderBy('id','desc')->get();

            foreach($data as $model){

                $response['andamentos'][] = [
                    'id' => (int) $model->id,
                    'usuario' => $model->usuario,
                    'pedido' => $model->pedido,
                    'comentario' => $model->comentario,
                    'status' => $model->status
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
            $aDados['idusuario'] = Auth::user()->id;
            $this->andamento = $this->andamento->create($aDados);
            $usuario = \App\Usuario::find($this->andamento->idusuario);
            $response = [
                'id' => (int) $this->andamento->id,
                'usuario' => $usuario,
                'pedido' => $this->andamento->pedido,
                'comentario' => $this->andamento->comentario,
                'status' => $this->andamento->status,
                'created_at' => $this->dateTimeFormatBr($this->andamento->created_at)
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
            $model = $this->andamento->find($id);
            $statusCode = 200;
            $response = [ "andamento" => [
                'id' => (int) $model->id,
                'usuario' => $model->usuario,
                'pedido' => $model->pedido,
                'comentario' => $model->comentario,
                'status' => $model->status
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
            $aDados = $request->all();
            $aDados['idusuario'] = Auth::user()->id;
            $andamento = $this->andamento->find($id);
            $andamento->update($aDados);
            $response = [
                'status' => $andamento->status
            ];
            return  response()->json(array('success' => true, 'retorno' => $response), 200);
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
            $this->andamento->find($id)->delete();
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
