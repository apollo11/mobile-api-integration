<?php

namespace App\Http\Controllers\EmployeeProfile;

use App\AdditionalInfo;
use App\History;
use Validator;
use App\Http\Traits\ProfileTrait;
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
        $id = $data['user_id'] ?? '';

        $validator = $this->rules($data);
        $errorMsg = $validator->errors()->all();

        if ($validator->fails()) {

            $result = $this->mapValidator($errorMsg);

        } else {

            $file = $this->uploadingFile($request);
            $merge = array_merge($data, $file);

            $isupdated = $this->isUserExist($id);

            if ($isupdated != null) {

                $this->updateData($merge);
                $result =  $this->show($id);

            } else {
                $this->saveData($merge);
                $result =  $this->show($id);
            }
        }

        return $result;
    }

    /**
     * Saving additional info
     */
    public function saveData(array $data)
    {
        $criminal = !empty($data['criminal_record']) ? $data['criminal_record'] : '';
        $medical = !empty($data['medication']) ? $data['medication'] : '';
        $school = !empty($data['school']) ? $data['school'] : '';
        $schoolExpiry = !empty($data['school_pass_expiry_date']) ? $data['school_pass_expiry_date'] : '1970-01-01';

        $user = \App\User::find($data['user_id']);

        $user->additionalInfo()->create([
            'gender' => $data['gender'],
            'birthdate' => $data['birthdate'],
            'religion' => $data['religion'],
            'address' => $data['address'],
            'email' => $data['email'],
            'school' => $school,
            'school_pass_expiry_date' => $schoolExpiry,
            'front_ic_path' => $data['front_ic_path'],
            'back_ic_path' => $data['back_ic_path'],
            'emergency_name' => $data['emergency_name'],
            'emergency_contact_no' => $data['emergency_contact_no'],
            'emergency_relationship' => $data['emergency_relationship'],
            'emergency_address' => $data['emergency_address'],
            'signature_file_path' => $data['signature_file_path'],
            'contact_method' => $data['contact_method'],
            'criminal_record' => $criminal,
            'medication' => $medical,
            'bank_statement' => $data['bank_account'],
            'language' => $data['language'],
            'is_uploaded' => 1
        ]);
    }

    public function updateData(array $data)
    {
        $criminal = !empty($data['criminal_record']) ? $data['criminal_record'] : '';
        $medical = !empty($data['medication']) ? $data['medication'] : '';
        $school = !empty($data['school']) ? $data['school'] : '';
        $schoolExpiry = !empty($data['school_pass_expiry_date']) ? $data['school_pass_expiry_date'] : '1970-01-01';


        $update = \App\AdditionalInfo::where('user_id', $data['user_id'])
            ->update([
                    'gender' => $data['gender'],
                    'birthdate' => $data['birthdate'],
                    'religion' => $data['religion'],
                    'address' => $data['address'],
                    'email' => $data['email'],
                    'school' => $school,
                    'school_pass_expiry_date' => $schoolExpiry,
                    'front_ic_path' => $data['front_ic_path'],
                    'back_ic_path' => $data['back_ic_path'],
                    'emergency_name' => $data['emergency_name'],
                    'emergency_contact_no' => $data['emergency_contact_no'],
                    'emergency_relationship' => $data['emergency_relationship'],
                    'emergency_address' => $data['emergency_address'],
                    'signature_file_path' => $data['signature_file_path'],
                    'contact_method' => $data['contact_method'],
                    'criminal_record' => $criminal,
                    'medication' => $medical,
                    'bank_statement' => $data['bank_account'],
                    'language' => $data['language'],
                    'is_uploaded' => 1
            ]);

        return $update;
    }

    /**
     * Upload file
     */
    function uploadingFile(Request $request)
    {
        if ($request->hasFile('front_ic_path')) {

            $file['front_ic_path'] = $request->file('front_ic_path')->store('additional');

        }
        if ($request->hasFile('back_ic_path')) {

            $file['back_ic_path'] = $request->file('back_ic_path')->store('additional');

        }
        if ($request->hasFile('signature_file_path')) {

            $file['signature_file_path'] = $request->file('signature_file_path')->store('additional');
        }

        return $file;
    }

    /**
     * @param $id
     * @return $this
     */
    public function isUserExist($id)
    {
        $isUpdated = new AdditionalInfo();

        return $isUpdated->isUserExist($id);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $info = new AdditionalInfo();
        $history = new History();

        $complete = $history->countCompletedJobs($id);
        $money = $history->countEarnedJobs($id);
        $count = $info->countPendingJobs($id);
        $add = $info->userInfo($id);

        return $this->profileIteration($add, $count, $complete, $money);
    }

    /**
     * Show the form for editing the specified resource.
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
            'bank_account' => 'required|string',
            'language' => 'required|string',
            'signature_file_path' => 'required'
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
    public function profileIteration($output, $count, $complete, $money)
    {
        $data = $this->userDetailsOutput($output, $count);
        $data['completed_job_count'] = $complete;
        $data['money_earned'] = $money;

        return response()->json(['user_detail' => $data]);
    }


}
