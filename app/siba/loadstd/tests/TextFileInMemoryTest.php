<?php

use Tests\TestCase;

class TextFileInMemoryTest extends TestCase {


	public function testDummy()
	{
		$res = true;
		$this->assertTrue(true,$res);
	}


	public function testLoadLineToMemory(){

		$line = "01:00---Godzilla 2014 (Doblada)---El monstruo más famoso del mundo se enfrenta a criaturas creadas por la arrogancia de científicos humanos que ponen en riesgo la existencia de la humanidad.---USA|TV-14---SIBA_TIPO|UNICO||SIBA_BASE|Pelicula||SIBA_BASE|Accion---eventprices|6900|---2014---USA--- --- ---SIN_CTI|El monstruo más famoso del mundo se enfrenta a criaturas creadas por la arrogancia de científicos humanos que ponen en riesgo la existencia de la humanidad.---Aaron Taylor-Johnson||Elizabeth Olsen||Bryan Cranston---Gareth Edwards--- ---";
		$rawLineInMemory = array('nombre'=>'MM');
		
		$this->assertArrayHasKey("nombre",$rawLineInMemory);
		/*
		$this->assertArrayHasKey("fechaHora",$rawLineInMemory);
		$this->assertArrayHasKey("fechaHoraUnix",$rawLineInMemory);
		$this->assertArrayHasKey("sinopsis",$rawLineInMemory);
		$this->assertArrayHasKey("ratings",$rawLineInMemory);
		$this->assertArrayHasKey("categorias",$rawLineInMemory);
		$this->assertArrayHasKey("ppv",$rawLineInMemory);
		$this->assertArrayHasKey("year",$rawLineInMemory);
		$this->assertArrayHasKey("pais",$rawLineInMemory);
		$this->assertArrayHasKey("serie",$rawLineInMemory);
		$this->assertArrayHasKey("temporada",$rawLineInMemory);
		$this->assertArrayHasKey("sinopsis_custom",$rawLineInMemory);
		$this->assertArrayHasKey("actores",$rawLineInMemory);
		$this->assertArrayHasKey("directores",$rawLineInMemory);
		$this->assertArrayHasKey("opcionales",$rawLineInMemory);
		*/

		/*
		$rawDataProgram = array (
	
			'nombre' => 'Godzilla 2014 (Doblada)',
			'fechaHora' => '2015-01-21 01:00:00',
			'fechaHoraUnix' => '1421802000',
			'sinopsis' => 'El monstruo más famoso del mundo se enfrenta a criaturas creadas por la arrogancia de científicos humanos que ponen en riesgo la existencia de la humanidad.',
			'ratings' => array(
							array('pais'=>'USA','rating'=>'TV-14'),
						),
			'categorias' => array('73','52','1'),
			'ppv' => array(
					array ('clave'=>'eventprices','valor'=>'6900'),
				),
			'year' => '2014',
			'pais' => 'USA',
			'serie' => ' ',
			'temporada' => ' ',
			'sinopsis_custom' => array(
				array('SIN_CTI','El monstruo más famoso del mundo se enfrenta a criaturas creadas por la arrogancia de científicos humanos que ponen en riesgo la existencia de la humanidad.'),			
			),
			'actores' => array(
				array('Aaron Taylor','Johnson',''),
				array('Elizabeth Olsen','',''),
				array('Bryan Cranston','',''),
			),
			'directores' => array(
				array('Gareth Edwards','',''),
			),
			'opcionales' => array(),

		);
		*/

	}


}
