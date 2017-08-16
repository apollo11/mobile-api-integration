<?php

namespace App\Http\Controllers\Social;

use App\Http\Traits\HttpRequest;
use App\Http\Traits\OauthTrait;
use Validator;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialController extends Controller
{
    use OauthTrait;
    use HttpRequest;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validate = $this->validator($data);
        $errorMsg  = $validate->errors()->all();

        if($validate->fails()) {

            return $this->mapValidator($errorMsg);

        } else {
            return $this->execution($data);
        }
    }

    /**
     * This are the data which needed to stored
     * @param array $data
     */

    public function userData(array $data)
    {
        $googleId = $data['social_google_id'] != null ? $data['social_google_id'] : null;
        $fbId = $data['social_fb_id'] != null ? $data['social_fb_id'] : null;
        $school = !empty($data['school']) ? $data['school'] : null;
        $role = 'employer';

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt(!$googleId ? $fbId : $googleId);
        $user->role = $role;
        $user->role_id = 2;
        $user->role = $role;
        $user->platform = $data['platform'];
        $user->mobile_no = $data['mobile_no'];
        $user->nric_no = $data['nric_no'];
        $user->school = $school;
        $user->social_access_token = bcrypt($data['social_access_token']);
        $user->social_fb_id = $googleId;
        $user->social_google_id = $fbId;
        $user->save();
    }

    /**
     * here isthe logic if the
     * @param array $data
     * @return mixed
     */

    public function execution(array $data)
    {
        $fbUser = $this->validateFbUser($data['social_access_token']);
        $googleUser = $this->validateGoogleUser($data['social_access_token']);
        if (!empty($data['social_fb_id'])) {
            if($fbUser['status_code'] == 200) {
                 $this->userData($data);
                 return $this->successResponse($data);

            } else {
                return $this->ValidUseSuccessResp(400, false);
            }
        } else {
            if($googleUser['status_code'] == 200) {
                $this->userData($data);
                return $this->successResponse($data);
            } else {
                return $this->ValidUseSuccessResp(400, false);
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($email)
    {
        $account = \App\User::where('email', $email)
            ->first();

        return $account;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function mapValidator($data)
    {
        foreach ($data as $error) {
            $value[] =  $error;
        }

        $output = ['error'=>
            [
                'title'=> 'Validation Error'
                , 'code' => 110002
                , "status_code" => 400
                , "messages" => $value
            ],
            "success" => false
        ];

        return response($output)->header('status', 400);

    }

    public function socialUserRules()
    {
        $validate = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile_no' => 'required',
            'nric_no' => 'required|string|unique:users',
            'social_fb_id' => 'unique:users',
            'social_google_id' => 'unique:users',
        ];

        return $validate;
    }

    public function socialUserValidate(Request $request)
    {
        $data = $request->all();
        $validate = $this->socialIdValidation($data);

        $validator = Validator::make($validate, $this->socialUserRules());
        $errorMsg  = $validator->errors()->all();

        if($validator->fails()) {

            return $this->mapValidator($errorMsg);

        } else {

            return $this->ValidUseSuccessResp(200, true);

        }

    }

    public function socialIdValidation(array $data)
    {
        $value = [
            'name' => $data['name'],
            'email' => $data['email'],
            'mobile_no' => $data['mobile_no'],
            'nric_no' => $data['nric_no'],
            'social_fb_id' => !empty($data['social_fb_id']) ? $data['social_fb_id'] : 'no id' ,
            'social_google_id' => !empty($data['social_google_id']) ? $data['social_google_id'] : 'no id'
        ];

        return $value;

    }

    /**
     * @return array
     */
    public function rules()
    {
        $validate = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile_no' => 'required',
            'nric_no' => 'required|string|unique:users',

        ];

        return $validate;
    }


    /**
     * @param $data
     * @return mixed
     */

    public function validator($data)
    {
        $validator = Validator::make($data, $this->rules());

        return $validator;

    }

    /**
     * @return mixed
     */

    public function successResponse($data)
    {
        return $this->ouathSocialResposne($data);
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
