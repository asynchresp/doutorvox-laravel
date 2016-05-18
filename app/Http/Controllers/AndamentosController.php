<?php

namespace App\Http\Controllers;

use App\Andamento;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
            return  response()->json(array('success' => true,'andamento' => $this->andamento->create($request->all())->toArray()), 200);
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
            $this->andamento->find($id)->update($request->all());
            return  response()->json(array('success' => true, 'andamento' => $this->andamento->find($id)->toArray()), 200);
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
}
