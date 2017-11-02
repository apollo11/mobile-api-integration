<?php

namespace App\Http\Controllers;

use App\Employer;
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
            'registeredEmployer' => $this->countEmployer(),
            'checkout' => $this->checkOut(),
            'checkin' => $this->checkIn(),
            'approved' => $this->approved(),
        ];

        return view('home', $param);
    }


    /**
     * @return mixed
     */
    public function countJobRequest()
    {
        $job = new Job();
        $count = $job->countJobRequest();

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

    /**
     * Count Newly registered employee
     */

    public function countNewlyRegEmployee()
    {
        $employer = new Employer();

        return view('layouts.sidebar',['newlyReg' => $employer->countRegMobile()]);
    }

    /**
     * Count Check in
     */
    public function checkIn()
    {
        $job = new Job();

        $count = $job->checkInCount();

        return $count;
    }

    /**
     * Checkout Count
     */
    public function checkOut()
    {
        $job = new Job();
        $count = $job->checkOutCount();

        return $count;

    }

    /**
     * Count approved Job
     */
    public function approved()
    {
        $job = new Job();
        $count = $job->approvedJob();

        return $count;

    }
}
