<?php

namespace App\Http\Controllers;
use App\Settings;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class WebContentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currentPath= Route::getFacadeRoot()->current()->uri();

        $settings = new Settings();
        $allsettings = $settings->allSettings();
        if(empty($allsettings)){
            abort(404);   
        }

        switch($currentPath){
            case 'terms-conditions':
                $content = $allsettings->terms_conditions;
                break;
            case 'privacy-policy':
                $content = $allsettings->privacy_policy;
                break;
            case 'faq':
                $content = $allsettings->faq;
                break;
            case 'interview-instruction':
                $content = $allsettings->interview_instruction;
                break;
            default:
                abort(404);   
                break;
        }

        return view('webcontent', ['content'=>$content]);
    }
}