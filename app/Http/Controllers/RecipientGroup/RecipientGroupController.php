<?php

namespace App\Http\Controllers\RecipientGroup;

use Validator;
use App\RecipientGroup;
use Illuminate\Support\Facades\Auth;
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
        $recipient = new RecipientGroup();
        return view('Recipient.lists', ['list' => $recipient->recipientList()]);
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
                'employee' => $recipientObj->employeeList($param),
                'employer' => $recipientObj->employerList()
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
        $data = $request->all();

        $validator = Validator::make($data, ['employee' => 'required', 'group_name' => 'required|unique:recipient_groups']);

        if ($validator->fails()) {

            $result = redirect(route('recipient.create'))
                ->withErrors($validator)
                ->withInput();
        } else {
            $this->saveGroup($data);
            $result = redirect(route('recipient.lists'));
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipient =  new RecipientGroup();
        $output =  $recipient->groupDetails($id);

       return view('Recipient.details', ['details' => $output]);
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
    public function destroy($id, $param = null)
    {
        $recipient = new RecipientGroup();
        $recipient->deleteRecipientGroup($id);

        return redirect()->back()->with('message', 'Record deleted successful.');

    }

    public function advanceSearch(Request $request)
    {
        $data = $request->all();
        $recipientObj = new RecipientGroup();

        return view('Recipient.form',
            [
                'agent' => $recipientObj->agentList(),
                'employee' => $recipientObj->employeeList($data),
                'employer' => $recipientObj->employerList()
            ]);

    }

    /**
     * @param array $data
     */
    public function saveGroup(array $data)
    {
        $recipient = \App\User::where('id','=',$data['employee'])->first();

        $insertedId = $recipient->recipient()->create(['group_name' => $data['group_name'], 'email' => Auth::user()->email]);
        $insertedId->id;
        $this->saveUserRecipientGroup($insertedId->id, $data['employee']);

        return Auth::user()->email;
    }

    /**
     * Save User Recipient Group
     */
    public function saveUserRecipientGroup($id, $data)
    {
        $recipientUser = \App\RecipientGroup::find($id);

        for($i = 0; $i < count($data); $i++) {
            $employee = $data;
            $recipientUser->userRecipientGroup()->firstOrCreate([
                'user_id' => $employee[$i]
            ]);
        }
    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function multiDestroy(Request $request)
    {

        //return $request->all();
        $user = new RecipientGroup();

        $multi['multicheck'] = (array)$request->input('multicheck');

        $validator = Validator::make($multi, ['multicheck' => 'required']);
        if ($validator->fails()) {

            $result = redirect(route('recipient.lists'))
                ->withErrors($validator)
                ->withInput();

        } else {

            $user->multiDelete($multi['multicheck']);

            $result = redirect()->back()->with('message', 'Record deleted successful.');
        }

        return $result;

    }

}
