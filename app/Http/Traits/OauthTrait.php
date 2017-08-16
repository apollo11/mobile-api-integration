<?php
namespace App\Http\Traits;

use GuzzleHttp\Client;

trait OauthTrait
{
    protected $accessUrl = 'http://yyjobs.local/oauth/token';
    protected $grantType = 'password';
    protected $clientId = '1';
    protected $clientSecret = 'hFTjAzBmp5MOIy7QpaKklBsFmQ16QkpvYbrhKLoB';

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

    public function ValidUseSuccessResp($status, $success)
    {
        $output = [
            "status_code" => (int) $status,
            "success" => (boolean) $success,
        ];

        return response($output)->header('status', $status);

    }




}