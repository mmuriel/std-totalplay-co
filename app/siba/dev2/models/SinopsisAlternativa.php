<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Siba\dev2\models;

/**
 * Description of Opcional
 *
 * @author macuser
 */
class SinopsisAlternativa extends \Eloquent{
    //put your code here
    protected $table = 'programacion_sinopsis';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function programa (){
        
        return $this->belongsTo('\Siba\Dev2\Models\Programa');
        
    }
}
