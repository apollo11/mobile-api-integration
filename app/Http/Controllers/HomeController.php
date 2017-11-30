<?php

namespace App\Http\Controllers;

use App\Employer;
use App\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $param = [];
        $user_role_id = Auth::user()->role_id;
        $user_id = '';

        if($user_role_id==1 || $user_role_id==0){
            if($user_role_id==1){$user_id = Auth::user()->id;}
            $param = [
                'jobRequest' => $this->countJobRequest($user_id),
                'approved' => $this->approved($user_id),
                // 'inactiveJob' => $this->countInactiveJob($user_id),
                'unassigned' => $this->countUnassignedJob($user_id),
                'cancelled' => $this->countCancelledJobs(),
                'registeredEmployer' => $this->countEmployer(),
                'checkout' => $this->checkOut(),
                'checkin' => $this->checkIn(),
            ];
        }
        return view('home', $param);
    }


    /**
     * @return mixed
     */
    public function countJobRequest($user_id)
    {
        $job = new Job();
        $count = $job->countJobRequest($user_id);

        return $count;
    }

    /**
     * @return mixed
     */
    public function countInactiveJob($user_id)
    {
        $job = new Job();
        $count = $job->countInactiveJobs($user_id);

        return $count;
    }

    /**
     * No. of Jobs unassigned
     */
    public function countUnassignedJob($user_id)
    {
        $job = new Job();
        $count = $job->unAssignedJobs($user_id);

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
    public function approved($user_id)
    {
        $job = new Job();
        $count = $job->approvedJob($user_id);

        return $count;
    }
}