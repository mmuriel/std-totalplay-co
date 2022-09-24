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
class FinderChannelByName {
    //put your code here
    
    public function findChannelByName(\Siba\loadstd\Models\FileDataSource $file) {

        $canal = \Siba\Dev2\Models\Canal::where("nombre","=",$file->getCleanName())->first();
        if ($canal == null){
            return $canal;
        }
        return $canal;

    }
}
