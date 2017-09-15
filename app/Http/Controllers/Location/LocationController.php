<?php

namespace App\Http\Controllers\Location;

use Validator;
use App\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $location = $this->locationLists();

        return view('location.lists', ['location' => $location]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('location.form');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = $this->rules($data);

        if ($validator->fails()) {

            return redirect(route('location.create'))
                ->withErrors($validator)
                ->withInput();
        } else {

           $this->saveData($data);

            return redirect(route('location.lists'));
        }

    }

    /**
     * @param array $data
     * @return array
     */
    public function saveData(array $data)
    {

        $query = new Location();
        $query->name = $data['name'];
        $query->zip_code = $data['zip_code'];
        $query->save();

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
     * Validation details
     * @param $data
     * @return mixed
     */

    public function rules($data)
    {
        return Validator::make($data, [
            'name' => 'required|string|unique:locations',
            'zip_code' => 'required|string|unique:locations',
        ]);
    }

    /**
     * List of location
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function locationLists()
    {
        $location = new Location();

        $output = $location::all();

        return $output;
    }

    /**
     * Output location
     * @return \Illuminate\Http\JsonResponse
     */

    public function lists()
    {
        $location = new location();

        $output = $location->locationLists();

        return response()->json(['locations' => $output]);
    }
}
