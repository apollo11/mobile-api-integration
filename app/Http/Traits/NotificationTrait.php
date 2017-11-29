<?php
namespace App\Http\Traits;

use App\DeviceToken as Token;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use App\DeviceToken;

trait NotificationTrait
{

    /**
     * @param $data
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function assignJobNotification($jobDetails)
    {
        $data['title'] = "New Jobs Assigned to You";
        $message = "Dear Sir/Madam, You have been assigned a job successfully!  Below is the job information: " . "\n" . "Job Name: " . $jobDetails->job_title . "\n" . " Job Date and Time: " .$jobDetails->job_date . "\n" . " Job Location: " . $jobDetails->location . "\n" . " Hourly Rate: " . $jobDetails->rate . "\n" . " Contact Person: " . $jobDetails->contact_person . "\n" . " Contact No.: " . $jobDetails->contact_no;

        $data["body"] = $message;
        $data["registration_ids"] = $data['token'];
        $data["badge"] = 1;
        $data["type"] = constan('ASSIGNED_JOB');
        $data["job_id"] = $jobDetails->id;
        //$this->pushNotif($data);

        return $data;
    }


}