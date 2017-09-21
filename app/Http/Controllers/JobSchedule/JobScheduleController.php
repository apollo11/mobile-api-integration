<?php

namespace App\Http\Controllers\JobSchedule;

use Validator;
use App\Job;
use App\JobSchedule;
use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobScheduleController extends Controller
{
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

            $checkJob = $this->isJobExist($request->input('job_id'), $request->input('user_id'));

            if ($checkJob != null) {

                $output = $this->errorResponse(['This job is already on your scheduled job list.'], 'Apply Failure', 110009, 400);

            } else {

                $user->jobSchedule()->create(['name' => null, 'job_id' => $request->input('job_id'), 'job_status' =>"accepted"]);

                $this->updateJobStatus($request->input('job_id'));

                $output = $this->show($request->input('job_id'));

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

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = new JobSchedule();

        $output = $job->getJobScheduleDetails($id, 'jobs.id');

        $details = $this->jobScheduleOutput($output);

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

    public function apply($id)
    {
        $employee = \App\User::where('role_id', 2)
            ->where('id',$id)
            ->first();

        return $employee;
    }

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
     * Job Schedule output
     */
    public function jobScheduleOutput($output)
    {
        $start_date = $date = date_create($output->start_date, timezone_open('UTC'));
        $end_date = $date = date_create($output->end_date, timezone_open('UTC'));
        $created = $date = date_create($output->created_at, timezone_open('UTC'));
        $details = [
               'schedule_id' => $output->schedule_id,
                'job' => [
                    'job_title' => $output->job_title,
                    'id' => $output->id,
                    'employer' => [
                        'image_url' => $output->profile_image_path,
                        'name' => $output->company_name,
                        'description' => $output->company_description
                    ],
                    'industry' => [
                        'id' => $output->industry_id,
                        'name' => $output->industry
                    ],
                    'location' => [
                        'id' => $output->location_id,
                        'name' => $output->location,
                    ],
                    'created_date' => date_format($created, 'Y-m-d H:i:sP'),
                    'start_date' => date_format($start_date, 'Y-m-d H:i:sP'),
                    'end_date' => date_format($end_date, 'Y-m-d H:i:sP'),
                    'contact_no' => $output->contact_no,
                    'rate' => $output->rate,
                    'thumbnail_url' => $output->job_image_path,
                    'nationality' => ucfirst($output->nationality),
                    'description' => $output->description,
                    'min_age' => $output->min_age,
                    'max_age' => $output->max_age,
                    'role' => $output->role,
                    'remarks' => $output->notes,
                    'language' => $output->language,
                    'gender' => $output->gender,
                    'job_requirements' => $output->job_requirements,
                    'status' => $output->job_status,
                    'is_assigned' => $output->is_assigned
                ]
        ];

        return $details;

    }

    /**
     * Adding response output for lists
     * @param $output
     * @return \Illuminate\Http\JsonResponse
     */
    function jobInfoOutput($output)
    {
        foreach ($output as $value) {

            $data[] =  $this->jobScheduleOutput($value);
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
