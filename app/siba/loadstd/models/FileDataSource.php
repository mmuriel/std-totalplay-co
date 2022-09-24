<?php

namespace Siba\loadstd\models;

class FileDataSource extends \Eloquent {

    //Table Name
    protected $table = 'std_loaddata_files';
        
	// Add your validation rules here
	public static $rules = [
		// 'title' => 'required'
	];

	// Don't forget to fill this array
	protected $fillable = array('checksum','name','status','notes','idcanal');


	/*

		Retorna el nombre del canal de manera limpia, es decir
		únicamente el nombre del archivo (nombre del canal) sin
		la extensión.
	
	*/
	public function getCleanName(){

		return preg_replace("/\.[txTX]{3,3}$/","",$this->name);

	}


	public function getFileExtension(){

		preg_match("/\.([^\.\/\ ]{2,6})$/",$this->name,$res);
		return $res[1];

	}

	public function findCanal(){

		$buscadorCanal = new \Siba\loadstd\classes\FinderChannelByName();
		$canal = $buscadorCanal->findChannelByName($this);

		return $canal;

	}
        

}