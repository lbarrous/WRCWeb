<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Entities\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function mail()
    {
        $user = User::find(1)->toArray();
        \Mail::send('emails.mailEvent', $user, function($message) use ($user) {
            $message->to($user["email"]);
            $message->subject('Mailgun Testing');
        });
        dd('Mail Send Successfully');
    }
}
