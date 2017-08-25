<?php

namespace App\Http\Controllers\Employer;

use Validator;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployerController extends Controller
{
    /**
     * @var string
     * Redirect when successful employer sign up.
     */
    protected $redirectTo = '/employer/lists';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employers = $this->userList();

        return view('dashboard.employer', ['employers' => $employers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('employer.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $companyLogo['company_logo'] = $request->file('company_logo')->store('avatars');
        $data = array_merge($request->all(), $companyLogo);
        //return $data;
        $validator = $this->rules($data);

        if($validator->fails()) {

            return redirect('employer/create')
                ->withErrors($validator)
                ->withInput();
        } else {

            return $this->saveData($data);
        }
    }

    /**
     * Saving employer information
     * @param array $data
     */
    public function saveData(array $data)
    {
        $employer = new User();
        $employer->role_id = 1;
        $employer->role = 'employer';
        $employer->name = 'None';
        $employer->company_name = $data['company_name'];
        $employer->email = $data['email'];
        $employer->company_description = $data['company_description'];
        $employer->business_manager = $data['business_manager'];
        $employer->password = $data['password'];
        $employer->contact_person = $data['contact_person'];
        $employer->rate = $data['hourly_rate'];
        $employer->profile_image_path = $data['company_logo'];
        $employer->industry = $data['industry'];

        $employer->save();
        return redirect('employer/list');
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
     * Employer information
     */
    public function userList()
    {
        $user = new User();
        $employers = $user::where('role_id', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return $employers;

    }

    /**
     * validation Rules
     */
    public function rules(array $data)
    {
        return Validator::make($data, [
            'company_logo' => 'required',
            'company_name' => 'required|string',
            'email' => 'email|required|string|email|max:255|unique:users',
            'business_manager' => 'required|string',
            'contact_person' => 'required|string',
            'password' => 'required|alpha_dash',
            'hourly_rate' => 'required|digits:1',
            'industry' => 'required|string'
        ]);

    }
}
