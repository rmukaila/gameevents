<?php

namespace App\Jobs;

use App\Http\Controllers\RewardController;
use App\Models\Reward;
use Carbon\Traits\Serialization;
use Error;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use function Illuminate\Log\log;

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


}
