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
     * @param $data
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function assignJobNotification($jobDetails, $token)
    {
        $data['title'] = "New Jobs Assigned to You";
        $message = "Dear Sir/Madam, You have been assigned a job successfully!  Below is the job information: " . "\n" . "Job Name: " . $jobDetails->job_title . "\n" . " Job Date and Time: " .$jobDetails->job_date . "\n" . " Job Location: " . $jobDetails->location . "\n" . " Hourly Rate: " . $jobDetails->rate . "\n" . " Contact Person: " . $jobDetails->contact_person . "\n" . " Contact No.: " . $jobDetails->contact_no;

        $data["body"] = $message;
        $data["registration_ids"] = (array) $token;
        $data["badge"] = 1;
        $data["type"] = constant('ASSIGNED_JOB');
        $data["job_id"] = $jobDetails->id;

        return $this->pushNotif($data);
    }


}