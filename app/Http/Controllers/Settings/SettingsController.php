<?php

namespace App\Http\Controllers\Settings;

use Validator;
use App\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\HttpResponse;

use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    use HttpResponse;
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
    public function store(Request $request)
    {
    	$data = $request->all();
        $validator = $this->updateRules($data);

        if ($validator->fails()) {
            return redirect(route('settings'))
                ->withErrors($validator)
                ->withInput();
        } else {
        	$settings = Settings::find(1);
        	$settings->terms_conditions = ($data['terms_conditions']==null) ? '' : $data['terms_conditions'];
            $settings->privacy_policy = ($data['privacy_policy']==null) ? '' :$data['privacy_policy'];
            $settings->faq = ($data['faq']==null) ? '' : $data['faq'];
            $settings->interview_instruction =($data['interview_instruction']==null) ? '' : $data['interview_instruction'];
            $settings->point_basic = ($data['point_basic']==null) ? '' :$data['point_basic'];
            $settings->point_min = ($data['point_min']==null) ? '' : $data['point_min'];
            $settings->point_reject_job = ($data['point_reject_job']==null) ? '' : $data['point_reject_job'];
            $settings->point_late_job = ($data['point_late_job']==null) ? '' : $data['point_late_job'];
            $settings->point_cancel_job_before_72_hours = ($data['point_cancel_job_before_72_hours']==null) ? '' : $data['point_cancel_job_before_72_hours'];
            $settings->point_cancel_job_within_72_hours = ($data['point_cancel_job_within_72_hours']==null) ? '' :$data['point_cancel_job_within_72_hours'];
            $settings->point_dont_turnup_job = ($data['point_dont_turnup_job']==null) ? '' : $data['point_dont_turnup_job'];
        	$settings->save();

        	return redirect()->back()->with('message', 'Updated successfully.');
        }
    }

    /**
     * Update validation Rules
     */
    public function updateRules(array $data)
    {
        $validator = Validator::make($data, [
            'point_basic' => 'required|integer|min:0',
            'point_min'   => 'required|integer|min:0',
            'point_reject_job'   =>'required|integer',
            'point_late_job'   => 'required|integer',
            'point_cancel_job_before_72_hours'   => 'required|integer',
            'point_cancel_job_within_72_hours'   => 'required|integer',
            'point_dont_turnup_job'   => 'required|integer'
        ]);

        $niceNames = array(
            'point_basic' => 'basic points setting',
            'point_reject_job'   =>'reject an assignment',
            'point_late_job'   => 'late to assigned job',
            'point_cancel_job_before_72_hours'   => 'cancel accepted job with valid reason',
            'point_cancel_job_within_72_hours'   => 'cancel accepted job without valid reason',
            'point_dont_turnup_job' => 'did not turn up to assigned job',
            'point_min' => 'minimum points required '
        );
        $validator->setAttributeNames($niceNames); 

        return $validator;
    }

    public function point_settings(){
        $settings = new Settings();
        $settings = $settings->allSettings();

        $error_code = 120002;
        if(empty($settings) ){
            $errors = array('Settings not found.');
            return $this->errorResponse($errors, 'Unexpected Error', $error_code, 400);
        }else{
            $data = array(
                'point_basic' => $settings->point_basic,
                'point_min' => $settings->point_min,
                'point_reject_job' => $settings->point_reject_job,
                'point_late_job' => $settings->point_late_job,
                'point_cancel_job_before_72_hours' => $settings->point_cancel_job_before_72_hours,
                'point_cancel_job_within_72_hours' => $settings->point_cancel_job_within_72_hours,
                'point_dont_turnup_job' => $settings->point_dont_turnup_job,
            );
            return response()->json(['success'=>true,'point_settings' => $data]);
        }
    }
}
