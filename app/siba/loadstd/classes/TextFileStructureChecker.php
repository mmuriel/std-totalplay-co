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
class TextFileStructureChecker implements \Siba\loadstd\interfaces\FileStructureChecker {
    //put your code here

    private $arrData = array();
    private $return;
    
    public function checkStructureIntegrity(\Siba\loadstd\Models\FileDataSource $file) {

        $this->return = new \Misc\Response();
        
        switch ($file->status){
            case 'uploading': 
                                $path = 'RUTA_LOADDATA_READY';
                                break;
            case 'ready':
                                $path = 'RUTA_LOADDATA_READY';
                                break;
            case 'inprocess':
                                $path = 'RUTA_LOADDATA_INPROCESS';
                                break;
            case 'done': 
                                $path = 'RUTA_LOADDATA_OK';
                                break;
            case 'error':
                                $path = 'RUTA_LOADDATA_ERROR';
                                break;
        }
        //======================================================================
        if (file_exists(env($path)."/".$file->name)){
            
            $arrDataFile = file(env($path)."/".$file->name);
            $ctrLines = 0;
            
            foreach ($arrDataFile as $line){

                $checkDate = $this->checkLineDate($line);
                $checkData = $this->checkLineData($line);
                if ($checkData->status == false && $checkDate->status == false){

                    $this->return->status = false;
                    $this->return->value = 0;
                    $this->return->notes = $this->return->notes."Error en la linea: ".($ctrLines+ 1)."\n";

                }

                $ctrLines++;
            }
            
        }
        else {
    
            $this->return->status = false;
            $this->return->value = 0;
            $this->return->notes = $this->return->notes."El archivo ".env($path)."/".$file->name." no existe\n";

        }
        
        return $this->return;
    }

    private function checkLineDate($line){

        $res = new \Misc\Response();

        if (preg_match("/^[0-9]{4,4}\-[0-9]{2,2}\-[0-9]{2,2}/",$line)){

            $arrDate = preg_split("/\-/",$line);

            if (!($arrDate[0] > 2000 && $arrDate[0] < 9999)){

                return new \Misc\Response('0','El año de la fecha está errado',false);
            }

            if (!($arrDate[1] >= 1  && $arrDate[1] <= 12)){
                return new \Misc\Response('0','El mes de la fecha está errado',false);
            }

            if (!($arrDate[2] >= 1  && $arrDate[1] <= 31)){
                return new \Misc\Response('0','El día de la fecha está errado',false);
            }

            return new \Misc\Response('1','',true);
        }
        else {
            return new \Misc\Response('0','La fecha no tiene un formato válido',false);
        }

    }

    private function checkLineData ($line){

        if (preg_match("/^[0-9]{1,2}:[0-9]{2,2}\-\-\-/",$line)){

            $arrFields = preg_split("/\-\-\-/",$line);

            if (count($arrFields)==13){

                return new \Misc\Response('1','',true);

            }
            else {
                return new \Misc\Response('0','El registro no contiene la cantidad de campos requerida',false);
            }


        }
        else {

            return new \Misc\Response('0','El registro de datos no inicia con el campo hora',false);

        }

    }

}
