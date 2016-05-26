<?php
namespace App\Http\Controllers\Mobile;
/**
 * Created by PhpStorm.
 * User: maykon
 * Date: 14/05/16
 * Time: 21:22
 */

use App\Cidade;
use App\Http\Controllers\Controller;
use App\Usuario;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class MobileUsuarioController extends Controller
{
    private $usuario;
    private $cidade;

    public function __construct(Usuario $usuario, Cidade $cidade)
    {
        $this->usuario = $usuario;
        $this->cidade = $cidade;
    }

    public function login(Request $request)
    {
        $returnAuth = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);
        if($returnAuth)
        {
            return response()->json(array('status' => 1,
                                    'debug' => 'realizou login',
                                    'msg' => 'Usuário logado com sucesso',
                                    'usuario' => Auth::user()))
                                    ->header('Content-Type','application/json');
        }
        else
        {
            return response()->json(array('status' => 0,
                                    'debug' => 'não logou','msg'=> 'Os dados informados estão incorretos'))
                                    ->header('Content-Type','application/json');
        }
    }

    public function registrar(Request $request)
    {

        // tratar primeiramente os parametros relacioandos a cidade
        $cidade = $request->input('cidade');
        $estado = $request->input('estado');

        if($cidade != "" && $estado != "")
        {
            $idcidade = 0;
            try{
                $cidadeResult = $this->cidade
                    ->where('cidade', $cidade)
                    ->where('estado', $estado)
                    // first = apenas um resultado
                    ->first();

                // cidade já existe, só precisamos do Id para associar ao usuário
                if($cidadeResult)
                {
                    $idcidade = $cidadeResult->id;
                }
                else
                {
                    // precisamos salvar a cidade e pegar o id de retorno para associar ao usuário
                    $idcidade = $this->cidade->insertGetId(
                        ['cidade' => $cidade, 'estado' => $estado]
                    );
                }
            }// erro ao tentar salvar/selecionar no banco
            catch(Exception $e){
                return  response()->json(array('status' => 0,
                    'debug'=>$e->getMessage(),
                    'msg' => 'Falha na conexão com o banco de dados ao salvar/selecionar cidade'))
                    ->header('Content-Type','application/json');
            }

            // adicionando o id da cidade para a requisição
            $request->merge(array('idcidade' => $idcidade));
            
            $validator =  Validator::make($request->all(), [
                'nome' => 'required|max:255',
                'email' => 'required|email|max:255|unique:usuarios',
                'cpf_cnpj' => 'required|min:11|max:11',
                'logradouro' => 'required',
                'bairro' => 'required',
                'cep' => 'required',
                'tipo' => 'required'
            ]);

            // passou na validação
            if($validator->passes())
            {
                try{
                    $usuario =  $this->usuario->create($request->all());
                    return response()->json(array(
                        'status' => 1,
                        'msg' => 'Cadastro realizado com sucesso',
                        'idusuario' => $usuario->id,
                        'debug'=> 'usuario criado no banco'))
                        ->header('Content-Type','application/json');
                }
                    // erro ao tentar salvar no banco
                catch(Exception $e){
                    return  response()->json(array('status' => 0,
                        'debug'=>$e->getMessage(),
                        'msg' => 'Falha na conexão com o banco de dados ao salvar o usuário'))
                        ->header('Content-Type','application/json');
                }
            }
            else
            {
                // nao passou na validação
                return response()->json(array('status' => 0, 'debug' => 'ERRO-VALIDAR','msg'=>$validator->errors()->all()))->header('Content-Type','application/json');
            }
        }
        else
        {
            return response()->json(array('status' => 0, 'debug' => 'Não enviou cidade nem estado','msg'=>'Falha na comunicação com o servidor.'))->header('Content-Type','application/json');
        }
    }

}
