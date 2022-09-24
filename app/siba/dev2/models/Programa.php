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
class Programa extends \Eloquent {
    //put your code here
    protected $table = 'programacion';
    protected $primaryKey = 'idprograma';
    public $timestamps = false;
    

    /*

        Relaciones con otras entidades

    */
    
    public function Opcionales (){
        
        return $this->hasMany('\Siba\Dev2\Models\Opcional');
        
    }
    
    
    public function cdnElementos(){
        
        return $this->belongsToMany('\Siba\Dev2\Models\CdnElemento','programacion_cdn_elemento','idprograma','idelemento');
        
    }
    
    public function canal(){
        
        return $this->belongsTo('\Siba\Dev2\Models\Canal','idcanal','idcanal');
        
    }

    public function ppvData(){

        return $this->hasMany('\Siba\Dev2\Models\AtributoPpv');
    }

    public function categorias(){

        return $this->belongsToMany('\Siba\Dev2\Models\CategoriaEvento','programas_categorias','idprograma','idcat');
    }

    public function participantes(){

        return $this->belongsToMany('\Siba\Dev2\Models\Participante','programacion_participantes','idprograma','idparticipante');
    }

    public function ratings(){

        return $this->belongsToMany('\Siba\Dev2\Models\RatingEvento','programas_ratings','idprograma','idrating');

    }


    /*
    ************************************
    Funciones
    ************************************
    */


    /*
    *
    * Esta función elimina todos los registros en la tabla programacion
    * de una canal en particular para un día determinado
    * 
    * @params
    * $idcanal: El canal sobre el que se aplicara el borrado de la programacion
    * $date:    Fecha en el formato YYYY-MM-DD, que indica un día del mes, donde
    *           se aplicará el borrado.
    *
    */
    public static function delAllProgramacionForDateAndCanal ($idcanal,$date){

        $res = \DB::table('programacion')->where('fecha_hora','>=',$date." 00:00:00")->where('fecha_hora','<=',$date." 23:59:59")->where('idcanal','=',$idcanal)->delete();
        return ($res);

    }
    
    
}
