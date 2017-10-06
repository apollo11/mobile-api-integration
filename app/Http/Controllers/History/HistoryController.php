<?php

namespace App\Http\Controllers\History;

use App\History;
use App\Http\Traits\JobDetailsOutputTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HistoryController extends Controller
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
        //
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
        $history = new History();
        $output = $history->getHistoryDetails($id, 'jobs.id');

        $details = $this->jobDetailsoutput($output, 'Pending');

        return response()->json(['job_details' => $details, 'status' => ['status_code' => 200, 'success' => true]]);

    }

    /**
     * History List Completed and Cancelled
     */
    public function CompletedCancelledList()
    {
        $history = new History();
        $param = [
            'industries' => (array) $this->request->get('industries'),
            'locations' => (array) $this->request->get('locations'),
            'start' => $this->request->get('start'),
            'created' =>$this->request->get('created'),
            'limit' => (int) $this->request->get('limit'),
            'date_from' => $this->request->get('date_from'),
            'date_to' => $this->request->get('date_to'),
            'id' => $this->request->get('user_id'),
        ];

        $output = $history->getCompletedCancelledJobs($param);

        return $this->jobInfoOutput($output);
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
    public function update(Request $request, $id)
    {
        //
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
     * Adding response output for lists
     * @param $output
     * @return \Illuminate\Http\JsonResponse
     */
    function jobInfoOutput($output)
    {
        foreach ($output as $value) {

            $data[] =  $this->jobDetailsoutput($value, 'Pending');
        }

        $dataUndefined = !empty($data) ? $data : [];

        return response()->json(['completed_jobs' => $dataUndefined]);

    }

}
