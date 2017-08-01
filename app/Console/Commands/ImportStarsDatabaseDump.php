<?php

namespace App\Console\Commands;

use Chumper\Zipper\Zipper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ImportStarsDatabaseDump extends Command
{
    protected $description = 'Un-compresses and imports the stars table database dump';
    protected $signature = 'dbdump:import-stars';

    /** @var Zipper */
    private $zipper;

    /** @var  ProgressBar */
    private $progressBar;

    /** @var int */
    private $timeOut = 60;

    /**
     * ImportStarsDatabaseDump constructor.
     */
    public function __construct()
    {
        ini_set('memory_limit', '-1');
        parent::__construct();
        $this->zipper = new Zipper;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!Storage::disk('dumps')->exists('stars.zip')) {
            $this->setupProgressBar(6);
            $this->updateMessage('Fetching database dump from S3...');
            Storage::disk('dumps')->put('stars.zip', Storage::disk('s3')->get('stars.zip'));
        } else {
            $this->setupProgressBar(5);
        }

        $this->updateMessage('Extracting database dump zip archive...');
        $this->zipper->make('database/dumps/stars.zip')->extractTo('database/dumps');

        $this->updateMessage('Truncating stars table...');
        DB::table('stars')->truncate();

        $this->updateMessage('Importing .sql file into mysql...');
        $this->executeDatabaseImport();

        $this->zipper->close();

        Storage::disk('dumps')->delete('stars.sql');
        Storage::disk('dumps')->delete('stars.zip');

        $this->updateMessage('Finished importing data for stars table.', 2);
        $this->progressBar->finish();
    }

    /**
     * @param integer $steps
     */
    private function setupProgressBar($steps)
    {
        $this->line("\e[H\e[J");
        $this->progressBar = $this->output->createProgressBar($steps);
        $format = "<fg=yellow;options=bold>Importing Stars Table Database Dump</>\n";
        $format .= "\n%message%\n\n";
        $format .= "%current%/%max% [%bar%] %percent:3s%%";
        $format .= " -- %elapsed:6s%/%estimated:-6s% %memory:6s%\n";
        $this->progressBar->setFormat($format);
    }

    /**
     * @param $message
     * @param $step
     */
    private function updateMessage($message, $step = 1)
    {
        $this->progressBar->setMessage($message);
        $this->progressBar->advance($step);
    }
    
    private function executeDatabaseImport()
    {
        $process = new Process("mysql -u " . env('DB_USERNAME') . " -p" . env('DB_PASSWORD') . " " .
            env('DB_DATABASE') . " < " . base_path('database/dumps/stars.sql'), null, null, null, $this->timeOut);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }
}
