<?php

namespace App\Http\Controllers\Auth;

//use App\User;
//use App\Models\Entities\User;

use App\Models\Repositories\UserRepository;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->middleware('guest', ['except' => ['logout', 'getLogout']]);
        $this->repoRepository = $repository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'birth' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $date = str_replace('/', '-', $data["birth"]);
        $date = date('Y-m-d', strtotime($date));
        $data["birth"] = $date;

        $this->repoRepository->createUser($data);
    }

    //Metodo para redirigir a la pantalla de registro de usuario
    public function getRegister()
    {
        return view('register');
    }

    //Metodo para registrar un nuevo usuario
    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            /*$this->throwValidationException(
                $request, $validator
            );*/
            $msgerrors = $validator->messages()->all();
            $datos["msgsErroresValidator"] = $msgerrors;
            return view('register')->with($datos);
        }
        else {
            $this->create($request->all());
            $this->postLogin($request);
            return view('welcome');
        }
    }


    protected function getCredentials(Request $request)
    {
        return[
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];
    }

    //Metodo para redirigir a la pantalla de login
    public function getLogin()
    {
        return view('login');
    }

    //Metodo para hacer login de un nuevo usuario
    public function postLogin(Request $request)
    {
        $credentials = $this->getCredentials($request);

        if(\Auth::attempt($credentials))
        {
            return redirect("/home");
        }
        else {
            $datos["msgError"] = "Datos de login erroneos";
            return view('login')->with($datos);
        }
    }

    //Metodo para hacer logout del user logeado
    public function getLogout()
    {
        \Auth::logout();
        \Session::flush();
        return redirect("/home");
    }

}
