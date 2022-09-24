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
class TextFileNameChanger implements \Siba\loadstd\interfaces\FileNameChanger {
    //put your code here
    
    public function changeFileName(\Siba\loadstd\Models\FileDataSource $file,$newName) {
        
        switch ($file->status){
            case 'uploading': 
                                $path = 'RUTA_LOADDATA_UPLOADING';
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
        $newName = $newName.".".$file->getFileExtension();
        if (copy(env($path)."/".$file->name, env($path)."/".$newName)) {
            
            unlink(env($path)."/".$file->name);
            $file->checksum = md5_file(env($path)."/".$newName);
            $file->name = $newName;
            $file->save();
            
        }  
        //======================================================================
        
        
    }
}
