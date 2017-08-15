<?php
namespace App\Http\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait HttpRequest
{
    protected $fbUrl;
    protected $googleUrl;

    public function fbEndpoint ()
    {
        $this->fbUrl = 'https://graph.facebook.com';

        return  $this->fbUrl;
     }

     public function googleEndPoint()
     {
         $this->googleUrl = 'https://www.googleapis.com';

         return $this->googleUrl;

     }

    public function getSocialFbResponse($token)
    {
        $client = new Client();
        try {
            $response = $client->request('GET', $this->fbEndpoint().'/v2.10/me?field=id,name,email&&access_token='.$token);
            return [
                  'status_code' => $response->getStatusCode()
                , 'body' => $response->getBody()
            ];


        }catch(RequestException $e) {
            if ($e->hasResponse()) {
                $body = $e->getResponse()->getBody();
                $status = $e->getResponse()->getStatusCode();

                return [
                    'status_code' => $status
                    , 'body' => $body
                ];

            }
        }
    }

    public function getSocialGoogleResponse($token)
    {
        $client = new Client();
        try {
            $response = $client->request('GET', $this->googleEndPoint().'/oauth2/v3/tokeninfo?id_token='.$token);

            return [
                'status_code' => $response->getStatusCode()
                , 'body' => $response->getBody()];

        }catch(RequestException $e) {

            if ($e->hasResponse()) {
                $body = $e->getResponse()->getBody();
                $status = $e->getResponse()->getStatusCode();

                return [
                    'status_code' => $status
                    , 'body' => $body
                ];

            }
        }
    }

}