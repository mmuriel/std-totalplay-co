<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Siba\dev2\models;

/**
 * Description of Cliente
 *
 * @author macuser
 */
class Cliente extends \Eloquent{
    //put your code here
    protected $table = 'clientes';
    protected $primaryKey = 'idcliente';
    public $timestamps = false;
    
    public function ClienteCanales(){
        
        return $this->hasMany('\Siba\Dev2\Models\ClienteCanal','idcliente');
    }
}
