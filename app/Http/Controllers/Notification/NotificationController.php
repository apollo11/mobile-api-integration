<?php

namespace App\Http\Controllers\Notification;

use Validator;
use App\Settings;
use App\CancelJob;
use App\Notification;
use Illuminate\Http\Request;
use App\Http\Traits\PushNotiftrait;
use App\Http\Traits\HttpResponse;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    use HttpResponse;
    use PushNotiftrait;

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
        $userId = $data['user_id'];
        $jobId = $data['job_id'];

        $validate =  Validator::make($data, ['job_id' => 'required', 'user_id' => 'required']);
        $error = $validate->errors()->all();

        if ($validate->fails()) {

            $result = $this->mapValidator($error, 110001);

        } else {

            $this->decductRejectNotif($userId);
            $this->addtoSchedRejectedJob($jobId, $userId);

            $result = $this->ValidUseSuccessResp(200, true);
        }

        return $result;

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param Request $request
     * @return mixed
     */
    public function addNotification(Request $request)
    {
        $data = $request->all();
        $validate = $this->validator($data);
        $error = $validate->errors()->all();

        if ($validate->fails()) {

            $result = $this->mapValidator($error, 110001);

        } else {

            $this->pushNotif($data);
            $this->saveNotif($data);

            $result = $this->ValidUseSuccessResp(200, true);
        }

        return $result;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function rejectJob(Request $request)
    {
        $jobId = $request->input('job_id');
        $find = \App\JobSchedule::where('job_id', $jobId)->first();


        if (is_null($find)) {

            $result = $this->mapValidator(['Job is not available in schedule'], 110001);

        } else {

            \App\JobSchedule::where('job_id', $jobId)
                ->update(['job_status' => 'available', 'is_assigned' => false]);

            $result = $this->ValidUseSuccessResp(200, true);

        }

        return $result;

    }

    /**
     * Mark as all read by user
     * @param Request $request
     * @return mixed
     */
    public function markAsAllRead(Request $request)
    {
        $userId = $request->input('user_id');
        $find = \App\Notification::where('user_id', $userId)->first();

        if (is_null($find)) {

            $result = $this->mapValidator(['Notification is not available'], 110001);

        } else {

            \App\Notification::where('user_id', $userId)
                ->update(['is_read' => true]);

            $result = $this->ValidUseSuccessResp(200, true);

        }

        return $result;

    }

    /**
     * Mark as read one by one
     * @param Request $request
     * @return mixed
     */
    public function markAsRead(Request $request)
    {
        $userId = $request->input('user_id');
        $id = $request->input('id');

        $find = \App\Notification::where('user_id', $userId)
            ->where('id', $id)
            ->first();

        if (is_null($find)) {

            $result = $this->mapValidator(['Notification is not available'], 110001);

        } else {

            \App\Notification::where('user_id', $userId)
                ->where('id', $id)
                ->update(['is_read' => true]);

            $result = $this->ValidUseSuccessResp(200, true);

        }

        return $result;

    }

    /**
     * @param array $data
     * @return mixed|static
     */
    public function saveNotif(array $data)
    {
        $save = \App\User::find($data['user_id']);

        $save->userNotification()->create([
            'job_id' => $data['job_id'],
            'type' => $data['type'],
            'title' => $data['title'],
            'message' => $data['message']
        ]);

        return $save;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function saveDeviceToken(Request $request)
    {

        if (!empty($request->input('device_token'))) {

            $save = \App\User::find($request->input('user_id'));
            $save->deviceToken()->firstOrCreate([
                'device_token' => $request->input('device_token')
            ]);

            $result = $this->ValidUseSuccessResp(200, true);

        } else {

             $result = $this->mapValidator(['Something went wrong'], 110001);

        }
        return $result;
    }

    /**
     * Delete Device Token for IOS
     */
    public function deleteToken(Request $request)
    {
        $token = $request->input('device_token');
        $userId = $request->input('user_id');
        $find = \App\DeviceToken::where('device_token', $token)
            ->where('user_id', $userId)->first();

        if (is_null($find)) {

            $result = $this->mapValidator(['Token unavailable or invalid'], 110011);

        } else {

            \App\DeviceToken::where('user_id', $userId)
                ->where('device_token', $token)
                ->delete();

            $result = $this->ValidUseSuccessResp(200, true);

        }

        return $result;

    }

    /**
     * Delete Notification
     */
    public function deleteNotfif(Request $request)
    {
        $find = \App\Notification::find($request->input('id'));

        if(is_null($find)) {

            $result = $this->mapValidator(['Something went wrong'], 10001);

        } else {

            \App\Notification::find($request->input('id'))
                ->delete();

            $result = $this->ValidUseSuccessResp(200, true);
        }

        return $result;

    }

    /**
     * Multiple Delete Notification
     */
    public function deleteMultipleNotfif(Request $request)
    {
        $userid = $request->input('user_id');

        $find = \App\Notification::where('user_id', $userid);

        if(is_null($find)) {

            $result = $this->mapValidator(['Something went wrong'], 10001);

        } else {

            \App\Notification::where('user_id', $userid)
                ->delete();

            $result = $this->ValidUseSuccessResp(200, true);
        }

        return $result;

    }


    /**
     * Notification list by user
     */
    public function notifList(Request $request)
    {
        $notif = new Notification();
        $userId = $request->get('user_id');
        $param = [
            'last_notification_id' => $request->get('last_notification_id'),
            'limit' => empty($request->get('limit')) ? 20 : $request->get('limit')
        ];

        $notifList = $notif->notificationByUser($userId, $param);
        $countNotif = $notif->countNotifByUser($userId);

        return $this->notifRespponse($notifList, $countNotif);
    }

    /**
     * Validation Rules
     *
     * @return array
     */
    public function rules()
    {
        $validate = [
            'type' => 'required',
            'title' => 'required',
            'message' => 'required'
        ];

        return $validate;

    }

    /**
     * Validation maker
     *
     * @param $data
     * @return mixed
     */
    public function validator($data)
    {
        $validator = Validator::make($data, $this->rules());

        return $validator;
    }

    /**
     * Map Validation
     * @param $data
     * @return mixed
     */
    public function mapValidator($data, $errorCode)
    {
        return $this->errorResponse($data, 'Validation Error', $errorCode, 400);
    }


    /**
     * @param $date
     * @return false|string
     */
    public function dateFormat($date)
    {
        $format = date_create($date, timezone_open('UTC'));
        $return = date_format($format, 'Y-m-d H:i:sO');

        return $return;
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function decductRejectNotif($userId)
    {
        $cancel = new CancelJob();
        $settingsObj = new Settings();
        $set = $settingsObj->allSettings();
        $points =  abs($set->point_reject_job);

        $result =$cancel->deductionsPoints($userId, $points);

        return $result;

    }

    /**
     * @param $jobId
     * @param $userId
     */
    public function addtoSchedRejectedJob($jobId, $userId)
    {
        $user = \App\User::find($userId);
        $user->jobSchedule()->updateOrCreate(['name' => null, 'job_id' => $jobId, 'job_status' => 'rejected']);

    }

    /**
     * @param $data
     * @param $count
     * @return \Illuminate\Http\JsonResponse
     */
    public function notifRespponse($data, $count)
    {
        foreach ($data as $output)
        {
            $assigned = is_null($output->schedule_status) ? 'available' : $output->schedule_status;
            $details[] = [
                'id' => $output->id,
                'type' => $output->type,
                'created_at' => $this->dateFormat($output->created_at),
                'updated_at' => $this->dateFormat($output->updated_at),
               'schedule_id' => $output->schedule_id,
                'job' => [
                    'id' => $output->jobid,
                    'job_title' => $output->job_title,
                    'employer' => [
                        'id' => $output->employer_id,
                        'image_url' => $output->profile_image_path,
                        'name' => $output->company_name,
                        'description' => $output->company_description,
                        'hourly_rate' => $output->employer_rate
                    ],
                    'industry' => [
                        'id' => $output->industry_id,
                        'name' => $output->industry
                    ],
                    'location' => [
                        'id' => $output->jobid,
                        'name' => is_null($output->geolocation_address) ? '10 Bayfront Ave, Singapore 018956' : $output->geolocation_address,
                        'latitude' => 1.2836402,
                        'longitude' => 103.8603731,
                    ],
                    'working_details' => [
                        'check_in' =>[
                            'datetime' => $this->dateFormat($output->checkin_datetime),
                            'location' => $output->checkin_location
                        ],
                        'check_out' => [
                            'datetime' => $this->dateFormat($output->checkout_datetime),
                            'location' => $output->checkout_location
                        ],
                        'working_time_in_minutes' => $output->working_hours,
                        'job_salary' => round($output->job_salary,'2'),
                        'processed_date' => $output->process_date,
                        'payment_method' => $output->payment_methods
                    ],
                    'created_date' => $this->dateFormat($output->created_at),
                    'start_date' => $this->dateFormat($output->start_date),
                    'end_date' => $this->dateFormat($output->end_date),
                    'contact_person' => $output->contact_person,
                    'contact_no' => $output->contact_no,
                    'rate' => $output->rate,
                    'thumbnail_url' => $output->job_image_path,
                    'nationality' => ucfirst($output->nationality),
                    'description' => $output->description,
                    'min_age' => $output->min_age,
                    'max_age' => $output->max_age,
                    'role' => $output->role,
                    'remarks' => $output->notes,
                    'language' => $output->language,
                    'gender' => $output->gender,
                    'job_requirements' => $output->job_requirements,
                    'status' => $assigned,
                    'payment_status' => $output->payment_status,
                    'is_assigned' => is_null($output->is_assigned) ? 0 :$output->is_assigned,
                    'cancellation_fee' => 25,
                    'cancellation_charge' => 0
                ]
            ];
        }
        $dataUndefined = !empty($details) ? $details : [];

        return response()->json(['notifications' => $dataUndefined, 'unread_count' => $count]);
    }

}
