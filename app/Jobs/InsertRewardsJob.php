<?php

namespace App\Jobs;

use App\Models\Reward;
use Carbon\Traits\Serialization;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertRewardsJob implements ShouldQueue
{
    use Queueable, DispatchesJobs, SerializesModels, InteractsWithQueue, Serialization;

    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Insert the data into the database
        Reward::insert($this->data);
    }
}
