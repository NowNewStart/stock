<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Company;

class RandomEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $company = Company::inRandomOrder()->first();
        if (rand(0, 100) > 50) {
            $company->multiplyValue(rand(0, 3) / 10);
            $company->transactions()->create([
                    'type' => 'random',
                    'payload' => serialize(['story' => 'A random event occurred which increased the value.']),
                    'user_id' => 1
                ]);
        } else {
            $company->multiplyValue(rand(0, 3) / (-10));
            $company->transactions()->create([
                    'type' => 'random',
                    'payload' => serialize(['story' => 'A random event occurred which decreased the value.']),
                    'user_id' => 1
                ]);
        }
    }
}
