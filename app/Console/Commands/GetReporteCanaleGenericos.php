<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Siba\dev2\classes\ReporteCanalesGenericos;

class GetReporteCanaleGenericos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siba:GetReporteCanalesGenericos  {fechaIni : fechaIni YYYY-MM-DD HH:MM:SS} {fechaFin : fechaFin YYYY-MM-DD HH:MM:SS}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando devuelve los canales con programacion generica entre dos fechas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $reporte = new ReporteCanalesGenericos();
		$query = $reporte->getCanalesGenericos(trim($this->argument('fechaIni')),trim($this->argument('fechaFin')));
        print($query);
		
        
    }
}
