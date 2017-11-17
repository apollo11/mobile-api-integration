<?php

namespace App\Http\Controllers\Employee;

use Validator;
use Input;

use App\Nationality;
use App\Location;
use App\Employee;
use App\User;
use App\Mail\EmployeeRegistration;
use App\AdditionalInfo;
use App\JobSchedule;
use App\Http\Traits\OauthTrait;
use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    use OauthTrait;
    use HttpResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param = [
          'checkin' => $request->get('checkin'),
          'checkout' => $request->get('checkout'),
          'job_status' => $request->get('status'),
        ];

        $employee = new Employee();
        $result = $employee->employeeLists($param);

        foreach ($result as $value) {
            $completed = $this->completedJobs($value->id);
            $applied = $this->appliedJobs($value->id);

            $data[] = [
                'id' => $value->id,
                'name' => $value->name,
                'birthdate' => $value->birthdate,
                'nric_no' => $value->nric_no,
                'mobile_no' => $value->mobile_no,
                'employee_status' => $value->employee_status,
                'joined' => $value->joined,
                'gender' => $value->gender,
                'completed' => $completed,
                'applied' => $applied,
                'business_manager' => $value->business_manager
            ];

        }
        $dataUndefined = !empty($data) ? $data : [];

        return view('employee.lists', ['employee' => $dataUndefined, 'count' => count($dataUndefined)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employee.form');
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
        $validate = $this->validator($data);
        $errorMsg = $validate->errors()->all();

        if ($validate->fails()) {

            return $this->mapValidator($errorMsg);

        } else {

            $this->save($data);

            return $this->successResponse($data);

        }

    }

    /**
     * Sign up new Employee
     */
    public function signup(Request $request)
    {
        $data = $request->all();
        $validate = $this->validator($data);

        if ($validate->fails()) {

            return redirect('employee/create')
                ->withErrors($validate)
                ->withInput();

        } else {

            $this->save($data);
            $this->sendEmailtoEmployee($data);

            return redirect('employee/lists');

        }
    }

    /**
     * Send Email
     */
    public function sendEmailToEmployee(array $data)
    {
        Mail::to($data['email'])->send( new EmployeeRegistration($data));

    }

    /**
     * Sign Up new Employee
     * @param array $data
     */
    public function save(array $data)
    {
        $school = !empty($data['school']) ? $data['school'] : null;
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->role_id = 2;
        $user->role = 'employee';
        $user->platform = $data['platform'];
        $user->mobile_no = $data['mobile_no'];
        $user->nric_no = $data['nric_no'];
        $user->school = $school;

        $user->save();
    }

    public function validateUser(Request $request)
    {
        $data = $request->all();
        $validate = $this->userValidator($data);
        $errorMsg = $validate->errors()->all();

        if ($validate->fails()) {

            return $this->mapValidator($errorMsg);

        } else {
            return $this->ValidUseSuccessResp(200, true);

        }
    }

    /**
     * @param $email
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function show($email)
    {
        $account = \App\User::where('email', $email)
            ->first();

        return $account;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userDetails = new AdditionalInfo();
        $location = new Location();
        $nationality = new Nationality();

        $contactMethod = [
            'sms'
            , 'phone'
            , 'email'
            , 'other'
        ];

        $details = $userDetails->userInfo($id);

        return view('employee.edit-form', [
            'details' => $details
            , 'contact_method' => $contactMethod
            , 'location' => $location->locationLists()
            , 'nationality' => $nationality->nationalityDropdown()
            , 'language' => $nationality->language()

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null)
    {
        $data = $request->all();
        $validator = $this->updateRules($data);

        if($validator->fails()) {

            return back()
                ->withErrors($validator)
                ->withInput();

        } else {

           $this->updateBasicAdditionalInfo($data, $id);

            return redirect('employee/lists');
        }
    }

    /**
     * Update additional information
     */
    public function updateBasicAdditionalInfo(array $data, $id)
    {
        $criminal = !empty($data['criminal_record']) ? $data['criminal_record'] : '';
        $medical = !empty($data['medication']) ? $data['medication'] : '';
        $school = !empty($data['school']) ? $data['school'] : '';
        $schoolExpiry = !empty($data['school_pass_expiry_date']) ? $data['school_pass_expiry_date'] : '1970-01-01';

        $additonalInfo = \App\AdditionalInfo::where('user_id', $id)->first();

        $user = \App\User::find($id);

        if(is_null($additonalInfo)) {

            $user->additionalInfo()->updateOrCreate([
                'gender' => $data['gender'],
                'birthdate' => $data['birthdate'],
                'religion' => $data['religion'],
                'address' => $data['address'],
                'email' => $data['email'],
                'school' => $school,
                'school_pass_expiry_date' => $schoolExpiry,
                'emergency_name' => $data['emergency_contact_person'],
                'emergency_contact_no' => $data['emergency_contact_person_no'],
                'emergency_relationship' => $data['emergency_person_relationship'],
                'emergency_address' => $data['emergency_person_address'],
                'contact_method' => $data['contact_method'],
                'criminal_record' => $criminal,
                'medication' => $medical,
                'language' => $data['language'],
                'nationality' => $data['nationality'],
                'front_ic_path' => 'none',
                'back_ic_path' => 'none',
                'signature_file_path' => 'none',
                'rate' => $data['rate']
            ]);

        } else {

            $user->additionalInfo()->update([
                'gender' => $data['gender'],
                'birthdate' => $data['birthdate'],
                'religion' => $data['religion'],
                'address' => $data['address'],
                'email' => $data['email'],
                'school' => $school,
                'school_pass_expiry_date' => $schoolExpiry,
                'emergency_name' => $data['emergency_contact_person'],
                'emergency_contact_no' => $data['emergency_contact_person_no'],
                'emergency_relationship' => $data['emergency_person_relationship'],
                'emergency_address' => $data['emergency_person_address'],
                'contact_method' => $data['contact_method'],
                'criminal_record' => $criminal,
                'medication' => $medical,
                'language' => $data['language'],
                'nationality' => $data['nationality'],
                'rate' => $data['rate']
            ]);

        }

        \App\User::where('id', $id)
            ->update([
                'name' => $data['name'],
                'mobile_no' => $data['mobile_no']
            ]);

    }

    /**
     * Update Profile Information Rules
     */
    public function updateRules(array $data)
    {

        return Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'mobile_no' => 'required',
                'birthdate' => 'date|required',
                'nationality' => 'required|string',
                'language' => 'required|string',
                'gender' => 'string|required',
                'emergency_contact_person' => 'required|string',
                'emergency_contact_person_no' => 'required|string',
                'emergency_person_relationship' => 'required|string',
                'contact_method' => 'required',
                'religion' => 'required|string',
                'emergency_person_address' => 'required|string',
                'address' => 'required',
                'rate' => 'required|numeric'
            ]
        );

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user = new User();

        $multi['multicheck'] = is_null($request->input('multicheck')) ? [] : $request->input('multicheck');
        $validator = Validator::make($multi, ['multicheck' => 'required']);

        if ($validator->fails()) {

            $result = redirect(route('employee.lists'))
                ->withErrors($validator)
                ->withInput();
        } else {
            $submit = $request->input('multiple');
            switch ($submit) {
                case 'Approve':
                    $user->multiUpdate($multi);
                    break;
                case 'Delete':
                    $user->multiDelete($multi);
                    break;
            }

            $result = back();
        }

        return $result;

    }

    /**
     * @return array
     */
    public function rules()
    {
        $validate = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|alpha_num',
            'mobile_no' => 'required|unique:users',
            'nric_no' => 'required|string|unique:users',

        ];

        return $validate;
    }

    /**
     * @return array
     */
    public function userRules()
    {
        $validate = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile_no' => 'required|unique:users',
            'nric_no' => 'required|string|unique:users',

        ];

        return $validate;
    }

    public function updateValidationRules(array $data)
    {
        return Validator::make($data, [
            'gender' => 'required|string',
            'birthdate' => 'date|string',
            'religion' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'school' => 'nullable',
            'school_pass_expiry_date' => 'nullable',
            'front_ic_path' => 'required|file',
            'back_ic_path' => 'required|file',
            'emergency_name' => 'required|string',
            'emergency_contact_no' => 'required|string',
            'emergency_relationship' => 'required|string',
            'emergency_address' => 'required|string',
            'contact_method' => 'required|string',
            'criminal_record' => 'nullable',
            'medication' => 'nullable',
            'bank_statement' => 'required|file',
            'language' => 'required|string',
            'signature_file_path' => 'required'
        ]);
    }

    /**
     * @param $data
     * @return mixed
     */

    public function validator($data)
    {
        $validator = Validator::make($data, $this->rules());

        return $validator;

    }

    /**
     * m
     * @param $data
     * @return mixed
     */

    public function userValidator($data)
    {
        $validator = Validator::make($data, $this->userRules());

        return $validator;

    }

    /**
     * Map Validation
     * @param $data
     * @return mixed
     */
    public function mapValidator($data)
    {
        return $this->errorResponse($data, 'Validation Error', 110001, 400);
    }

    /**
     * @return mixed
     */

    public function successResponse($data)
    {
        return $this->ouathResponse($data);
    }

    /**
     * Reject Employee User
     * 0 Pending
     */
    public function pendingStatus($id)
    {
        $user = \App\User::find($id);
        $user->employee_status = "pending";
        $user->save();

        return back();

    }

    /**
     * 1 Approve Employee user
     */
    public function approveStatus($id)
    {
        $user = \App\User::find($id);
        $user->employee_status = "approved";
        $user->save();

        return back();

    }

    /**
     * 2 Upload Info
     */
    public function uploadInfoUser($id)
    {
        $user = \App\User::find($id);
        $user->employee_status = "upload";
        $user->save();

        return back();

    }

    /**
     * 3 Reject user
     */
    public function rejectUser($id)
    {
        $user = \App\User::find($id);

        $user->employee_status = "reject";
        $user->save();

        return back();
    }

    /**
     * Delete one user
     */
    public function destroyOne($id)
    {
        $flight = \App\User::find($id);

        $flight->delete();

        return back();
    }

    public function details($id)
    {
        $userDetails = new AdditionalInfo();

        $details = $userDetails->userInfo($id);
        $jobInfo = $this->availableJobs($id);
        $applied = $this->completedJobs($id);
        $completed = $this->appliedJobs($id);

        return view('employee.details', ['userDetails' => $details
            , 'jobInfo' => $jobInfo
            , 'applied' => $applied
            , 'completed' => $completed
        ]);

    }

    public function availableJobs($id)
    {
        $job = new JobSchedule();
        $jobInfo = $job->getAvailJobsByUser($id);

        return $jobInfo;

    }

    public function completedJobs($id)
    {
        $count = new JobSchedule();
        $result = $count->countCompletedJobs($id);

        return $result;
    }

    public function appliedJobs($id)
    {
        $count = new JobSchedule();
        $result = $count->countAppliedJobs($id);

        return $result;
    }

    public function updateFrontIc(Request $request, $id)
    {
        $additonalInfo = \App\AdditionalInfo::where('user_id', $id)->first();
        $user = \App\User::find($id);

        $data['profile_front_ic'] = $request->file('profile_front_ic');

        $validator = Validator::make($data, [
            'profile_front_ic' => 'required|file',
        ]);

        if ($validator->fails()) {

            return redirect(route('employee.details', ['id' => $id]))
                ->withErrors($validator)
                ->withInput();

        } else {

            $profileImg = $this->uploadingFile($request);

            if (is_null($additonalInfo)) {

                $user->additionalInfo()->firstOrCreate([
                    'front_ic_path' => $profileImg['profile_front_ic'],
                ]);

            } else {
                $user->additionalInfo()->update([
                    'front_ic_path' => $profileImg['profile_front_ic'],
                ]);
            }

            return redirect(route('employee.details', ['id' => $id]));

        }

    }

    public function updateBacktIc(Request $request, $id)
    {
        $additonalInfo = \App\AdditionalInfo::where('user_id', $id)->first();
        $user = \App\User::find($id);

        $data['profile_back_ic'] = $request->file('profile_back_ic');

        $validator = Validator::make($data, [
            'profile_back_ic' => 'required|file',
        ]);

        if ($validator->fails()) {

            return redirect(route('employee.details', ['id' => $id]))
                ->withErrors($validator)
                ->withInput();

        } else {

            $profileImg = $this->uploadingFile($request);

            if (is_null($additonalInfo)) {

                $user->additionalInfo()->firstOrCreate([
                    'back_ic_path' => $profileImg['profile_back_ic'],
                ]);

            } else {
                $user->additionalInfo()->update([
                    'back_ic_path' => $profileImg['profile_back_ic'],
                ]);
            }

            return redirect(route('employee.details', ['id' => $id]));

        }

    }

    public function updateBankStmnt(Request $request, $id)
    {
        $additonalInfo = \App\AdditionalInfo::where('user_id', $id)->first();
        $user = \App\User::find($id);

        $data['bank_statement'] = $request->file('bank_statement');

        $validator = Validator::make($data, [
            'bank_statement' => 'required|file',
        ]);

        if ($validator->fails()) {

            return redirect(route('employee.details', ['id' => $id]))
                ->withErrors($validator)
                ->withInput();

        } else {

            $profileImg = $this->uploadingFile($request);

            if (is_null($additonalInfo)) {

                $user->additionalInfo()->firstOrCreate([
                    'bank_statement' => $profileImg['bank_statement'],
                ]);

            } else {
                $user->additionalInfo()->update([
                    'bank_statement' => $profileImg['bank_statement'],
                ]);
            }

            return redirect(route('employee.details', ['id' => $id]));

        }

    }

    public function updateProfileImg(Request $request, $id = null)
    {
        $user = \App\User::find($id);
        $data['profile_image'] = $request->file('profile_image');

        $validator = Validator::make($data, [
            'profile_image' => 'required|file',
        ]);

        if($validator->fails()) {

            return redirect(route('employee.details',['id' => $id]))
                ->withErrors($validator)
                ->withInput();

        } else {

           $profileImg = $this->uploadingFile($request);


           $user->profile_image_path = $profileImg['profile_image'];
           $user->save();

            return redirect(route('employee.details',['id' => $id]));
        }

    }

    function uploadingFile(Request $request)
    {
        if ($request->hasFile('profile_front_ic')) {

            $file['profile_front_ic'] = $request->file('profile_front_ic')->store('additional');
        }
        if ($request->hasFile('profile_back_ic')) {

            $file['profile_back_ic'] = $request->file('profile_back_ic')->store('additional');

        }

        if ($request->hasFile('bank_statement')) {

            $file['bank_statement'] = $request->file('bank_statement')->store('additional');
        }

        if ($request->hasFile('profile_image')) {

            $file['profile_image'] = $request->file('profile_image')->store('avatars');
        }

        return $file;
    }



}
