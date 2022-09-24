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
use Illuminate\Http\Request;
use Response;

use Siba\Dev2\Models\Canal;

class ChannelsApi extends Controller {

	/**
	 * Display a listing of the resource.
	 * GET /channelsapi
	 *
	 * @return Response
	 */

	protected $arrModelAtt = ['name','descp'];

	public function index(Request $request)
	{
		//
		//Verifica los parametros tipo GET:
		$uriBuilder = new HttpURIBuilder($_GET);
		$filterRaw = $request->input('filter');
		$fieldsRaw = $request->input('fields');
		$limitRaw = $request->input('limit');
		$uriAttrRaw = $uriBuilder->getRawURIString();
		$map = array('name'=>'nombre','descp'=>'descripcion');
		$mapeador = new ApiModelAttrMapper($map);


		
		/*  Determina si en el QUERY STRING define un FILTRO de busqueda tipo "filter" */
		$httpFilter = new HttpGetParamFilter($filterRaw);
		$httpFilter->setMap($mapeador);

		/*  Determina si en el QUERY STRING definen una cantidad exacta de campos al retornar las respuestas */
		$httpFields = new HttpGetParamFields($fieldsRaw);


		/*  Determina si en el QUERY STRING se define una búsqueda por atributos (publicos) del modelo */
		$httpModelAttr = new HttpGetParamModelAttributes($uriAttrRaw,$this->arrModelAtt,$mapeador);

		/* Define los limites de la consulta SQL */
		if (preg_match("/([0-9\,]{1,10})/",$limitRaw)){
			$httpLimit = new HttpGetParamLimit($limitRaw);
		}
		else{
			$httpLimit = new HttpGetParamLimit('0,'.env('MAX_RESULTS_PER_QUERY'));
		}



		/* Si existen campos del modelo público en el query string se filtra por ese concepto*/
		if (count($httpModelAttr->getData()) > 0){

			$channels = Canal::whereRaw($httpModelAttr->getSqlWhereString())->skip($httpLimit->getData()['index'])->take($httpLimit->getData()['total'])->get();

		}/* Si no se han definido campos de atributo y se ha definido el campo "filter" en el query string */
		elseif (preg_match("/([\(\)a-zA-Z]{2,30})/",$filterRaw) && $filterRaw!='' && $filterRaw!=null){
			$channels = Canal::whereRaw($httpFilter->getSqlWhereString())->skip($httpLimit->getData()['index'])->take($httpLimit->getData()['total'])->get();
		}/* Valor por defecto, no se ha definido criterio de busqueda alguno */
		else{

			$channels = Canal::whereRaw(" 1 ")->skip($httpLimit->getData()['index'])->take($httpLimit->getData()['total'])->get();	
		}

		//return $httpFilter->getSqlWhereString()."\n\n".implode("-",$httpFields->getData())."\n\n".implode("-",$httpLimit->getData())."\n";

		//var_dump($events[1]['nombre']);
		//return "";
		$res = array('channels' =>  array());

		foreach ($channels as $chn){

			if (isset($fieldsRaw) && $fieldsRaw != null & $fieldsRaw != ''){


				$tmpChn = array();
				$tmpChn['id'] = $chn->idcanal;
				if (in_array('name',$httpFields->getData())){
					$tmpChn['name'] = $chn->nombre;
				}

				if (in_array('desc',$httpFields->getData())){
					$tmpChn['desc'] = $chn->descripcion;
				}

				array_push($res['channels'],$tmpChn);
			}
			else{

				//var_dump($dataChn);
				//return "";

				if (count($chn->productora) > 0){

					$tmpChn = array(
						"id" => $chn->idcanal,
						"name" =>  TextUTF8Normalizer::normalizeText($chn->nombre,false),
						"desc" => $chn->descripcion,
						"prod_company" => array(
							"name" => $chn->productora[0]->nombre,
							"id" => $chn->productora[0]->idproductora
						)
					);

				}
				else{

					$tmpChn = array(
						"id" => $chn->idcanal,
						"name" =>  TextUTF8Normalizer::normalizeText($chn->nombre,false),
						"desc" => $chn->descripcion,
					);
				}
				array_push($res['channels'],$tmpChn);
			}

		}
		return Response::json($res);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /channelsapi/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /channelsapi
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /channelsapi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
		$chn = Canal::find($id);
		if ($chn != null){

			if (count($chn->productora) > 0){

				$tmpChn = array(
					"id" => $chn->idcanal,
					"name" =>  $chn->nombre,
					"desc" => $chn->descripcion,
					"prod_company" => array(
						"name" => $chn->productora[0]->nombre,
						"id" => $chn->productora[0]->idproductora
					)
				);
			}
			else{

				$tmpChn = array(
					"id" => $chn->idcanal,
					"name" =>  $chn->nombre,
					"desc" => $chn->descripcion,
				);

			}

			return Response::json($tmpChn);
		}
		else{

			$tmpChn=array();
			$tmpChn = array("message"=>"Entity not found","code"=>"404");
			return Response::json($tmpChn,404);
		}

		
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /channelsapi/{id}/edit
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
	 * PUT /channelsapi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /channelsapi/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}