<?php
namespace App\Http\Traits;

use App\DeviceToken as Token;
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
        $deviceToken = $this->getToken($details->id);
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
                , 'notification' => $deviceToken
                , 'oauth' =>  json_decode((string) $response->getBody(), true)
            ];

        }catch (RequestException $e) {

            if ($e->hasResponse()) {

                return $this->errorResponse(['Invalid Username or Password'],'Invalid Credentials', 110002, 401);
            }

        }
   }

    /**
     * @param array $data
     * @return array
     */
    public function ouathSociaLoginlResponse(array $data)
    {
        $details = $this->show($data['email']);
        $deviceToken = $this->getToken($details->id);
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
                , 'notification' => $deviceToken
                , 'oauth' =>  json_decode((string) $response->getBody(), true)
            ];


        } catch (RequestException $e) {

            if ($e->hasResponse()) {

                return $this->errorResponse(['Invalid Social Account'],'Invalid Credentials', 110003, 401);
            }
        }

    }

    /**
     * @param array $data
     * @return array
     */
    public function ouathSocialFbResponse(array $data)
    {
        $details = $this->show($data['email']);
        $socialUniqueId = $data['social_fb_id'];
        $deviceToken = $this->getToken($details->id);

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
                , 'notification' => $deviceToken
                , 'oauth' =>  json_decode((string) $response->getBody(), true)
            ];

        } catch (RequestException $e) {

            if ($e->hasResponse()) {

                return $this->errorResponse(['Invalid Social Account'],'Invalid Credentials', 110004, 401);
            }
        }

    }

    /**
     * @param array $data
     * @return array
     */
    public function ouathSocialGoogleResponse(array $data)
    {
        $details = $this->show($data['email']);
        $socialUniqueId = $data['social_google_id'];
        $deviceToken = $this->getToken($details->id);

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
                , 'notification' => $deviceToken
                , 'oauth' =>  json_decode((string) $response->getBody(), true)
            ];

        } catch (RequestException $e) {

            if ($e->hasResponse()) {

                return $this->errorResponse(['Invalid Social Account'],'Invalid Credentials', 110004, 401);
            }
        }

    }

    /**
     * @param array $data
     * @return array
     */
    public function mobileOauthResponse(array $data)
    {

        $details = $this->getUserByMobile($data['mobile_no']);
        $deviceToken = $this->getToken($details->id);

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
                , 'notification' => $deviceToken
                , 'oauth' =>  json_decode((string) $response->getBody(), true)
            ];

        } catch (RequestException $e) {

            if ($e->hasResponse()) {

                return $this->errorResponse(['Invalid Social Account'],'Invalid Credentials', 110004, 401);
            }
        }

    }

    /**
     * Getting Device Token
     * @param $userId
     * @return mixed
     */
    public function getToken($userId)
    {
        $deviceToken = new Token();
        $result = $deviceToken->getDeviceTokenByUserId($userId);

       return $result;
    }

}