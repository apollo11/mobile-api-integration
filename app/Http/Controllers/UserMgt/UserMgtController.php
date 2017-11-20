<?php

namespace App\Http\Controllers\UserMgt;

use Validator;
use App\Permission;
use App\User;
use App\Http\Requests\UserMgt;
use Illuminate\Http\Request;
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
        $user = new User();
        $you = $user->testYou();
        return view('usermgt.lists',['test' => $you]);
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
        $data = request()->all();

        User::create([
            'name' => $data['name'], //$request->input('name'),
            'email' => $data['email'] ,//$request->input('email'),
            'password' => bcrypt($data['password']),
            'role' => $data['role'], //$request->input('role'),
            'employer' => $data['employer'],
            'mobile_no' => $data['mobile_no'], //$request->input('mobile_no'),
            'dashboard_permissions' =>  $data['dashboard'],
            'employees_permissions' => $data['employees'],
            'employers_permissions' => $data['employers'],
            'payout_permissions' => $data['payout'],
            'job_permissions' => $data['job'],
            'reports_permissions' => $data['reports'],
            'push_permissions' => $data['push'],
            'recipient_permissions' =>  $data['recipient'],
            'settings_permissions' => $data['settings'],
            'role_id' => 0,
        ]);

        return redirect()->back()->with('message', 'Updated successfully.');
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
     * @param $data
     * @return mixed
     */
    public function validator($data)
    {
        $validator = Validator::make($data, $this->rules());

        return $validator;

    }

}
