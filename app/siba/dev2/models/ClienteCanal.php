<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Siba\dev2\models;

/**
 * Description of ClienteCanal
 *
 * @author macuser
 */
class ClienteCanal extends \Eloquent{
    //put your code here
    protected $table = 'clientes_canales';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;
    
    public function cliente(){
        
        //return $this->hasMany('\Siba\Dev2\Models\ClienteCanal','idcliente');
        return $this->belongsTo('\Siba\Dev2\Models\Cliente','idcliente');
    }


    public function canal(){
        
        return $this->belongsTo('\Siba\Dev2\Models\Canal','idcanal');
        //return $this->belongsTo('Cliente','idcliente');
    }
}
