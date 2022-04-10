<?php

namespace App\Http\Controllers;

use App\Interfaces\IUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PaymentController extends Controller
{
    protected $user;

    public function __construct(IUser $user)
    {
        $this->user = $user;
    }

    public function billpaymentForm()
    {
        $bill_types = DB::table('bill_types')->select('id','bill_name')->get();
        return view('StaffDashboard.bill_payment', ['bills'=> $bill_types]);
    }

    public function payBill(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            'account_number'=> 'required|numeric',
            'name'=> 'required|string',
            'email'=> 'required|email',
            'amount'=> 'required|numeric',
            'bill_type'=> 'required|integer'
        ]);


        if($validator->fails()){
            return $this->sendBadRequestResponse("Validation Error - {$validator->errors()->first()}");
        }

      
        $check_ac = DB::table('customer_details')->where('account_number', $request->get('account_number'))->first();

       

        if(is_null($check_ac)){
            return $this->sendBadRequestResponse('Invalid account number');
        }

       
        $get_user = $this->user->findItem(['id'=>$check_ac->user_id]);

        if($get_user->status == 0){
            return $this->sendBadRequestResponse('Account not active');
        }

        if($request->get('amount') > $check_ac->account_balance){
            return $this->sendBadRequestResponse("Insufficient balance");
        }

        DB::beginTransaction();

            DB::table('billings')->insert([
                'user_id' => Auth::user()->id,
                'email' => $request->get('email'),
                'ac_number' => $request->get('account_number'),
                'depositor_name' => $request->get('name'),
                'amount' => $request->get('amount'),
                'billType' => $request->get('bill_type'),
                'created_at'=> Carbon::now()
            ]);

            $this->deductBalance($request->get('amount'), $check_ac->account_balance, $get_user->id);

            DB::commit();

        try {
           
        } catch (\Exception $ex) {
            DB::rollBack();

            return $this->sendBadRequestResponse($ex->getMessage());

        }


        return $this->sendSuccessResponse("Bill Paid successfully");
    }

   
        private function deductBalance($amount, $prev_amount, $id)
        {
            $newbalance = $prev_amount - $amount;
            
            DB::table('customer_details')->where('user_id', $id)->update([
                'account_balance'=> $newbalance
            ]);

            return true;
        }

   
}
