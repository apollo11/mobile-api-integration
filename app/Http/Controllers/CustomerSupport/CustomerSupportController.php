<?php

namespace App\Http\Controllers\CustomerSupport;

use Validator;
use App\Mail\CustomerSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Traits\HttpResponse;
use App\Http\Controllers\Controller;

class CustomerSupportController extends Controller
{

    use HttpResponse;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $validate = $this->validator($data);
        $error = $validate->errors()->all();

        if($validate->fails()) {

            return $this->mapValidator($error);

        }else {

            Mail::to('apollomalapote@gmail.com')->send(new CustomerSupport($data));

            return $this->successReponse();

        }

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
        //
    }

    /**
     * Validation rules
     */
    public function rules()
    {
        $validate = [
            'subject' => 'required|string',
            'message' => 'required| string'
        ];

        return $validate;
    }

    /**
     * Public function map validation
     */
    public function validator($data)
    {
        $validator = Validator::make($data, $this->rules());

        return $validator;
    }

    /**
     * Map Validation
     * @param $data
     * @return mixed
     */
    public function mapValidator($data)
    {
        return $this->errorResponse($data, 'Validation Error', 110001, 400);
    }

    /**
     * Success Response
     */
    public function successReponse()
    {
        return $this->ValidUseSuccessResp(200, true);

    }

}
