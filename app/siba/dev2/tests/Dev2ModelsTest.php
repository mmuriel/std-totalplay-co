<?php

use Siba\Dev2\Models\Productora;
use Siba\Dev2\Models\Canal;
use Siba\Dev2\Models\Programa;
use Siba\Dev2\Models\ProgramacionGenerica;
use Tests\TestCase;

class Dev2ModelsTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */


	/* Test for  */
	public function testDev2ModelsTest_canalLinkedToProductora(){
		//echo 'http://devstb.localhost/api/channels?filter='.urlencode ($filter);

		$canal = Canal::find(380);//A&E Mundo
		$this->assertEquals("HBO",$canal->productora[0]->nombre,"Error analizando la productos asociada");
	}

	public function testDev2ModelsTest_canalNoLinkedToProductora(){
		//echo 'http://devstb.localhost/api/channels?filter='.urlencode ($filter);
		
		$canal = Canal::find(388);//BBC World
		$this->assertEquals(0,count($canal->productora),"Este canal no deberia tener una productora asociada!");
	}

	public function testDev2ModelsTest_productora(){
		//echo 'http://devstb.localhost/api/channels?filter='.urlencode ($filter);
		
		$productora = Productora::find(10);//FOX
		//print_r($productora->canales);
		$this->assertEquals(33,count($productora->canales),"La productora FOX debería tener 33 canales asociados!");
	}

}
