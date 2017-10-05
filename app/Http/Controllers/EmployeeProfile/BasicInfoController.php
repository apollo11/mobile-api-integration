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
        $availability = [
            'day' =>  $request->get('days'),
            'start_time' =>  $request->get('start_times'),
            'end_time' => $request->get('end_times')
        ];

        $data = $request->all(); //Http request

        $file = !$request->file('profile_photo') ? null : $request->file('profile_photo');

        $value = [
            'old_password' => !empty($data['old_password']) ? $data['old_password'] : null,
            'password' => !empty($data['password']) ? $data['password'] : null,
            'user_id' => $data['user_id'],
            'mobile_no' => !empty($data['mobile_no']) ? $data['mobile_no'] : null,
            'profile_photo' => $file,
        ];

//        if ($oldPasswd == 0) {
//
//            $result = $this->mapValidator(['The specified password does not match the database password']);
//
//        }
//        $oldPasswd = $this->oldPasswordValidation($value); // Validation of password


        $id = $data['user_id'];

        $validator = $this->rules($data);
        $errorMsg = $validator->errors()->all();

        if ($validator->fails()) {

            $result = $this->mapValidator($errorMsg);

        } else {

            $file = $this->uploadingFile($request);
            $merge = array_merge($value, $file);

            $this->updateMobileNo($merge);

            $this->storeAvailability($availability, $id);
            $result = $this->show($id);
        }

        return $result;
    }

    /**
     * Updating Mobile and Password
     */
    public function updateMobilePassword(array $data)
    {
        $update = \App\User::find($data['user_id'])
            ->update([
                'password'=> bcrypt($data['password']),
                'mobile_no' => $data['mobile_no'],
                'profile_image_path' => $data['profile_photo']
            ]);

        return $update;

    }

    /**
     * Updating Mobile Number
     */
    public function updateMobileNo(array $data)
    {
        $update = \App\User::find($data['user_id']);

        //return $update;

        if ($data['mobile_no'] != null) {

            $update->update([
                'mobile_no' => $data['mobile_no']
            ]);
        }

        if ($data['profile_photo'] != null) {
            $update->update([
                'profile_image_path' => $data['profile_photo']
            ]);
        }

        if ($data['password'] != null) {
            $update->update([
                'password' => bcrypt($data['password'])
            ]);
        }

        if ($data['mobile_no'] != null && $data['profile_photo'] != null) {
            $update->update([
                'mobile_no' => $data['mobile_no'],
                'profile_image_path' => $data['profile_photo']
            ]);
        }

        if (!empty($data['profile_photo']) && !empty($data['password'])) {
            $update->update([
                'profile_image_path' => $data['profile_photo'],
                'password' => bcrypt($data['password'])
            ]);

        }

        if (!empty($data['mobile_no']) && !empty($data['password'])) {
            $update->update([
                'mobile_no' => $data['mobile_no'],
                'password' => bcrypt($data['password'])
            ]);
        }

        if (!empty($data['mobile_no']) && !empty($data['password']) && !empty($data['profile_photo'])) {
            $update->update([
                'mobile_no' => $data['mobile_no'],
                'password' => bcrypt($data['password']),
                'profile_image_path' => $data['profile_photo']
            ]);
        }
    }

    /**
     * Availability
     */
    public function storeAvailability($data, $id)
    {
        $this->deleteAvailabilities($id); // Deleting availabilities and adding new again

        $user = \App\User::find($id);

        for($i = 0; $i < count($data['day']); $i++) {
            $days = $data['day'];
            $startTimes = $data['start_time'];
            $endTimes = $data['end_time'];

            $user->availability()->create([
                'day' => $days[$i],
                'start_time' => $startTimes[$i],
                'end_time' => $endTimes[$i]
            ]);

        }
    }

    /**
     * Delete User
     */
    public function deleteAvailabilities($userId)
    {
        $deleteRows = \App\Availability::where('user_id', $userId)->delete();

        return $deleteRows;
    }


    /**
     * Upload file
     */
    function uploadingFile(Request $request)
    {
        if ($request->hasFile('profile_photo')) {

            $file['profile_photo'] = $request->file('profile_photo')->store('avatars');
        }

        return !empty($file) ? $file : [];
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
            'old_password' => 'nullable',
            'password_confirmation' => 'nullable',
            'password' => 'min:8|confirmed',
            'mobile_no' => 'nullable'
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
