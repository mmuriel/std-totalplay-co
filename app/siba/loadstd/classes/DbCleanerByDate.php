<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Siba\loadstd\classes;
/**
 * Description of newPHPClass
 *
 * @author @maomuriel
 * mauricio.muriel@calitek.net
 */
class DbCleanerByDate  {


	private $dates = array();
	private $idcanal;

	public function __construct($idcanal){

		$this->idcanal = $idcanal;
	}

	public function deleteEventsByDate ($date){

		if ($this->checkDateAlreadyDeteled($date)){

			return false;

		}

		//Borra los registros de la fecha en adelante.
		\Siba\Dev2\Models\Programa::delAllProgramacionForDateAndCanal($this->idcanal,trim($date));
		//Registra la fecha en 
		array_push($this->dates,$date);

	}

	private function checkDateAlreadyDeteled ($date){

		foreach ($this->dates as $dateLocal){

			if ($date === $dateLocal){

				return true;
			}
			
		}

		return false;
	}


}