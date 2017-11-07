<?php

namespace App\Http\Controllers\Payout;

use App\Payout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PayoutController extends Controller
{
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

        return view('payout.lists', ['list' => $output]);
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
}
