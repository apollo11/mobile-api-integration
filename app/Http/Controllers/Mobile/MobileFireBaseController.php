<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Traits\OauthTrait;
use App\Http\Traits\HttpResponse;
use App\User;
use Illuminate\Support\Facades\Crypt;
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
            'mobile_no' => $value['mobile_no']
        ];

        return $data;
    }

    public function fireBaseValidation(Request $request)
    {
        $data = $this->userData($request->all());

        $user = new User();
        $userDetails = $user->getUserDetailsByMobileNo($data['mobile_no']);
        $getMobileNo = $this->setMobileNo($userDetails);
        $decrypt = decrypt($getMobileNo['password']);

        return $decrypt; //$this->ouathResponse($getMobileNo);



//        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/firebase_credentials.json');
//
//
//
//        $firebase = (new Factory)
//            ->withServiceAccount($serviceAccount)
//            ->create();

//        try {
//
//            $tokenHandler = $firebase->getTokenHandler();
//            $idToken = $tokenHandler->verifyIdToken($data['firebase_token']);
//            $uid = $idToken->getClaim('sub');
//
//            if ($getMobileNo && $uid) {
//
//                return $uid = $idToken->getClaim('sub');
//
//            } else {
//
//                return $this->ValidUseSuccessResp(400, false);
//
//            }
//
//        } catch (\Firebase\Auth\Token\Exception\ExpiredToken $e) {
//
//            return response()->json(['expired' => $e->getMessage()]);
//
//        } catch (\Firebase\Auth\Token\Exception\IssuedInTheFuture $e) {
//
//            return response()->json(['future_error' => $e->getMessage()]);
//
//        } catch (\Firebase\Auth\Token\Exception\InvalidToken $e) {
//
//            return response()->json(['invalid_token' => $e->getMessage()]);
//        }

    }

    public function getMobileNo($mobileNo)
    {

        $user = new User();
        $userDetails = $user->getUserDetailsByMobileNo($mobileNo);

        return $userDetails;
    }

    public function testDecrypt()
    {
        $encrypted = Crypt::encryptString('Hello World');

        $decrypted = Crypt::decryptString($encrypted);

        return $decrypted;

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
