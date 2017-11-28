<?php

namespace App\Http\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait PushNotiftrait
{
    private $ENDPOINT;
    protected $FCM_KEY;

    public function __construct()
    {
        $this->ENDPOINT = constant('FCM_ENDPOINT');
        $this->FCM_KEY = env('FCM_SERVER_KEY');
    }

    public function pushNotif($data)
    {
        $client = new Client();

        try {
            if (!empty($data['registration_ids'])) {
                $map = [
                    'notification' => [
                        'title' => $data['title'],
                        'body' => $data['body'],
                        'content-available' => 1,
                        'sound' => 'default',
                        'badge' => (string) $data['badge']
                    ],
                    'data'=>[
                        'title' => $data['title'],
                        'body' => $data['body'],
                        // 'job_id' => $data['job_id'],
                        'type' => $data['type']
                    ],
                    'registration_ids' => $data['registration_ids']
                    // 'priority' => 'high'
                ];
                if(isset($data['job_id'])) {
                    $map['data']['job_id'] = $data['job_id']; 
                }
                $response = $client->request('POST',constant('FCM_ENDPOINT'), [
                    'headers' => [
                        'Authorization' => 'key=AIzaSyBvyxjYHkMdHvGocO821JrUwj3ap2eo3MA'
                    ],
                    'json' => $map,
                ]);

                return $response->getStatusCode();
            }

        } catch (RequestException $e) {

            if ($e->hasResponse()) {

                return response()->json([$e->getMessage()]);
            }
        }
    }

}



