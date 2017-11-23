<?php

namespace App\Http\Controllers\PushNotification;

use GuzzleHttp\Exception\RequestException;
use Validator;
use App\PushNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pushNotification = new PushNotification();
        // return view('PushNotification.lists', ['list' => $pushnotification->pushNotificationList()]);
        return view('PushNotification.lists', ['list' => $pushNotification->pushNotificationList()]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $pushNotification = PushNotification::all();
        // return view('PushNotification.lists', ['list' => $pushnotification->pushNotificationList()]);
        return view('PushNotification.lists', ['list' => $pushNotification]);
    }



    public function create()
    {
        $pushnotification = new PushNotification();
        return view('PushNotification.form');
    }

    public function add(Request $request)
    {
        $data = $request->all();

        // echo $request->input('receipient-group');
        // echo "</br>";
        // echo $request->input('subject');
        // echo "</br>";
        // echo $request->input('publish-date');
        // echo "</br>";
        // echo $request->input('message-content');
        // echo "</br>";
        // echo "</br>";

        $validator = $this->rules($data);

        if ($validator->fails()) {

            return redirect('pushnotification/create')
                ->withErrors($validator)
                ->withInput();
        } else {

            $pushNotification = new PushNotification();
            $pushNotification->job_id = 101;
            $pushNotification->is_read = 0;
            $pushNotification->type = "normal";
            $pushNotification->title = $request->input('subject');
            $pushNotification->message = $request->input('message-content');
            $dateFormatter = explode('/', $request->input('publish-date'));
            $pushNotification->user_id = 3;
            $pushNotification->created_at = $dateFormatter[2] . '-' . $dateFormatter[0] . '-' . $dateFormatter[1];
            // $pushNotification->updated_at = "2018-01-01 00:00:00";

            $pushNotification -> save();

            return redirect('pushnotification/lists');
        }
    }



    public function edit($id)
    {
        $pushNotification = PushNotification::find($id);
        return view('PushNotification.edit-form', ['pushNotification'=>$pushNotification]);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        $validator = $this->rules($data);

        if ($validator->fails()) {

            return redirect('pushnotification/lists')
                ->withErrors($validator)
                ->withInput();
        } else {
            $pushNotification = PushNotification::find($request->input('id'));
            $pushNotification->job_id = 102;
            $pushNotification->is_read = 0;
            $pushNotification->type = "normal";
            $pushNotification->title = $request->input('subject');
            $pushNotification->message = $request->input('message-content');
            $dateFormatter = explode('/', $request->input('publish-date'));
            $pushNotification->user_id = 3;
            $pushNotification->created_at = $dateFormatter[2] . '-' . $dateFormatter[0] . '-' . $dateFormatter[1];
            $pushNotification -> save();

            return redirect('pushnotification/lists');
        }
    }



    public function delete($id)
    {
        PushNotification::find($id)->delete();
        return redirect('pushnotification/lists');
    }


    /**
     * Validation Rule
     */
    public function rules(array $data)
    {
        return Validator::make($data, [
            'receipient-group' => 'required',
            'subject' => 'required',
            'publish-date' => 'required|date',
            'message-content' => 'required'
        ]);
    }
}