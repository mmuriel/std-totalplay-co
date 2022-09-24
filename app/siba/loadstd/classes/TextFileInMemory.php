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
class TextFileInMemory  {
    //put your code here
    private $arrEvents = array();

    public function loadFromFile(\Siba\loadstd\Models\FileDataSource $file) {
        
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
            
            $arrFile = file(env($path)."/".$file->name);
            $actualDate = '';
            $indArr = 0;
            for ($i=0; $i < (count($arrFile) - 1); $i++){

                $lineObj = new \Siba\loadstd\classes\TextFileRecord(trim($arrFile[$i]));
                if ($lineObj->lineType()=='date'){

                    $actualDate = trim($arrFile[$i]);

                }
                else if ($lineObj->lineType()=='data'){

                    $lineObj->setDate($actualDate);
                    $lineObjNext = new \Siba\loadstd\classes\TextFileRecord(trim($arrFile[($i+1)]));
                    if ($lineObjNext->lineType()=='date'){
                        $nextDate = trim($arrFile[$i+1]);
                        $lineObjNext = new \Siba\loadstd\classes\TextFileRecord(trim($arrFile[($i+2)]));
                    }
                    else {
                        $nextDate = $actualDate;
                    }
                    $inicioNext = $lineObjNext->getTimestampByLine($nextDate);
                    $inicioActual = $lineObj->getTimestampByLine();
                    $lineObj->setDuracion(($inicioNext - $inicioActual));
                    array_push($this->arrEvents,$lineObj);

                };

            }

            if (count($this->arrEvents)>0){

                return true;

            }
            else {

                return false;

            }

            
        }
        else {

            return false;
        }
    }

    public function saveToDb(\Siba\loadstd\Models\FileDataSource $file){

        if (count($this->arrEvents)>0){

            //\Siba\Dev2\Models\Programa::delAllProgramacionForDateAndCanal($file->idcanal,trim($line->getDate()));
            $deleterByDate = new DbCleanerByDate($file->idcanal);
            $ctrlForEach = 0;
            try {
                foreach ($this->arrEvents as $line){

                    //==================================
                    //Borra la programación del día, pero respetando que solo sea una vez
                    $deleterByDate->deleteEventsByDate($line->getDate());
                    //==================================
                    //Registra el programa
                    $programa = new \Siba\Dev2\Models\Programa();
                    $programa->nombre = trim($line->getNombre());
                    $programa->descripcion = trim($line->getSinopsis());
                    $programa->idcanal = $file->idcanal;
                    $programa->fecha_hora = trim($line->getDate())." ".trim($line->getLineTime());
                    $programa->duracion = $line->getDuracion();
                    $programa->save();

                    //==================================
                    //Registra los datos ppv
                    if (is_array($line->getPpvValues()) && count($line->getPpvValues())>0)
                    {
                        foreach ($line->getPpvValues() as $dataPpv)
                        {

                            $ppvAtt = new \Siba\Dev2\Models\AtributoPpv();
                            $ppvAtt->idprograma = $programa->idprograma;
                            $ppvAtt->clave = $dataPpv['clave'];
                            $ppvAtt->valor = $dataPpv['valor'];
                            $ppvAtt->save();
                        }
                    }
                    //=================================
                    //Registra las categorias
                    if (is_array($line->getCategorias()) && count($line->getCategorias())>0){

                        $arrCatsRaw = $line->getCategorias();

                        foreach ($arrCatsRaw as $dataCategoria){

                            $categoria = \Siba\Dev2\Models\CategoriaEvento::find($dataCategoria);
                            if ($categoria->tipo_clasificacion == 'SIBA_TIPO'){

                                $opcional = new \Siba\Dev2\Models\Opcional();
                                $opcional->clave = 'tipo';
                                $opcional->idprograma = $programa->idprograma;
                                if ($categoria->nombre == 'SERIE'){
                                    $opcional->valor = 'S';
                                }
                                else {
                                    $opcional->valor = 'U';   
                                }
                                $opcional->save();
                            }
                            else {

                                $programa->categorias()->attach($categoria->idcategoria);

                            }

                        }

                    }
                    //==================================
                    //Registra el año
                    if ($line->getYear()!=null){

                        $opcional = new \Siba\Dev2\Models\Opcional();
                        $opcional->clave = 'year';
                        $opcional->idprograma = $programa->idprograma;
                        $opcional->valor = $line->getYear();   
                        $opcional->save();

                    }

                    //==================================
                    //Registra el pais
                    if ($line->getPais()!=null){

                        $opcional = new \Siba\Dev2\Models\Opcional();
                        $opcional->clave = 'pais';
                        $opcional->idprograma = $programa->idprograma;
                        $opcional->valor = $line->getPais();   
                        $opcional->save();

                    }

                    //==================================
                    //Registra la serie

                    if ($line->getSerie()!=null){

                        $opcional = new \Siba\Dev2\Models\Opcional();
                        $opcional->clave = 'serie';
                        $opcional->idprograma = $programa->idprograma;
                        $opcional->valor = $line->getSerie();   
                        $opcional->save();

                    }

                    //==================================
                    //Registra la temporada

                    if ($line->getTemporada()!=null){

                        $opcional = new \Siba\Dev2\Models\Opcional();
                        $opcional->clave = 'temporada';
                        $opcional->idprograma = $programa->idprograma;
                        $opcional->valor = $line->getTemporada();   
                        $opcional->save();

                    }

                    //=================================
                    //Registra las sinopsis adicionales
                    if (is_array($line->getSinopsisCustom()) && count($line->getSinopsisCustom())>0){

                        $arrSinopsisCustom = $line->getSinopsisCustom();

                        foreach ($arrSinopsisCustom as $sinopsisCustom){

                            $sinopsisAlt = new \Siba\Dev2\Models\SinopsisAlternativa();
                            $sinopsisAlt->sinopsis = $sinopsisCustom[1];
                            $sinopsisAlt->idprograma = $programa->idprograma;
                            $sinopsisAlt->tipo = $sinopsisCustom[0];
                            $sinopsisAlt->save();

                        }

                    }
                    //=================================
                    //Registra los actores
                    if (is_array($line->getActores()) && count($line->getActores())>0){

                        $arrActores = $line->getActores();

                        foreach ($arrActores as $act){

                            if (is_array($act) && count($act) > 1){
                                
                                $participante = \Siba\Dev2\Models\Participante::where("md5","=",md5(\Misc\Helper::normalizeText($act[0])))->first();
                                

                                if ($participante == null){
                                    
                                    $pais = \Siba\Dev2\Models\Pais::where("prefijopais","=",$act[1])->first();
                                    if (!isset($pais->idpais)){
                                        $actIdPais = 0;
                                    }
                                    else{
                                        $actIdPais = $pais->idpais; 
                                    }
                                    $participanteParams = array(

                                        'nombre_completo' => $act[0],
                                        'idpais' => $actIdPais,
                                        'sexo' => $act[2],
                                        'md5' => md5(\Misc\Helper::normalizeText($act[0]))
                                    );

                                    $participante = new \Siba\Dev2\Models\Participante($participanteParams);
                                    $participante->save();

                                   
                                }

                                if (isset($participante->idparticipante))
                                    $programa->participantes()->attach($participante->idparticipante,array("tipo"=>"actor"));

                            }else{

                                $participante = \Siba\Dev2\Models\Participante::where("md5","=",md5(\Misc\Helper::normalizeText($act)))->first();
                                
                                /*
                                echo $act."\n";
                                echo "=============\n";
                                $queries = \DB::getQueryLog();
                                $last_query = end($queries);
                                print_r($last_query);
                                */

                                if ($participante== null){
                                    
                                    $participanteParams = array(

                                        'nombre_completo' => $act,
                                        'md5' => md5(\Misc\Helper::normalizeText($act)),
                                        'idpais' => 0
                                    );

                                    $participante = new \Siba\Dev2\Models\Participante($participanteParams);
                                    $participante->save();

                                   
                                }

                                if (isset($participante->idparticipante))
                                    $programa->participantes()->attach($participante->idparticipante,array("tipo"=>"actor"));
                                
                            }

                        }

                    }


                    //=================================
                    //Registra los directores

                    if (is_array($line->getDirectores()) && count($line->getDirectores())>0){

                        $arrDirectores = $line->getDirectores();

                        foreach ($arrDirectores as $dir){

                            if (is_array($dir) && count($dir) > 1){
                                
                                $participante = '';
                                $participante = \Siba\Dev2\Models\Participante::where("md5","=",md5(\Misc\Helper::normalizeText($dir[0])))->first();
                                if ($participante == null){
                                    
                                    $pais = \Siba\Dev2\Models\Pais::where("prefijopais","=",$dir[1])->first();
                                    if (!isset($pais->idpais)){
                                        $actIdPais = 0;
                                    }
                                    else{
                                        $actIdPais = $pais->idpais; 
                                    }
                                    $participanteParams = array(

                                        'nombre_completo' => $dir[0],
                                        'idpais' => $actIdPais,
                                        'sexo' => $dir[2],
                                        'md5' => md5(\Misc\Helper::normalizeText($dir[0]))
                                    );

                                    $participante = new \Siba\Dev2\Models\Participante($participanteParams);
                                    $participante->save();

                                   
                                }

                                if (isset($participante->idparticipante))
                                    $programa->participantes()->attach($participante->idparticipante,array("tipo"=>"director"));

                            }else{
                                
                                $participante = \Siba\Dev2\Models\Participante::where("md5","=",md5(\Misc\Helper::normalizeText($dir)))->first();
                                if ($participante == null){
                                    
                                    $participanteParams = array(

                                        'nombre_completo' => $dir,
                                        'md5' => md5(\Misc\Helper::normalizeText($dir)),
                                        'idpais' => 0
                                    );

                                    $participante = new \Siba\Dev2\Models\Participante($participanteParams);
                                    $participante->save();

                                   
                                }

                                if (isset($participante->idparticipante) && ! preg_match("/[^0-9]/",$participante->idparticipante))
                                    $programa->participantes()->attach($participante->idparticipante,array("tipo"=>"director"));
                                
                            }

                        }

                    }

                    //=================================
                    //Registra los opcionales
                    if (is_array($line->getOpcionales()) && count($line->getOpcionales())>0){

                        $arrOpcionales = $line->getOpcionales();

                        foreach ($arrOpcionales as $opc){

                            $opcional = new \Siba\Dev2\Models\Opcional();
                            $opcional->clave = $opc[0];
                            $opcional->idprograma = $programa->idprograma;
                            $opcional->valor = $opc[1];
                            $opcional->save();

                        }

                    }

                    //=================================
                    //Registra los ratings
                    if (is_array($line->getRatings()) && count($line->getRatings())>0){

                        $arrRatings = $line->getRatings();

                        foreach ($arrRatings as $ratingRaw){

                            $rating = \Siba\Dev2\Models\RatingEvento::getRatingEventoByKeyVal($ratingRaw['pais'],$ratingRaw['rating']);
                            if ($rating != null)
                                $programa->ratings()->attach($rating->idrating);
                            else {

                                echo "Verificando el error lanzado por el sistema: ".$line->getRawLine()."\n";
                                $msg = "Error registrando en la base de datos, ".$line->getRawLine()."\n";
                                $log = new \Monolog\Logger('LOADDATA');
                                $log->pushHandler(new \Monolog\Handler\StreamHandler(base_path().'/app.log', \Monolog\Logger::WARNING));
                                $log->addWarning($msg);
                            }

                        }

                    }
                    $ctrlForEach++;

                }
            }
            catch (Exception $exception) {

                $msg = "Error registrando en la base de datos, ".$line->getRawLine()." (".$exception->getMessage().")\n";
                $log = new \Monolog\Logger('LOADDATA');
                $log->pushHandler(new \Monolog\Handler\StreamHandler(base_path().'/app.log', \Monolog\Logger::ERROR));
                $log->addError($msg);
                return false;

            }
            return true;

        }
        else {

            return false;
        }

    }




}
