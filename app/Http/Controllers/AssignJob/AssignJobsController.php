<?php

namespace App\Http\Controllers\AssignJob;

use Validator;
use App\User as User;
use App\Job as Job;
use App\AssignJob;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignJobsController extends Controller
{
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

                    $this->saveNotif($value->id, $jobs->id);
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
        $save->userNotification()->updateOrCreate([
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