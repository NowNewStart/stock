<?php

namespace App\Jobs;

use App\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $this->info('Company ID '.$company->id);
        if (rand(0, 100) > 50) {
            $company->multiplyValue(rand(0, 3) / 10);
            $company->transactions()->create([
                'type'    => 'random',
                'payload' => serialize(['story' => "Something happened which increased the company's value"]),
                'user_id' => null,
            ]);
        } else {
            $company->multiplyValue(rand(0, 3) / (-10));
            $company->transactions()->create([
                'type'    => 'random',
                'payload' => serialize(['story' => "Something happened which decreased the company's value"]),
                'user_id' => null,
            ]);
        }
    }
}
