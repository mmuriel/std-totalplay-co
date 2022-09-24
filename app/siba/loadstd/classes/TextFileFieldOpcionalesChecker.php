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
class TextFileFieldOpcionalesChecker implements \Siba\loadstd\interfaces\FileDataFieldChecker {
    //put your code here
    private $return;

    public function checkFieldIntegrity($field) {
        
        $this->return = new \Misc\Response();

        if ($field==' '){
            return $this->return;
        }

        if (preg_match("/(\-){2,10}$/",$field)){

            $this->return->status = false;
            $this->return->value = 0;
            $this->return->notes = "Se han dejado caracteres separadores de campo (guiones)";
            return $this->return;

        }

        if (preg_match("/([^\|]){2,200}\|([^\|]){1,400}/",$field)){

            return $this->return;

        }

        $this->return->status = false;
        $this->return->value = 0;
        $this->return->notes = "El tipo de dato registrado en el campo Opcionales no es valido";
        return $this->return;

    }
}
