<?php

namespace App\Http\Controllers\AssignJob;

use Validator;
use App\User as User;
use App\Job as Job;
use App\AssignJob;
use App\DeviceToken;
use App\Http\Traits\PushNotiftrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignJobsController extends Controller
{
    use PushNotiftrait;

    protected $assignedJob;

    public function __construct()
    {
        $this->assignedJob = constant('ASSIGNED_JOB');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $job = new AssignJob();
        $jobsLists = $job->assignedJobs();

        return view('job.lists', ['job' => $jobsLists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input('user_id');
        $jobId =  $request->input('job_id');

        $multi['user_assign'] = is_null($data) ? [] : $data;

        $validator = Validator::make($multi, ['user_assign' => 'required']);


        if ($validator->fails()) {

            $result = redirect(route('job.details',['id' => $jobId ]))
                ->withErrors($validator)
                ->withInput();
        } else {
            $user = User::find($data);
            $jobs = Job::find($jobId);

            foreach ($user as $key => $value) {
                if(!$this->findExistingJob($value->id, $jobs->id)) {
                    $assigned[] = [
                        $value->id => [
                            'is_assigned' => true,
                            'assign_job_id' => $jobs->id,
                            'user_id' => $value->id
                        ],
                    ];

                    $jobDetails = Job::where('id', $jobId)->get();
                    $user_ids = $value->id;

                    $message = "Dear Sir/Madam, You have been assigned a job successfully!  Below is the job information: " . "\n" . "Job Name: " . $jobDetails[0]->job_title . "\n" . " Job Date and Time: " . $jobDetails[0]->job_date . "\n" . " Job Location: " . $jobDetails[0]->location . "\n" . " Hourly Rate: " . $jobDetails[0]->rate . "\n" .  " Contact Person: " . $jobDetails[0]->contact_person . "\n" . " Contact No.: " . $jobDetails[0]->contact_no;

                    $deviceTokenResult = DeviceToken::whereIn('user_id', $user_ids)->get();
                    $deviceTokens = array();
                        for ($i=0; $i < count($deviceTokenResult); $i++) { 
                        array_push($deviceTokens, $deviceTokenResult[$i]->device_token);
                    }

                    $data['title'] = "New Jobs Assigned to You";
                    $data["body"] = $message;
                    $data["registration_ids"] = $deviceTokens;
                    $data["badge"] = 1;
                    $data["type"] = "job_assigned";
                    $data["job_id"] = $jobId;


                    if ($this->pushNotif($data) == "200") {
                        //  Success Code
                        $this->saveNotif($value->id, $jobs->id);
                    } else {
                        //  Failed Code
                    }
                    
                } else {
                    $assigned[] = [];

                }
            }

            for ($i = 0; $i < count($assigned); $i++) {
                $jobs->assignJobs()->syncWithoutDetaching($assigned[$i]);
            }

            $result = redirect(route('job.details',['id' => $jobId]));

        }

        return $result;

    }

    /**
     * Find Existing Job
     * @param $userId
     * @param $jobId
     * @return mixed
     */
    public function findExistingJob($userId, $jobId)
    {
        $data = new AssignJob();
        $output = $data->ifDataExist($userId, $jobId);

        return $output;

    }

    /**
     * Saving Notification when assigning the Job
     * @return mixed|static
     */
    public function saveNotif($userId, $jobId)
    {
        $save = \App\User::find($userId);
        $save->userNotification()->create([
            'job_id' => $jobId,
            'type' => $this->assignedJob
        ]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}