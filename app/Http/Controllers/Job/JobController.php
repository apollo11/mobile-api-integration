<?php

namespace App\Http\Controllers\Job;

use Storage;
use Validator;
use App\DeviceToken;
use App\Employee;
use App\Employer;
use App\JobSchedule;
use App\Nationality;
use App\Job;
use App\Location;
use App\Industry;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\Http\Traits\DateFormatDate;
use App\Http\Traits\PushNotiftrait;
use App\Http\Traits\JobDetailsOutputTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class JobController extends Controller
{
    use DateFormatDate;
    use JobDetailsOutputTrait;
    use PushNotiftrait;

    private $request;
    protected $data;
    public $lastInsertedId;
    public $newJob;
    protected $googleMap;


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->newJob = constant('NEW_JOB');
        $this->googleMap = constant('GOOGLE_MAP_ENDPOINT');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = Auth::user()->role;


        if ($role == 'employer') {
            $userid = Auth::user()->id;
        } else {
            $userid = '';
        }

        $param = [
            'status' => $request->get('status'),
            'userid' => $userid
        ];


        $jobsLists = $this->jobLists($param);

        return view('job.lists', ['job' => $jobsLists, 'role' => $role ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new Employer();
        $location = new Location();
        $nationality = new Nationality();
        $industry = $this->industry();
        $employee = $user->employerList();
        $age = $this->age();
        $businessMngr = \App\User::where('role', 'business_manager')->pluck('name', 'id');
        $group = \App\RecipientGroup::all();


        return view('job.form', ['user' => $user
            , 'industry' => $industry
            , 'location' => $location->locationLists()
            , 'nationality' => $nationality->nationalityDropdown()
            , 'employer' => $employee
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
        $zipCode = $this->getAddress($request->input('postal_code'));
        $data['zip_code'] = $request->input('postal_code');
        $data['postal_code'] = $zipCode;
        $industry = explode('.', $request->input('industry'));
        $age = explode('-', $request->input('age'));
        $employer = explode('.', $request->input('job_employer'));

        $split = [
            'location_id' => $location[0],
            'location' => $location[1],
            'industry_id' => $industry[0],
            'industry' => $industry[1],
            'min_age' => $age[0],
            'max_age' => $age[1],
            'employer_id' => $employer[0],
            'employer' => $employer[1]
        ];

        $validator = $this->rules($data);

        if ($validator->fails()) {

            return redirect('job/create')
                ->withErrors($validator)
                ->withInput();
        } else {
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
            'role' => $data['job_role'],
            'gender' => empty($data['gender']) ? '' : $data['gender'],
            'nationality' => empty($data['nationality']) ? '' : $data['nationality'],
            'job_image_path' => $data['job_image'],
            'no_of_person' => $data['no_of_person'],
            'contact_person' => empty($data['contact_person']) ? '' : $data['contact_person'],
            'contact_no' => empty($data['contact_no']) ? '' : $data['contact_no'],
            'business_manager' => empty($data['business_manager']) ? '' : $data['business_manager'],
            'employer' => $data['employer'],
            'rate' => empty($data['hourly_rate']) ? 0 : $data['hourly_rate'],
            'language' => empty($data['preferred_language']) ? '' : $data['preferred_language'],
            'job_date' => $this->convertToUtc($data['date']),
            'end_date' => $this->convertToUtc($data['end_date']),
            'industry_id' => $data['industry_id'],
            'industry' => $data['industry'],
            'notes' => empty($data['notes']) ? '' : $data['notes'],
            'status' => Auth::user()->role_id == 0 ? 'active' : 'inactive',
            'min_age' => $data['min_age'],
            'max_age' => $data['max_age'],
            'latitude' => $data['postal_code']['lat'],
            'longitude' => $data['postal_code']['lng'],
            'geolocation_address' => $data['address'],
            'zip_code' => $data['zip_code'],
            'recipient_group' => $data['recipient_group']
        ]);

        $this->lastInsertedId = $insertedId->id;
    }

    /**
     * @param array $data
     */
    public function updateData(array $data)
    {

        $user = \App\Job::find($data['job_id']);

        $user->update([
            'job_title' => $data['job_title'],
            'job_id' => $data['employer_id'],
            'location_id' => $data['location_id'],
            'location' => $data['location'],
            'description' => $data['job_description'],
            'job_requirements' => empty($data['job_requirements']) ? '' : $data['job_requirements'],
            'role' => $data['job_role'],
            'gender' => empty($data['gender']) ? '' : $data['gender'],
            'nationality' => empty($data['nationality']) ? '' : $data['nationality'],
            'job_image_path' => $data['job_image'],
            'no_of_person' => $data['no_of_person'],
            'contact_person' => empty($data['contact_person']) ? '' : $data['contact_person'],
            'contact_no' => empty($data['contact_no']) ? '' : $data['contact_no'],
            'business_manager' => empty($data['business_manager']) ? '' : $data['business_manager'],
            'employer' => $data['employer'],
            'rate' => empty($data['hourly_rate']) ? 0 : $data['hourly_rate'],
            'language' => empty($data['preferred_language']) ? '' : $data['preferred_language'],
            'job_date' => $this->convertToUtc($data['date']),
            'end_date' => $this->convertToUtc($data['end_date']),
            'industry_id' => $data['industry_id'],
            'industry' => $data['industry'],
            'notes' => empty($data['notes']) ? '' : $data['notes'],
            'status' => Auth::user()->role_id == 0 ? 'active' : 'inactive',
            'min_age' => $data['min_age'],
            'max_age' => $data['max_age'],
            'latitude' => $data['postal_code']['lat'],
            'longitude' => $data['postal_code']['lng'],
            'geolocation_address' => $data['address'],
            'zip_code' => $data['zip_code']
        ]);
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

        $details = $job->jobAdminDetails($id);
        $location = $this->location();
        $industry = $this->industry();
        $nationality = $this->nationalityList();
        $age = $this->age();
        $employer = $user->employerList();

        return view('job.edit-form', ['user' => $user
            , 'industry' => $industry
            , 'location' => $location
            , 'details' => $details
            , 'nationality' => $nationality
            , 'age' => $age
            , 'employer' => $employer
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
        $zipCode = $this->getAddress($request->input('postal_code'));
        $data['postal_code'] = $zipCode;

        $data = $request->all();
        $location = explode('.', $request->input('job_location'));
        $zipCode = $this->getAddress($request->input('postal_code'));
        $data['zip_code'] = $request->input('postal_code');
        $data['postal_code'] = $zipCode;
        $industry = explode('.', $request->input('industry'));
        $age = explode('-', $request->input('age'));
        $employer = explode('.', $request->input('job_employer'));
        $split = [
            'location_id' => $location[0],
            'location' => $location[1],
            'industry_id' => $industry[0],
            'industry' => $industry[1],
            'min_age' => $age[0],
            'max_age' => $age[1],
            'employer_id' => $employer[0],
            'employer' => $employer[1]

        ];

        $validator = $this->rules($data);

        if ($validator->fails()) {

            return redirect(route('job.edit', ['id' => $id]))
                ->withErrors($validator)
                ->withInput();
        } else {

            $data['address'] = $this->getFormattedAddress($data['postal_code']['lat'], $data['postal_code']['lng']);
            $profile['job_image'] = $request->file('job_image')->store('jobs');

            $mergeData = array_merge($data, $profile, $split);

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
        $multi['multicheck'] = is_null($id) ? (array)$request->input('multicheck') : (array) $id;

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
    public function rules(array $data)
    {
        return Validator::make($data, [
            'job_title' => 'required',
            'job_description' => 'required|string',
            'job_role' => 'required|string',
            'job_image' => 'required',
            'no_of_person' => 'required|numeric',
            'job_employer' => 'required|string',
            'date' => 'required|date',
            'end_date' => 'required|date',
            'job_location' => 'required|string',
            'industry' => 'required|string',
            'postal_code' => 'required'
        ]);
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
        $relatedCandidates = $schedule->getRelatedCandidates($id);
        $employeeList = $employee->employeeLists($param);

        return view('job.details', ['details' => $details, 'related' => $relatedCandidates, 'list' => $employeeList]);
    }

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
        $token = new DeviceToken();
        $tokenValue = $token->listDeviceToken();
        foreach ($tokenValue as $value) {
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

}
