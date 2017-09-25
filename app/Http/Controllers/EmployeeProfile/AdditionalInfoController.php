<?php

namespace App\Http\Controllers\EmployeeProfile;

use Validator;
use App\Http\Traits\ProfileTrait;
use App\AdditionalInfo;
use Illuminate\Http\Request;
use App\Http\Traits\HttpResponse;
use App\Http\Controllers\Controller;

class AdditionalInfoController extends Controller
{
    use HttpResponse;
    use ProfileTrait;

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = $this->rules($data);
        $errorMsg = $validator->errors()->all();

        if ($validator->fails()) {

            $result = $this->mapValidator($errorMsg);

        } else {

            $isupdated = $this->isUserExist($data['user_id']);

            if($isupdated != null) {

                $this->updateData($data);

            } else {

                $this->saveData($data);
            }

            $result = $output = $this->show($data['user_id']);
        }

        return $result;
    }

    /**
     * Saving additional info
     */
    public function saveData(array $data)
    {
        $user = \App\User::find($data['user_id']);

        $user->additionalInfo()->create([
            'name' => $data['name'],
            'gender' => $data['gender'],
            'birthdate' => $data['birthdate'],
            'religion' => $data['religion'],
            'address' => $data['address'],
            'email' => $data['email'],
            'contact_no' => $data['contact_no'],
            'school' => $data['school'],
            'school_pass_expiry_date' => $data['school_pass_expiry_date'],
            'front_ic_path' => $data['front_ic_path'],
            'back_ic_path' => $data['back_ic_path'],
            'emergency_name' => $data['emergency_name'],
            'emergency_contact_no' => $data['emergency_contact_no'],
            'emergency_relationship' => $data['emergency_relationship'],
            'emergency_address' => $data['emergency_address'],
            'contact_method' => $data['contact_method'],
            'criminal_record' => $data['criminal_record'],
            'medication' => $data['medication']
        ]);
    }

    public function updateData(array $data)
    {
        $update = \App\AdditionalInfo::where('user_id', $data['user_id'])
            ->update([
                    'name' => $data['name'],
                    'gender' => $data['gender'],
                    'birthdate' => $data['birthdate'],
                    'religion' => $data['religion'],
                    'address' => $data['address'],
                    'email' => $data['email'],
                    'contact_no' => $data['contact_no'],
                    'school' => $data['school'],
                    'school_pass_expiry_date' => $data['school_pass_expiry_date'],
                    'front_ic_path' => $data['front_ic_path'],
                    'back_ic_path' => $data['back_ic_path'],
                    'emergency_name' => $data['emergency_name'],
                    'emergency_contact_no' => $data['emergency_contact_no'],
                    'emergency_relationship' => $data['emergency_relationship'],
                    'emergency_address' => $data['emergency_address'],
                    'contact_method' => $data['contact_method'],
                    'criminal_record' => $data['criminal_record'],
                    'medication' => $data['medication']
                ]);

        return $update;

    }

    /**
     * @param $id
     * @return $this
     */
    public function isUserExist($id)
    {
        $isUpdated = new AdditionalInfo();

        return response()->json($isUpdated->isUserExist($id));
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
     * Rules in validation
     */
    public function rules(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string',
            'gender' => 'required|string',
            'birthdate' => 'date|string',
            'religion' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'contact_no' => 'required|string',
            'school' => 'required',
            'school_pass_expiry_date' => 'required|date',
            'front_ic_path' => 'required|string',
            'back_ic_path' => 'required|string',
            'emergency_name' => 'required|string',
            'emergency_contact_no' => 'required|string',
            'emergency_relationship' => 'required|string',
            'emergency_address' => 'required|string',
            'contact_method' => 'required|string',
            'criminal_record' => 'required| string',
            'medication' => 'required|string',
        ]);
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
