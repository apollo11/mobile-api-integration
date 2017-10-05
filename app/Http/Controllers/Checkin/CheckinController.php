<?php

namespace App\Http\Controllers\Checkin;

use Mapper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckinController extends Controller
{
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
        //
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

    }

    /**
     * Get Address
     */
    public function getAddress($lat, $lang) {

        $http = new Client();

        try {

            $response = $http->get($this->googleMap.'?latlng='.$lat.','.$lang.'&key='.env('GOOGLE_API_KEY'));

            $result = json_decode((string) $response->getBody(), true);

            return $result['results'][0]['formatted_address'];

        }catch(RequestException $e) {

            if ($e->hasResponse()) {

                return 'Unknown Address';
            }

        }

    }
}
