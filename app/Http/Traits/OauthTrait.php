<?php
namespace App\Http\Traits;

use GuzzleHttp\Client;

trait OauthTrait
{
    protected $accessUrl = 'http://yyjobs.local/oauth/token';
    protected $grantType = 'password';
    protected $clientId = '1';
    protected $clientSecret = 'NlAGjQ2GRQsvmvRwyJYtw1yV17VUw6Me3VZON0ol';

    public function ouathResposne(array $data)
    {
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

        return json_decode((string) $response->getBody(), true);
   }

    public function ouathSocialResposne(array $data)
    {
        $socialUniqueId = !$data['social_google_id'] ? $data['social_fb_id'] : $data['social_google_id'];
        $http = new Client();

        $response = $http->post($this->accessUrl,['form_params' =>
            [
                'grant_type' => $this->grantType,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'username' => $data['email'],
                'password' => $socialUniqueId ,
                'scope' => '*'

            ]
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    public function ValidUseSuccessResp()
    {
        $output = [
            "status_code" => 200,
            "success" => true,
        ];

        return response($output)->header('status', 200);


    }




}