<?php

namespace App\Http\Controllers\Job;

use Storage;
use Validator;
use App\DeviceToken;
use App\Employee;
use App\JobSchedule;
use App\Nationality;
use App\Job;
use App\Location;
use App\Industry;
use App\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Traits\PushNotiftrait;
use App\Http\Traits\JobDetailsOutputTrait;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    use JobDetailsOutputTrait;
    use PushNotiftrait;

    private $request;
    protected $data;
    public $lastInsertedId;
    public $newJob;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->newJob = constant('NEW_JOB');
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
        $nationality = $this->nationalityList();


        return view('job.form', ['user' => $user
            , 'industry' => $industry
            , 'location' => $location
            , 'nationality' => $nationality]);
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
            $this->saveNotif();
            $this->saveJobsNotif($mergeData);

            return redirect('job/lists');
        }

    }

    /**
     * @param array $data
     */
    public function saveData(array $data)
    {
        $user = \App\User::find(Auth::user()->id);

        $insertedId = $user->job()->create([
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
            'status' => $data['status'],
            'min_age' => $data['min_age'],
            'max_age' => $data['max_age']
        ]);

        $this->lastInsertedId = $insertedId->id;
    }

    /**
     * @param array $data
     */
    public function updateData(array $data)
    {

        $user = \App\User::find($data['user_id']);

        $user->job()->update([
            'job_title' => $data['job_title'],
            'job_id' => Auth::user()->id,
            'location_id' => $data['location_id'],
            'location' => $data['job_location'],
            'description' => $data['job_description'],
            'job_requirements' => $data['job_requirements'],
            'role' => $data['job_role'],
            'choices' => $data['gender'],
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
            'status' => $data['status'],
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

        return response()->json(['job_details' => $details]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $job = new Job();

        $details = $job->jobAdminDetails($id);

        $location = $this->location();
        $industry = $this->industry();
        $nationality = $this->nationalityList();

        return view('job.edit-form', ['user' => $user
            ,'industry' => $industry
            , 'location' => $location
            , 'details' => $details
            , 'nationality' => $nationality
        ]);

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

            return redirect(route('job.edit', ['id' => $id]))
                ->withErrors($validator)
                ->withInput();
        } else {

            $profile['job_image'] = $request->file('job_image')->store('jobs');
            $mergeData = array_merge($data, $profile, $split);

            $this->updateData($mergeData, $data['user_id']);

            return redirect(route('job.details', ['id' => $id]));

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id=null , $param=null)
    {
        $job = new Job();
        $submit = empty($request->input('multiple')) ? $param : $request->input('multiple');
        $multi = is_null($id) ? $request->input('multicheck') : (array) $id;

        switch ($submit) {
            case 'Approve':
                $job->multiUpdateActive($multi);
                break;
            case 'Delete':
                $job->multiDelete($multi);
                break;
            case 'Reject':
                $job->multiUpdateInactive($multi);
                break;
        }

        return back();

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
            'hourly_rate' => 'required|numeric',
            'preferred_language' => 'required|string',
            'date' => 'required|date',
            'end_date' => 'required|date',
            'notes' => 'required|string',
            'status' => 'required|string',
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

        $jobLists = $jobs->jobList();

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
     * Nationality
     */
    public function nationalityList()
    {
        $nationality = new Nationality();

        return $nationality->nationalityDropdown();
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
            'user_id' => $this->request->get('user_id')
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

    /**
     * Job Details
     */
    public function details($id)
    {
        $job = new Job();
        $schedule = new JobSchedule();
        $employee = new Employee();

        $details = $job->jobAdminDetails($id);
        $relatedCandidates = $schedule->getAvailJobsByUser($id);
        $employeeList = $employee->employeeLists();

        return view('job.details', ['details' => $details, 'related' => $relatedCandidates, 'list' => $employeeList]);
    }

    public function saveJobsNotif($data)
    {
        $date = Carbon::parse($data['date'], 'Asia/Singapore')->format('M d, Y, h:i A');
        $push['job_id'] = $this->lastInsertedId;
        $push['title'] = 'New Job Available';
        $push['type'] = constant('NEW_JOB');
        $push['body'] = $data['job_employer'].' is hiring for '. $data['job_title']. ' at '. $data['job_location'].' on '.$date.'.';
        $push['registration_ids'] = $this->returnToken();

        return $this->pushNotif($push);
    }

    /**
     * @return array
     */
    public function returnToken()
    {
        $token = new DeviceToken();
        $tokenValue = $token->listDeviceToken();
        foreach ($tokenValue as $value)
        {
            $device[] = $value->device_token;
        }

        return $device;
    }

    /**
     * @param array $data
     * @return mixed|static
     */
    public function saveNotif()
    {
        $employeeId = $this->listOfEmployeeId();

        foreach ($employeeId as $value ) {

            $save = \App\User::find($value->id);

            $save->userNotification()->create([
                'job_id' => $this->lastInsertedId,
                'type' => $this->newJob
            ]);

        }
        return $save;
    }

    /**
     * @return array
     */
    public function listOfEmployeeId()
    {
        $employee = new Employee();

        $output = $employee->employeeLists();


        return $output;
    }



}
