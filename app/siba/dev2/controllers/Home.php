<?php

namespace Siba\dev2\controllers;


use View;
use \Siba\dev2\classes\ReporteCanalesGenericos;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Home extends Controller {

	
	public function home(){
		$name = ucfirst(Auth::user()->nombres);
		return View::make('home',compact('name'));
	}
	

	public function queryAjax(){

		$fechaIni = trim(date('Y-m-d 00:00:00',time()));
		$fechaFin = date('Y-m-d 00:00:00',strtotime($fechaIni.'+ 3 days'));
		$reporte = new ReporteCanalesGenericos();
		$query = $reporte->getCanalesGenericos($fechaIni,$fechaFin);
		$query_json = \Response::make(json_encode($query),200)->header('Content-type','text/plain');
		return $query_json;
	}
	


}
