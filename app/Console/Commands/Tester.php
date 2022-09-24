<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Tester extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'siba:Tester';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando está diseñado para probar lineas de código básicas,pero teniendo el stack del framework disponible';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $stdLoadCtrl = new \Siba\loadstd\controllers\LoadStdController();
		$fileSeeker = new \Siba\loadstd\classes\TextSeekerFiles();
        $txtfiles = $fileSeeker->seekFiles(env('RUTA_LOADDATA_READY'));

        print_r($txtfiles);

        foreach ($txtfiles as $txtfile){

                preg_match("/([^\/]{1,190}\.txt$)/i",$txtfile,$fileResults);
                $file = \Siba\loadstd\Models\FileDataSource::whereRaw("name='".$fileResults[1]."' AND status='ready' AND checksum='".md5_file(env('RUTA_LOADDATA_READY')."/".trim($fileResults[1]))."'")->first();
                echo "php ".base_path()."/artisan siba:LoadSTDTxtFile ".$file->id." > /dev/null 2>/dev/null &\n";

            }
    }
}
