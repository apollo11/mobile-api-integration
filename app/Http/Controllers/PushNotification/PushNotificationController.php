<?php

namespace App\Http\Controllers\PushNotification;

use Carbon\Carbon;
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

        $pushNotification = PushNotification::where("publish_date",">=","NOW()")
        ->where("publish_date","<","DATE_ADD(NOW(), INTERVAL 5 MINUTE)")
        ->get();

        // print_r($pushNotification);

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





    public function quickNotification() {

        $pushnotification = new PushNotification();
        $groups = \App\RecipientGroup::all();
        return view('PushNotification.quick-form', ['recipientGroup' => $groups]);
    }


    public function quickNotificationadd(Request $request) {

        $validator = $this->ruless($request->all());

        if ($validator->fails()) {
            return redirect('pushnotification/quickNotification')
                ->withErrors($validator)
                ->withInput();
        } else {

            $deviceTokenResult = array();

            $recipient_group_id = $request->input('recipient_group');
            if ($recipient_group_id == 0) {
                $recipient_group_name = "All";   

                $deviceTokenResult = DeviceToken::join('user_recipient_groups', 'user_recipient_groups.user_id', '=', 'user_push_notification_tokens.user_id')
                ->get();

            }
            else {
                $recipient_group_name = $request->input('group_name');
                $deviceTokenResult = DeviceToken::join('user_recipient_groups', 'user_recipient_groups.user_id', '=', 'user_push_notification_tokens.user_id')
                ->where('user_recipient_groups.recipient_group_id', '=', $recipient_group_id)
                ->get();
            }
        
            $pushNotification = new PushNotification();
            $pushNotification->is_read = 0;
            $pushNotification->type = "custom";
            $pushNotification->recipient_group_id = $request->input('receipient-group');
            $pushNotification->group_name = $recipient_group_name;
            $pushNotification->title = $request->input('subject');
            $pushNotification->message = $request->input('message-content');
            $pushNotification -> save();

            // print_r($deviceTokenResult);

            $deviceTokens = array();
            for ($j=0; $j < count($deviceTokenResult); $j++) { 
                array_push($deviceTokens, $deviceTokenResult[$j]->device_token);
            }

            $data['title'] = $request->input('subject');
            $data["body"] = $request->input('message-content');
            $data["registration_ids"] = $deviceTokens;
            $data["badge"] = 1;
            $data["type"] = "custom";


            if ($this->pushNotif($data) == "200") {
                $pushNotificationList = PushNotification::all();
                return view('PushNotification.lists', ['list' => $pushNotificationList]);
            } else {
                // echo "Error occured while sending scheduled push notification";
            }                
        }
    }







    public function create()
    {
        // $groups = RecipientGroup::all();
        $pushnotification = new PushNotification();
        $groups = \App\RecipientGroup::all();

        return view('PushNotification.form', ['recipientGroup' => $groups]);
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

            $publishDate = $request->input('publish-date');
            $recipient_group_id = $request->input('recipient_group');
            // echo $recipient_group_id;
            // echo $recipient_group_name;
            if ($recipient_group_id == 0) {
                $recipient_group_name = "All";   
            }
            else {
                $recipient_group_name = $request->input('group_name');
            }
        
            $pushNotification = new PushNotification();
            $pushNotification->is_read = 0;
            $pushNotification->type = "custom";
            $pushNotification->recipient_group_id = $request->input('receipient-group');
            $pushNotification->group_name = $recipient_group_name;
            $pushNotification->title = $request->input('subject');
            $pushNotification->message = $request->input('message-content');
            $pushNotification->publish_date = $request->input('publish-date');
            $pushNotification -> save();
            return redirect('pushnotification/lists');
        }
    }


    public function edit($id)
    {
        $pushNotification = PushNotification::find($id);
        $groups = \App\RecipientGroup::all();
        return view('PushNotification.edit-form', ['pushNotification'=>$pushNotification, 'groups'=>$groups]);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        // echo $request->input('publish-date');

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
            $pushNotification->publish_date = $request->input('publish-date');
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
            // 'receipient-group' => 'required',
            'subject' => 'required',
            'publish-date' => 'required|date|after:today',
            'message-content' => 'required',
        ]);
    }


    public function ruless(array $data)
    {
        return Validator::make($data, [
            // 'receipient-group' => 'required',
            'subject' => 'required',
            'message-content' => 'required',
        ]);
    }


}

?>