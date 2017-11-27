<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class AutoCancelled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:auto_cancelled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancelling Job';

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
            ->join('job_schedules', 'job_schedules.job_id', '=', 'jobs.id')
            ->whereNull('job_schedules.checkin_datetime')
            ->whereNull('job_schedules.checkout_datetime')
            ->where('jobs.job_date', '>', Carbon::parse('24 hours'))
            ->where('job_schedules.job_status', 'accepted')
            ->update(['job_schedules.job_status'=>'auto_cancelled']);

    }
}
