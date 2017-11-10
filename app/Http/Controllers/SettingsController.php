<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    //
    public function index(){
    	echo 'OLA~';
    	// return view('settings.index',['industry' => $industry]);
    	return view('settings.index');
    }
}
