<?php

namespace App\Http\Controllers;

use App\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $param = [
            'jobRequest' => $this->countJobRequest(),
            'inactiveJob' => $this->countInactiveJob(),
            'unassigned' => $this->countUnassignedJob(),
            'cancelled' => $this->countCancelledJobs(),
            'registeredEmployer' => $this->countEmployer()
        ];

        return view('home', $param);
    }


    /**
     * @return mixed
     */
    public function countJobRequest()
    {
        $job = new Job();
        $count = $job->countActiveJobs();

        return $count;
    }

    /**
     * @return mixed
     */
    public function countInactiveJob()
    {
        $job = new Job();
        $count = $job->countInactiveJobs();

        return $count;
    }

    /**
     * No. of Jobs unassigned
     */
    public function countUnassignedJob()
    {
        $job = new Job();
        $count = $job->unAssignedJobs();

        return $count;
    }

    /**
     * No. of cancellation by jobseekers
     */
    public function countCancelledJobs()
    {
        $job = new Job();
        $count = $job->cancelledJobs();

        return $count;

    }

    /**
     * No. of registered employers from mobile
     */
    public function countEmployer()
    {
        $job = new Job();
        $count = $job->registeredEmployersviaMobile();

        return $count;


    }
}
