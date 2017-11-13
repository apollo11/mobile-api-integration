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
    	$settings->terms_conditions = $data['terms_conditions'];
    	$settings->privacy_policy = $data['privacy_policy'];
    	$settings->save();

    	return redirect()->back()->with('message', 'Updated successfully.');
    }
}
