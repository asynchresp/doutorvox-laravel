<?php

namespace App\Http\Controllers;

use App\Estado;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EstadosController extends Controller
{
    private $estado;

    public function __construct(Estado $estado)
    {
        $this->estado = $estado;
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
                'estados'  => []
            ];

            $estados = $this->estado->orderBy('id','desc')->get();

            foreach($estados as $estado){

                $response['estados'][] = [
                    'id' => (int) $estado->id,
                    'nome' => $estado->nome,
                    'uf' => $estado->uf,
                    'ativo' => $estado->ativo,
                    'usuarios' => $estado->usuarios
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

            return  response()->json(array('success' => true, 'estado' => $this->estado->create($request->all())->toArray()), 200);
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
            $estado = $this->estado->find($id);
            $statusCode = 200;
            $response = [ "estado" => [
                'id' => (int) $estado->id,
                'nome' => $estado->nome,
                'uf' => $estado->uf,
                'ativo' => $estado->ativo,
                'usuarios' => $estado->usuarios
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
            $this->estado->find($id)->update($request->all());
            return  response()->json(array('success' => true, 'estado' => $this->estado->find($id)->toArray()), 200);
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
            $this->estado->find($id)->delete();
            return  response()->json(array('success' => true), 200);
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }
    }

    public function auth()
    {
        $user = \App\Usuario::find();
    }
}
