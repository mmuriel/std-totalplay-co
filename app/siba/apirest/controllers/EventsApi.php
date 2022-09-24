<?php

namespace Siba\apirest\controllers;
use App\Http\Controllers\Controller;
use Siba\apirest\Classes\HttpGetParamFields;
use Siba\apirest\Classes\HttpGetParamFilter;
use Siba\apirest\Classes\HttpGetParamLimit;
use Siba\apirest\Classes\HttpGetParamModelAttributes;
use Siba\apirest\Classes\HttpURIBuilder;
use Siba\apirest\Classes\ApiModelAttrMapper;
use Misc\TextUTF8Normalizer;
use Siba\Dev2\Models\Programa;
use Illuminate\Http\Request;
use Response;

class EventsApi extends Controller {


	protected $arrModelAtt = ['title','begin','sinop','duration','channel'];
	/**
	 * Display a listing of the resource.
	 * GET /eventosapi
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		//Verifica los parametros tipo GET:
		$uriBuilder = new HttpURIBuilder($_GET);
		$filterRaw = $request->input('filter');
		$fieldsRaw = $request->input('fields');
		$limitRaw = $request->input('limit');
		$uriAttrRaw = $uriBuilder->getRawURIString();
		$map = array('title'=>'nombre','begin'=>'fecha_hora','sinop'=>'descripcion','channel'=>'idcanal','duration'=>'duracion');
		$mapeador = new ApiModelAttrMapper($map);

		/*  Determina si en el QUERY STRING define un FILTRO de busqueda tipo "filter" */
		$httpFilter = new HttpGetParamFilter($filterRaw);
		$httpFilter->setMap($mapeador);

		/*  Determina si en el QUERY STRING definen una cantidad exacta de campos al retornar las respuestas */
		$httpFields = new HttpGetParamFields($fieldsRaw);

		
		
		/*  Determina si en el QUERY STRING se define una búsqueda por atributos (publicos) del modelo */
		$httpModelAttr = new HttpGetParamModelAttributes($uriAttrRaw,$this->arrModelAtt,$mapeador);

		if (preg_match("/([0-9\,]{1,10})/",$limitRaw)){
			$httpLimit = new HttpGetParamLimit($limitRaw);
		}
		else{
			$httpLimit = new HttpGetParamLimit(env('MAX_RESULTS_PER_QUERY'));
		}


		/* Si existen campos del modelo público en el query string se filtra por ese concepto*/
		if (count($httpModelAttr->getData()) > 0){

			$events = Programa::whereRaw($httpModelAttr->getSqlWhereString())->skip($httpLimit->getData()['index'])->take($httpLimit->getData()['total'])->get();

		}/* Si no se han definido campos de atributo y se ha definido el campo "filter" en el query string */
		elseif (preg_match("/([\(\)a-zA-Z]{2,30})/",$filterRaw) && $filterRaw!='' && $filterRaw!=null){
			$events = Programa::whereRaw($httpFilter->getSqlWhereString())->skip($httpLimit->getData()['index'])->take($httpLimit->getData()['total'])->get();
		}/* Valor por defecto, no se ha definido criterio de busqueda alguno */
		else{

			$baseTime = strtotime("now");
			$fHoraIni = date("Y-m-d H:i:s",$baseTime);
			$fHoraFin = date ("Y-m-d H:i:s",($baseTime + (60 * 60 * 6)));
			$events = Programa::whereRaw(" fecha_hora >= '".$fHoraIni."' && fecha_hora < '".$fHoraFin."' ")->skip($httpLimit->getData()['index'])->take($httpLimit->getData()['total'])->get();	

		}


		//return $httpFilter->getSqlWhereString()."\n\n".implode("-",$httpFields->getData())."\n\n".implode("-",$httpLimit->getData())."\n";
		$res = array('events' =>  array());

		foreach ($events as $event){

			if (isset($fieldsRaw) && $fieldsRaw != null & $fieldsRaw != ''){


				$tmpEvent = array();
				$tmpEvent['id'] = $event->idprograma;
				if (in_array('title',$httpFields->getData())){
					$tmpEvent['title'] = $event->nombre;
				}

				if (in_array('begin',$httpFields->getData())){
					$tmpEvent['begin'] = $event->fecha_hora;
				}

				if (in_array('sinop',$httpFields->getData())){
					$tmpEvent['sinop'] = $event->descripcion;
				}

				if (in_array('channel',$httpFields->getData())){

					$dataChn = $event->canal;
					$tmpEvent['channel'] = array(
						'id'=>$dataChn->idcanal,
						'name'=> $dataChn->nombre
					);
				}

				if (in_array('duration',$httpFields->getData())){

					$tmpEvent['duration'] = $event->duracion; 
				}

				array_push($res['events'],$tmpEvent);
			}
			else{

				$dataChn = $event->canal;
				//var_dump($dataChn);
				//return "";
				$tmpEvent = array(
					"id" => $event->idprograma,
					"title" =>  TextUTF8Normalizer::normalizeText($event->nombre,false),
					"begin" => $event->fecha_hora,
					"sinop" => TextUTF8Normalizer::normalizeText($event->descripcion,false),
					"channel" => array(
						"id" => $dataChn->idcanal,
						"name" => TextUTF8Normalizer::normalizeText($dataChn->nombre,false),
					),
					"duration" => $event->duracion,
				);
				
				/*
				$tmpEvent = array(
					"id" => $event->idprograma,
					"title" => $event->nombre,
					"begin" => $event->fecha_hora,
					"sinop" => $event->descripcion,
					"channel" => array(
						"id" => $dataChn->idcanal,
						"name" => $dataChn->nombre,
					),
					"duration" => $event->duracion,
				);
				*/
				array_push($res['events'],$tmpEvent);
			}

		}
 
 		//$response = response()->json($res);
 		$response = Response::json($res);
 		$response->header('Content-Type', 'application/json');
		$response->header('charset', 'utf-8');
		
		return $response;

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /eventosapi/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /eventosapi
	 *
	 * @return Response
	 */
	public function store()
	{
		//

		//It gets the content body request
		$content = Request::all();
		return Response::json($content);
		//return "POST";
	}

	/**
	 * Display the specified resource.
	 * GET /eventosapi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		/*
		$content = Request::all();
		return Response::json($content);
		*/

		
		$event = Programa::find($id);

		if ($event != null){
			$dataChn = $event->canal;
			//var_dump($dataChn);
			//return "";


			$tmpEvent = array(
				"id" => $event->idprograma,
				"title" =>  TextUTF8Normalizer::normalizeText($event->nombre,false),
				"begin" => $event->fecha_hora,
				"sinop" => TextUTF8Normalizer::normalizeText($event->descripcion,false),
				"channel" => array(
					"id" => $dataChn->idcanal,
					"name" => TextUTF8Normalizer::normalizeText($dataChn->nombre,false),
				),
				"duration" => $event->duracion,
			);

			return Response::json($tmpEvent);
		}
		else{

			$tmpEvent = array("message"=>"Entity not found","code"=>"404");
			return Response::json($tmpEvent,404);
		}

		
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /eventosapi/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /eventosapi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		return Response::json(array('evento'=>
			array(
				'id' => $id,
				'title' => 'La rosa de guadalupe',
				'date_time' => 927746265000,
				'length' => 1800,
				'chn' => array(
					'id' => 35,
					'name' => 'Canal Caracol',

				)
			)
		));
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /eventosapi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
		return Response::json(array('destroy'=>true));
	}

}