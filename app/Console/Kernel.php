<?php

namespace App\Console;

use App\Company;
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
        $schedule->call(function () {
            Company::all()->each(function ($company) {
                $company->payDividends();
            });
        })->everyMinute();

        $schedule->call(function () {
            $company = Company::inRandomOrder()->first();
            if (rand(0, 100) > 50) {
                $company->multiplyValue(rand(0, 3) / 10);
                $company->transactions()->create([
                    'type'    => 'random',
                    'payload' => serialize(['story' => 'A random event occurred which increased the value.']),
                    'user_id' => 1,
                ]);
            } else {
                $company->multiplyValue(rand(0, 3) / (-10));
                $company->transactions()->create([
                    'type'    => 'random',
                    'payload' => serialize(['story' => 'A random event occurred which decreased the value.']),
                    'user_id' => 1,
                ]);
            }
        })->hourly();
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
