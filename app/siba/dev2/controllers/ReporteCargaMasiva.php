<?php

namespace Siba\dev2\controllers;

use View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReporteCargaMasiva extends Controller {

	
	public function index(){
		$name = ucfirst(\Auth::user()->nombres);
		$std =  \Siba\Dev2\Models\ReporteCargaMasiva::all();
		return View::make('reporteCargaMasiva',compact('std','name'));
	}

	public function queryAjax(Request $request){

		$query =  \Siba\Dev2\Models\ReporteCargaMasiva::all();
		$query_json = \Response::make(json_encode($query),200)->header('Content-type','text/plain');
	
	
		$datos = array(
			'canal' => $request->input('iptCanal'),
			'fechaIni' => str_replace("T"," ",$request->input('iptFechaIni')),
			'fechaFin' => $request->input('iptFechaFin'),
			'estado' => $request->input('iptStatus')
		);


		//Cuando todos los campos estan vacios
		if($datos["canal"] == ""  && $datos["fechaIni"] == "" && $datos["fechaFin"] == "" && $datos["estado"] == ""){
			$query =  \Siba\Dev2\Models\ReporteCargaMasiva::all();
			$query_json = \Response::make(json_encode($query),200)->header('Content-type','text/plain');

			return $query_json;
		
		//Cuando el campo canal esta lleno
		}else if($datos["canal"] != ""  && $datos["fechaIni"] == "" && $datos["fechaFin"] == "" && $datos["estado"] == ""){
			
			$query =  \DB::table('std_loaddata_files')
			->select('std_loaddata_files.*')
			->where('name','LIKE', '%' . $datos['canal'] . '%')
			->orderBy('created_at','desc')
			->get();

			$query_json = \Response::make(json_encode($query),200)->header('Content-type','text/plain');

			return $query_json;

		}//Cuando el campo status es lleno
		else if($datos["canal"] == ""  && $datos["fechaIni"] == "" && $datos["fechaFin"] == "" && $datos["estado"] != ""){
			
			$query =  \DB::table('std_loaddata_files')
			->select('std_loaddata_files.*')
			->where('status',$datos['estado'])
			->orderBy('created_at','desc')
			->get();

			$query_json = \Response::make(json_encode($query),200)->header('Content-type','text/plain');

			return $query_json;

		//Cuando el campo Fecha Inici y Fecha final  esta lleno	
		}else if($datos["canal"] == ""  && $datos["fechaIni"] != "" && $datos["fechaFin"] != "" && $datos["estado"] == ""){
			
			$query =  \DB::table('std_loaddata_files')
			->select('std_loaddata_files.*')
			->whereBetween('created_at',[$datos['fechaIni'],$datos['fechaFin']])
			->orderBy('created_at','desc')
			->get();

			$query_json = \Response::make(json_encode($query),200)->header('Content-type','text/plain');

			return $query_json;

		//Cuando todos los campos estan llenos
		}else if($datos["canal"] != "" && $datos["fechaIni"] != "" && $datos["fechaFin"] != "" && $datos["estado"] != ""){
			
			$query =  \DB::table('std_loaddata_files')
			->select('std_loaddata_files.*')
			->where('name','LIKE', '%' . $datos['canal'] . '%')
			->whereBetween('created_at',[$datos['fechaIni'],$datos['fechaFin']])
			->where('status',$datos['estado'])
			->orderBy('created_at','desc')
			->get();

			$query_json = \Response::make(json_encode($query),200)->header('Content-type','text/plain');

			return $query_json;
		}// Cuando canal y estado estan llenos
		else if($datos["canal"] != "" && $datos["fechaIni"] == "" && $datos["fechaFin"] == "" && $datos["estado"] != ""){
			
			$query =  \DB::table('std_loaddata_files')
			->select('std_loaddata_files.*')
			->where('name','LIKE', '%' . $datos['canal'] . '%')
			->where('status',$datos['estado'])
			->orderBy('created_at','desc')
			->get();

			$query_json = \Response::make(json_encode($query),200)->header('Content-type','text/plain');

			return $query_json;
		}// Cuando canal, fecha inicio y fecha final estan llenos
		else if($datos["canal"] != "" && $datos["fechaIni"] != "" && $datos["fechaFin"] != "" && $datos["estado"] == ""){
			
			$query =  \DB::table('std_loaddata_files')
			->select('std_loaddata_files.*')
			->where('name','LIKE', '%' . $datos['canal'] . '%')
			->whereBetween('created_at',[$datos['fechaIni'],$datos['fechaFin']])
			->orderBy('created_at','desc')
			->get();

			$query_json = \Response::make(json_encode($query),200)->header('Content-type','text/plain');

			return $query_json;
		}//cuando fecha inicio,fecha final y estado estan llenos
		else if($datos["canal"] == "" && $datos["fechaIni"] != "" && $datos["fechaFin"] != "" && $datos["estado"] != ""){
			
			$query =  \DB::table('std_loaddata_files')
			->select('std_loaddata_files.*')
			->where('status',$datos['estado'])
			->whereBetween('created_at',[$datos['fechaIni'],$datos['fechaFin']])
			->orderBy('created_at','desc')
			->get();

			$query_json = \Response::make(json_encode($query),200)->header('Content-type','text/plain');

			return $query_json;
		}

		return $query_json;
		
	}
}
