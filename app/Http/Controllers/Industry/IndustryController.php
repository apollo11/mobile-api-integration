<?php

namespace App\Http\Controllers\Industry;

use Validator;
use App\Industry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $industry = $this->industryList();

        return view('industry.lists',['industry' => $industry]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('industry.form');
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
        $validator = $this->rules($data);

        if($validator->fails()) {

            return redirect(route('industry.create'))
                ->withErrors($validator)
                ->withInput();
        } else {

            $this->saveData($data);

            return redirect(route('industry.lists'));
        }
    }

    /**
     * Saving Industry
     * @param array $data
     */

    public function saveData(array $data)
    {
        $query = new Industry();
        $query->industry = $data['industry'];
        $query->save();
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
        //
    }

    /**
     * Validation rules for industry need to be required
     */

    public function rules($data)
    {
        return Validator::make($data, [
            'industry' => 'required|string|unique:industries'
        ]);
    }

    /**
     * List of available industries
     */

    public function industryList()
    {
        $industry = new Industry();

        $output = $industry::all();

        return $output;

    }
}
