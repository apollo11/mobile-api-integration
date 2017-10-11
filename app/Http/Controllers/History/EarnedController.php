<?php

namespace App\Http\Controllers\History;

use App\History;
use App\Http\Traits\JobDetailsOutputTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EarnedController extends Controller
{
    use JobDetailsOutputTrait;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Earned Job List History
     */
    public function earnedJobList()
    {
        $history = new History();

        $param = [
            'industries' => (array)$this->request->get('industries'),
            'locations' => (array)$this->request->get('locations'),
            'start' => $this->request->get('start'),
            'created' => $this->request->get('created'),
            'limit' => (int)$this->request->get('limit'),
            'date_from' => $this->request->get('date_from'),
            'date_to' => $this->request->get('date_to'),
            'id' => $this->request->get('user_id'),
            'job_statuses' => $this->request->get('job_statuses'),
            'payment_statuses' => $this->request->get('payment_statuses'),
        ];

        $output = $history->getEarnedJobs($param);
        $earned = $this->earnedJobs($param['id']);

        return $this->jobInfoOutput($output, $earned);
    }

    /**
     * Adding response output for lists
     * @param $output
     * @return \Illuminate\Http\JsonResponse
     */
    function jobInfoOutput($output,$earned)
    {

        foreach ($output as $value) {

            $data[] = $this->jobDetailsoutput($value);

        }
        $dataUndefined = !empty($data) ? $data : [];

        return response()->json(['earned_jobs' => $dataUndefined, 'total_amount_earned' => $earned]);

    }

    /**
     * @param $id
     * @return mixed
     */
    public function earnedJobs($id)
    {
        $earned = new History();

        $output = $earned->countEarnedJobs($id);

        return $output;
    }

}
