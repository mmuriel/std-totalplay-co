<?php

use Tests\TestCase;

class TextFileFieldDirectoresCheckerTest extends TestCase {

	/**
	 * Este test, verifica que el campo "Categorias" de los archivos de carga
	 * de DEV2 (STD) estén correctos, el campo "Categorias" debe tener la siguiente
	 * estructura:
	 *
	 * SIBA_TIPO|UNICO||SIBA_BASE|Deportivo
	 * 
	 * @return void
	 */
	public function testCheckFieldDirectoresCheckerOk()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldDirectoresChecker();
		$field="Claudia Gurisati||Jeisson Calderón||Carlos Sanabria||Carolina Hernández";
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(true,$res->status);
	}


	public function testCheckFieldDirectoresCheckerError()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldDirectoresChecker();
		$field="SIN_CTI_NNNNN|Programacion Canal RCN";
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
	}


}
