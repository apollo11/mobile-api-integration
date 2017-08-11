<?php

namespace App\Http\Controllers;

use App\Http\Traits\OauthTrait;
use Validator;
use App\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use OauthTrait;
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

            return view('dashboard.employee', ['employees' => $employee]);
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
        $data = $request->all();
        $validate = $this->validator($data);
        $errorMsg  = $validate->errors()->all();

        if($validate->fails()) {

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
     * @return array
     */
    public function rules()
    {
        $validate = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'mobile_no' => 'required',
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

    public function mapValidator($data)
    {
        foreach ($data as $error) {
            $value[] =  $error;
        }

        $output = ['error'=>
            [
                'title'=> 'Validation Error'
                , 'code' => 110001
                , "status_code" => 400
                , "messages" => $value
            ],
            "success" => false
        ];

        return response($output)->header('status', 400);

    }

    /**
     * @return mixed
     */

    public function successResponse($data)
    {
        return $this->ouathResposne($data);
//        $output = [
//            "status_code" => 200,
//            "success" => true,
//        ];
//
//        return response($output)->header('status', 200);
    }


}
