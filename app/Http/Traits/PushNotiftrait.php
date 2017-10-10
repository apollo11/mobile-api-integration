<?php

namespace App\Http\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait PushNotiftrait
{
    protected $ENDPOINT;
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
                        'message' => $data['message']
                    ],
                    'registration_ids' => [$data['registration_ids']]
                ];

                $response = $client->request('POST', $this->ENDPOINT, [
                    'headers' => [
                        'Authorization' => 'key=AAAARF0JD0Q:APA91bE4FYvPVP6Yio1o4XJf0mt92OcZu6LJ6Ped7Zq-JEIf2_vruKiPduekmjTZAhFvzEh1KfW-boaIfZFeMGJvFj7mtNcL7WHFvGWuYastxGZqu_6yzFFcz_RLOpevKGnrS9P2tL-S'
                    ],
                    'form_params' => $map,
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



