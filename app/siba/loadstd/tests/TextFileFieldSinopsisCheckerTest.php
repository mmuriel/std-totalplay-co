<?php

use Tests\TestCase;

class TextFileFieldSinopsisCheckerTest extends TestCase {

	/**
	 * Este test, verifica que el campo "Categorias" de los archivos de carga
	 * de DEV2 (STD) estén correctos, el campo "Categorias" debe tener la siguiente
	 * estructura:
	 *
	 * SIBA_TIPO|UNICO||SIBA_BASE|Deportivo
	 * 
	 * @return void
	 */
	public function testCheckFieldSinopsisCheckerOk()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldSinopsisChecker();
		$field="Para dar a conocer diferentes temas relacionados con el esoterismo, manejo de las energías, el mundo astral y consejos para que los televidentes puedan afrontar sus problemas de la vid";
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(true,$res->status);
	}

	public function testCheckFieldSinopsisCheckerErrorByPipe()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldSinopsisChecker();
		$field="UNITED STATES|TV-14";//
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
	}


	public function testCheckFieldSinopsisCheckerErrorByAmp()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldSinopsisChecker();
		$field="Para dar a conocer diferentes temas relacionados con el esoterismo, manejo de las energías, el mundo astral y consejos para que los televidentes puedan afrontar sus problemas de la vida & muerte";//
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/caracteres no permitidos/',$res->notes);
	}


	public function testCheckFieldSinopsisCheckerErrorByLessThan()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldSinopsisChecker();
		$field="Para dar a conocer diferentes temas relacionados con el esoterismo, manejo de las energías, el mundo astral y consejos para que los televidentes puedan afrontar sus problemas de la vida < muerte";//
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/caracteres no permitidos/',$res->notes);
	}

	public function testCheckFieldSinopsisCheckerErrorByMoreThan()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldSinopsisChecker();
		$field="Para dar a conocer diferentes temas relacionados con el esoterismo, manejo de las energías, el mundo astral y consejos para que los televidentes puedan afrontar sus problemas de la vida > muerte";//
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/caracteres no permitidos/',$res->notes);
	}


	public function testCheckFieldSinopsisCheckerErrorByApostrofe()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldSinopsisChecker();
		$field="Para dar a conocer diferentes temas relacionados con el esoterismo, manejo de las energías, el mundo astral y consejos para que los televidentes puedan afrontar sus problemas de la vida ' muerte";//
		$res = $checker->checkFieldIntegrity($field);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/caracteres no permitidos/',$res->notes);
	}


	public function testCheckFieldSinopsisCheckerOkWithTilde()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldSinopsisChecker();
		$field="Un acto de compasión y arrogancia conduce a una guerra como ninguna y al origen del planeta de los simios. El equipo de efectos especiales ganador de un premio Óscar que dio vida a las películas Avatar y El señor de los anillos abre nuevos caminos creando un simio digital que realiza una interpretación dramática de una emoción y una inteligencia sin precedentes, y épicas batallas en las que descansa el destino de los hombres y de los simios.";//Programa de VH1 que nos muestra  sigue estando de moda.
		$res = $checker->checkFieldIntegrity($field);
		//print_r($res);
		$this->assertSame(true,$res->status);
	}

	public function testCheckFieldSinopsisCheckerErrorWithSpecialChars()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldSinopsisChecker();
		$field="Un acto de compasión y arrogancia conduce a una guerra como ninguna y al origen del planeta de los simios. El equipo de efectos especiales ganador de un premio Óscar que dio vida a las películas Avatar y El señor de los anillos abre nuevos caminos creando un simio digital que realiza una interpretación dramática de una emoción y una inteligencia sin precedentes, y épicas batallas en las que descansa el destino de los hombres y de los simios»";//Programa de VH1 que nos muestra  sigue estando de moda.
		$res = $checker->checkFieldIntegrity($field);
		//print_r($res);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/caracteres no permitidos/',$res->notes);
	}

	public function testCheckFieldSinopsisCheckerErrorWithSpecialChars2()
	{
		$checker = new \Siba\loadstd\classes\TextFileFieldSinopsisChecker();
		$field="Al perder su casa, trabajo, '\"¡¿&“”<>–‘’—« esposa, y pasar meses en prisión, Pat Solatano termina con sus padres. Él está decidido a reconstruir su vida y reunirse con su esposa, pero sus padres estarán felices si él comparte su obsesión por las Águilas de Filadelfia.";//Programa de VH1 que nos muestra  sigue estando de moda.
		$res = $checker->checkFieldIntegrity($field);
		//print_r($res);
		$this->assertSame(false,$res->status);
		$this->assertMatchesRegularExpression('/caracteres no permitidos/',$res->notes);
	}
	
}
