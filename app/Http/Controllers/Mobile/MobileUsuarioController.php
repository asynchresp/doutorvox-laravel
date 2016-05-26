<?php
namespace App\Http\Controllers\Mobile;
/**
 * Created by PhpStorm.
 * User: maykon
 * Date: 14/05/16
 * Time: 21:22
 */

use App\Http\Controllers\Controller;
use App\Usuario;
use Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Request;

class MobileUsuarioController extends Controller
{
    private $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    public function login(Request $request)
    {
        $returnAuth = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);
        if($returnAuth)
        {
            return response()->json(array('status' => 1))->header('Content-Type','application/json');
        }
        else
        {
            return response()->json(array('status' => 0))->header('Content-Type','application/json');
        }
    }

    public function registrar(Request $request)
    {
       $validator =  Validator::make($request->all(), [
            'nome' => 'required|max:255',
            'email' => 'required|email|max:255|unique:usuarios',
            'cpf_cnpj' => 'required|min:11|max:11',
        ]);

        // passou na validação
        if($validator->passes())
        {
            try{
                $usuario =  $this->usuario->create($request->all());
                return response()->json(array(
                                'status' => 1,
                                'msg' => 'Cadastro realizado com sucesso',
                                'usuario' => $usuario->id,
                                'debug'=> 'usuario criado no banco'))
                    ->header('Content-Type','application/json');
            }
            // erro ao tentar salvar no banco
            catch(Exception $e){
               return  response()->json(array('status' => 0,
                                       'debug'=>$e->getMessage(),
                                       'msg' => 'Falha na conexão com o banco de dados',
                                        $usuario->id))
                                ->header('Content-Type','application/json');
            }
        }
        else
        {
            // nao passou na validação
            return response()->json(array('status' => 0, 'debug' => 'ERRO-VALIDAR','msg'=>$validator->errors()->all()))->header('Content-Type','application/json');
        }
    }

}
