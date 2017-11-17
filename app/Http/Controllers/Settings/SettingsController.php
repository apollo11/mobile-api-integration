<?php

namespace App\Http\Controllers\Settings;

use Validator;
use App\Settings;
use Illuminate\Http\Request;
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
        	$settings->terms_conditions = $data['terms_conditions'];
            $settings->privacy_policy = $data['privacy_policy'];
            $settings->faq = $data['faq'];
            $settings->interview_instruction = $data['interview_instruction'];
            $settings->point_basic = $data['point_basic'];
            $settings->point_min = $data['point_min'];
            $settings->point_reject_job = $data['point_reject_job'];
            $settings->point_late_job = $data['point_late_job'];
            $settings->point_cancel_job_w_reason = $data['point_cancel_job_w_reason'];
            $settings->point_cancel_job_wt_reason = $data['point_cancel_job_wt_reason'];
            $settings->point_dont_turnup_job = $data['point_dont_turnup_job'];
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
            'point_cancel_job_w_reason'   => 'required|integer',
            'point_cancel_job_wt_reason'   => 'required|integer',
            'point_dont_turnup_job'   => 'required|integer'
        ]);

        $niceNames = array(
            'point_basic' => 'basic points setting',
            'point_reject_job'   =>'reject an assignment',
            'point_late_job'   => 'late to assigned job',
            'point_cancel_job_w_reason'   => 'cancel accepted job with valid reason',
            'point_cancel_job_wt_reason'   => 'cancel accepted job without valid reason',
            'point_dont_turnup_job' => 'did not turn up to assigned job',
            'point_min' => 'minimum points required '
        );
        $validator->setAttributeNames($niceNames); 

        return $validator;
    }
}
