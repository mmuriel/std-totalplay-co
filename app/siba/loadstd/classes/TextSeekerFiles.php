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
class TextSeekerFiles implements \Siba\loadstd\interfaces\SeekerFiles {
    //put your code here
    
    public function seekFiles ($path){

    	$path = $path.'/*.[tT][xX][tT]';
        $files = glob($path);
        return $files;

    }
}
