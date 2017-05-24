<?php
/**
 * Created by PhpStorm.
 * User: Alvaro
 * Date: 24/05/2017
 * Time: 11:50
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Validator;
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
    public function actualizarPerfil(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $msgerrors = $validator->messages()->all();
            $datos["msgsErroresValidator"] = $msgerrors;
            return view('perfil')->with($datos);
        }
        else {
            $this->repoRepository->actualizarUserByID(\Auth::user()->id, $request->all());
            $datos["usuario"] = $this->repoRepository->getUserByID(\Auth::user()->id);
            //$datos["usuario"]["birth"] = $date = str_replace('-', '/', $datos["usuario"]["birth"]);
            return view('perfil')->with('datos', $datos);
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,id',
            'birth' => 'required',
        ]);
    }

    public function showPerfil()
    {
        $datos = array();

        if(!\Auth::guest()) {
            $datos["usuario"] = $this->repoRepository->getUserByID(\Auth::user()->id);
            //$datos["usuario"]["birth"] = $date = str_replace('-', '/', $datos["usuario"]["birth"]);
        }
        return view('perfil')->with('datos', $datos);
    }
}
