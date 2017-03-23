<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clears the /storage/logs/laravel.log file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $f = @fopen(storage_path() . '/logs/laravel.log', 'r+');
        if ($f !== false) {
            ftruncate($f, 0);
            fclose($f);
        }
        $this->line('The laravel.log file was cleared!');
    }
}
