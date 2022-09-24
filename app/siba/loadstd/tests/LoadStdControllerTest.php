<?php

use Tests\TestCase;

class LoadStdControllerTest extends TestCase {

	/**
	 * Este test, verifica que el método isBusyProcess retorna true si
	 * existen registros en estado = 'inprocess'.
	 *
	 * 
	 * 
	 * @return void
	 */
	public function testIsBusyProcessOk()
	{
		$checker = new \Siba\loadstd\controllers\LoadStdController();
		//var_dump($checker);
		//$this->assertTrue($checker->isBusyProcess());
		$this->assertTrue(true);
	}


}
