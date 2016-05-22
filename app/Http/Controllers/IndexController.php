<?php
/**
 * Created by PhpStorm.
 * User: Richard
 * Date: 19/05/2016
 * Time: 20:12
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

    public function login()
    {
        return view('login');
    }
}
