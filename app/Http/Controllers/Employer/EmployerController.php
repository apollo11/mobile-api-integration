<?php

namespace App\Http\Controllers\Employer;

use Validator;
use App\Employer;
use App\User;
use App\Industry;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $employer = new Employer();

        $list = $employer->employerList();

        foreach ($list as $value)
        {
            $countPosted = $employer->postedJobCounts($value->id);
            $applied = $employer->candidates($value->id);

            $data[] = [
                'id' => $value->id,
                'business_manager' => $value->business_manager,
                'business_manager_name' => $value->business_manager_name,
                'company_name' => $value->company_name,
                'status' => $value->status,
                'applied' => $applied,
                'posting' => $countPosted,
                'contact_person' => $value->contact_person,
                'contact_no' => $value->contact_no,
                'email' => $value->email
            ];

        }

        $dataUndefined = !empty($data) ? $data : [];


        return view('employer.lists', ['employers' => $dataUndefined]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $industry = $this->industryList();
        $businessMngr = \App\User::where('role', 'business_manager')->pluck('name', 'id');


        return view('employer.form', ['industry' => $industry], compact('businessMngr'));
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

        $validator = $this->rules($data);

        if ($validator->fails()) {

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
        $employer->contact_no = $data['contact_no'];
        $employer->email = $data['email'];
        $employer->company_description = $data['company_description'];
        $employer->business_manager = $data['business_manager'];
        $employer->password = bcrypt($data['password']);
        $employer->contact_person = $data['contact_person'];
        $employer->rate = $data['hourly_rate'];
        $employer->profile_image_path = $data['company_logo'];
        $employer->industry = $data['industry'];
        $employer->dashboard_permissions =  null;
        $employer->employees_permissions = ['true'];
        $employer->employers_permissions = null;
        $employer->payout_permissions = null;
        $employer->job_permissions = ['true'];
        $employer->reports_permissions = null;
        $employer->push_permissions = null;
        $employer->recipient_permissions = null;
        $employer->settings_permissions = ['true'];
        $employer->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = new Employer();
        $employer = $user->employerDetails($id);
        if(empty($employer)){abort(404);}

        $countPosted = $user->postedJobCounts($employer->id);
        $applied = $user->candidates($employer->id);
        $related = $user->relatedJobs($employer->id);

        return view('employer.details',
            [
                'employer' => $employer
                , 'applied' => $applied
                , 'posting' => $countPosted
                , 'job' => $related
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $industry = $this->industryList();
        $user = new Employer();
        $employer = $user->employerDetails($id);
        if(empty($employer)){abort(404);}

        $businessMngr = \App\User::where('role', 'business_manager')->pluck('name', 'id');

        return view('employer.edit-form', ['industry' => $industry, 'user' => $employer],  compact('businessMngr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id=null)
    {
        // $user = new Employer();
        // $employer = $user->employerDetails($id);
        $employer = \App\User::find($id);
        if(empty($employer)){abort(404);}

        $data = $request->all();
        $validator = $this->updateRules($data,$id, $employer->profile_image_path );

        if ($validator->fails()) {
            return redirect(route('employer.edit',['id' => $id]))
                ->withErrors($validator)
                ->withInput();
        } else {
            if ($request->hasFile('company_logo')) {
                $companyLogo['company_logo'] = $request->file('company_logo')->store('avatars');
                $merge = array_merge($data, $companyLogo);
                $employer->profile_image_path = $merge['company_logo'];
            }else{
                $merge = $data;
            }
            $employer->company_name = $merge['company_name'];
            $employer->email = $merge['email'];
            $employer->company_description = $merge['company_description'];
            $employer->business_manager = $merge['business_manager'];
            $employer->contact_person = $merge['contact_person'];
            $employer->contact_no = $data['contact_no'];
            $employer->rate = $merge['hourly_rate'];
            $employer->industry = $merge['industry'];
            $employer->save();

            return redirect('employer/details/'.$id);
        }

    }

    /**
     * Remove the specified resource from storage.
     * 0 Pending
     * 1 Approved
     * 2 Upload
     * 3 Reject
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id = null, $param = null)
    {
        $employer = new Employer();

        $submit = empty($request->input('multiple')) ? $param : $request->input('multiple');
        $multi['multicheck'] = is_null($request->input('multicheck')) ? (array) $id : $request->input('multicheck');

        $validator = Validator::make($multi, ['multicheck' => 'required']);

        if ($validator->fails()) {

            $result = redirect(route('employer.lists'))
                ->withErrors($validator)
                ->withInput();
        } else {

            switch ($submit) {
                case 'Approve':
                    $employer->multiUpdateApprove($multi['multicheck'] );
                    break;
                case 'Delete':
                    $employer->multiDelete($multi['multicheck'] );
                    break;
                case 'Reject':
                    $employer->multiUpdateReject($multi['multicheck'] );
                    break;
            }
            $result = back();
        }

        return $result;
    }

    /**
     * Employer information
     */
    public function newlyRegisteredEmployer()
    {
        $user = new Employer();
        $employers = $user->userByMobile();

        return view('employer.newly-lists', ['employers' => $employers ]);

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
            'contact_no' => 'required|string',
            'password' => 'required|alpha_dash',
            'hourly_rate' => 'required|numeric',
            'industry' => 'required|string'
        ]);

    }

    /**
     * Update validation Rules
     */
    public function updateRules(array $data,$id, $profile_image_path)
    {
        $rules = [
            // 'company_logo' => 'required',
            'company_name' => 'required|string',
            'email' => 'email|required|string|email|max:255|unique:users,email,'.$id,
            'business_manager' => 'required|string',
            'contact_person' => 'required|string',
            'contact_no' => 'required|string',
            'hourly_rate' => 'required|numeric',
            'industry' => 'required|string'
        ];

        if(empty($profile_image_path)){
            $rules['company_logo'] = 'required';
        }

        return Validator::make($data,$rules);

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
