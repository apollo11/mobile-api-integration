<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class AutoCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:auto_completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto Complete Job';

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
            ->whereNotNull('job_schedules.checkin_datetime')
            ->where('jobs.job_date', '>', Carbon::parse('24 hours'))
            ->where('job_schedules.job_status', 'accepted')
            ->update(['job_schedules.job_status'=>'auto_completed']);

    }
}
