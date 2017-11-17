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
        $user = User::find( Auth::user()->id );
        if(empty($user)){abort(404);}
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
        $employer = \App\User::find($id);
        if(empty($employer)){abort(404);}
        
        $validator = $this->updateRules($data,$id,$employer->role);
        

        if ($validator->fails()) {
            return redirect(route('myprofile'))
                ->withErrors($validator)
                ->withInput();
        } else {
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
                $employer->contact_no = $merge['contact_no'];   
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
    public function updateRules(array $data, $id, $role)
    {
        $validations = [
            'name' => 'required|string',
            'email' => 'email|required|string|email|max:255|unique:users,email,'.$id
        ];

        if($role=='employer'){
            $validations['contact_no'] = 'required|string';
        }

        return Validator::make($data, $validations);

    }
}
