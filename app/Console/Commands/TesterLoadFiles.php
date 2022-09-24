<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TesterLoadFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siba:TesterLoadFiles {archivo : Full path al archivo que se requiere analizar} {lines? : Numero de linea que se requiere analizar, pueden ser varias separadas por comas, así: \-\-lines=201,202,203,210; Si no se suministra se analizan todas las lineas del archivo }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando está diseñado para probar el contenido de los archivos de carga';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //========================================================
		//========================================================
		/*
		$varFile = "/home/std/ready/AXN HD.TXT";
		echo "\n";
		echo (md5_file($varFile));
		echo "\n";
		*/
		//========================================================
		//========================================================
		echo "\n";

		$archivo = preg_split("%:%",$this->argument('archivo'));
        print_r($archivo);
		$archivo = $archivo[0];
		
		if (null !== $this->argument("lines")){

			$lines = preg_split("%:%",$this->argument("lines"));
			$lines = $lines[1];
			$lines = preg_split("%\,%",$lines);

		}
		
		//print_r($archivo);
		//echo $this->argument("lines")."\n";
		$file = file($archivo);

		for ($i=0;$i<count($file);$i++){

			if (isset($lines)){

				$ctrlLine = false;
				for ($j=0;$j<count($lines);$j++){

					if ($lines[$j]==($i+1)){

						$ctrlLine = true;
						break;
					}

				}

				if ($ctrlLine)
					echo "\n[".($i+1)."] ".$file[$i]."\n";
			}
			else{


				echo "\n[".($i+1)."] ".$file[$i]."\n";

			}
			
		}
        //print_r($lines);
    }
}
