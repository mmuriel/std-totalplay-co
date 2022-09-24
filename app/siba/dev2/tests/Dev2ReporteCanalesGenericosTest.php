<?php

/*
use \User;
use \Auth;
*/

use \Siba\dev2\classes\ReporteCanalesGenericos;
use Tests\TestCase;

class Dev2ReporteCanalesGenericosTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */


	/* Test for  */
	public function testGetCanalesGenericos(){

		$fechaIni = "2025-12-30 00:00:00";
		$fechaFin = "2025-12-30 23:59:59";
		$reporte = new ReporteCanalesGenericos();
		$query = $reporte->getCanalesGenericos($fechaIni,$fechaFin);
		$this->assertEquals(2,count($query),"Deberia traer solo un registro");
		
			
	}

	


	



	

}
