<?php

namespace App\Http\Controllers\Employee;

use App\Employee;
use Input;
use App\User;
use App\AdditionalInfo;
use App\JobSchedule;
use Validator;
use App\Http\Traits\OauthTrait;
use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;
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
    public function index()
    {
        $employee = new Employee();
        $result = $employee->employeeLists();

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

        return view('employee.lists', ['employee' => $data, 'count' => count($data)]);
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

            return redirect('employee/lists');

        }
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

        $details = $userDetails->userInfo($id);

        return view('employee.edit-form', ['details' => $details ]);
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
        $submit = $request->input('multiple');
        $multi = $request->input('multicheck');

        switch ($submit) {
            case 'Approve':
                $user->multiUpdate($multi);
                break;
            case 'Reject':
                $user->multiDelete($multi);
                break;
        }

        return back();
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

}
