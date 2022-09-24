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
class CategoriaCanal extends \Eloquent {
    //put your code here
    protected $table = 'categorias_canales';
    protected $primaryKey = 'idcategoria';
    public $timestamps = false;
    
    
}
