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
use Siba\Dev2\Models\Cliente;
use Siba\Dev2\Models\ClienteCanal;

class ClientsApi extends Controller {

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
		$map = array('name'=>'nombre','country'=>'idpais');
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

			$clients = Cliente::whereRaw($httpModelAttr->getSqlWhereString())->skip($httpLimit->getData()['index'])->take($httpLimit->getData()['total'])->get();

		}/* Si no se han definido campos de atributo y se ha definido el campo "filter" en el query string */
		elseif (preg_match("/([\(\)a-zA-Z]{2,30})/",$filterRaw) && $filterRaw!='' && $filterRaw!=null){
			$clients = Cliente::whereRaw($httpFilter->getSqlWhereString())->skip($httpLimit->getData()['index'])->take($httpLimit->getData()['total'])->get();
		}/* Valor por defecto, no se ha definido criterio de busqueda alguno */
		else{

			$clients = Cliente::whereRaw(" 1 ")->skip($httpLimit->getData()['index'])->take($httpLimit->getData()['total'])->get();	
		}

		//return $httpFilter->getSqlWhereString()."\n\n".implode("-",$httpFields->getData())."\n\n".implode("-",$httpLimit->getData())."\n";

		//var_dump($events[1]['nombre']);
		//return "";
		$res = array('clients' =>  array());

		foreach ($clients as $clt){

			if (isset($fieldsRaw) && $fieldsRaw != null & $fieldsRaw != ''){


				$cltTmp = array();
				$cltTmp['id'] = $clt->idcliente;
				if (in_array('name',$httpFields->getData())){
					$cltTmp['name'] = $clt->nombre;
				}

				if (in_array('country',$httpFields->getData())){
					$cltTmp['country'] = $chn->idpais;
				}

				array_push($res['clients'],$cltTmp);
			}
			else{

				//var_dump($dataChn);
				//return "";
				$cltTmp = array(
					"id" => $clt->idcliente,
					"name" =>  TextUTF8Normalizer::normalizeText($clt->nombre,false),
					"country" => $clt->idpais,
				);
				array_push($res['clients'],$cltTmp);
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
		$clt = Cliente::find($id);
		if ($clt != null){
			$tmpClt = array(
				"id" => $clt->idcliente,
				"name" =>  $clt->nombre,
				"country" => $clt->idpais
			);
			return Response::json($tmpClt);
		}
		else{

			$tmpClt=array();
			$tmpClt = array("message"=>"Entity not found","code"=>"404");
			return Response::json($tmpClt,404);
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


	public function searchClientsChannels(Request $request,$id){

		$uriBuilder = new HttpURIBuilder($_GET);
		$filterRaw = $request->input('filter');
		$fieldsRaw = $request->input('fields');
		$limitRaw = $request->input('limit');
		$uriAttrRaw = $uriBuilder->getRawURIString();
		$map = array('name'=>'nombre_personalizado','frequency'=>'frecuencia','channel'=>'idcanal');
		$mapeador = new ApiModelAttrMapper($map);
		/*  Determina si en el QUERY STRING define un FILTRO de busqueda tipo "filter" */
		$httpFilter = new HttpGetParamFilter($filterRaw);
		$httpFilter->setMap($mapeador);
		/*  Determina si en el QUERY STRING definen una cantidad exacta de campos al retornar las respuestas */
		$httpFields = new HttpGetParamFields($fieldsRaw);
		/*  Determina si en el QUERY STRING se define una búsqueda por atributos (publicos) del modelo */
		//$httpModelAttr = new HttpGetParamModelAttributes($uriAttrRaw,$this->arrModelAtt,$mapeador);
		$httpModelAttr = new HttpGetParamModelAttributes($uriAttrRaw,['name','frequency','channel'],$mapeador);
		/* Define los limites de la consulta SQL */
		if (preg_match("/([0-9\,]{1,10})/",$limitRaw)){
			$httpLimit = new HttpGetParamLimit($limitRaw);
		}
		else{
			$httpLimit = new HttpGetParamLimit('0,50');
		}
		/* Si existen campos del modelo público en el query string se filtra por ese concepto*/
		if (count($httpModelAttr->getData()) > 0){
			//return $httpModelAttr->getSqlWhereString() ." && idcliente='".$id."' "."<br />";
			$sqlWhereStr = $httpModelAttr->getSqlWhereString();
			$sqlWhereStr = preg_replace("/nombre_personalizado=/","nombre_personalizado like ",$sqlWhereStr);
			$channels = ClienteCanal::whereRaw($sqlWhereStr ." && idcliente='".$id."' ")->skip($httpLimit->getData()['index'])->take($httpLimit->getData()['total'])->get();
		}/* Si no se han definido campos de atributo y se ha definido el campo "filter" en el query string */
		elseif (preg_match("/([\(\)a-zA-Z]{2,30})/",$filterRaw) && $filterRaw!='' && $filterRaw!=null){
			$channels = ClienteCanal::whereRaw($httpFilter->getSqlWhereString() ." && idcliente='".$id."' ")->skip($httpLimit->getData()['index'])->take($httpLimit->getData()['total'])->get();
		}/* Valor por defecto, no se ha definido criterio de busqueda alguno */
		else{

			$channels = ClienteCanal::whereRaw(" idcliente='".$id."' ")->skip($httpLimit->getData()['index'])->take($httpLimit->getData()['total'])->get();	
		}

		//return $httpFilter->getSqlWhereString()."\n\n".implode("-",$httpFields->getData())."\n\n".implode("-",$httpLimit->getData())."\n";

		//var_dump($events[1]['nombre']);
		//return "";
		$res = array('channels' =>  array());

		foreach ($channels as $chn){

			$chnRaw = Canal::find($chn->idcanal);

			if (isset($fieldsRaw) && $fieldsRaw != null & $fieldsRaw != ''){


				$chnTmp = array();
				$chnTmp['channel'] = $chn->idcanal;
				if (in_array('name',$httpFields->getData())){
					$chnTmp['name'] = $chn->nombre_personalizado;
				}

				if (in_array('frequency',$httpFields->getData())){
					$chnTmp['frequency'] = $chn->frecuencia;
				}

				if (in_array('prod_company',$httpFields->getData())){
					if (count($chnRaw->productora) > 0)
						$chnTmp['prod_company'] = array(
							"name" => $chnRaw->productora[0]->nombre,
							"id" => $chnRaw->productora[0]->idproductora
						);
				}

				array_push($res['channels'],$chnTmp);
			}
			else{

				//var_dump($dataChn);
				//return "";
				if (count($chnRaw->productora) > 0){
					$chnTmp = array(
						"channel" => $chn->idcanal,
						"name" =>  TextUTF8Normalizer::normalizeText($chn->nombre_personalizado,false),
						"frequency" => $chn->frecuencia,
						"prod_company" => array(
							"name" => $chnRaw->productora[0]->nombre,
							"id" => $chnRaw->productora[0]->idproductora
						)
					);

				}
				else{
					$chnTmp = array(
						"channel" => $chn->idcanal,
						"name" =>  TextUTF8Normalizer::normalizeText($chn->nombre_personalizado,false),
						"frequency" => $chn->frecuencia,
					);
				}
						
				
				array_push($res['channels'],$chnTmp);
			}

		}

		
		return Response::json($res);

	}

}