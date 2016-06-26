<?php

namespace App\Console\Commands;

use App\Models\Job;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldJobPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:delete_old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
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
        $monthAgo = Carbon::now()->startOfDay()->subMonth()->format('Y-m-d H:i:s');
        $deleted = Job::where('updated_at', '<=', $monthAgo)->delete();

        $this->info("Successfully deleted {$deleted} old job posts.");
    }
}