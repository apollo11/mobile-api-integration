<?php
namespace App\Http\Traits;

use GuzzleHttp\Client;

trait OauthTrait
{
    protected $accessUrl = 'http://yyjobs.local/oauth/token';

    public function ouathResposne(array $data)
    {
        $http = new Client();

        $response = $http->post($this->accessUrl,['form_params' =>
        [
            'grant_type' => 'password',
            'client_id' => 1,
            'client_secret' => 'V9D1qNxo4SB50AXFnbUnQ1sAKVZfoFo7iaH6vEEr',
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
                'grant_type' => 'password',
                'client_id' => 1,
                'client_secret' => 'V9D1qNxo4SB50AXFnbUnQ1sAKVZfoFo7iaH6vEEr',
                'username' => $data['email'],
                'password' => $socialUniqueId ,
                'scope' => '*'

            ]
        ]);

        return json_decode((string) $response->getBody(), true);
    }




}