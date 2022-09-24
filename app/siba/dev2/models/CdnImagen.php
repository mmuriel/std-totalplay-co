<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CdnImagen
 *
 * @author macuser
 */

namespace Siba\dev2\models;

class CdnImagen extends \Eloquent{
    //put your code here
    
    protected $table = 'cdn_imagenes';
    protected $primaryKey = 'idimagen';
    public $timestamps = false;
    
    public function cdnElemento()
    {
        return $this->belongsTo('CdnElemento','idelemento');
    }
}
