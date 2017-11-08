<?php

namespace App\Http\Controllers\RecipientGroup;

use Validator;
use App\User;
use App\RecipientGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecipientGroupController extends Controller
{
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
        $recipientObj = new RecipientGroup();
        $param = null;

        return view('Recipient.form',
            [
                'agent' => $recipientObj->agentList(),
                'employee' => $recipientObj->employeeList($param)
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userObj = new User();
        $data = $request->all();
        $validator = Validator::make($data, ['employee' => 'required', 'group_name' => 'required']);

        if ($validator->fails()) {

            $test = redirect(route('recipient.create'))
                ->withErrors($validator)
                ->withInput();
        } else {

            $result = User::find($data);
            $test = $result['id'];
            //$result = $data;
        }

        return $test;
//        return $data;



       // $userObj->recipient()->attach()
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

    public function advanceSearch(Request $request)
    {
        $data = $request->all();
        $recipientObj = new RecipientGroup();


        return view('Recipient.form',
            [
                'agent' => $recipientObj->agentList(),
                'employee' => $recipientObj->employeeList($data)
            ]);

    }



}
