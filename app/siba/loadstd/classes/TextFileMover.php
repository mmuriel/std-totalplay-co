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
class TextFileMover implements \Siba\loadstd\interfaces\FileMover {
    //put your code here
    
    public function moveFileToPath(\Siba\loadstd\Models\FileDataSource $file,$pathTo) {
        
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
        if (copy(env($path)."/".$file->name, $pathTo."/".$file->name)) {
            
            unlink(env($path)."/".$file->name);
            
        }  
        //======================================================================
        
        
    }
}
