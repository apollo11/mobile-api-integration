<?php

namespace App\Http\Controllers\Settings;

use Validator;
use App\Settings;
use App\Http\Requests\SettingsRequest;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    //
    public function index(){
    	$settings = new Settings();
    	$allsettings = $settings->allSettings();

    	return view('settings.index',['settings'=>$allsettings]);
    }


    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SettingsRequest $request)
    {
    	$data = $request->all();
    	
    	$settings = Settings::find(1);
/*    	$allsettings = $settings->allSettings();

    	$settings->id = $allsettings->id;*/
    	$settings->terms_conditions = $data['terms_conditions'];
    	$settings->privacy_policy = $data['privacy_policy'];
    	$settings->save();

    	return redirect()->back()->with('message', 'Updated successfully.');

    	// echo $data['terms_conditions'];
		/*// print_r($data);exit;
    	DB::table('settings')->first()->update([
    		'terms_conditions'=>$data['terms_conditions'],
    		'privacy_policy'=>$data['privacy_policy'],
    	]);*/
/*

    	$user->update([
            'job_title' => $data['job_title'],
            'job_id' => Auth::user()->id,
            'location_id' => $data['location_id'],
            'location' => $data['location'],
            'description' => $data['job_description'],
            'job_requirements' => $data['job_requirements'],
            'role' => $data['job_role'],
            'choices' => $data['gender'],
            'nationality' => $data['nationality'],
            'job_image_path' => $data['job_image'],
            'no_of_person' => $data['no_of_person'],
            'contact_person' => $data['contact_person'],
            'contact_no' => $data['contact_no'],
            'business_manager' => $data['business_manager'],
            'employer' => $data['job_employer'],
            'rate' => $data['hourly_rate'],
            'language' => $data['preferred_language'],
            'job_date' => $this->convertToUtc($data['date']),
            'end_date' => $this->convertToUtc($data['end_date']),
            'industry_id' => $data['industry_id'],
            'industry' => $data['industry'],
            'notes' => $data['notes'],
            'status' => $data['status'],
            'min_age' => $data['min_age'],
            'max_age' => $data['max_age']
        ]); */

        /*$validator = $this->rules($data);

        if($validator->fails()) {
            return redirect(route('settings'))
                ->withErrors($validator)
                ->withInput();
        } else {
        	echo '~~~~';exit;
        }*/
    }
}
