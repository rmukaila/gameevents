<?php

namespace App\Jobs;

use App\Http\Controllers\RewardController;
use App\Models\Reward;
use Carbon\Traits\Serialization;
use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertRewardsJob implements ShouldQueue
{
    use Queueable;

    protected $data;
    /**
     * Create a new job instance.
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Insert the data into the database
        // Reward::insert($this->data);
        $reward_controller = new RewardController();
        $reward_controller->rewardAllPlayers__();
    }


    public function failed(\Exception $exception)
    {
        // also send email to admin
        // Handle the job failure (e.g., log the error, notify admins)
        // \Log::error('Job failed: ' . $exception->getMessage());
    }
}
