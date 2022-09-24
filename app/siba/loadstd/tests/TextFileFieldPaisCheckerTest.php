<?php

use Tests\TestCase;

class TextFileFieldPaisCheckerTest extends TestCase {

	/**
	 * Este test, verifica que el campo "Actores" de los archivos de carga
	 * de DEV2 (STD) estén correctos, el campo "Actores" debe tener la siguiente
	 * estructura:
	 *
	 * nombre1 apellido1||nombre2 apellido2||nombre3 apellido3
	 * 
	 * @return void
	 */
	public function testCheckFieldPaisCheckerOk()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldPaisChecker();
		$field="USA";
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(true,$res->status);
	}

	public function testCheckFieldPaisCheckerError()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldPaisChecker();
		$field="Colombia";//
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
	}

}
