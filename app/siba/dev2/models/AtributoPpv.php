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
class AtributoPpv extends \Eloquent {
    //put your code here
    protected $table = 'programacion_ppv';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    
    public function programa(){
        
        return $this->belongsTo('\Siba\Dev2\Models\Programa');
        
    }
    
    
}
