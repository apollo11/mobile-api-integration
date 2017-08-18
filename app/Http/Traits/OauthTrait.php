<?php
namespace App\Http\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait OauthTrait
{
    protected $accessUrl;
    protected $grantType = 'password';
    protected $clientId = '1';
    protected $clientSecret = 'BkAuHnUmw64JvC2AivyFj6umB9wFI9ZXRjrkf2Df';


    /**
     * @return mixed
     */
    public function endpoint()
    {
        return $this->accessUrl = constant('OUATH_ENDPOINT');
    }

    /**
     * @param $nric
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getUserNric($nric)
    {
        $account = \App\User::where('nric_no', $nric)
            ->first();

        return $account;

    }

    public function ouathResponse(array $data)
    {
        $details = $this->getUserNric($data['nric_no']);
        $http = new Client();
        try{
            $response = $http->post($this->endpoint(),['form_params' =>
                [
                    'grant_type' => $this->grantType,
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'username' => $details['email'],
                    'password' => $data['password'],
                    'scope' => '*'
                ]
            ]);

            return [
                'user' => $details
                , 'oauth' =>  json_decode((string) $response->getBody(), true)
            ];

        }catch (RequestException $e) {

            if ($e->hasResponse()) {

                return $this->errorResponse(['Invalid Username or Password'],'Invalid Credentials', 110002, 401);
            }

        }
   }

    public function ouathSociaLoginlResponse(array $data)
    {
        $details = $this->show($data['email']);

        $http = new Client();

        try {
            $response = $http->post($this->endpoint(),['form_params' =>
                [
                    'grant_type' => $this->grantType,
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'username' => $data['email'],
                    'password' => $data['social_id'],
                    'scope' => '*'
                ]
            ]);

            return [
                'user' => $details
                , 'oauth' =>  json_decode((string) $response->getBody(), true)
            ];


        } catch (RequestException $e) {

            if ($e->hasResponse()) {

                return $this->errorResponse(['Invalid Social Account'],'Invalid Credentials', 110003, 401);
            }
        }

    }

    public function ouathSocialResponse(array $data)
    {
        $details = $this->show($data['email']);
        $socialUniqueId = !$data['social_google_id'] ? $data['social_fb_id'] : $data['social_google_id'];

        $http = new Client();
        try {
            $response = $http->post($this->endpoint(),['form_params' =>
                [
                    'grant_type' => $this->grantType,
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'username' => $details['email'],
                    'password' => $socialUniqueId ,
                    'scope' => '*'

                ]
            ]);
            return [
                'user' => $details
                , 'oauth' =>  json_decode((string) $response->getBody(), true)
            ];

        } catch (RequestException $e) {

            if ($e->hasResponse()) {

                return $this->errorResponse(['Invalid Social Account'],'Invalid Credentials', 110004, 401);
            }
        }

    }


}