<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    //
    public function weekly_report(){
    	$result = DB::table('jobs')
            ->select(DB::raw("user_id, sum(no_of_person) as request, date(job_date) as jobs_date "))
            ->groupBy('user_id')
            ->groupBy('jobs_date')
            ->orderBy('user_id', 'asc')
            ->orderBy('job_date', 'asc')
            ->get();
        // print_r($result);

        foreach($result as $k=>$v){
        	print_r($v);
        	echo '<br><br>';
        }

    	return view('reports.weekly_report');
    }
}
