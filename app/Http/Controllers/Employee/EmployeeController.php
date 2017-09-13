<?php

namespace App\Http\Controllers\Employee;

use App\Http\Traits\OauthTrait;
use App\Http\Traits\HttpResponse;
use Validator;
use App\User;
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
        $employee = \App\User::where('role_id', 2)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('employee.lists', ['employees' => $employee]);
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

            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->role = $request->input('role');
            $user->role_id = 2;
            $user->platform = $request->input('platform');
            $user->mobile_no = $request->input('mobile_no');
            $user->nric_no = $request->input('nric_no');
            $user->school = $request->input('school');
            $user->save();

            return $this->successResponse($data);

        }

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
     * m
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
     * Approve Employee user
     */
    public function approveUser($id)
    {

        $user = \App\User::find($id);
        $user->is_approved = 1;
        $user->save();

        return back();

    }

    /**
     * Reject Employee User
     */
    public function rejectUser($id)
    {
        $user = \App\User::find($id);
        $user->is_approved = 0;
        $user->save();

        return back();

    }


}
