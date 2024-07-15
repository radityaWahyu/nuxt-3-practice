<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class installAplikasi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aplikasi:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setting data awal aplikasi';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Proses setting aplikasi...');
            $this->info('Proses pembuatan tabel data');
            Artisan::call('migrate:fresh');
            print_r(Artisan::output());
            $this->info('Proses pembuatan data awal');
            Artisan::call('db:seed', [
                '--class' => 'DataAwalSeeder'
            ]);
            $this->info('Proses instalasi selesai');
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
