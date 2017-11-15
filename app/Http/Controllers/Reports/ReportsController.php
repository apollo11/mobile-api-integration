<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    //
    public function related_jobs(){
    	return view('reports.related_jobs');
    }
}
