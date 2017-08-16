<?php

namespace App\Http\Controllers;

use Validator;
use App\User;
use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    use HttpResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employers = \App\User::where('role_id', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.employer', ['employers' => $employers]);

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
            $user->role = $request->input('role');
            $user->role_id = 1;
            $user->platform = $request->input('platform');
            $user->mobile_no = $request->input('mobile_no');
            $user->business_name = $request->input('business_name');
            $user->save();

            return $this->successResponse();

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
            'mobile_no' => 'required',
            'business_name' => 'required|string'
        ];

        return $validate;
    }

    public function validator($data)
    {
        $validator = Validator::make($data, $this->rules());

        return $validator;

    }


    public function mapValidator($data)
    {
        return $this->errorResponse($data, 'Validation Error',110001,400 );

    }

    public function successResponse()
    {
        return $this->ValidUseSuccessResp(200, true);
    }


}
