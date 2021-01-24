<?php

namespace App\Http\Controllers;

use App\Interfaces\IUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    protected $user, $current_date;

    public function __construct(IUser $user)
    {
        $this->user = $user;
        $this->current_date = Carbon::now();
    }

    public function index()
    {
        $account_types = DB::table('account_types')->where('status', 1)->select('id', 'name')->get();
        $verification_id = DB::table('verification_ids')->where('status', 1)->select('id', 'id_name')->get();
        return view('addCustomer', [
            'account_types'=> $account_types,
            'verfication_id'=>  $verification_id
        ]);
    }

    public function customerviews()
    {
        return view('viewCustomer');
    }

    public function addCustomer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'=> 'required|string',
            'last_name'=> 'required|string',
            'email'=> 'required|email|unique:users,email',
            'contact'=> 'required|numeric',
            'address'=> 'required',
            'dateOfbirth'=> 'required',
            'occupation'=> 'required',
            'other_name'=> 'required|string',
            'maiden_name'=> 'required|string',
            'contact'=> 'required|numeric',
            'alt_contact'=> 'nullable|numeric',
            'personal_id'=> 'required',
            'gender'=> 'required|integer',
            'account_type'=> 'required|integer',
            'valid_date'=> 'required'
        ]);

        if($validator->fails()){
            return $this->sendBadRequestResponse($validator->errors()->first());
        }

       

        DB::beginTransaction();

        try {
            $create = $this->user->create([
                'uuid' => rand(1000, 9999),
                'password' => bcrypt(12345),
                'first_name'=> $request->get('first_name'),
                'last_name'=> $request->get('last_name'),
                'email'=> $request->get('email'),
                'phone'=> $request->get('contact'),
            ]);

            $this->user->createCustomer([
                'user_id'=> $create,
                'account_number' => rand(1000000000, 9999999999),
                'account_type' => $request->get('account_type'),
                'account_balance' => 0.00,
                'address' => $request->get('address'),
                'DOB' => $request->get('dateOfbirth'),
                'occupation' => $request->get('occupation'),
                'other_name' => $request->get('other_name'),
                'maiden_name' => $request->get('maiden_name'),
                'contact' => $request->get('contact'),
                'alt_contact' => $request->get('alt_contact') ?? '',
                'personal_id' => $request->get('personal_id'),
                'valid_date' => Carbon::parse($request->get('valid_date')),
                'gender' => $request->get('gender')
            ]);

            DB::commit();

        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->sendBadRequestResponse('Invalid request');
        }

        return $this->sendSuccessResponse('Customer Created Successfully');
    }

    public function all_customers()
    {
        $staff = DB::table('users')
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
                        ->get();

        return $this->sendSuccessResponse('', $staff);
    }

    public function disable()
    {
        $user_id = request()->user_id;

        $user = $this->user->findItem(['id' => $user_id]);

        if (is_null($user)) {
            return $this->sendBadRequestResponse('User not found');
        }

        if ($user->status == 1) {

            $this->user->updateItem(['id' => $user->id], [
                'status' => 0
            ]);

            return $this->sendSuccessResponse("{$user->first_name} disabled successfully");
        }
    }

    public function enable()
    {
        $user_id = request()->user_id;

        $user = $this->user->findItem(['id' => $user_id]);

        if (is_null($user)) {
            return $this->sendBadRequestResponse('User not found');
        }

        if ($user->status == 0) {

            $this->user->updateItem(['id' => $user->id], [
                'status' => 1
            ]);

            return $this->sendSuccessResponse("{$user->first_name} enabled successfully");
        }
    }


    public function customer_details($id)
    {
        $customer = DB::table('users')
                            ->join('customer_details', 'users.id', '=', 'customer_details.user_id')
                            ->join('account_types', 'customer_details.account_type', '=', 'account_types.id')
                            ->where('users.id', $id)
                            ->select('users.*', 'customer_details.*', 'account_types.name')
                            ->first();
       // dd($customer);

        $account_types = DB::table('account_types')->where('status', 1)->select('id', 'name')->get();
        $verification_id = DB::table('verification_ids')->where('status', 1)->select('id', 'id_name')->get();

        return view('customer_details', [
            'customer'=> $customer,
            'account_types' => $account_types,
            'verfication_id' =>  $verification_id
        ]);
    }

    public function update_profile(Request $request, $id)
    {
        //dd($request->all());
       
        $validator = Validator::make($request->all(), [
            'first_name'=> 'required|string',
            'last_name'=> 'required|string',
            'email'=> "nullable|email",
            'contact' => 'required|numeric',
            'address' => 'required',
            'dateOfbirth' => 'required',
            'occupation' => 'required',
            'other_name' => 'required|string',
            'maiden_name' => 'required|string',
            'contact' => 'required|numeric',
            'alt_contact' => 'nullable|numeric',
            'personal_id' => 'required',
            'gender' => 'required|integer',
            'account_type' => 'required|integer',
            'valid_date' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendBadRequestResponse($validator->errors()->first());
        }

        DB::beginTransaction();

        try {
             $this->user->updateItem(['id'=> $id],[
               
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'email' => $request->get('email'),
                'phone' => $request->get('contact'),
            ]);

            DB::table('customer_details')->where('id', $id)->update([
               
                'account_type' => $request->get('account_type'),
              
                'address' => $request->get('address'),
                'DOB' => $request->get('dateOfbirth'),
                'occupation' => $request->get('occupation'),
                'other_name' => $request->get('other_name'),
                'maiden_name' => $request->get('maiden_name'),
                'contact' => $request->get('contact'),
                'alt_contact' => $request->get('alt_contact') ?? '',
                'personal_id' => $request->get('personal_id'),
                'valid_date' => Carbon::parse($request->get('valid_date')),
                'gender' => $request->get('gender')
            ]);
           

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->sendBadRequestResponse('Invalid request');
        }

        return $this->sendSuccessResponse("Customer update successfully");
    }

    
}
