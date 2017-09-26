<?php

namespace App\Http\Controllers\EmployeeProfile;

use Validator;
use App\Http\Traits\ProfileTrait;
use App\AdditionalInfo;
use App\Http\Traits\HttpResponse;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BasicInfoController extends Controller
{
    use ProfileTrait;
    use HttpResponse;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $info = new AdditionalInfo();
        $count = $info->countPendingJobs($id);
        $add = $info->userInfo($id);

        return $this->profileIteration($add, $count);
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function update(Request $request)
    {
        $data = $request->all(); //Http request
        $oldPasswd = $this->oldPasswordValidation($data); // Validation of password

        $availability = empty($data['availabilities']) ? [] : $data['availabilities'];

        $id = $data['user_id'];

        $validator = $this->rules($data);
        $errorMsg = $validator->errors()->all();

        if ($oldPasswd == 0) {

            $result = $this->mapValidator(['The specified password does not match the database password']);

        } elseif ($validator->fails()) {

            $result = $this->mapValidator($errorMsg);

        } else {

            $this->updateData($data);
            $this->storeAvailability($availability, $id);
            $result = $this->show($id);
        }

        return $result;
    }

    /**
     * Updating Basic Info
     */

    public function updateData(array $data)
    {
        $update = \App\User::find($data['user_id'])
            ->update([
               'name' => $data['name'],
                'password'=> bcrypt($data['password']),
                'mobile_no' => $data['mobile_no']
            ]);

        return $update;

    }

    /**
     * Availability
     */
    public function storeAvailability($data, $id)
    {
        $user = \App\User::find($id);


        foreach ($data as $value => $output) {
            $user->availability()->create([
                'day' => $output['day'],
                'start_time' => $output['start_time'],
                'end_time' => $output['end_time']
            ]);
        }


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
     * Rules Validation
     */
    public function rules(array $data)
    {
        return Validator::make($data, [
            'old_password' => 'required',
            'password_confirmation' => 'required|min:8',
            'password' => 'required||min:8|confirmed',
            'mobile_no' => 'required'
            ]);
    }

    /**
     * Old password Validation
     */
    public function oldPasswordValidation($data)
    {
        $user = User::find($data['user_id']);

        if (Hash::check($data['old_password'], $user->password)) {

            $result= 1;

        }else {
            $result = 0;
        }

        return $result;
    }


    /**
     * Validation Response
     * @param $data
     * @return mixed
     */
    public function mapValidator($data)
    {
        return $this->errorResponse($data, 'Validation Error', 110001, 400);
    }

    /**
     * Iteration of profile output
     */
    public function profileIteration($output, $count)
    {
        $data = $this->userDetailsOutput($output, $count);

        return response()->json(['user_detail' => $data]);
    }


}
