<?php

use Tests\TestCase;

class TextFileFieldNombreCheckerTest extends TestCase {

	/**
	 * Este test, verifica que el campo "Actores" de los archivos de carga
	 * de DEV2 (STD) estén correctos, el campo "Actores" debe tener la siguiente
	 * estructura:
	 *
	 * nombre1 apellido1||nombre2 apellido2||nombre3 apellido3
	 * 
	 * @return void
	 */
	public function testCheckFieldNombreCheckerOk()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldNombreChecker();
		$field="Contacto Astral";
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(true,$res->status);
	}

	public function testCheckFieldNombreCheckerError()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldNombreChecker();
		$field="Contacto A stral C  l C Contacto Astral C CofghfgCo ntacto Ast ral C Cont acto Astrantacto Astral C mmmmmmmmm ";//Campo errado, se intenta simular el campo "Opcionales"
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
	}


	public function testCheckFieldNombreCheckerErrorByLong()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldNombreChecker();
		$field="Contacto A stral C  l C Contacto Astral C Cofgh k kdkdkkdk k kdkdk fgCo ntkdkkfm kdkmkdmkm kmddacto Ast ral C Cont acto Astrantacto Astral C mmmmmmmmm ";//Campo errado, se intenta simular el campo "Opcionales"
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/(longitud permitida)/',$res->notes);
	}



	public function testCheckFieldNombreCheckerErrorBySpecialChars()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldNombreChecker();
		$field="Contacto astral &";//Campo errado, se intenta simular el campo "Opcionales"
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/(caracteres no permitidos)/',$res->notes);
	}


	public function testCheckFieldNombreCheckerErrorBySpecialCharAmp()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldNombreChecker();
		$field="Contacto astral &";//Campo errado, se intenta simular el campo "Opcionales"
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/(caracteres no permitidos)/',$res->notes);
	}

	public function testCheckFieldNombreCheckerErrorBySpecialCharComilla()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldNombreChecker();
		$field="Contacto astral 'Lobo'";//Campo errado, se intenta simular el campo "Opcionales"
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/contiene caracteres/',$res->notes);
	}


	public function testCheckFieldNombreCheckerErrorBySpecialCharComillaYAmp()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldNombreChecker();
		$field="Contacto astral 'Lobo' &  the music";//Campo errado, se intenta simular el campo "Opcionales"
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/contiene caracteres/',$res->notes);
	}

	public function testCheckFieldNombreCheckerErrorBySpecialCharLessThan()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldNombreChecker();
		$field="Contacto astral <Lobo  the music";//Campo errado, se intenta simular el campo "Opcionales"
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/caracteres no permitidos/',$res->notes);//Validando que en la nota de error venga el caracter "<"
	}

	public function testCheckFieldNombreCheckerErrorBySpecialCharMoreThan()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldNombreChecker();
		$field="Contacto astral >Lobo  the music";//Campo errado, se intenta simular el campo "Opcionales"
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/caracteres no permitidos/',$res->notes);
	}

	public function testCheckFieldNombreCheckerErrorBySpecialCharApostrofe()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldNombreChecker();
		$field="Contacto astral 'Lobo  the music";//Campo errado, se intenta simular el campo "Opcionales"
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/caracteres no permitidos/',$res->notes);
	}


	public function testCheckFieldNombreCheckerErrorBySpecialCharLeftDoubleQuotation()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldNombreChecker();
		$field="Contacto astral  Lobo “ the music";//Campo errado, se intenta simular el campo "Opcionales"
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/caracteres no permitidos/',$res->notes);
		//$this->assertMatchesRegularExpression('/\(“\)/',$res->notes);
	}


	public function testCheckFieldNombreCheckerErrorBySpecialCharLeftPointingDoubleQuotation()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldNombreChecker();
		$field="Contacto astral Lobo the music «";//Campo errado, se intenta simular el campo "Opcionales"
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/caracteres no permitidos/',$res->notes);
		//$this->assertMatchesRegularExpression('/\(“\)/',$res->notes);
	}

}
