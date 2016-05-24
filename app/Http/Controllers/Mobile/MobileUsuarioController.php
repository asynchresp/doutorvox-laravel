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
            return response()->json(array('status' => 1), 200)->header('Content-Type','application/json');
        }
        else
        {
            return response()->json(array('status' => 0), 200)->header('Content-Type','application/json');
        }
    }

}
