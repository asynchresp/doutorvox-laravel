<?php

namespace App\Http\Controllers;

use App\Usuario;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class UsuariosController extends Controller
{
    private $usuario;
	private $tipo_pessoa = array( 1 => "Pessoa F�sica",
	2 => "Advogado",
	3 => "Escrit�rio"
	);
	

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
                    'tipo_assinatura' => $model->tipo_assinatura

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
                "tipo_assinatura" => $usuario->tipo_assinatura,
                "tipo" => $this->tipo_pessoa[$usuario->tipo]
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
            $diligencias = $aDados['diligencias'];
            $this->usuario->create($aDados);
            $aDiligencias = array();
            foreach($diligencias as $diligenciaId)
            {
                if(is_array($diligenciaId))
                    $aDiligencias[] = $diligenciaId['id'];
                else
                    $aDiligencias[] = $diligenciaId;
            }
            $this->usuario->diligencias()->sync($aDiligencias);
            return  response()->json(array('success' => true,'retorno' => $this->usuario->toArray()), 200);
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
                'imagem_perfil' => $model->imagem_perfil,
                'tipo_assinatura' => $model->tipo_assinatura
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
            $usuario = $this->usuario->find($id);
            $usuario->update($aDados);
            $diligencias = $aDados['diligencias'];
            $aDiligencias = array();
            foreach($diligencias as $diligenciaId)
            {
                if(is_array($diligenciaId))
                    $aDiligencias[] = $diligenciaId['id'];
                else
                    $aDiligencias[] = $diligenciaId;
            }
            $usuario->diligencias()->sync($aDiligencias);

            return  response()->json(array('success' => true, 'retorno' => $usuario->toArray()), 200);
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

    public function UploadImagePerfil(Request $request)
    {
        $response = null;
        try{
            $statusCode = 200;
            $aDados = $request->all();
            $usuario = $this->usuario->find($aDados['Id']);
            if (Input::hasFile('file')) {
                $file = Input::file('file');
                $extension = $file->getClientOriginalExtension();
                $sNomeArquivo = md5($file->getClientOriginalName().date('dd/mm/yyyy hh:mm:ss')).'.'.$extension;
                if(Input::file('file')->move(__DIR__ . '/../../../public/fotos_perfil/', $sNomeArquivo)){
                    $usuario->update(array('imagem_perfil' => $sNomeArquivo));
                    $response = array('success' => true, 'mensagem' => 'Sua imagem foi enviado com sucesso.', 'imagem'=>$sNomeArquivo);
                } else {
                    echo '2';exit;
                    $response = array('success' => false, 'mensagem' => 'Erro ao enviar imagem ao servidor.');
                }
            } else {
                $response = array('success' => false, 'mensagem' => 'Nenhum arquivo foi encontrado.');
            }
        }catch(Exception $e){
            $response = [
                "error" => "Erro ao enviar foto."+$e->getMessage()
            ];
            $statusCode = 400;
        }finally{
            return  response()->json($response, $statusCode);
        }
    }
    public function usuario_senha(Request $request, $id)
    {
        $response = null;
        try{
            $aDados = $request->all();
            $model = $this->usuario->find($id);
            $statusCode = 200;

            if (Hash::check($aDados['password'], $model->password)){
                $model->update(array('password' => $aDados['new_password']));
                $response = array('success'=>true);
            } else {
                $response = array('success'=>false, 'mensagem' => 'Sua senha antiga e inválida.');
            }

        }catch(Exception $e){
            $response = [
                "error" => "data doesn`t exists"
            ];
            $statusCode = 400;
        }finally{
            return  response()->json($response, $statusCode);
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
