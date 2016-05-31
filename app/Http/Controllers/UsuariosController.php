<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    private $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
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
            $data = $this->usuario->orderBy('id','desc')->get();

            foreach($data as $model){

                $response[] = [
                    'id' => (int) $model->id,
                    'nome' => $model->nome,
                    'email' => $model->email,
                    'cpf_cnpj' => $model->cpf_cnpj,
                    'telefone' => $model->telefone,
                    'comercial' => $model->comercial,
                    'celular' => $model->celular,
                    'tipo' => $model->tipo,
                    'logradouro' => $model->logradouro,
                    'bairro' => $model->bairro,
                    'cidade' => $model->cidade,
                    'estado' => $model->estado,
                    'cep' => $model->cep,

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

    public function get_usuario_logado()
    {
        try{
            $usuario = \App\Usuario::find(Auth::user()->id);
            $aDados = [
                "id" => $usuario->id,
                "nome" => $usuario->nome,
                "email" => $usuario->email,
                "tipo_assinatura" => $usuario->tipo_assinatura
            ];
            return  response()->json(array('success' => true,'retorno' => $aDados), 200);
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }
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
            return  response()->json(array('success' => true,'retorno' => $this->usuario->create($aDados)->toArray()), 200);
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
            $model = $this->usuario->find($id);
            $statusCode = 200;
            $response =  [
                'id' => (int) $model->id,
                'nome' => $model->nome,
                'email' => $model->email,
                'cpf_cnpj' => $model->cpf_cnpj,
                'telefone' => $model->telefone,
                'comercial' => $model->comercial,
                'celular' => $model->celular,
                'tipo' => $model->tipo,
                'logradouro' => $model->logradouro,
                'bairro' => $model->bairro,
                'estado' => $model->estado,
                'cep' => $model->cep,
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
            if(is_array($aDados['idcidade']) && $aDados['idcidade'] != null)
                $aDados['idcidade'] = $aDados['idcidade']['id'];
            $this->usuario->find($id)->update($aDados);
            return  response()->json(array('success' => true, 'retorno' => $this->usuario->find($id)->toArray()), 200);
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
            $this->usuario->find($id)->delete();
            return  response()->json(array('success' => true), 200);
        }catch (Exception $e){
            return  response()->json(array('success' => false), 400);
        }
    }

    public function advogado()
    {
        try{
            $statusCode = 200;
            $response = [
                'usuarios'  => []
            ];

            $data = $this->usuario->orderBy('id','desc')->get()->where('tipo',0);

            foreach($data as $model){

                $response['usuarios'][] = [
                    'id' => (int) $model->id,
                    'nome' => $model->nome,
                    'email' => $model->email,
                    'cpf_cnpj' => $model->cpf_cnpj,
                    'telefone' => $model->telefone,
                    'comercial' => $model->comercial,
                    'celular' => $model->celular,
                    'tipo' => $model->tipo,
                    'logradouro' => $model->logradouro,
                    'bairro' => $model->bairro,
                    'cidade' => $model->cidade,
                    'estado' => $model->estado,
                    'cep' => $model->cep,

                ];
            }

        }catch (Exception $e){
            $statusCode = 400;
        }finally{
            return response()->json($response, $statusCode);
        }
    }

    public function advogadoDashboard()
    {
        try{
            $statusCode = 200;
            $response = [
                'usuarios'  => []
            ];

            $data = $this->usuario->orderBy('id','desc')->get()->where('tipo',2)->take(20);

            foreach($data as $model){

                $response['usuarios'][] = [
                    'id' => (int) $model->id,
                    'nome' => $model->nome,
                    'email' => $model->email,
                    'cpf_cnpj' => $model->cpf_cnpj,
                    'telefone' => $model->telefone,
                    'comercial' => $model->comercial,
                    'celular' => $model->celular,
                    'tipo' => $model->tipo,
                    'logradouro' => $model->logradouro,
                    'bairro' => $model->bairro,
                    'cidade' => $model->cidade,
                    'estado' => $model->estado,
                    'cep' => $model->cep,

                ];
            }

        }catch (Exception $e){
            $statusCode = 400;
        }finally{
            return response()->json($response, $statusCode);
        }
    }




}
