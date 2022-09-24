<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Siba\dev2\models;

/**
 * Description of Canal
 *
 * @author macuser
 */
class Canal extends \Eloquent{
    //put your code here
    protected $table = 'canales';
    protected $primaryKey = 'idcanal';
    public $timestamps = false;
    
    public function programas(){
        
        return $this->hasMany('\Siba\Dev2\Models\Programa','idprograma');
    }
    
    public function cdnElementos(){
        
        return $this->belongsToMany('CdnElemento','canales_cdn_elementos','idcanal','idelemento');
        
    }


    public function productora(){

        return $this->belongsToMany('\Siba\Dev2\Models\Productora','canales_productoras','idcanal','idproductora');

    }
    
    public function getCdnLogo(){
        
        $cdn_imagen = DB::table("cdn_imagenes")
            ->leftJoin("cdn_elementos","cdn_elementos.idelemento","=","cdn_imagenes.idelemento")
            ->leftJoin("canales_cdn_elementos","canales_cdn_elementos.idcdnelemento","=","cdn_elementos.idelemento")
            ->whereRaw("canales_cdn_elementos.idcanal = '".$this->idcanal."' && cdn_imagenes.logo = '1'")
            ->select("cdn_imagenes.*")
            ->get();
        
        return $cdn_imagen;
        
    }
}
