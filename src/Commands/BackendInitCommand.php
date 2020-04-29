<?php

namespace Toyza55k\Backend\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackendInitCommand extends Command
{
    private $stubDir = __DIR__.'/../stubs';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backend:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initial Laravel Backend and AdminLTE 3';

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
        // copy export
        File::ensureDirectoryExists(app_path('Exports/Backend'));
        copy($this->stubDir.'/exports/backend/UserExport.php', app_path('Exports/Backend/UserExport.php'));

        // copy helper
        File::ensureDirectoryExists(app_path('Helpers'));
        copy($this->stubDir.'/helpers/Array.php', app_path('Helpers/Array.php'));
        copy($this->stubDir.'/helpers/Date.php', app_path('Helpers/Date.php'));
        copy($this->stubDir.'/helpers/File.php', app_path('Helpers/File.php'));
        copy($this->stubDir.'/helpers/String.php', app_path('Helpers/String.php'));
        copy($this->stubDir.'/helpers/Utility.php', app_path('Helpers/Utility.php'));
    }
}
