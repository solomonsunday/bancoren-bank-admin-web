<?php

namespace App\Http\Controllers;

use App\Interfaces\IUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    protected $user;

    public function __construct(IUser $user)
    {
        $this->user = $user;
    }

    public function Adminindex()
    {
        $total_customer = DB::table('users')->where('access_type', 3)->count();
        $total_staff = DB::table('users')->where('access_type', 2)->count();
        $total_request = DB::table('requests')->count();

        $staffs = DB::table('users')
                            ->join('staffs', 'users.id', '=', 'staffs.user_id')
                            ->where('users.id', '!=', Auth::user()->id)
                            ->select(
                                'users.id',
                                'users.first_name',
                                'users.last_name',
                                'users.email',
                                'users.phone',
                                'users.status',
                                'users.access_type',
                                'staffs.address'
                            )
                            ->orderByDesc('id')
                            ->limit(5)
                            ->get();
          
            
        $customers =  DB::table('users')
                            ->join('customer_details', 'users.id', '=', 'customer_details.user_id')
                            ->join('account_types', 'customer_details.account_type', '=', 'account_types.id')
                            ->where('users.access_type', 3)
                            ->select(
                                'users.id',
                                'users.first_name',
                                'users.last_name',
                                'users.email',
                                'users.phone',
                                'users.status',
                                'customer_details.address',
                                'customer_details.account_number',
                                'customer_details.account_balance',
                                'account_types.name',
                                'customer_details.gender'
                            )
                            ->orderByDesc('id')
                            ->limit(5)
                            ->get();
        return view('AdminDashboard.index', [
            'total_customers'=> $total_customer,
            'total_staffs'=> $total_staff,
            'total_requests'=> $total_request,
            'staffs'=> $staffs,
            'customers'=> $customers
        ]);

        
    }

    public function Staffindex()
    {
        return view('StaffDashboard.index');
    }


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }


    public function allRequest()
    {
        //$requets = $this->user->user_requests();

        //return $this->sendSuccessResponse('success',)
        
        return view('AdminDashboard.request');
    }

    public function madeRequests()
    {
         $requests = $this->user->user_requests();

        return $this->sendSuccessResponse('success',$requests);   
    }

    public function approve_request(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'request_id'=> 'required|integer'
        ]);

        if($validate->fails()){
            return $this->sendBadRequestResponse($validate->errors()->first());
        }

       
        $update = $this->user->approve_request($request->get('request_id'));
       

        if($update == 0){
            return $this->sendBadRequestResponse('Invaild request');
        }

        return $this->sendSuccessResponse('Request Approved successfully');
    }

    
}
