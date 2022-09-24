<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartLoadData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siba:StartLoadData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este script inicia el proceso de carga automática de datos para el sistema STD, su objetivo fundamental es verificar la existencia de archivos en la carpeta adecuada y tomar la decisión de iniciar el proceso o no.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stdLoadCtrl = new \Siba\loadstd\controllers\LoadStdController();
		$stdLoadCtrl->makeFilesReadyToProcess();
    }
}
