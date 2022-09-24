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
class Opcional extends \Eloquent{
    //put your code here
    protected $table = 'programas_opcionales';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    public function programa (){
        
        return $this->belongsTo('Programa');
        
    }
}
