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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $location = explode('.', $request->input('job_location'));
        $industry = explode('.', $request->input('industry'));
        $age = explode('-', $request->input('age'));

        $split = [
            'location_id' => $location[0],
            'job_location' => $location[1],
            'industry_id' => $industry[0],
            'industry' => $industry[1],
            'min_age' => $age[0],
            'max_age' => $age[1]
        ];

        $validator = $this->rules($data);

        if ($validator->fails()) {

            return redirect('job/create')
                ->withErrors($validator)
                ->withInput();
        } else {

            $profile['job_image'] = $request->file('job_image')->store('jobs');
            $mergeData = array_merge($data, $profile, $split);

            $this->saveData($mergeData);

            return redirect('job/lists');
        }

    }

    public function saveData(array $data)
    {

        $user = \App\User::find(Auth::user()->id);

        $user->job()->create([
            'job_title' => $data['job_title'],
            'job_id' => Auth::user()->id,
            'location_id' => $data['location_id'],
            'location' => $data['job_location'],
            'description' => $data['job_description'],
            'job_requirements' => $data['job_requirements'],
            'role' => $data['job_role'],
            'gender' => $data['gender'],
            'nationality' => $data['nationality'],
            'job_image_path' => $data['job_image'],
            'no_of_person' => $data['no_of_person'],
            'contact_person' => $data['contact_person'],
            'contact_no' => $data['contact_no'],
            'business_manager' => $data['business_manager'],
            'employer' => $data['job_employer'],
            'rate' => $data['hourly_rate'],
            'language' => $data['preferred_language'],
            'job_date' => $data['date'],
            'end_date' => $data['end_date'],
            'industry_id' => $data['industry_id'],
            'industry' => $data['industry'],
            'notes' => $data['notes'],
            'job_status' => $data['job_status'],
            'min_age' => $data['min_age'],
            'max_age' => $data['max_age']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $job = new Job();

        $output = $job->jobDetails($this->request->get('id'), $this->request->get('user_id'));

        $details = $this->jobDetailsoutput($output);

        return response()->json(['job_details' => $details]);    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
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
            'job_requirements' => 'required|string',
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
            'age' => 'required',
            'nationality' => 'required|string'
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

        $param = [
            'industries' => (array) $this->request->get('industries'),
            'locations' => (array) $this->request->get('locations'),
            'start' => $this->request->get('start'),
            'created' =>$this->request->get('created'),
            'limit' => (int) $this->request->get('limit'),
            'date_from' => $this->request->get('date_from'),
            'date_to' => $this->request->get('date_to'),
        ];

        $output = $job->filterByLimitStartEnd($param['limit'], $param);

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

            $data[] = $this->jobDetailsoutput($value);
        }

        $dataUndefined = !empty($data) ? $data : [];

        return response()->json(['jobs' => $dataUndefined]);

    }

    public function jobDetailsoutput($output)
    {
        $start_date = $date = date_create($output->start_date, timezone_open('UTC'));
        $end_date = $date = date_create($output->end_date, timezone_open('UTC'));
        $created = $date = date_create($output->created_at, timezone_open('UTC'));

        $details = [
            'id' => $output->schedule_id,
            'job' => [
                'id' => $output->id,
                'user_id' => $output->user_id,
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
                'is_assigned' => 0
            ]
        ];

        return $details;

    }

}
