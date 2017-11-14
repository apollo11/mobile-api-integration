<?php

namespace App\Http\Controllers\MyProfile;

use Validator;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    public function index(){
    /*	$settings = new Settings();
    	$allsettings = $settings->allSettings();*/
        // $user = Auth::user();
        // print_r($user);
        $user = User::find( Auth::user()->id );
        // $user = $userModel->getUserDetails(Auth::user()->);
        // print_r($user);
    	return view('myprofile.index',['user'=>$user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
    	$data = $request->all();
        $id = Auth::user()->id;
        
        $validator = $this->updateRules($data,$id);

        if ($validator->fails()) {
            return redirect(route('myprofile'))
                ->withErrors($validator)
                ->withInput();
        } else {
            $employer = \App\User::find($id);
            $old_email = $employer->email;

            if ($request->hasFile('user_profile_image')) {
                $profileimage['user_profile_image'] = $request->file('user_profile_image')->store('avatars');
                $merge = array_merge($data, $profileimage);
                $employer->profile_image_path = $merge['user_profile_image'];
            }else{
                $merge = $data;
            }
            
            if($employer->role == 'employer'){ 
                $employer->company_name = $merge['name'];    
            }else{
                $employer->name = $merge['name'];
            }
            $employer->email = $merge['email'];

            if(!empty($merge['password'])){
                $employer->password = bcrypt($merge['password']);
            }

            $employer->save();

            return redirect()->back()->with('message', 'Updated successfully.');
        }
    }

    /**
     * Update validation Rules
     */
    public function updateRules(array $data, $id)
    {
        return Validator::make($data, [
            'name' => 'required|string',
            'email' => 'email|required|string|email|max:255|unique:users,email,'.$id
        ]);

    }
}
