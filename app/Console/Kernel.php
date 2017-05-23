<?php

namespace App\Console;

use App\Console\Commands\PayDividendsCommand;
use App\Console\Commands\RandomEventCommand;
use App\Console\Commands\StockChangeCommand;
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
        \Spatie\MigrateFresh\Commands\MigrateFresh::class,
        PayDividendsCommand::class,
        RandomEventCommand::class,
        StockChangeCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(PayDividendsCommand::class)->everyThirtyMinutes();

        $schedule->command(RandomEventCommand::class)->hourly();

        $schedule->command(StockChangeCommand::class)->everyFiveMinutes();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
