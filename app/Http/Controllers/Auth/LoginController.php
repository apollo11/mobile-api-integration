<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    /**
     * @param $provider
     * @return mixed
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

    }

    /**
     * @param $provider
     */
    public function handleProviderCallBack($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();
        dd($user);
    }
}
