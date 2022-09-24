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
class ReporteCargaMasiva extends \Eloquent {
    //put your code here
    protected $table = 'std_loaddata_files';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    
}