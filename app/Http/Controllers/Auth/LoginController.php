<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Traits\OauthTrait;
use App\Http\Traits\HttpRequest;
use App\Http\Traits\HttpResponse;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    use OauthTrait;
    use HttpRequest;
    use HttpResponse;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function oauthLogin(Request $request)
    {
        $data = $request->all();
        return $this->ouathResponse($data);
    }

    public function show($email)
    {
        $user = new User();
        $account = $user::where('email', $email)
            ->first();

        return $account;

    }

    public function fbUser($fbId)
    {
        $user = new User();
        $account = $user::where('social_fb_id', $fbId)
            ->first();

        return $account;


    }

    public function googleUser($googleId)
    {
        $user = new User();
        $account = $user::where('social_google_id', $googleId)
            ->first();

        return $account;


    }

    public function socialFBLogin(Request $request)
    {
        $data = $request->all();
        $user = $this->fbUser($data['social_fb_id']);
        $fbUser = $this->validateFbUser($data['social_access_token']);
        if (!empty($user['social_fb_id']) || !empty($user)) {
            if ($fbUser['status_code'] == 200) {
                $value = [
                    'social_id' => $user['social_fb_id'],
                    'email' => $user['email']
                ];

                return $this->ouathSociaLoginlResponse($value);

            } else {
                return $this->ValidUseSuccessResp(400, false);
            }
        }else {
            return $this->ValidUseSuccessResp(400, false);
        }
    }

    public function socialGoogleLogin(Request $request)
    {
        $data = $request->all();
        $user = $this->googleUser($data['social_google_id']);
        $googleUser = $this->validateGoogleUser($data['social_access_token']);
        if (!empty($user['social_google_id']) || !empty($user)) {
            if ($googleUser['status_code'] == 200) {
                $value = [
                    'social_id' => $user['social_google_id'],
                    'email' => $user['email']
                ];

                return $this->ouathSociaLoginlResponse($value);

            } else {
                return $this->ValidUseSuccessResp(400, false);
            }
        }else {
            return $this->ValidUseSuccessResp(400, false);
        }
    }

    public function validateFbUser($token)
    {
        return $this->getSocialFbResponse($token);
    }

    public function validateGoogleUser($token)
    {
        return $this->getSocialGoogleResponse($token);
    }


}
