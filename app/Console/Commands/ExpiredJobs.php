<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class ExpiredJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired:job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Will run if jobs is expired';

    /**
     * Create a new command instance.
     *
     * @return void
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
        DB::table('jobs')
            ->leftJoin('job_schedules', 'jobs.id', '=', 'job_schedules.job_id')
            ->whereNull('job_schedules.job_status')
            ->where('jobs.job_date', '<', Carbon::now())
            ->update(['jobs.status' => 'expired']);
    }
}
