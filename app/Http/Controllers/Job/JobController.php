<?php

namespace App\Http\Controllers\Job;

use Storage;
use Validator;
use App\User as User;
use App\AssignJob;
use App\DeviceToken;
use App\Employee;
use App\Employer;
use App\JobSchedule;
use App\Nationality;
use App\Job;
use App\Age;
use App\Location;
use App\Industry;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Http\Traits\NotificationTrait;
use App\Http\Traits\DateFormatDate;
use App\Http\Traits\PushNotiftrait;
use App\Http\Traits\JobDetailsOutputTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Traits\HttpResponse;

class JobController extends Controller
{
    use DateFormatDate;
    use JobDetailsOutputTrait;
    use HttpResponse;
    //use PushNotiftrait;
    use NotificationTrait;

    private $request;
    protected $data;
    public $lastInsertedId;
    public $newJob;
    protected $googleMap;
    protected $assignedJob;


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->newJob = constant('NEW_JOB');
        $this->googleMap = constant('GOOGLE_MAP_ENDPOINT');
        $this->assignedJob = constant('ASSIGNED_JOB');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $notification_status = null)
    {
        $role = Auth::user()->role;
        $roleId = Auth::user()->role_id;
        $param = [];
        $status = $request->get('status');

        if ($role == 'employer') {
            $param['userid'] = Auth::user()->id;
        }

        if($status=='unassigned'){
            $param['unassigned'] = true;
            $param['status'] = 'active';
        }else{
            $param['status'] = $status;
        }
            $jobsLists = $this->jobLists($param);

        return view('job.lists', [
            'job' => $jobsLists
            , 'role' => $role
            , 'role_id' => $roleId
            , 'status' => $status
            , 'notification_status' => $notification_status]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Auth::user()->role;
        $roleId = Auth::user()->role_id;
        if ($role == 'employer') {
            $userid = Auth::user()->id;
        } else {
            $userid = '';
        }

        $user = new Employer();
        $location = new Location();
        $nationality = new Nationality();
        $industry = $this->industry();
        $employer = $user->employerList($userid);
        $age = $this->age();
        $businessMngr = \App\User::where('role', 'business_manager')->pluck('name', 'id');
        $group = \App\RecipientGroup::all();

        return view('job.form', ['user' => $user
            , 'industry' => $industry
            , 'location' => $location->locationLists()
            , 'nationality' => $nationality->nationalityDropdown()
            , 'employer' => $employer
            , 'age' => $age
            , 'language' => $nationality->language()
            , 'recipientGroup' => $group

        ], compact('businessMngr'));
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
        $businessMngr = explode('.', $request->input('business_manager'));
        $zipCode = $this->getAddress($request->input('postal_code'));
        $data['zip_code'] = $request->input('postal_code');
        $data['postal_code'] = $zipCode;
        $industry = explode('.', $request->input('industry'));
        // $age = explode('-', $request->input('age'));
        $employer = explode('.', $request->input('job_employer'));

        $validator = $this->rules($data);

        if ($validator->fails()) {

            return redirect('job/create')
                ->withErrors($validator)
                ->withInput();
        } else {
             $split = [
                'location_id' => $location[0],
                'location' => $location[1],
                'industry_id' => $industry[0],
                'industry' => $industry[1],
                'employer_id' => $employer[0],
                'employer' => $employer[1],
                'business_id' => $businessMngr[0],
                'business' => $businessMngr[1],
    //            'min_age' => $age[0],
    //            'max_age' => $age[1],

            ];

            $data['address'] = $this->getFormattedAddress($data['postal_code']['lat'], $data['postal_code']['lng']);
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
        $user = \App\User::find($data['employer_id']);

        $insertedId = $user->job()->create([
            'job_title' => $data['job_title'],
            'job_id' => $data['employer_id'],
            'location_id' => $data['location_id'],
            'location' => $data['location'],
            'description' => $data['job_description'],
            'job_requirements' => empty($data['job_requirements']) ? '' : $data['job_requirements'],
            'role' => $data['job_role'] ?? '',
            'gender' => empty($data['gender']) ? '' : $data['gender'],
            'nationality' => empty($data['nationality']) ? '' : $data['nationality'],
            'job_image_path' => $data['job_image'],
            'no_of_person' => $data['no_of_person'],
            'contact_person' => empty($data['contact_person']) ? '' : $data['contact_person'],
            'contact_no' => empty($data['contact_no']) ? '' : $data['contact_no'],
            'business_manager' => empty($data['business']) ? '' : $data['business'],
            'business_manager_id' => empty($data['business_id']) ? '' : $data['business_id'],
            'employer' => $data['employer'],
            'rate' => empty($data['hourly_rate']) ? 0 : $data['hourly_rate'],
            'language' => '',// empty($data['preferred_language']) ? '' : $data['preferred_language'],
            'job_date' => $this->convertToUtc($data['date']),
            'end_date' => $this->convertToUtc($data['end_date']),
            'industry_id' => $data['industry_id'],
            'industry' => $data['industry'],
            'notes' => empty($data['notes']) ? '' : $data['notes'],
            'status' => Auth::user()->role_id == 0 ? 'active' : 'pending',
            'min_age' => $data['min_age'] ?? 0,
            'max_age' => $data['max_age'] ?? 0,
            'latitude' => $data['postal_code']['lat'],
            'longitude' => $data['postal_code']['lng'],
            'geolocation_address' => $data['address'],
            'zip_code' => $data['zip_code'],
            'recipient_group' => $data['recipient_group']
        ]);

        $this->lastInsertedId = $insertedId->id;

        $this->saveAge($this->lastInsertedId, $data);
        $this->saveLanguage($this->lastInsertedId, $data);
    }

    /**
     * @param array $data
     */
    public function updateData(array $data)
    {

        $user = \App\Job::find($data['job_id']);

        $toupdate = [
            'job_title' => $data['job_title'],
            'job_id' => $data['employer_id'],
            'location_id' => $data['location_id'],
            'location' => $data['location'],
            'description' => $data['job_description'],
            'job_requirements' => empty($data['job_requirements']) ? '' : $data['job_requirements'],
            'role' => $data['job_role'] ?? '',
            'gender' => empty($data['gender']) ? '' : $data['gender'],
            'nationality' => empty($data['nationality']) ? '' : $data['nationality'],
            'no_of_person' => $data['no_of_person'],
            'contact_person' => empty($data['contact_person']) ? '' : $data['contact_person'],
            'contact_no' => empty($data['contact_no']) ? '' : $data['contact_no'],
            'business_manager' => empty($data['business']) ? '' : $data['business'],
            'business_manager_id' => empty($data['business_id']) ? '' : $data['business_id'],
            'employer' => $data['employer'],
            'rate' => empty($data['hourly_rate']) ? 0 : $data['hourly_rate'],
            'language' => '',//empty($data['preferred_language']) ? '' : $data['preferred_language'],
            'job_date' => $this->convertToUtc($data['date']),
            'end_date' => $this->convertToUtc($data['end_date']),
            'industry_id' => $data['industry_id'],
            'industry' => $data['industry'],
            'notes' => empty($data['notes']) ? '' : $data['notes'],
            'status' => Auth::user()->role_id == 0 ? 'active' : 'inactive',
            'min_age' => $data['min_age'] ?? 0,
            'max_age' => $data['max_age'] ?? 0,
            'latitude' => $data['postal_code']['lat'],
            'longitude' => $data['postal_code']['lng'],
            'geolocation_address' => $data['address'],
            'zip_code' => $data['zip_code']
        ];

        if(isset($data['job_image'])){
            $toupdate['job_image_path'] = $data['job_image'];
        }
        $user->update($toupdate);
    }

    /**
     * Return Job Details from users
     *
     * @return \Illuminate\Http\JsonResponse
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
        $user = new Employer();
        $job = new Job();
        $nationObj = new Nationality();
        $modelAge = new Age();

        $role = Auth::user()->role;
        $roleId = Auth::user()->role_id;
        if ($role == 'employer') {
            $userid = Auth::user()->id;
        } else {
            $userid = '';
        }

        $details = $job->jobAdminDetails($id);
        if(empty($details)){abort(404);}

        $location = $this->location();
        $industry = $this->industry();
        $nationality = $this->nationalityList();
        $age = $this->age();
        $employer = $user->employerList($userid);
        $businessMngr = \App\User::where('role', 'business_manager')->pluck('name', 'id');

        $age_arr = array();
        $selectedage = $modelAge->getAgeByJob($id);
        if(!empty($selectedage)){
            foreach($selectedage as $k=>$v){
                $age_arr[] = $v->name;
            }
        }

        $lang_arr = array();
        $selectedLang = $this->getLanguageViaId($id);
        if(!empty($selectedLang)){
            foreach($selectedLang as $k){
                $lang_arr[] = $k->name;
            }
        }

        return view('job.edit-form', ['user' => $user
            , 'industry' => $industry
            , 'location' => $location
            , 'details' => $details
            , 'nationality' => $nationality
            , 'age' => $age
            , 'language' => $nationObj->language()
            , 'employer' => $employer
            , 'existing_age' => $age_arr
            , 'existing_lang' => $lang_arr
        ], compact('businessMngr'));

    }


    /**
     * Show the form for listing the jobs seekers.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getJobsSeekers($id)
    {
        $user = Auth::user();
        $job = new Job();

        $emp = $job->getUnemployed();

        $details = $job->jobAdminDetails($id);
        $location = $this->location();
        $industry = $this->industry();
        $nationality = $this->nationalityList();
        $age = $this->age();

        return view('job.job-seeker-list', [
            'details' => $details
            , 'employees' => $emp
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendNotification(Request $request, $id)
    {
        $user_ids = $request->input("employees-list");
        $jobDetails = \App\Job::where('id', $id)->first();
        $token = $this->parsingToken($user_ids);

        if (count($request->input("employees-list")) > 0) {

            $this->insertUpdateAssignJob($user_ids, $id);
            $this->assignJobNotification($jobDetails, $token);

            return back();

        } else {

            return back();

        }

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
        $job = new Job();
        $details = $job->jobAdminDetails($id);
        if(empty($details)){abort(404);}

        $data = $request->all();
        $zipCode = $this->getAddress($request->input('postal_code'));
        $data['postal_code'] = $zipCode;

        $data = $request->all();
        $location = explode('.', $request->input('job_location'));
        $businessMngr = explode('.', $request->input('business_manager'));
        $zipCode = $this->getAddress($request->input('postal_code'));
        $data['zip_code'] = $request->input('postal_code');
        $data['postal_code'] = $zipCode;
        $industry = explode('.', $request->input('industry'));
        //$age = explode('-', $request->input('age'));
        $employer = explode('.', $request->input('job_employer'));

        $split = [
            'location_id' => $location[0],
            'location' => $location[1],
            'industry_id' => $industry[0],
            'industry' => $industry[1],
            'employer_id' => $employer[0],
            'employer' => $employer[1],
            'business_id' => $businessMngr[0],
            'business' => $businessMngr[1]
        ];

        $validator = $this->rules($data,$details->job_image_path );

        if ($validator->fails()) {
            return redirect(route('job.edit', ['id' => $id]))
                ->withErrors($validator)
                ->withInput();
        } else {

            $data['address'] = $this->getFormattedAddress($data['postal_code']['lat'], $data['postal_code']['lng']);
            

            if ($request->hasFile('job_image')) {
                $profile['job_image'] = $request->file('job_image')->store('jobs');
                $mergeData = array_merge($data, $profile, $split);
            }else{
                $mergeData = array_merge($data, $split);
                // $merge = $data;

            }

            $this->deleteAge($mergeData, $id);
            $this->saveAge($id, $data);
            $this->deleteLanguage($mergeData, $id);
            $this->saveLanguage($id, $data);
            $this->updateData($mergeData);

            return redirect(route('job.details', ['id' => $id]));

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null, $param = null)
    {
        $job = new Job();

        $submit = empty($request->input('multiple')) ? $param : $request->input('multiple');
        $multi['multicheck'] = is_null($id) ? (array)$request->input('multicheck') : (array)$id;

        $validator = Validator::make($multi, ['multicheck' => 'required']);

        if ($validator->fails()) {

            $result = redirect(route('job.lists'))
                ->withErrors($validator)
                ->withInput();
        } else {

            switch ($submit) {
                case 'Approve':
                    $job->multiUpdateActive($multi['multicheck']);
                    break;
                case 'Delete':
                    $job->multiDelete($multi['multicheck']);
                    break;
                case 'Reject':
                    $job->multiUpdateInactive($multi['multicheck']);
                    break;
            }
            $result = back();
        }

        return $result;
    }

    /**
     * Validation Rule
     */
    public function rules(array $data, $job_image_path='')
    {
        $rules = [
            'job_title' => 'required',
            'job_description' => 'required|string',
            'job_role' => 'nullable',
            'no_of_person' => 'required|numeric',
            'job_employer' => 'required|string',
            'date' => 'required|date',
            'end_date' => 'required|date',
            'job_location' => 'required|string',
            'industry' => 'required|string',
            'postal_code' => 'required'
        ];
        if(empty($job_image_path)){
            $rules['job_image'] = 'required'; 
        }
        return Validator::make($data, $rules);
    }


    /**
     * Job Lists
     */
    public function jobLists($param)
    {
        $jobs = new Job();

        $jobLists = $jobs->jobList($param);

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
     * Set list
     */
    public function age()
    {
        $age = new Job();

        return $age->ageList();
    }

    /**
     * API List for jobs
     */
    public function jobApiLists()
    {
        $job = new Job();

        $param = [
            'industries' => (array)$this->request->get('industries'),
            'locations' => (array)$this->request->get('locations'),
            'start' => $this->request->get('start'),
            'created' => $this->request->get('created'),
            'limit' => (int)$this->request->get('limit'),
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
        $param[] = null;
        $job = new Job();
        $schedule = new JobSchedule();
        $employee = new Employee();

        $details = $job->jobAdminDetails($id);
        if(empty($details)){abort(404);}

        $relatedCandidates = $schedule->getRelatedCandidates($id);
        $employeeList = $employee->employeeLists($param);
        $age = $this->getAgeViaId($id);
        $language = $this->getLanguageViaId($id);

        return view('job.details', ['details' => $details
            , 'related' => $relatedCandidates
            , 'list' => $employeeList
            , 'role_id' => Auth::user()->role_id
            , 'age' => $age
            , 'language' => $language
        ]);
    }

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function saveJobsNotif($data)
    {
        $employer = explode('.', $data['job_employer']);

        $date = Carbon::parse($data['date'], 'Asia/Singapore')->format('M d, Y, h:i A');
        $push['job_id'] = $this->lastInsertedId;
        $push['title'] = 'New Job Available';
        $push['type'] = constant('NEW_JOB');
        $push['badge'] = 1;
        $push['body'] = $employer[1] . ' is hiring for ' . $data['job_title'] . ' at ' . $data['address'] . ' on ' . $date . '.';
        $push['registration_ids'] = $this->returnToken();

        return $this->pushNotif($push);
    }

    /**
     * @return array
     */
    public function returnToken()
    {
        $device = array();
        $token = new DeviceToken();
        $tokenValue = $token->listDeviceToken();
        foreach ($tokenValue as $value) {
            $device[] = $value->device_token;
        }

        return $device;
    }

    /**
     * @return mixed|static
     */
    public function saveNotif()
    {
        $employeeId = $this->listOfEmployeeId();

        foreach ($employeeId as $value) {

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
        $param[] = null;
        $employee = new Employee();

        $output = $employee->employeeLists($param);


        return $output;
    }

    /**
     * Get Address using postal code
     * @param $postal
     * @return string
     */
    public function getAddress($postal)
    {
        $http = new Client();
        try {
            $response = $http->get($this->googleMap . '?components=postal_code:' . $postal . '&key=' . env('GOOGLE_API_KEY'));
            $result = json_decode((string)$response->getBody(), true);
            if (!empty($result['results'])) {

                $param['location'] = [
                    'lng' => $result['results'][0]['geometry']['location']['lng'],
                    'lat' => $result['results'][0]['geometry']['location']['lat']
                ];

            } else {

                $param['location'] = '';
            }

            return $param['location'];

        } catch (RequestException $e) {

            if ($e->hasResponse()) {

                return 'Unknown Address';
            }
        }

    }

    /**
     * @param $lat
     * @param $lng
     * @return string
     */
    public function getFormattedAddress($lat, $lng)
    {
        $http = new Client();
        try {
            $response = $http->get($this->googleMap . '?latlng=' . $lat . ',' . $lng . '&key=' . env('GOOGLE_API_KEY'));
            $result = json_decode((string)$response->getBody(), true);

            if (!empty($result['results'])) {
                $param = $result['results'][0]['formatted_address'];
            } else {

                $param = '';
            }

            return $param;

        } catch (RequestException $e) {

            if ($e->hasResponse()) {

                return 'Unknown Address';
            }
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function location_tracking($id)
    {
        $param[] = null;
        $job = new Job();
        $schedule = new JobSchedule();
        $employee = new Employee();

        $details = $job->jobAdminDetails($id);
        if (empty($details)) {
            abort(404);
        }

        $relatedCandidates = $schedule->getCandidatesLocation($id);
        $markers = array();
        foreach ($relatedCandidates as $k => $v) {
            if (!empty($v->employee_current_lat) && !empty($v->employee_current_long) && $v->employee_current_lat != 0 && $v->employee_current_long != 0) {
                $markers[] = $v;
            }
        }
        return view('job.location_tracking', ['details' => $details, 'related' => $relatedCandidates, 'markers' => $markers]);
    }

    /**
     * Saving Notification when assigning the Job
     * @return mixed|static
     */
    public function saveAssignedNotif($userId, $jobId)
    {
        $save = \App\User::find($userId);
        $save->userNotification()->updateOrCreate([
            'job_id' => $jobId,
            'type' => $this->assignedJob
        ]);
    }

    /**
     * Insert Update NOtification assigned Job
     * @param $userId
     * @param $jobId
     */
    public function insertUpdateAssignJob($userId, $jobId)
    {
        $user = User::find($userId);
        $jobs = Job::find($jobId);

        foreach ($user as $key => $value) {
            if (!$this->findExistingJob($value->id, $jobs->id)) {
                $assigned[] = [
                    $value->id => [
                        'is_assigned' => true,
                        'assign_job_id' => $jobs->id,
                        'user_id' => $value->id
                    ],
                ];

                $this->saveAssignedNotif($value->id, $jobs->id);
            } else {
                $assigned[] = [];

            }
        }

        for ($i = 0; $i < count($assigned); $i++) {
            $jobs->assignJobs()->syncWithoutDetaching($assigned[$i]);
        }

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
     * @param $data
     */
    public function saveAge($id, $data)
    {
        if (!empty($data['age'])) {
            $job = \App\Job::find($id);

            for ($i = 0; $i < count($data['age']); $i++) {
                $age = $data['age'];
                $job->age()->create([
                    'name' => $age[$i]
                ]);
            }
        }
    }

    /**
     * @param $data
     */
    public function saveLanguage($id, $data)
    {
        if (!empty($data['preferred_language'])) {
            $user = \App\Job::find($id);

            for ($i = 0; $i < count($data['preferred_language']); $i++) {
                $saveLang = $data['preferred_language'];
                $user->language()->create([
                    'name' => $saveLang[$i]
                ]);

            }
        }
    }

    /**
     * Get language via id
     */
    public function getLanguageViaId($id)
    {
        $obj = \App\Language::where('job_id', $id)->get();

        return $obj;
    }

    /**
     * Get Age via id
     */
    public function getAgeViaId($id)
    {
        $obj = \App\Age::where('job_id', $id)->get();

        return $obj;
    }


    /**
     * Delete User
     */
    public function deleteAge($data, $id)
    {
        if(!empty($data['age'])) {

            $deleteRows = \App\Age::where('job_id', $id)->delete();
            return $deleteRows;

        }
    }

    /**
     * Delete User
     */
    public function deleteLanguage($data, $id)
    {
        if(!empty($data['preferred_language'])) {

            $deleteRows = \App\Language::where('job_id', $id)->delete();

            return $deleteRows;

        }
    }

    public function update_schedule(Request $request){
        $id = $request->input('id');
        $status = $request->input('status');

        $response = array('success'=>false,'data'=>array());
        if(empty($id) || empty($status)){
           $response['data'] = array('error'=>'Invalid data');
        }else{
           $jobdetail = \App\JobSchedule::find($id);
            if(empty($jobdetail)){
                $response['data'] = array('error'=>'Invalid data');
            }else{
                $job_status = '';
                switch($status){
                    case 'accept':
                        if($jobdetail->job_status=='pending' || $jobdetail->job_status=='reject_request'){
                            $job_status = 'accepted';
                        }else{
                            $error = 'Invalid data';
                        }
                        break;
                    case 'reject_request':
                        if($jobdetail->job_status=='pending' || $jobdetail->job_status=='accepted'){
                            $job_status = 'reject_request';
                        }else{
                            $error = 'Invalid data';
                        }
                        break;
                    case 'cancel':
                        if($jobdetail->job_status=='pending' || $jobdetail->job_status=='rejected_request' || $jobdetail->job_status=='accepted'){
                            $job_status = 'cancelled';
                        }else{
                            $error = 'Invalid data';
                        }
                        break;
                    case 'approve':
                        if($jobdetail->job_status=='completed'){
                            $job_status = 'approved';
                            $jobdetail->payment_status = 'pending';
                        }else{
                            $error = 'Invalid data';
                        }
                        break;
                    case 'reject':
                        if($jobdetail->job_status=='completed'){
                            $job_status = 'rejected';
                        }else{
                            $error = 'Invalid data';
                        }
                        break;
                    default:
                        $error = "Invalid data";
                        break;
                }
                if(!empty($error)){
                    $response['data'] = array('error'=>'Invalid data');
                }else{
                    $jobdetail->job_status = $job_status;
                    $jobdetail->save();
                    $response['success'] = true;
                    $response['data'] = array('msg'=>'Updated successfully.');
                }
            }
        }
        return response()->json($response);
    }
}
