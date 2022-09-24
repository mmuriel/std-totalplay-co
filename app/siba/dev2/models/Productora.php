<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Siba\dev2\models;

/**
 * Description of Productora
 *
 * @author macuser
 */
class Productora extends \Eloquent {
    //put your code here
    protected $table = 'productoras';
    protected $primaryKey = 'idproductora';
    public $timestamps = false;
    

    /*

        Relaciones con otras entidades

    */
    public function canales(){

        return $this->belongsToMany('\Siba\Dev2\Models\Canal','canales_productoras','idproductora','idcanal');

    }
}
