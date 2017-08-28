<?php

namespace App\Http\Controllers\Job;

use Validator;
use App\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobsLists = $this->jobLists();

        return view('job.lists', ['job' => $jobsLists]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('job.form');
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

        $validator = $this->rules($request->all());

        if($validator->fails($data)) {
            return redirect('job/create')
                ->withErrors($validator)
                ->withInput();
        } else {

            $profile['job_image'] = $request->file('job_image')->store('jobs');
            $mergeData = array_merge($data, $profile);

            $this->saveData($mergeData);

            return redirect('job/list');
        }

    }

    public function saveData(array $data)
    {
        $id = Auth::user()->id();

        $employer = \App\User::find($id);
        $query = new Job();
        $query->job_title = $data['job_title'];
        $query->description = $data['job_description'];
        $query->role = $data['job_role'];
        $query->choices = $data['gender'];
        $query->job_image_path = $data['job_image'];
        $query->no_of_person = $data['no_of_person'];
        $query->contact_person = $data['contact_person'];
        $query->business_manager = $data['business_manager'];
        $query->employer = $data['job_employer'];
        $query->rate = $data['hourly_rate'];
        $query->language = $data['preferred_language'];
        $query->job_date = $data['date'];
        $query->notes = $data['notes'];
        $query->status = $data['job_status'];

        $employer->job()->save($query);

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
     * Validation Rule
     */
    public function rules(array $data)
    {
        return Validator::make($data, [
           'job_title' => 'required',
            'job_desc' => 'required|string',
            'job_role' => 'required|string',
            'job_image' => 'required',
            'no_of_person' => 'required|numeric',
            'contact_person' => 'required|string',
            'business_manager' => 'required|string',
            'job_employer' => 'required|string',
            'hourly_rate' => 'required|digits_between:1,5',
            'preferred_language' => 'required|string',
            'date' => 'required|date',
            'notes' => 'required|string',
            'job_status' => 'required|string',
            'gender' => 'required:string'
        ]);
    }

    /**
     * Job Lists
     */
    public function jobLists()
    {
        $jobs = new Job();
        $jobLists = $jobs::all();

        return $jobLists;

    }

}
