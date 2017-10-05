<?php

namespace App\Http\Controllers\Checkin;

use Carbon\Carbon;
use App\Http\Traits\JobDetailsOutputTrait;
use App\CheckIn;
use App\Job;
use App\JobSchedule;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckinController extends Controller
{
    use JobDetailsOutputTrait;

    protected $googleMap;

    public function __construct()
    {
        $this->googleMap = constant('GOOGLE_MAP_ENDPOINT');
    }

    /**
     *
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     *
     */
    public function index(Request $request)
    {
        $param = [
            'id' => $request->get('user_id')
        ];

        $checkin = new CheckIn();

        $output = $checkin->getCheckInJob($param);

        return $this->jobInfoOutput($output);
    }

    /**
     * Output response for the schedule
     * @param $output
     * @return \Illuminate\Http\JsonResponse
     */
    function jobInfoOutput($output)
    {
        $data[] = $this->jobDetailsoutput($output, 'Pending');

        $dataUndefined = !empty($data) ? $data : [];

        return response()->json(['jobs' => $dataUndefined]);
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

        $details = $this->jobDetailsoutput($output, 'Pending');

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

        //$geolocation = $this->getAddress($data['latitude'], $data['longtitude']);

        $jobSched = \App\JobSchedule::find($data['id']);

        $jobDetails = $this->getJob($jobSched['user_id'],$jobSched['job_id']);

        return response()->json(['test' => $jobDetails]);

        $jobSched->update([
            'checkin_datetime' => Carbon::now(),
            'checkin_location' => '10 Bayfront Ave, Singapore 018956'
        ]);

        return $this->show($data['id']);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

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
