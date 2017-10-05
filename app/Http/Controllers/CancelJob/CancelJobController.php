<?php

namespace App\Http\Controllers\CancelJob;

use Validator;
use App\JobSchedule;
use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CancelJobController extends Controller
{
    use HttpResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();

        $validate = $this->rules($data);
        $errorMsg = $validate->errors()->all();

        if ($validate->fails()) {

            $output = $this->mapValidator($errorMsg);

        } else {

            $IsjobCancelled = $this->isJobExist($data['id']);


            if ($IsjobCancelled != null) {

                $output = $this->errorResponse(['This job is already cancelled.'], 'Cancel Failure', 1100012, 400);

            } else {

                if ($request->hasFile('file')) {

                    $file['file'] = $request->file('file')->store('cancelJobs');
                } else {

                    $file['file'] = null;
                }

                $merge = array_merge($data, $file);
                $this->edit($merge);

                $output = $this->show($request->input('id'));
            }
        }

        return $output;

    }

    /**
     * Condition if account exist in schedule
     */
    public function isJobExist($id)
    {
        $jobSched = \App\JobSchedule::where('id','=', $id)
            ->where('job_status', 'cancelled')
            ->first();

        return $jobSched;

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = new JobSchedule();

        $output = $job->getJobScheduleDetails($id, 'job_schedules.id');

        $details = $this->jobScheduleOutput($output);

        return response()->json(['job_details' => $details, 'status' => ['status_code' => 200, 'success' => true]]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(array $data)
    {

        $job = \App\JobSchedule::where('id', $data['id']);

        $job->update([
            'cancel_status' => $data['type'],
            'cancel_reason' => $data['reason'],
            'cancel_file_path' => $data['file'],
            'job_status' => "cancelled"
        ]);

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
     * Validation rules cancelling job
     */
    public function rules(array $data)
    {
        return Validator::make($data,
            [
                'type' => 'required',
                'file' => 'nullable'
            ]);
    }

    public function mapValidator($data)
    {
        return $this->errorResponse($data, 'Validation Error', 1100011, 400);
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
                'status' => $output->schedule_status,
                'is_assigned' => $output->is_assigned
            ]
        ];

        return $details;

    }
}
