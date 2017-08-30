<?php

namespace App\Http\Controllers\Job;

use Validator;
use App\Job;
use App\Location;
use App\Industry;
use Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobsLists = $this->jobLists();

        return view('job.lists', ['job' => $jobsLists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $location = $this->location();
        $industry = $this->industry();

        return view('job.form', ['user' => $user, 'industry' => $industry, 'location' => $location]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $location = explode('.',$request->input('job_location'));
        $industry = explode('.', $request->input('industry'));

        $splitJobAndIndustry = [
            'location_id' => $location[0],
            'job_location' =>  $location[1],
            'industry_id' => $industry[0],
            'industry' => $industry[1]
        ];

        $validator = $this->rules($data);

        if($validator->fails()) {

            return redirect('job/create')
                ->withErrors($validator)
                ->withInput();
        } else {

            $profile['job_image'] = $request->file('job_image')->store('jobs');
            $mergeData = array_merge($data, $profile, $splitJobAndIndustry);


            $this->saveData($mergeData);

            return redirect('job/lists');
     }

    }

    public function saveData(array $data)
    {
        $query = new Job();
        $query->job_id = Auth::user()->id;
        $query->job_title = $data['job_title'];
        $query->location_id = $data['location_id'];
        $query->location = $data['job_location'];
        $query->description = $data['job_description'];
        $query->role = $data['job_role'];
        $query->choices = $data['gender'];
        $query->job_image_path = $data['job_image'];
        $query->no_of_person = $data['no_of_person'];
        $query->contact_person = $data['contact_person'];
        $query->contact_no = $data['contact_no'];
        $query->business_manager = $data['business_manager'];
        $query->employer = $data['job_employer'];
        $query->rate = $data['hourly_rate'];
        $query->language = $data['preferred_language'];
        $query->job_date = $data['date'];
        $query->end_date = $data['end_date'];
        $query->industry_id = $data['industry_id'];
        $query->industry = $data['industry'];
        $query->notes = $data['notes'];
        $query->status = $data['job_status'];

        $query->save();

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

    /**
     * Validation Rule
     */
    public function rules(array $data)
    {
        return Validator::make($data, [
           'job_title' => 'required',
            'job_description' => 'required|string',
            'job_role' => 'required|string',
            'job_image' => 'required',
            'no_of_person' => 'required|numeric',
            'contact_person' => 'required|string',
            'business_manager' => 'required|string',
            'job_employer' => 'required|string',
            'hourly_rate' => 'required|digits_between:1,5',
            'preferred_language' => 'required|string',
            'date' => 'required|date',
            'end_date' => 'required|date',
            'notes' => 'required|string',
            'job_status' => 'required|string',
            'gender' => 'required|string',
            'job_location' => 'required|string',
            'contact_no' => 'required|string',
            'industry' => 'required|string',

        ]);
    }

    /**
     * Job Lists
     */
    public function jobLists()
    {
        $jobs = new Job();
        $jobLists = $jobs::all();

        return $jobLists;

    }

    /**
     * Lists of location for dropdown
     */
    public function location()
    {
        $location = new Location();

        $output = $location->locationLists();

        return $output;

    }

    /**
     * List of available industries for dropdown
     */
    public function industry()
    {
        $location = new Industry();

        $output = $location::all();

        return $output;

    }

    /**
     * API List for jobs
     */

    public function jobApiLists()
    {
        $job = new Job();

        $output = $job->jobLists();

        foreach ($output as $value) {

            $start_date = $date = date_create($value->start_date, timezone_open('UTC'));
            $end_date = $date = date_create($value->end_date, timezone_open('UTC'));


            $data[] = [
                'id' => $value->id,
                'employer' => $value->employer,
                'industry' => [
                    'id' => $value->industry_id,
                    'name' => $value->industry
                ],
                'location' => [
                    'id' => $value->location_id,
                    'name' => $value->location,
                ],
                'start_date' => date_format($start_date, 'Y-m-d H:i:sP'),
                'end_date' => date_format($end_date, 'Y-m-d H:i:sP'),
                'contact_no' => $value->contact_no,
                'rate' => $value->rate,
                'thumbnail_url' => $value->job_image_path
            ];
        }

        return response()->json(['jobs' => $data]);
    }

    /**
     * @param array $location
     * @param array $industry
     * @param $date
     * @return mixed
     */
    public function filterJobs($location = null, $industry = null, $date=null)
    {
       $splitLocation =  explode(',',$location);
       $splitIndustry = explode(',', $industry);

        $job = new Job();
        $value = $job->multipleFilter($splitLocation,$splitIndustry, $date);

        return $value;

    }
}
