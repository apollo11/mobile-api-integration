<?php

namespace App\Http\Controllers\Payout;

use Validator;
use App\Payout;
use App\Http\Traits\NotificationTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayoutController extends Controller
{
    use NotificationTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $param = [
            'payment_status' => $request->get('payment-status')
        ];

        $payoutObj = new Payout();
        $output = $payoutObj->payout($param);

        return view('Payout.lists', ['list' => $output]);
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
        $payoutObj = new Payout();
        $details = $payoutObj->payoutDetails($id);
        return view('Payout.edit-form',['details' => $details]);
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
        $payoutObj = new Payout();
        $data = $request->all();

        $validator = Validator::make($data, ['working_hours' => 'required|numeric']);

        if($validator->fails()) {

            $result = redirect(route('payout.edit',['id' => $id]))
                ->withErrors($validator)
                ->withInput();
        } else {
            $payoutObj->updateWorkingHours($id, $data['working_hours']);
            $result = redirect(route('payout.lists',['id' => $id]));
        }

        return $result;

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
     * Approved Job Schedule
     * @param $id
     * @return mixed
     */
    public function approvedJob($id, $userId)
    {
        $payoutObj = new Payout();

        $payoutObj->approveJob($id, $userId);

        return back();

    }


    /**
     * Job has been processed
     * @param $id
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processedJob($id, $userId)
    {
        $payoutObj = new Payout();
        $payoutObj->processedJob($id, $userId);

        $this->pushProcessedNotif($userId);
        $this->saveProcessedNotif($id, (array)$userId, constant('PAYMENT_INITIATED'));

        return back();
    }

    /**
     * Change status to accepted
     * @param $id
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptedJob($id, $userId)
    {
        $payoutObj = new Payout();
        $payoutObj->changeStatustoAccepted($id, $userId);

        return back();
    }



    /**
     * Rejecting job
     * @param $id
     * @param $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectJob($id, $userId)
    {
        $payoutObj = new Payout();
        $payoutObj->rejectJob($id, $userId);

        return back();
    }

    public function multiProcessed(Request $request)
    {
        $payoutObj = new Payout();
        $multi['multicheck'] = (array) $request->input('multicheck');

        $validator = Validator::make($multi, ['multicheck' => 'required']);
        if($validator->fails()) {
            $result = redirect(route('payout.lists'))
                ->withErrors($validator)
                ->withInput();

        } else {
            $payoutObj->multipleProcessed($multi['multicheck']);

            $result = back();
        }

        return $result;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function pushProcessedNotif($id)
    {
        $userId[] = $id;
        $token = $this->parsingToken($userId);
        $result = $this->paymentProcessed($token);

        return $result;
    }

    /**
     * @param $jobId
     * @param $userId
     * @param $type
     */
    public function saveProcessedNotif($jobId, $userId, $type)
    {
        $user = $userId;

        foreach ($user as $key) {
            $save = \App\User::find($key);
            $save->userNotification()->updateOrCreate([
                'type' => $type,
                'job_id' => $jobId
            ]);
        }

    }
}
