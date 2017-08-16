<?php
namespace App\Http\Traits;

use GuzzleHttp\Client;

trait OauthTrait
{
    protected $accessUrl = 'http://yyjobs.local/oauth/token';
    protected $grantType = 'password';
    protected $clientId = '1';
    protected $clientSecret = '7BOMAH7M8FitqZNV1blAkVjpp1K9dfrvPpqH5Vwy';

    public function ouathResposne(array $data)
    {
        $details = $this->show($data['email']);
        $http = new Client();

        $response = $http->post($this->accessUrl,['form_params' =>
        [
            'grant_type' => $this->grantType,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $data['email'],
            'password' => $data['password'],
            'scope' => '*'

        ]
        ]);

        $object =  json_decode((string) $response->getBody(), true);

        return ['oauth' => $object , 'user' => $details];

   }

    public function ouathSocialResposne(array $data)
    {
        $details = $this->show($data['email']);
        $http = new Client();

        $response = $http->post($this->accessUrl,['form_params' =>
            [
                'grant_type' => $this->grantType,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'username' => $data['email'],
                'password' => $data['social_id'] ,
                'scope' => '*'

            ]
        ]);

        $object =  json_decode((string) $response->getBody(), true);

        return ['oauth' => $object , 'user' => $details];


    }


}