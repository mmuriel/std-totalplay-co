<?php
namespace Siba\dev2\controllers;

use App\Http\Controllers\Controller;
use Siba\Dev2\Classes\SibaAuth;
use \View;
use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Login extends Controller {

    public function getIndex(){
        return View::make('login');
    }


	public function postUser(Request $request){
		$userdata = array(
            'email' => $request->input('email'),
            'password' => $request->input('pass'),
            'pwd' => md5($request->input('pass')),
        );
        if (SibaAuth::validate($userdata))
        {
            $user = Usuarios::whereRaw("email = '".$userdata['email']."' ")->first();
            Auth::login($user);
            return redirect('/home');
        }
        return redirect('/login')->withErrors('El nombre de usuario o contraseña son incorrectos');
	}
}
