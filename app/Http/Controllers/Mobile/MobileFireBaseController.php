<?php

namespace App\Http\Controllers\Mobile;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MobileFireBaseController extends Controller
{

    public function checkIfValidToken(Request $request)
    {
        $data = $request->input('access_token');

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/firebase_credentials.json');

        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();

        try {

            $tokenHandler = $firebase->getTokenHandler();
            $idToken = $tokenHandler->verifyIdToken($data);
            $uid = $idToken->getClaim('sub');

            return response()->json(['success', $uid]);

        } catch (\Firebase\Auth\Token\Exception\ExpiredToken $e) {

            return response()->json(['expired' => $e->getMessage()]);

        } catch (\Firebase\Auth\Token\Exception\IssuedInTheFuture $e) {

            return response()->json(['testError' => $e->getMessage()]);

        } catch (\Firebase\Auth\Token\Exception\InvalidToken $e) {

            return response()->json(['invalid_token' => $e->getMessage()]);
        }
    }

}
