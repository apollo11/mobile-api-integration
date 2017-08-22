<?php

namespace App\Http\Controllers\Social;

use Validator;
use App\User;
use App\Http\Traits\HttpRequest;
use App\Http\Traits\OauthTrait;
use App\Http\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoogleController extends Controller
{
    use OauthTrait;
    use HttpRequest;
    use HttpResponse;

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
        $school = !empty($data['school']) ? $data['school'] : null;
        $role = 'employee';

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($googleId);
        $user->role = $role;
        $user->role_id = 2;
        $user->role = $role;
        $user->platform = $data['platform'];
        $user->mobile_no = $data['mobile_no'];
        $user->nric_no = $data['nric_no'];
        $user->school = $school;
        $user->social_access_token = bcrypt($data['social_access_token']);
        $user->social_google_id = $googleId;

        $user->save();
    }

    /**
     * here isthe logic if the
     * @param array $data
     * @return mixed
     */

    public function execution(array $data)
    {
        $googleUser = $this->validateFbUser($data['social_access_token']);

        if (!empty($data['social_google_id']) && $googleUser['status_code'] == 200) {

            $this->userData($data);

            return $this->successResponse($data);

        } else {
            return $this->ValidUseSuccessResp(400, false);
        }

    }

    /**
     * @param $email
     * @return \Illuminate\Database\Eloquent\Model|null|static
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
        return $this->errorResponse($data, 'Validation Error',110001,400 );

    }

    /**
     * @return array
     */
    public function rules()
    {
        $validate = [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile_no' => 'required|unique:users',
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
        return $this->ouathSocialGoogleResponse($data);
    }

    public function validateFbUser($token)
    {
        return $this->getSocialGoogleResponse($token);
    }
}
