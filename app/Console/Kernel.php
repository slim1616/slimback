<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    // define your queues here in order of priority
    protected $queues = [
        'notifications',
        'default',
    ];
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CronDailyMail::class,
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
        $schedule->command('daily:cron')->dailyAt('20:00');
        // $schedule->command($this->getQueueCommand())
        // ->everyMinute()
        // ->withoutOverlapping();
        // $schedule->command('queue:restart')
        // ->everyMinute();
        // ->hourly();
    }

    protected function getQueueCommand()
    {
        // build the queue command
        $params = implode(' ',[
            '--daemon',
            '--tries=3',
            '--sleep=3',
            '--queue='.implode(',',$this->queues),
        ]);

        return sprintf('queue:work %s', $params);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
