<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CdnElemento
 *
 * @author macuser
 */

namespace Siba\dev2\models;

class CdnElemento extends \Eloquent{
    //put your code here
    protected $table = 'cdn_elementos';
    protected $primaryKey = 'idelemento';
    public $timestamps = false;
    
    
    public function image()
    {
        return $this->hasOne('CdnImage','idelemento');
    }
    
    public function video()
    {
        return $this->hasOne('CdnVideo','idelemento');
    }
}
