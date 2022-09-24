<?php

namespace Siba\dev2\classes;

use \Auth;
use App\Models\Usuarios;


class SibaAuth extends Auth {

	public static function validate($params){
		$user = Usuarios::whereRaw (" email='".$params['email']."' && pwd = '".$params['pwd']."' ")->first();
		if ($user){
			return true;
		}
		unset($params['pwd']);//Elimina el campo que no sirva, para evitar falllo.
		return Auth::validate($params);
	}

}