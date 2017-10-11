<?php

namespace App\Http\Controllers\Notification;

use Validator;
use App\User;
use App\DeviceToken;
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
        //
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

            $result = $this->mapValidator($error);

        } else {

            $this->pushNotif($data);
            $this->saveDeviceToken($data);
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

            $result = $this->mapValidator(['Job is not available in schedule']);

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

            $result = $this->mapValidator(['Notification is not available']);

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

            $result = $this->mapValidator(['Notification is not available']);

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
     * @param array $data
     * @return mixed|static
     */
    public function saveDeviceToken(array $data)
    {
        if (!empty($data['registration_ids'])) {

            $save = \App\User::find($data['user_id']);
            $save->deviceToken()->create([
                'device_token' => $data['registration_ids']
            ]);

            return $save;
        }
    }

    /**
     * Notification list by user
     */
    public function notifList(Request $request)
    {
        $userId = $request->get('user_id');
        $notif = new Notification();

        $notifList = $notif->notificationByUser($userId);

        return response()->json(['notifications' => $notifList]);
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
    public function mapValidator($data)
    {
        return $this->errorResponse($data, 'Validation Error', 110001, 400);
    }

}
