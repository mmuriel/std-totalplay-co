<?php

namespace Siba\dev2\classes;
use Siba\Dev2\Models\Programa;




class ReporteCanalesGenericos {

    

    
	public function getCanalesGenericos($fechaIni,$fechaFin){

        $query = Programa::
				select('canales.nombre','programacion.idcanal','programacion.fecha_hora')
				->join('canales','canales.idcanal','=','programacion.idcanal')
				->where(function($query) {
					$query->where('programacion.descripcion','LIKE','Programac%')
						  ->where('programacion.duracion', '=' ,'21600')
                          ->where('programacion.fecha_hora', 'LIKE' ,'% 18:00:00');
						  
					})
				->whereBetween('programacion.fecha_hora',[$fechaIni,$fechaFin])
				->groupBy('programacion.idcanal')
				->get();

		return $query;

    }


}