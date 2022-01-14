<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\RunScheduler::class,
        Commands\DatabaseBackup::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('db:backup')->daily();
        $schedule->command('invoice:expire')->everyMinute();
        $schedule->command('mutasi')->everyFiveMinutes();
        $schedule->command('smile')->everyTenMinutes()
            ->appendOutputTo(storage_path() . '/logs/scheduler.log');
        $schedule->command('kiosgamercheck')->everyTenMinutes()
            ->appendOutputTo(storage_path() . '/logs/scheduler.log');
        $schedule->command('kiosgamercodmcheck')->everyTenMinutes()
            ->appendOutputTo(storage_path() . '/logs/scheduler.log');
        /** Run every minute specified queue if not already started */
        // if (stripos((string) shell_exec('ps xf | grep \'[q]ueue:work\''), 'artisan queue:work') === false) {
        // $schedule->command('queue:work --stop-when-empty')->withoutOverlapping()->everyMinute()->appendOutputTo(storage_path() . '/logs/scheduler.log');
        // $schedule->command('queue:restart')
        //     ->everyFiveMinutes();

        $schedule->command('queue:work --stop-when-empty')
           ->everyMinute()
           ->withoutOverlapping()
           ->appendOutputTo(storage_path() . '/logs/scheduler.log');
        // $schedule->command('queue:work --daemon')
        //     ->everyMinute()
        //     ->withoutOverlapping()->appendOutputTo(storage_path() . '/logs/scheduler.log');;
        // }
        // $schedule->command('queue:work --stop-when-empty')
        //     ->everyMinute()
        //     ->withoutOverlapping()
        //     ->evenInMaintenanceMode()
        //     ->sendOutputTo(storage_path() . '/queue-logs/queue-jobs.log', true);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
