<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoadSTDTxtFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siba:LoadSTDTxtFile {idfile : El ID del archivo en la tabla std_loaddata_files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando procesa un archivo de texto de carga de datos para DEV2 (STD) que se encuentra listo para este proceso';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = \Siba\loadstd\models\FileDataSource::where("id","=",$this->argument('idfile'))->first();
		$logger = new \Misc\CustomLogger('DEBUG');
		$logger->writeToLog("Verificando el dato que llega de la consola: ".$this->argument('idfile'),"INFO");
		$dataLoader = new \Siba\loadstd\classes\TextFileDataLoader($file);
    }
}
