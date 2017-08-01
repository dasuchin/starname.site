<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    /** @var ProgressBar */
    private $progressBar;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->setupProgressBar();

        $this->updateMessage('Configuring roles and creating default administrator account...');
        $this->executeRolesSeeders();

        $this->updateMessage('Importing data for stars table...');
        $this->command->call('dbdump:import-stars', [], $this->command->getOutput());

        $this->updateMessage('Importing data for junk_stars table (this takes a very long time) ...');
        $this->command->call('dbdump:import-junk-stars', [], $this->command->getOutput());

        $this->progressBar->setMessage('Seeding completed.');
        $this->progressBar->finish();

        Model::reguard();
    }

    private function setupProgressBar()
    {
        $this->command->line("\e[H\e[J");
        $this->progressBar = $this->command->getOutput()->createProgressBar(4);
        $format = "<fg=yellow;options=bold>Database Seeder</>\n";
        $format .= "\n%message%\n\n";
        $format .= "%current%/%max% [%bar%] %percent:3s%%";
        $format .= " -- %elapsed:6s%/%estimated:-6s% %memory:6s%\n";
        $this->progressBar->setFormat($format);
    }

    private function executeRolesSeeders()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->command->line("\e[H\e[J");
    }

    /**
     * @param $message
     */
    private function updateMessage($message)
    {
        $this->progressBar->setMessage($message);
        $this->progressBar->advance();
    }
}
