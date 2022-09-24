<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SearchForReadyFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siba:SearchForReadyFiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando busca los archivos que están en estado Ready, para lanzar el proceso de carga de datos hacia la base de datos.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $files = \Siba\loadstd\Models\FileDataSource::where("status","=","ready")->get();
		foreach ($files as $file){
            
		    system("php ".base_path()."/artisan siba:LoadSTDTxtFile ".$file->id." > /dev/null 2>/dev/null &");

		}
		
    }
}
