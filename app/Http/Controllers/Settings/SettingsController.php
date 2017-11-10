<?php

namespace App\Http\Controllers\Settings;

use Validator;
use App\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    //
    public function index(){
    	// return view('settings.index',['industry' => $industry]);
    	return view('settings.index');
    }
}
