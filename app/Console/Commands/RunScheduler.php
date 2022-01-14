<?php

/**


This Scheduler will run once every minute unlike the Heroku scheduler which only runs every 10 mintues.

To use this scheduler with Laravel 5.4+ add this file to /app/Console/Commands/RunScheduler.php
Register this file in app/Console/Kernel.php

protected $commands = [
...
Commands\RunScheduler::class
...
]

Add this line to your Procfile:

scheduler: php -d memory_limit=512M artisan schedule:cron

Push to Heroku and you will see you have a new dyno option called Scheduler, start ONE only.

I highly recommend using Artisan::queue to run your cron jobs so that your scheduler does not over run.

 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

/**
 *
 * Runs the scheduler every 60 seconds as expected to be done by cron.
 * This will break if jobs exceed 60 seconds so you should make sure all scheduled jobs are queued
 *
 * Class RunScheduler
 * @package App\Console\Commands
 */
class RunScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:cron {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the scheduler without cron (For use with Heroku etc)';

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
        $this->info('Waiting ' . $this->nextMinute() . ' for next run of scheduler');
        sleep($this->nextMinute());
        $this->runScheduler();
    }

    /**
     * Main recurring loop function.
     * Runs the scheduler every minute.
     * If the --queue flag is provided it will run the scheduler as a queue job.
     * Prevents overruns of cron jobs but does mean you need to have capacity to run the scheduler
     * in your queue within 60 seconds.
     *
     */
    protected function runScheduler()
    {
        $fn = $this->option('queue') ? 'queue' : 'call';

        $this->info('Running scheduler');
        Artisan::$fn('schedule:run');
        $this->info('completed, sleeping..');
        sleep($this->nextMinute());
        $this->runScheduler();
    }

    /**
     * Works out seconds until the next minute starts;
     *
     * @return int
     */
    protected function nextMinute()
    {
        $current = Carbon::now();
        return 60 - $current->second;
    }
}
