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
class Participante extends \Eloquent {
    //put your code here
    protected $table = 'participantes';
    protected $primaryKey = 'idparticipante';
    protected $fillable = array('nombre_completo', 'fecha_nacimiento', 'sexo', 'idpais', 'md5');
    public $timestamps = false;
    
    
}
