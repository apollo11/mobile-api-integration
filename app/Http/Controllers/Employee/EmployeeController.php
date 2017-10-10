<?php

namespace App\Http\Controllers\Employee;

use App\Employee;
use App\User;
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

        return view('employee.lists', ['employees' => $employee->employeeLists()]);
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



}
