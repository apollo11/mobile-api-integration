<?php

namespace App\Http\Controllers\UserMgt;

use Validator;
use App\Employer;
use App\Permission;
use App\UserManagement;
use App\User;
use App\Mail\UserMgtMail;
use App\Http\Requests\UserMgt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class UserMgtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = new UserManagement();
        $users = $user->userMgtList();

        return view('usermgt.lists',['user' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = new Permission();
        $permissionValue = $permission->crud();
        $employer = User::where('role_id',1)->pluck('company_name', 'id');

        return view('usermgt.form',  compact('employer'), compact('permissionValue'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserMgt $request)
    {
        $data = $request->all();

        // print_r($data['employer']);
        // echo "</br></br>";
        // $string_array = serialize($data['employer']);
        // echo $string_array;
        // echo "</br></br>";
        // print_r(unserialize($string_array));

        $employer_string_array;
        if (isset($data['employer'])) {
            $employer_string_array = serialize($data['employer']);
        }
        else {
            $employer_string_array = null;
        }
        

        $lastId = User::create([
            'name' => $data['name'], //$request->input('name'),
            'email' => $data['email'] ,//$request->input('email'),
            'password' => bcrypt($data['password']),
            'role' => $data['role'], //$request->input('role'),
            'employer' => $employer_string_array,
            'mobile_no' => $data['mobile_no'], //$request->input('mobile_no'),
            'dashboard_permissions' =>  $data['dashboard'] ?? null,
            'employees_permissions' => $data['employees'] ?? null,
            'employers_permissions' => $data['employers'] ?? null,
            'payout_permissions' => $data['payout'] ?? null,
            'job_permissions' => $data['job'] ?? null,
            'reports_permissions' => $data['reports'] ?? null,
            'push_permissions' => $data['push'] ?? null,
            'recipient_permissions' =>  $data['recipient'] ?? null,
            'settings_permissions' => $data['settings'] ?? null,
            'role_id' => 0,
        ]);

        $this->saveEmployer($lastId->id, $data);
        $this->sendEmailToUser($data);

        return redirect()->back()->with('message', 'Adding new user successfully saved.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mgt = new UserManagement();
        $employer = new Employer();
        $details  = $mgt->user($id);

        return view('usermgt.details',
            [
              'details' => $details
            , 'dashboard' => $this->parseObject($details->dashboard_permissions)
            , 'employees' => $this->parseObject($details->employees_permissions)
            , 'employers' => $this->parseObject($details->payout_permissions)
            , 'job' => $this->parseObject($details->job_permissions)
            , 'reports' => $this->parseObject($details->reports_permissions)
            , 'push'=> $this->parseObject($details->push_permissions)
            , 'recipient' => $this->parseObject($details->recipient_permissions)
            , 'settings' => $this->parseObject($details->settings_permissions)
            , 'payout' => $this->parseObject($details->payout_permissions)
            , 'getEmployer' => $employer->getEmployersList($id)
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mgt = new UserManagement();
        $permission = new Permission();
        $permissionValue = $permission->crud();
        $details  = $mgt->user($id);

        $employer = User::where('role_id',1)->pluck('company_name', 'id');

        // print_r(unserialize($details->employer));
        // echo (unserialize($details->employer))[0];

        return view('usermgt.edit-form',['details' => $details
            , 'employer' =>  $employer
            , 'dashboard' => $this->parseObject($details->dashboard_permissions)
            , 'employees' => $this->parseObject($details->employees_permissions)
            , 'employers' => $this->parseObject($details->employers_permissions)
            , 'job' => $this->parseObject($details->job_permissions)
            , 'reports' => $this->parseObject($details->reports_permissions)
            , 'push'=> $this->parseObject($details->push_permissions)
            , 'recipient' => $this->parseObject($details->recipient_permissions)
            , 'settings' => $this->parseObject($details->settings_permissions)
            , 'payout' => $this->parseObject($details->payout_permissions)
            , 'getEmployer' => $this->getEmployer($id)
        ], compact('permissionValue'));
    }

    /**
     * @param $data
     * @return mixed
     */
    public function parseObject($data)
    {
        $parse = json_decode($data, true);

        return $parse;

    }

    /**
     * @param Request $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $employer = empty($data['employer']) ? false : true;


        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role' => 'required',
//             'employer' => 'required',
//            'dashboard' => 'required',
//            'employees' => 'required',
//            'employers' => 'required',
//            'payout' => 'required',
//            'job' => 'required',
//            'reports' => 'required',
//            'push' => 'required',
//            'recipient' => 'required',
//            'settings' => 'required'
        ]);

        if ($validator->fails()) {

            return redirect(route('mgt.edit', ['id' => $id]))
                ->withErrors($validator)
                ->withInput();
        } else {

            $employer_string_array;
            if (isset($data['employer'])) {
                $employer_string_array = serialize($data['employer']);
            }
            else {
                $employer_string_array = null;
            }

            $user = \App\User::find($id);
            $user->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => $data['role'],
                'employer' => $employer_string_array,
                'mobile_no' => $data['mobile_no'],
                'dashboard_permissions' => $data['dashboard'] ?? null,
                'employees_permissions' => $data['employees'] ?? null,
                'employers_permissions' => $data['employers'] ?? null,
                'payout_permissions' => $data['payout'] ?? null,
                'job_permissions' => $data['job'] ?? null,
                'reports_permissions' => $data['reports'] ?? null,
                'push_permissions' => $data['push'] ?? null,
                'recipient_permissions' => $data['recipient'] ?? null,
                'settings_permissions' => $data['settings'] ?? null,
                'role_id' => 0,
            ]);

            if ($employer == true) {

                $this->deleteEmployer($id);
                $this->saveEmployer($id, $data);

            }
        }
        return redirect()->back()->with('message', 'Updating details successful.');

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = new UserManagement();

        $user->deleteUserMgt($id);

        return redirect()->back()->with('message', 'Record deleted successful.');

    }

    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function multiDestroy(Request $request)
    {

        //return $request->all();
        $user = new UserManagement();

        $multi['multicheck'] = (array)$request->input('multicheck');

        $validator = Validator::make($multi, ['multicheck' => 'required']);
        if ($validator->fails()) {

            $result = redirect(route('mgt.list'))
                ->withErrors($validator)
                ->withInput();

        } else {

            $user->multiDelete($multi['multicheck']);

            $result = redirect()->back()->with('message', 'Record deleted successful.');
        }

        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function validator($data)
    {
        $validator = Validator::make($data, $this->rules());

        return $validator;

    }

    /**
     * Send Email
     */
    public function sendEmailToUser(array $data)
    {
        Mail::to($data['email'])->send( new UserMgtMail($data));

    }

    /**
     * @param $id
     * @param $data
     */
    public function saveEmployer($id, $data)
    {
        $user = \App\User::find($id);

        for($i = 0; $i < count($data['employer']); $i++) {
            $employer = $data['employer'];
            $employer_id = $id;

            $user->employer()->create([
                'name' => $employer[$i],
                'employer_id' => $employer_id
            ]);

        }
    }

    /**
     * Get employer
     */
    public function getEmployer($id)
    {
        $employer = new Employer();
        $result = $employer->getEmployersList($id);

        return $result;
    }

    /**
     * Delete User
     */
    public function deleteEmployer($userId)
    {
        $deleteRows = \App\Employer::where('user_id', $userId)->delete();

        return $deleteRows;
    }

}
