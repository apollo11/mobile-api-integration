<?php

namespace App\Http\Controllers\Mobile;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use App\Http\Traits\OauthTrait;
use App\Http\Traits\HttpResponse;
use Validator;
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

                return $this->errorResponse(['Mobile number not found'],'Invalid Credentials', 110007, 401);
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

    /**
     * Validation rules
     */

    public function rules()
    {
       $validate = [
           'mobile_no' => 'required|unique:users'
       ];

       return $validate;
    }

    /**
     * Instantiate Validator
     */
    public function validator($data)
    {
        $validator = Validator::make($data, $this->rules());

        return $validator;

    }

    /**
     * Validate mobile No
     */

    public function validateMobile(Request $request)
    {
        $data = $request->all();
        $validate = $this->validator($data);

        $errorMsg  = $validate->errors()->all();

        if($validate->fails()) {

            return $this->ValidUseSuccessResp(200, true);

        } else {

            return $this->mapValidator($errorMsg);

        }

    }

    public function mapValidator()
    {
        return $this->errorResponse(['Mobile number not found'], 'Validation Error',110001,400 );

    }

}
