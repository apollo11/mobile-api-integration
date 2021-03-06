<?php

namespace App\Http\Controllers\EmployeeProfile;

use App\EmployeeProfile;
use App\AdditionalInfo;
use App\History;
use App\Http\Traits\ProfileTrait;
use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Validator;

class EmployeeProfileController extends Controller
{
    use ProfileTrait;
    use HttpResponse;

    public function __construct()
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
     * @param  \Illuminate\Http\Request $request
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
        $id = $request->get('id');
        $additional = new AdditionalInfo();
        $history = new History();

        $count = $additional->countPendingJobs($id);
        $complete = $history->countCompletedJobs($id);
        $money = $history->countEarnedJobs($id);

        $output = $additional->userInfo($id);

        return $this->profileIteration($output, $count, $complete, $money);
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
     * Iteration of profile output
     */
    public function profileIteration($output, $count, $complete, $money)
    {
        $data = $this->userDetailsOutput($output, $count);
        $data['completed_job_count'] = $complete;
        $data['money_earned'] = $money;

        return response()->json(['user_detail' => $data]);

    }

    /**
     * Response output for User Profile
     */
    public function output($output, $count, $complete)
    {
        $availability[] = [
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
            'completed_job_count' => $complete
        ];

        return $data;
    }


    /*
    * Update employee location
    */
    public function update_location(Request $request){
        $return_data = '';
        $error_code = 120001;
        
        $user_id = $request->get('user_id');
        $lat = $request->get('lat');
        $long = $request->get('long');

        $schedule_id = $request->get('schedule_id');

        $data = $request->all();
        // $user = \App\User::find($user_id);
        if(empty($user_id)  || !is_numeric($user_id) || empty($schedule_id)  || !is_numeric($schedule_id) ){
            $errors = array('User id or schedule id is empty');
            return $this->errorResponse($errors, 'Validation Error', $error_code, 400);
        }else{
            $schedule = \App\JobSchedule::find($schedule_id);
            if(empty($schedule) || $schedule->user_id!=$user_id){
                $errors = array('Job schedule not found');
                return $this->errorResponse($errors, 'Validation Error', $error_code, 400);
            }

            $validator = $this->updateRules($data);
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $return_data = $this->errorResponse($errors, 'Validation Error', $error_code, 400);
            } else {
                $schedule->employee_current_lat = $lat;
                $schedule->employee_current_long = $long;
                $schedule->save();

                $return_data = $this->ValidUseSuccessResp(200,true);
            }
        }
        return $return_data;
    }

    public function updateRules(array $data)
    {
        $validations = [
            'lat' => 'required|numeric|is_valid_lat',
            'long' => 'required|numeric|is_valid_long',
        ];

        return Validator::make($data, $validations);
    }
}
