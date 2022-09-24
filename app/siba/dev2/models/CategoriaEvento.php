<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Siba\dev2\models;

/**
 * Description of Programa
 *
 * @author macuser
 */
class CategoriaEvento extends \Eloquent {
    //put your code here
    protected $table = 'programacion_categorias';
    protected $primaryKey = 'idcategoria';
    public $timestamps = false;
    

    public function programas (){

    	return $this->belongsToMany('\Siba\Dev2\Models\Programa','programas_categorias','idcat','idprograma');
    }

    public static function getCategoriaEventoByKeyVal ($nombre,$tipo){

        $categoria = \Siba\Dev2\Models\CategoriaEvento::whereRaw(" nombre='".$nombre."' && tipo_clasificacion='".$tipo."' ")->first();
        return $categoria;

    }
    
}
