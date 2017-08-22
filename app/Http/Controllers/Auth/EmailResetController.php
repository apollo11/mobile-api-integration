<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Traits\HttpResponse;
use Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class EmailResetController extends Controller
{
    use HttpResponse;

    /**
     * EmailResetController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmailControl(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, $this->validateEmail());
        $checkSocialAccount = $this->show($data['email']);
        $checkAccount = !empty($checkSocialAccount['social_google_id']) || !empty($checkSocialAccount['social_fb_id']);

        if ($validator->fails()) {

            return $this->errorResponse($validator->errors()->all(), 'Validation Error', 110001, 400);


        } else if ($checkAccount) {

            return $this->errorResponse(['Email not found in record'], 'Invalid email', 110001, 400);

        } else {

            // We will send the password reset link to this user. Once we have attempted
            // to send the link, we will examine the response then see the message we
            // need to show to the user. Finally, we'll send out a proper response.
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );

            return $response == Password::RESET_LINK_SENT
                ? $this->sendResetLinkResponse($response)
                : $this->sendResetLinkFailedResponse($request, $response);

        }

    }

    public function show($email)
    {
        $user = new User();
        $account = $user::where('email', $email)
            ->first();

        return $account;

    }


    /**
     * @return array
     */
    protected function validateEmail()
    {
        $validate = [
            'email' => 'required|email',
        ];

        return $validate;

    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return $this->ValidUseSuccessResp(200, true);
        //return $response()->json(['status' => $response]);
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request
     * @param  string $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return $this->errorResponse(['Email not registered.'], 'Password failed to reset.', 110006, 400);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
}
