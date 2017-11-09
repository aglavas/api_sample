<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwaggerInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swagger:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize swagger index file';

    /**
     * Create a new command instance.
     *
     * SwaggerInit constructor.
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
        // Prompting for host name
        $host = $this->ask('Please enter host name for this application:', 'localhost');

        // save swagger index file
        $this->createSwaggerIndexFile($host);
    }

    private function createSwaggerIndexFile($host)
    {
        $swaggerPath = resource_path('assets/swagger/');
        $indexPath = $swaggerPath.'index-swagger.yaml';

        if (file_exists($indexPath)) {
            $this->error("Swagger index file ({$indexPath}) already exist. Remove this file and call this method again, or simply run 'gulp' to compile swagger files!");
            return;
        }

        $data = file_get_contents($swaggerPath.'index-swagger.yaml.sample');

        $data = str_replace('{{hostname}}', '"'.$host . '"', $data);

        file_put_contents($indexPath, $data);

        exec('gulp');

        $this->info("You can check available routes on ".url('/docs/dist'));
    }
}
