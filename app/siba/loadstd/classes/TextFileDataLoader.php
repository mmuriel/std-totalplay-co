<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Siba\loadstd\classes;
use Monolog\Logger;
/**
 * Description of newPHPClass
 *
 * @author @maomuriel
 * mauricio.muriel@calitek.net
 */
class TextFileDataLoader implements \Siba\loadstd\interfaces\FileDataLoader {
    //put your code here
    private $file;
    private $ctrlFileCorrect = true;

    public function __construct(\Siba\loadstd\Models\FileDataSource $file){

        $this->file = $file;
        $this->startLoadData();

    }

    public function startLoadData(){

        /* Determina si está listo el archivo */
        if ($this->file->status == 'ready'){

            //Esta listo para ser procesado
            //1. Mueve el archivo a la carpte "inprocess"
            $this->moveAndRenameFile("RUTA_LOADDATA_INPROCESS");
            //2. Modifica el status del $file
            $this->file->status = 'inprocess';
            $this->file->save();
            //3. Escribe al log
            $msg = "Se inicia el proceso de carga de contenido para el archivo ".$this->file->name." (".$this->file->checksum.")";
            $this->writeToLog ($msg,"INFO");

        }
        else {

            //No está listo para ser procesado
            //1. Escribe en el log
            $msg = "Se ha intentando procesar el archivo ".$this->file->name." (".$this->file->checksum.") sin éxito";
            $this->writeToLog ($msg,"WARNING");

            $this->file->notes = $this->file->notes."\n"."----------\n".date("Y-m-d H:i:s")."\n".$msg."\n";
            $this->file->save();
            return false;

        }

        /* Determina si hay un canal asociado al archivo */
        $canal = $this->file->findCanal();
        if ($canal == null){

            //No hay un Canal asociado al archivo

            //1. Mueve el archivo a la carpeta de error
            $this->moveAndRenameFile("RUTA_LOADDATA_ERROR",1);
            //2. Modifica el estatus de $file
            $this->file->status = 'error';
            $this->file->notes = $this->file->notes."\n"."----------\n".date("Y-m-d H:i:s")."\n"."No existe el canal con el nombre seleccionado\n";
            $this->file->save();
            //3. Escribe al log
            $msg = "El archivo de carga ".$this->file->name." no se relaciona con algún canal registrado en el sistema";
            $this->writeToLog ($msg,"ERROR");
            return false;

        }
        else {

            //1. Asegura el ID del canal para $file
            $this->file->idcanal = $canal->idcanal;
            $this->file->save();
        }

        /* Garantiza la estructura del archivo */
        $structureChecker = new \Siba\loadstd\classes\TextFileStructureChecker();
        $resStructure = $structureChecker->checkStructureIntegrity($this->file);
        if ($resStructure->status == false){

            //El archivo tiene errores en la estructura del mismo

            $this->file->notes = $this->file->notes."\n"."----------\n".date("Y-m-d H:i:s")."\n"."[error] Existen errores en la estructura del archivo: ".$resStructure->notes."\n";
            $this->file->save();
            //3. Escribe al log
            $msg = "El archivo de carga ".$this->file->name." tiene errores en las estructura del archivo";
            $this->writeToLog ($msg,"ERROR");
            $this->ctrlFileCorrect = false;

        }
        /* Garantia la estructura de los campos (los datos) del archivo */
        $dataChecker = new \Siba\loadstd\classes\TextFileDataChecker();
        $resData = $dataChecker->checkDataIntegrity($this->file);

        if ($resData->status == false){

            //El archivo tiene errores en la estructura del mismo

            
            $this->file->notes = $this->file->notes."\n"."----------\n".date("Y-m-d H:i:s")."\n"."[error] Existen errores en los campos del archivo: ".$resData->notes."\n";
            $this->file->save();
            //3. Escribe al log
            $msg = "El archivo de carga ".$this->file->name." tiene errores en algunos campos del archivo";
            $this->writeToLog ($msg,"ERROR");
            $this->ctrlFileCorrect = false;
        } 

        //Toma la decisión de registrar los datos en la DB dependiento 
        //de las revisiones de integridad del archivo y datos
        if ($this->ctrlFileCorrect == false){

            //1. Mueve el archivo a la carpeta de error
            $this->moveAndRenameFile("RUTA_LOADDATA_ERROR",1);
            //2. Modifica el estatus de $file
            $this->file->status = 'error';
            $this->file->save();
            return false;

        }   
        /* Registra la información en la DB */
        $loaderFromFile = new \Siba\loadstd\classes\TextFileInMemory();
        $loaderFromFile->loadFromFile($this->file);
        if ($loaderFromFile->saveToDb($this->file) == true){

            $this->moveAndRenameFile("RUTA_LOADDATA_OK",1);
            //2. Modifica el estatus de $file
            $this->file->status = 'done';
            $this->file->notes = $this->file->notes."\n"."----------\n".date("Y-m-d H:i:s")."\n"."[info] Se ha procesado exitosamente el archivo\n";
            $this->file->save();
            //3. Escribe al log
            $msg = "El archivo de carga ".$this->file->name." (".$this->file->checksum.") se ha procesado correctamente";
            $this->writeToLog ($msg,"INFO");
            return true;

        }
        else {

            $this->moveAndRenameFile("RUTA_LOADDATA_ERROR",1);
            //2. Modifica el estatus de $file
            $this->file->status = 'error';
            $this->file->notes = $this->file->notes."\n"."----------\n".date("Y-m-d H:i:s")."\n"."Se ha producido un error registrando la información en la base de datos\n";
            $this->file->save();
            //3. Escribe al log
            $msg = "Error registrando los datos en DB, archivo: ".$this->file->name;
            $this->writeToLog ($msg,"ERROR");
            return false;

        }

        


    }


    public function moveAndRenameFile($path,$rename=null){

        $filemover = new \Siba\loadstd\classes\TextFileMover();
        
        
        if ($rename != null){

            $fileReNamer = new \Siba\loadstd\classes\TextFileNameChanger();
            $timeCreated = "-".$this->file->created_at;
            $timeCreated = preg_replace("/:/","-",$timeCreated);
            $timeCreated = preg_replace("/\ /","_",$timeCreated);
            $timeCreated = preg_replace("/\./","-",$timeCreated);
            $newName = $this->file->getCleanName().$timeCreated;
            $fileReNamer->changeFileName($this->file,$newName);
        }

        
        //$filemover->moveFileToPath($this->file,env("sibastd.RUTA_LOADDATA_ERROR"));
        $filemover->moveFileToPath($this->file,env($path));

    } 

    public function writeToLog ($msg,$type_message){

        $log = new \Monolog\Logger('LOADDATA');

        switch ($type_message){

            case 'WARNING': $log->pushHandler(new \Monolog\Handler\StreamHandler(base_path().'/app.log', \Monolog\Logger::WARNING));
                            $log->warning($msg);
                            break;
            case 'ERROR':   
                            $log->pushHandler(new \Monolog\Handler\StreamHandler(base_path().'/app.log', \Monolog\Logger::ERROR));
                            $log->error($msg);
                            break;
            case 'INFO':   
                            $log->pushHandler(new \Monolog\Handler\StreamHandler(base_path().'/app.log', \Monolog\Logger::INFO));
                            $log->info($msg);
                            break;

        }

    }

    
}
