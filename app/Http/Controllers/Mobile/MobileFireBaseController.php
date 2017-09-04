<?php

namespace App\Http\Controllers\Mobile;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use App\Http\Traits\OauthTrait;
use App\Http\Traits\HttpResponse;
use App\User;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class MobileFireBaseController extends Controller
{
    use OauthTrait;
    use HttpResponse;

    public function userData(array $value)
    {
        $data = [
           'firebase_token' => $value['firebase_token'],
            'mobile_no' => $value['mobile_no'],
            'client_id' => $value['client_id'],
            'client_secret' => $value['client_secret'],
        ];

        return $data;
    }

    public function fireBaseValidation(Request $request)
    {
        $data = $this->userData($request->all());

        $user = new User();
        $userDetails = $user->getUserDetailsByMobileNo($data['mobile_no']);
        $getMobileNo = $this->setMobileNo($userDetails);

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/firebase_credentials.json');

        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();

        try {

            $tokenHandler = $firebase->getTokenHandler();
            $idToken = $tokenHandler->verifyIdToken($data['firebase_token']);
            $uid = $idToken->getClaim('sub');

            if ($getMobileNo && $uid) {

                return  $this->mobileOauthResponse($data);

            } else {

                return $this->ValidUseSuccessResp(400, false);

            }

        } catch (\Firebase\Auth\Token\Exception\ExpiredToken $e) {

            return response()->json(['expired' => $e->getMessage()]);

        } catch (\Firebase\Auth\Token\Exception\IssuedInTheFuture $e) {

            return response()->json(['future_error' => $e->getMessage()]);

        } catch (\Firebase\Auth\Token\Exception\InvalidToken $e) {

            return response()->json(['invalid_token' => $e->getMessage()]);
        }

    }

    public function getMobileNo($mobileNo)
    {

        $user = new User();
        $userDetails = $user->getUserDetailsByMobileNo($mobileNo);

        return $userDetails;
    }

    public function setMobileNo($data)
    {
        foreach ($data as $value => $user)
        {
            $output = [ 'mobile_no' => $user->mobile_no
                        , 'password' => $user->password
                        , 'email' => $user->password
                        , 'nric_no' => $user->nric_no
            ];

        }

        return !isset($output) ? '': (array) $output;
    }

}
