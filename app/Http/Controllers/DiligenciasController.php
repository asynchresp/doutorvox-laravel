<?php

namespace App\Http\Controllers;

use App\Diligencia;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DiligenciasController extends Controller
{
    private $diligencia;

    public function __construct(Diligencia $diligencia)
    {
        $this->diligencia = $diligencia;
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

            $diligencias = $this->diligencia->orderBy('id','desc')->get();

            foreach($diligencias as $model){

                $response[] = [
                    'id' => (int) $model->id,
                    'nome' => $model->nome,
                    'status' => $model->status,
                    'pedidos' => $model->pedidos
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
            return  response()->json(array('success' => true, 'retorno' => $this->diligencia->create($request->all())->toArray()), 200);
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
            $model = $this->diligencia->find($id);
            $statusCode = 200;
            $response = [ "diligencia" => [
                'id' => (int) $model->id,
                'nome' => $model->nome,
                'status' => $model->status,
                'pedidos' => $model->pedidos
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
            $this->diligencia->find($id)->update($request->all());
            return  response()->json(array('success' => true, 'retorno' => $this->diligencia->find($id)->toArray()), 200);
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
            $this->diligencia->find($id)->delete();
            return  response()->json(array('success' => true), 200);
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }
    }
}
