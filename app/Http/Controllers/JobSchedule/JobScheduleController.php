<?php

namespace App\Http\Controllers\JobSchedule;

use Illuminate\Console\Scheduling\Schedule;
use Validator;
use App\History;
use Carbon\Carbon;
use App\JobSchedule;
use App\AdditionalInfo;
use App\Http\Traits\ProfileTrait;
use App\Http\Traits\JobDetailsOutputTrait;
use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobScheduleController extends Controller
{
    use JobDetailsOutputTrait;
    use HttpResponse;
    use ProfileTrait;

    private $request;
    protected $data;

    public function __construct(Request $request)
    {
        $this->request = $request;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $sched = new JobSchedule();

        $jobId = $request->input('job_id');
        $userId = $request->input('user_id');

        $user = \App\User::find($userId);


        if ($user['employee_status'] == 'pending' || $user['employee_status'] == 'reject') {

            $output = $this->errorResponse(['Your account status is pending or blocked'], 'User Verification', 110008, 400);

        } else {
            $jobSched = $sched->listofDatebyId($jobId);

            $validateSched = $sched->schedConflict($userId, $jobSched->job_date, $jobSched->end_date);

            $checkJob = $this->isJobExist($request->input('job_id'), $request->input('user_id'));

            if ($checkJob != null) {

                $output = $this->errorResponse(['This job is already on your scheduled job list.'], 'Apply Failure', 110009, 400);

            } elseif ($jobSched->job_date < Carbon::now()) {

                $output = $this->errorResponse(['The job has already expired.'], 'Apply Failure', 1100015, 400);

            } elseif (count($validateSched) > 0) {

                if($validateSched->job_status == "accepted") {

                    $output = $this->errorResponse(['You have a schedule that overlaps with this job start date or end date.'], 'Apply Failure', 1100014, 400);

                } else {
                    $output = $this->errorResponse(['You have a pending schedule that overlaps with this job start date or end date.'], 'Apply Failure', 1100014, 400);
                }

            } else {

                $statusPoints = $this->comparePoints($userId);

                $user->jobSchedule()->create(['name' => null, 'job_id' => $request->input('job_id'), 'job_status' => $statusPoints]);

                $this->updateJobStatus($request->input('job_id'));

                $output = $this->show($jobId, $userId);

            }

        }

        return $output;
    }

    /**
     * Condition if account exist in schedule
     */
    public function isJobExist($jobId, $userId)
    {
        $jobSched = \App\JobSchedule::where('job_id', $jobId)
                    ->where('user_id', $userId)
                    ->first();

        return $jobSched;

    }

    public function allSchedules()
    {
        $sched = \App\JobSchedule::all();

        foreach ($sched as $key)
        {
            $appliedDate[] = $key->applied_date;
        }

        return $appliedDate;
    }

    /**
     * @param $jobId
     * @param $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($jobId, $userId)
    {
        $job = new JobSchedule();

        $output = $job->getJobScheduleDetails($jobId, 'jobs.id');

        $jobDetails = $this->jobDetailsoutput($output);
        $userDetails = $this->profileIteration($userId);

        return response()->json(['job_details' => $jobDetails, 'user_details' => $userDetails,'status' => ['status_code' => 200, 'success' => true]]);

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

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function apply($id)
    {
        $employee = \App\User::where('role_id', 2)
            ->where('id',$id)
            ->first();

        return $employee;
    }

    public function findJob($id) {

        $find = \App\Job::find($id)->first();

        return $find;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function jobScheduleLists()
    {
        $jobSchedule = new JobSchedule();

        $param = [
            'industries' => (array) $this->request->get('industries'),
            'locations' => (array) $this->request->get('locations'),
            'start' => $this->request->get('start'),
            'created' =>$this->request->get('created'),
            'limit' => (int) $this->request->get('limit'),
            'date_from' => $this->request->get('date_from'),
            'date_to' => $this->request->get('date_to'),
            'id' => $this->request->get('user_id'),
        ];

        $output = $jobSchedule->getJobByUserSchedule($param);

        return $this->jobInfoOutput($output);

    }

    /**
     * Adding response output for lists
     * @param $output
     * @return \Illuminate\Http\JsonResponse
     */
    function jobInfoOutput($output)
    {
        foreach ($output as $value) {

            $data[] =  $this->jobDetailsoutput($value);
        }

        $dataUndefined = !empty($data) ? $data : [];

        return response()->json(['schedules' => $dataUndefined]);

    }

    /**
     * Update Job lists status
     */
    public function updateJobStatus($id)
    {
        $job = \App\Job::find($id);
        $job->job_status = "accepted";
        $job->save();
    }

    /**
     * Cancel Job
     */
    public function cancelJob(Request $request)
    {
        $data = $request->all();

        $job = new JobSchedule();
        $job::find($data);
        $job->job_status = "cancelled";

    }

    /**
     * Iteration of profile output
     */
    public function profileIteration($userId)
    {
        $info = new AdditionalInfo();
        $history = new History();

        $complete = $history->countCompletedJobs($userId);
        $money = $history->countEarnedJobs($userId);
        $count = $info->countPendingJobs($userId);
        $data = $info->userInfo($userId);

        $data = $this->userDetailsOutput($data, $count);
        $data['completed_job_count'] = $complete;
        $data['money_earned'] = $money;

        return $data;
    }

    /**
     * @param $userId
     * @return string
     */
    public function comparePoints($userId)
    {
        $sched = new JobSchedule();
        $result = $sched->userPoints($userId);
        if ($result->employee_points < 70) {
            $output = 'pending';
        } else {

            $output = 'accepted';
        }

        return $output;
    }

}
