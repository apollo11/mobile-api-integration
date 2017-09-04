<?php
namespace App\Http\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait OauthTrait
{
    protected $accessUrl;
    protected $grantType = 'password';


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

    /**
     * @param $mobile
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function getUserByMobile($mobile)
    {
        $details = \App\User::where('mobile_no', $mobile)
            ->first();

        return $details;
    }

    public function ouathResponse(array $data)
    {
        $details = $this->getUserNric($data['nric_no']);
        $http = new Client();

        try {
            $response = $http->post($this->endpoint(),['form_params' =>
                [
                    'grant_type' => $this->grantType,
                    'client_id' => $data['client_id'],
                    'client_secret' => $data['client_secret'],
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
                    'client_id' => $data['client_id'],
                    'client_secret' => $data['client_secret'],
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

    public function ouathSocialFbResponse(array $data)
    {
        $details = $this->show($data['email']);
        $socialUniqueId = $data['social_fb_id'];

        $http = new Client();
        try {
            $response = $http->post($this->endpoint(),['form_params' =>
                [
                    'grant_type' => $this->grantType,
                    'client_id' => $data['client_id'],
                    'client_secret' => $data['client_secret'],
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


    public function ouathSocialGoogleResponse(array $data)
    {
        $details = $this->show($data['email']);
        $socialUniqueId = $data['social_google_id'];

        $http = new Client();
        try {
            $response = $http->post($this->endpoint(),['form_params' =>
                [
                    'grant_type' => $this->grantType,
                    'client_id' => $data['client_id'],
                    'client_secret' => $data['client_secret'],
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

    public function mobileOauthResponse(array $data)
    {

        $details = $this->getUserByMobile($data['mobile_no']);
        $http = new Client();

        try {
            $response = $http->post($this->endpoint(),['form_params' =>
                [
                    'grant_type' => 'client_credentials',
                    'client_id' => $data['client_id'],
                    'client_secret' => $data['client_secret'],
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