<?php

namespace App\Http\Controllers;

use App\Interfaces\IUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    protected $user;
    
    public function __construct(IUser $user)
    {
        $this->user = $user;
    }

    public function profile()
    {
        
        return view('profile');
    }

    public function updateProfile(Request $request, $id)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'first_name'=> 'required|string',
            'last_name'=> 'required|string',
            'email'=> "required|email|unique:users,email,{$id}",
            'phone'=> 'required|numeric'
        ]);

        if($validator->fails()){
            return $this->sendBadRequestResponse($validator->errors()->first());
        }

        $update = $this->user->updateItem(['id'=> $id], [
            'first_name'=> $request->get('first_name'),
            'last_name'=> $request->get('last_name'),
            'email'=> $request->get('email'),
        ]);

        DB::table('customer_details')->where('id', $id)->update([
            'contact'=> $request->get('phone')
        ]);

        if($update == 0){
            return $this->sendBadRequestResponse('Invaild Request');
        }

        return $this->sendSuccessResponse("Profile updated successfully");
    }


    public function changePasswordForm()
    {
        return view('Auth.change_password');
    }

    public function new_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password'=> 'required',
            'password'=> 'required|min:6|confirmed'
        ]);

        if($validator->fails()){
            return $this->sendBadRequestResponse($validator->errors()->first());
        }

        $user = Auth::user();

        if (!Hash::check($request->get('old_password'), $user->password)) {
            return $this->sendBadRequestResponse('Current Password does not match');
        }

        $update = $this->user->updateItem(['id' => $user->id], [
            'password' => bcrypt($request->get('password'))
        ]);

        if (!$update) {
            return $this->sendBadRequestResponse('Invalid request sent');
        }

        Auth::logout();

        return $this->sendSuccessResponse("Password changed successfully",'');
    }

}
