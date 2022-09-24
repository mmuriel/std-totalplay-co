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
class TextFileChecker implements \Siba\loadstd\interfaces\FileChecker {
    //put your code here
    
    public function checkFileIntegrity(\Siba\loadstd\Models\FileDataSource $file) {
        
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
            
            return false;
            
        }
        
        if (md5_file (env($path)."/".$file->name) == $file->checksum){
            return true;
        }
        return false;
    }
}
