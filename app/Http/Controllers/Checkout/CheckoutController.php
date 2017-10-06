<?php

namespace App\Http\Controllers\Checkout;

use Carbon\Carbon;
use App\Checkout;
use App\Job;
use App\JobSchedule;
use App\Http\Traits\HttpResponse;
use App\Http\Traits\JobDetailsOutputTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    use HttpResponse;
    use JobDetailsOutputTrait;

    protected $googleMap;

    public function __construct()
    {
        $this->googleMap = constant('GOOGLE_MAP_ENDPOINT');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $job = new JobSchedule();

        $output = $job->getJobScheduleDetails($id, 'job_schedules.id');

        $details = $this->jobDetailsoutput($output);

        return response()->json(['job_details' => $details, 'status' => ['status_code' => 200, 'success' => true]]);

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
    public function update(Request $request)
    {
        $data = $request->all();
        $jobSched = \App\JobSchedule::find($data['schedule_id']);


        $jobDetails = $this->getJob($jobSched['user_id'], $jobSched['job_id']);
        $geolocation = $this->getAddress($data['latitude'], $data['longitude']);
        $hours = $this->compareDates($jobSched->checkin_datetime);
        $salaryRate = $this->salaryRate($hours, $jobDetails->rate);

        $jobSched->update([
            'checkout_datetime' => Carbon::now(),
            'checkout_location' => $geolocation,
            'working_hours' => $hours,
            'job_salary' => $salaryRate,
            'job_status' => 'completed'
        ]);

            $result = $this->show($data['schedule_id']);

        return $result;

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
     * Get job schedule by id
     */
    public function getJob($userId, $id)
    {
        $job = new Job();
        $result = $job->jobDetails($userId, $id);

        return $result;
    }

    /**
     * Different in Hours
     */
    public function compareDates($start)
    {
        $start = Carbon::parse($start);
        $now = Carbon::now();

        return $now->diffInHours($start);
    }

    public function salaryRate($hours, $rate)
    {
        $salary = $hours * $rate;

        return $salary;
    }



    /**
     * Get the exact address by getting latitude and longtitude
     * @param $lat
     * @param $lang
     * @return string
     */
    public function getAddress($lat, $lang)
    {
        $http = new Client();
        try {
            $response = $http->get($this->googleMap . '?latlng=' . $lat . ',' . $lang . '&key=' . env('GOOGLE_API_KEY'));

            $result = json_decode((string)$response->getBody(), true);

            return $result['results'][0]['formatted_address'];

        } catch (RequestException $e) {

            if ($e->hasResponse()) {

                return 'Unknown Address';
            }
        }

    }
}
