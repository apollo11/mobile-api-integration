<?php
namespace App\Http\Traits;

use GuzzleHttp\Client;

trait OauthTrait
{
    protected $accessUrl = 'http://yyjobs.local/oauth/token';
    protected $grantType = 'password';
    protected $clientId = '1';
    protected $clientSecret = 'SSja2wOoGu1bxAolvwAyHfMCKQJG4skQnE97k2iZ';

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUserNric($nric)
    {
        $account = \App\User::where('nric_no', $nric)
            ->first();

        return $account;

    }

    public function ouathResposne(array $data)
    {
        $details = $this->getUserNric($data['nric_no']);

        $http = new Client();
        $response = $http->post($this->accessUrl,['form_params' =>
        [
            'grant_type' => $this->grantType,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'username' => $details['email'],
            'password' => $data['password'],
            'scope' => '*'
        ]
        ]);

        $object =  json_decode((string) $response->getBody(), true);

        return ['oauth' => $object , 'user' => $details];

   }

    public function ouathSociaLoginlResposne(array $data)
    {
        $details = $this->show($data['email']);
        $http = new Client();

        $response = $http->post($this->accessUrl,['form_params' =>
            [
                'grant_type' => $this->grantType,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'username' => $data['email'],
                'password' => $data['social_id'],
                'scope' => '*'
            ]
        ]);

        $object =  json_decode((string) $response->getBody(), true);

        return ['oauth' => $object , 'user' => $details];


    }

    public function ouathSocialResposne(array $data)
    {
        $details = $this->show($data['email']);
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

        $object =  json_decode((string) $response->getBody(), true);
        return ['oauth' => $object , 'user' => $details];


    }


}