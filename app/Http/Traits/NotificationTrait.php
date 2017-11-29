<?php
namespace App\Http\Traits;

use App\Http\Traits\PushNotiftrait;
use App\DeviceToken as Token;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\DeviceToken;

trait NotificationTrait
{
    use PushNotiftrait;

    /**
     * @param $id
     * @return array
     */
    public function parsingToken($id)
    {
        $device = array();
        $token = new DeviceToken();
        $tokenValue = $token->getMultipleDeviceTokenByUserId($id);
        foreach ($tokenValue as $value) {
            $device[] = $value->device_token;
        }

        return $device;

    }

    /**
     * @param $jobDetails
     * @param $token
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function assignJobNotification($jobDetails, $token)
    {

        $data['title'] = "New Jobs Assigned to You";
        $message = "Dear Sir/Madam, You have been assigned a job successfully!  Below is the job information: " . "\n" . "Job Name: " . $jobDetails->job_title . "\n" . " Job Date and Time: " .$jobDetails->job_date . "\n" . " Job Location: " . $jobDetails->location . "\n" . " Hourly Rate: " . $jobDetails->rate . "\n" . " Contact Person: " . $jobDetails->contact_person . "\n" . " Contact No.: " . $jobDetails->contact_no;

        $data["body"] = $message;
        $data["registration_ids"] = $token;
        $data["badge"] = 1;
        $data["type"] = constant('ASSIGNED_JOB');
        $data["job_id"] = $jobDetails->id;

         return $this->pushNotif($data);

    }

    /**
     * @param $user
     * @param $token
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function registrationNotification($user, $token)
    {

        $data['title'] = "Registration Successful!";
        $message = "Hello $user->name, welcome to YY Part-time jobs! I hopen you have a wonderful time here! Try finding your favourite jobs by today!";

        $data["body"] = $message;
        $data["registration_ids"] = $token;
        $data["badge"] = 1;
        $data["type"] = constant('REGISTRATION');

        return $this->pushNotif($data);

    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function updateProfileNotif($token)
    {

        $data['title'] = "Update your profile!";
        $data["body"] = "Please update your profile details on your profile page.";
        $data["registration_ids"] = $token;
        $data["badge"] = 1;
        $data["type"] = constant('PROFILE');

        return  $this->pushNotif($data);

    }

    public function interviewApprovedNotif($token)
    {
        $data['title'] = "Your interview has been approved by YY Part-time Jobs!";
        $data["body"] = "Congratulations! You have been approved by YY part-time jobs admin. Now you can start applying for your interested jobs!.";
        $data["registration_ids"] = $token;
        $data["badge"] = 1;
        $data["type"] = constant('INTERVIEW');

        return  $this->pushNotif($data);

    }
    public function rejectEmployeedNotif($token)
    {
        $data['title'] = "Your interview has been rejected by YY Part-time Jobs!";
        $data["body"] = "We are sorry to inform you that you are rejected by YY Part-time jobs!.";
        $data["registration_ids"] = $token;
        $data["badge"] = 1;
        $data["type"] = constant('USER_REJECT');

        return  $this->pushNotif($data);

    }



}