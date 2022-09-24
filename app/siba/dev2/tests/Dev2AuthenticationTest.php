<?php

/*
use \User;
use \Auth;
*/

use \Siba\dev2\classes\SibaAuth;
use Tests\TestCase;
use App\Models\Usuarios;

class Dev2AuthenticationTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */


	/* Test for  */
	public function testTestAddNewUserToDB(){

		$user = Usuarios::whereRaw(" email='juan@p.com' ")->first();
		if($user){
			$user->delete();
		}

		$user = new Usuarios();
		$user->nombres = 'juan';
		$user->apellidos = 'juan';
		$user->email = 'juan@p.com';
		$user->pwd = md5('Testing-123456_');
		$user->password = Hash::make('Testing-123456_');
		$user->tipo_usr = 'client';
		$operationResult = $user->save();
		$usrUnderTesting = Usuarios::whereRaw(" email='juan@p.com' ")->first();

		$this->assertEquals($user->email,$usrUnderTesting->email);
		$this->assertEquals(md5('Testing-123456_'),$usrUnderTesting->pwd);

		//Se borra el usuario en la base de datos, esto es solo un test
		$usrUnderTesting->delete();
	}

	public function testValidateADev2User(){
		/*
			There must be an user with next attributes in database, this is a real world app user,
			I hope he isn't fired by the time when you run this test, becasue this user is MEEEEEEE!:
			{
				'email':'mauricio.muriel@calitek.net',
				'nombres':'Mauricio',
				'apellidos':'Muriel',
				'pwd': 'e10adc3949ba59...', (too much details ;-) )
				'tipo_usr':'admin'
			}
		*/

		//print_r($user);
		$this->assertTrue(SibaAuth::validate(array('email'=>'mauricio.muriel@calitek.net','pwd'=>md5('123456'),'password'=>'123456')));
	}

	public function testLogingADev2User(){
		/*
			There must be an user with next attributes in database, this is a real world app user,
			I hope he isn't fired by the time when you run this test, becasue this user is MEEEEEEE!:
			{
				'email':'mauricio.muriel@calitek.net',
				'nombres':'Mauricio',
				'apellidos':'Muriel',
				'pwd': 'e10adc3949ba59...', (too much details ;-) )
				'tipo_usr':'admin'
			}
		*/

		if (\Auth::check()){
			Auth::logout();
		}

		
		$usrUnderTesting = Usuarios::whereRaw(" email='mauricio.muriel@calitek.net' ")->first();
		\Auth::login($usrUnderTesting);
		$this->assertEquals('mauricio.muriel@calitek.net',Auth::user()->email);
		Auth::logout();
		$this->assertFalse(\Auth::check());
	}

	public function testValidateAStdUser(){
		$user = Usuarios::whereRaw(" email='juan@p.com' ")->first();
		if($user){
			$user->delete();
		}

		$user = new Usuarios();
		$user->nombres = 'juan';
		$user->apellidos = 'juan';
		$user->email = 'juan@p.com';
		$user->password = Hash::make('Testing-123456_');
		$user->tipo_usr = 'client';
		$operationResult = $user->save();
		$usrUnderTesting = Usuarios::whereRaw(" email='juan@p.com' ")->first();
		$this->assertTrue(SibaAuth::validate(array('email'=>'juan@p.com','pwd'=>md5('Testing-123456_'),'password'=>'Testing-123456_')));
		//$user->delete();
	}


	/*

		Test de Integracion

	*/

	

}
