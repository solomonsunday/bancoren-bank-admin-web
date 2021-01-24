<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Interfaces\IUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected $user;

    public function __construct(IUser $user)
    {
        $this->user = $user;
    }

    public function loginForm()
    {
        return view('Auth.Login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=> 'required|email',
            'password'=> 'required'
        ]);

        if($validator->fails()){
            return $this->sendBadRequestResponse($validator->errors());
        }

      

        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
        
           $user = User::where('email', $request->get('email'))->first();

          
            if ($user->access_type == 1) {
                $intended_url = Redirect::intended("dashboard/index")->getTargetUrl();
                
            } elseif ($user->access_type == 2) {
                $intended_url = Redirect::intended("dashboard/staff")->getTargetUrl();
            } else {
                return $this->sendUnAuthorisedResponse();
            }
           
           Auth::login($user);
           return $this->sendSuccessResponse("Login Success", [
                "intended_url"=> $intended_url
           ]);
           
        }else{
            return $this->sendBadRequestResponse('Invalid credentials');
        }
    }

    
}
