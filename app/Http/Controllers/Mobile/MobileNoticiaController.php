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
use App\Noticia;
use App\Usuario;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;
use Symfony\Component\HttpFoundation\Request;

class MobileNoticiaController extends Controller
{
    private $noticia;

    public function __construct(Noticia $noticia)
    {
        $this->noticia = $noticia;
    }

    public function obterNoticias(Request $request)
    {

        $dataAtualizacao = $request->input('data');
        try{
            if($dataAtualizacao)
            {
                // retorna as noticias depois da data de atualização
                return  response()->json(array('status' => 1,
                    'debug'=>'retornando com data de atualização',
                    'noticias' => $this->noticia->where('created_at', '>=', $dataAtualizacao)->get()))
                    ->header('Content-Type','application/json');
            }
            else
            {
                // retorna as ultimas dez noticias
                return  response()->json(array('status' => 1,
                    'debug'=>'retornando sem data de atualização',
                    'noticias' => $this->noticia->take(10)->orderBy('id', 'desc')->get()))
                    ->header('Content-Type','application/json');
            }
        }catch(Exception $e)
        {
            response()->json(array('status' => 0,
                'debug'=>$e->getMessage(),
                'msg' => 'Falha na conexão com o banco de dados ao buscar noticias'))
                ->header('Content-Type','application/json');
        }
    }
}
