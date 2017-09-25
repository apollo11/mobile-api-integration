<?php

namespace App\Http\Controllers\EmployeeProfile;

use App\EmployeeProfile;
use App\AdditionalInfo;
use App\Http\Traits\ProfileTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeProfileController extends Controller
{
    use ProfileTrait;

    public function  __construct()
    {


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $additional = new AdditionalInfo();

        $count = $additional->countPendingJobs($request->get('id'));

        $output = $additional->userInfo($request->get('id'));

        return $this->profileIteration($output, $count);
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
     * Iteration of profile output
     */
    public function profileIteration($output, $count)
    {
        $data = $this->userDetailsOutput($output, $count);

        return response()->json(['user_detail' => $data]);

    }

    /**
     * Response output for User Profile
     */
    public function output($output, $count)
    {
       $availability[] =  [
            'day' => null,
            'start_time' => null,
            'end_time' => null
        ];

        $data = [
            'id' => $output->id,
            'name' => $output->name,
            'mobile_no' => $output->mobile_no,
            'nric_no' => $output->nric_no,
            'email' => $output->email,
            'school' => $output->school,
            'points' => 10,
            'image_url' => null,
            'additional_info' => [
                'birthdate' => $output->date_of_birth,
                'nationality' => null,
                'religion' => null,
                'address' => null,
                'school_pass_expiry_date' => null,
                'emergency_contact' => [
                    'name' => null,
                    'contact_no' => null,
                    'relationship' => null,
                    'address' => null,
                ],
                'contact_method' => null,
                'criminal_record' => [
                    'has_record' => null,
                    'reason' => null,
                ],
                'medical_condition' => [
                    'has_medical_condition' => null,
                    'condition' => null
                ],
                'availabilities' => $availability,
                'language' => null,
            ],
            'created_at' => $output->created_at,
            'updated_at' => $output->updated_at,
            'employee_status' => $output->employee_status,
            'schedule_count' => $count,
            'money_earned' => 0,
            'completed_job_count' => 0
        ];

        return $data;
    }
}
