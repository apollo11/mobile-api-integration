<?php

namespace App\Http\Controllers\Employer;

use Validator;
use App\Employer;
use App\User;
use App\Industry;
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

        return view('employer.lists', ['employers' => $employers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $industry = $this->industryList();

        return view('employer.form', ['industry' => $industry]);
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

        $validator = $this->rules($data);

        if($validator->fails()) {

            return redirect('employer/create')
                ->withErrors($validator)
                ->withInput();

        } else {

            $companyLogo['company_logo'] = $request->file('company_logo')->store('avatars');
            $merge = array_merge($data, $companyLogo);

            $this->saveData($merge);

            return redirect('employer/lists');
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
        $employer->password = bcrypt($data['password']);
        $employer->contact_person = $data['contact_person'];
        $employer->rate = $data['hourly_rate'];
        $employer->profile_image_path = $data['company_logo'];
        $employer->industry = $data['industry'];

        $employer->save();
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
     * 0 Pending
     * 1 Approved
     * 2 Upload
     * 3 Reject
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id=null , $param=null)
    {
        $employer = new Employer();
        $submit = empty($request->input('multiple')) ? $param : $request->input('multiple');
        $multi = is_null($id) ? $request->input('multicheck') : (array) $id;
        switch ($submit) {
            case 'Approve':
                $employer->multiUpdateApprove($multi);
                break;
            case 'Delete':
                $employer->multiDelete($multi);
                break;
            case 'Reject':
                $employer->multiUpdateReject($multi);
                break;
        }

        return back();

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

    /**
     * List of available industries
     */
    public function industryList()
    {
        $industry = new Industry();

        $output = $industry::all();

        return $output;

    }


}
