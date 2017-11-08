<?php

namespace App\Http\Controllers\JobSchedule;

use Validator;
use App\JobSchedule;
use App\Http\Traits\JobDetailsOutputTrait;
use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobScheduleController extends Controller
{
    use JobDetailsOutputTrait;
    use HttpResponse;

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
        $user = \App\User::find($request->input('user_id'));

        if ($user['employee_status'] == 'pending' || $user['employee_status'] == 'reject') {

            $output = $this->errorResponse(['Your account status is pending or blocked'], 'User Verification', 110008, 400);

        } else {
            $job = $this->findJob($request->input('job_id'));
            $checkJob = $this->isJobExist($request->input('job_id'), $request->input('user_id'));

            if ($job['job_date'] == $checkJob['applied_date']) {

                $output = $this->errorResponse(['You have already had a job at the same time slot!.'], 'Apply Failure', 1100014, 400);

            } else {

                if ($checkJob != null) {

                    $output = $this->errorResponse(['This job is already on your scheduled job list.'], 'Apply Failure', 110009, 400);

                } else {

                    $user->jobSchedule()->create(['name' => null, 'job_id' => $request->input('job_id'), 'job_status' => "accepted", 'applied_date' => $job['job_date']]);

                    $this->updateJobStatus($request->input('job_id'));

                    $output = $this->show($request->input('job_id'));

                }

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

    public function compareJobSchedDate($jobDate)
    {
        $findSched = new JobSchedule();

        $result = $findSched->checkScheduleDate($jobDate);

        return $result;
    }


    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = new JobSchedule();

        $output = $job->getJobScheduleDetails($id, 'jobs.id');

        $details = $this->jobDetailsoutput($output);

        return response()->json(['job_details' => $details, 'status' => ['status_code' => 200, 'success' => true]]);

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

}
