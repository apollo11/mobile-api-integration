<?php

namespace App\Http\Controllers\PushNotification;

use GuzzleHttp\Exception\RequestException;
use Validator;
use App\Http\Traits\PushNotiftrait;
use App\PushNotification;
use App\DeviceToken;
use App\RecipientGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PushNotificationController extends Controller
{
    use PushNotiftrait;

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

    public function notifyByPublishDateTime() {

        $pushNotification = PushNotification::where("created_at",">=","NOW()")
        ->where("created_at","<","DATE_ADD(NOW(), INTERVAL 5 MINUTE)")
        ->get();

        if (count($pushNotification) > 0) 
        {
            for ($i=0; $i < count($pushNotification); $i++) { 

                $deviceTokenResult = DeviceToken::join('user_recipient_groups', 'user_recipient_groups.user_id', '=', 'user_push_notification_tokens.user_id')
                    ->where('user_recipient_groups.recipient_group_id', '=', $pushNotification[$i]->recipient_group_id)
                    ->get();

                $deviceTokens = array();
                for ($j=0; $j < count($deviceTokenResult); $j++) { 
                    array_push($deviceTokens, $deviceTokenResult[$j]->device_token);
                }

                $title = $pushNotification[$i]->title;
                $message = $pushNotification[$i]->message;
                $data['title'] = $title;
                $data["body"] = $message;
                $data["registration_ids"] = $deviceTokens;
                $data["badge"] = 1;
                $data["type"] = "custom";

                if ($this->pushNotif($data) == "200") {
                    // echo "SUCESS in scheduled push notification";
                } else {
                    // echo "Error occured while sending scheduled push notification";
                }                
            }

            // SELECT user_push_notification_tokens.user_id, device_token, user_notifications.created_at 
            // FROM user_notifications, user_push_notification_tokens, user_recipient_groups 
            // WHERE user_notifications.created_at >= NOW()
            // AND user_notifications.created_at < DATE_ADD(NOW(), INTERVAL 15 MINUTE)
            // AND user_recipient_groups.recipient_group_id = user_notifications.recipient_group_id
            // AND user_recipient_groups.user_id = user_push_notification_tokens.user_id
        }
        
    }




    public function create()
    {
        $groups = RecipientGroup::all();
        $pushnotification = new PushNotification();
        return view('PushNotification.form', ['groups' => $groups]);
    }

    public function add(Request $request)
    {
        $data = $request->all();

        $validator = $this->rules($data);

        if ($validator->fails()) {

            return redirect('pushnotification/create')
                ->withErrors($validator)
                ->withInput();
        } else {

            echo 
            $pushNotification = new PushNotification();
            $pushNotification->is_read = 0;
            $pushNotification->type = "custom";
            $pushNotification->recipient_group_id = $request->input('receipient-group');
            $pushNotification->title = $request->input('subject');
            $pushNotification->message = $request->input('message-content');
            $dateTimeFormatter = explode(' ', $request->input('publish-date'));
            $dateFormatter = explode('-', $dateTimeFormatter[0]);
            $pushNotification->created_at = $dateFormatter[0] . '-' . $dateFormatter[2] . '-' . $dateFormatter[1] . " " . $dateTimeFormatter[1] . ":00";
            $pushNotification -> save();
            return redirect('pushnotification/lists');
        }
    }


    public function edit($id)
    {
        $pushNotification = PushNotification::find($id);
        $groups = RecipientGroup::all();
        return view('PushNotification.edit-form', ['pushNotification'=>$pushNotification, 'groups'=>$groups]);
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
            $pushNotification->is_read = 0;
            $pushNotification->type = "custom";
            $pushNotification->recipient_group_id = $request->input('receipient-group');
            $pushNotification->title = $request->input('subject');
            $pushNotification->message = $request->input('message-content');
            $dateTimeFormatter = explode(' ', $request->input('publish-date'));
            $dateFormatter = explode('-', $dateTimeFormatter[0]);
            $pushNotification->created_at = $dateFormatter[0] . '-' . $dateFormatter[2] . '-' . $dateFormatter[1] . " " . $dateTimeFormatter[1] . ":00";
            
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