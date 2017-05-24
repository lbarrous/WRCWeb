<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 24/05/2017
 * Time: 11:50
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Repositories\UserRepository;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        //$this->middleware('auth');
        $this->repoRepository = $repository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function actualizarPerfil()
    {
        //return view('welcome');
    }

    public function showPerfil()
    {
        $datos = array();

        if(!\Auth::guest()) {
            $datos["usuario"] = $this->repoRepository->getUserByID(\Auth::user()->id);
        }
        return view('perfil')->with('datos', $datos);
    }
}
