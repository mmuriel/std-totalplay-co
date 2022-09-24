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
class RatingEvento extends \Eloquent {
    //put your code here
    protected $table = 'programacion_ratings';
    protected $primaryKey = 'idrating';
    public $timestamps = false;
    

    public static function getRatingEventoByKeyVal ($pais,$sticker){

        $rating = \Siba\Dev2\Models\RatingEvento::whereRaw(" country='".$pais."' && sticker='".$sticker."' ")->first();
        return $rating;

    }
    
}
