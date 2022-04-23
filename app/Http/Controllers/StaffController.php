<?php

namespace App\Http\Controllers;

use App\Interfaces\IUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{
    protected $user, $current_date;

    public function __construct(IUser $user)
    {
        $this->user = $user;
        $this->current_date = Carbon::now();
    }

    public function index()
    {
        $recent_deposit = DB::table('money_transfers')->limit(5)->get();
        $recent_bills = DB::table('billings')
                            ->join('bill_types', 'billings.billType', '=', 'bill_types.id')
                            ->select('billings.email', 'billings.ac_name','billings.ac_number','billings.depositor_name','billings.amount', 'bill_types.bill_name', 'billings.created_at')
                            ->limit(5)->get();

      
       
        return view('StaffDashboard.index', [
            'deposits'=> $recent_deposit,
            'bills'=> $recent_bills
        ]);
    }

    public function addStaffForm()
    {
        return view('StaffDashboard.addStaff');
    }

    public function depositForm()
    {
        $currencies = DB::table('currencies')->select('id', 'currency_name')->get();
        return view('StaffDashboard.deposit', [
            'currencies'=> $currencies
        ]);
    }

    public function createStaff(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'first_name'=> 'required|string',
            'last_name'=> 'required|string',
            'email'=> 'required|email|unique:users,email',
            'address'=> 'required|string',
            'phone'=> 'required|numeric',
            'privilege'=> 'required|integer'
        ]);

        if($validate->fails()){
            return $this->sendBadRequestResponse($validate->errors()->first());
        }

        DB::beginTransaction();

        try {
            $data = [
                'first_name' => $request->get('first_name'),
                'last_name' => $request->get('last_name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'password' => bcrypt('123456'),
                'access_type' => $request->get('privilege'),
                'uuid' => rand(1000, 9999),
            ];


            $create = $this->user->create($data);

            $this->user->createStaff([
                'uuid' => rand(1000, 9999),
                'user_id'=> $create,
                'first_name'=> $request->get('first_name'),
                'last_name'=> $request->get('last_name'),
                // 'email'=> $request->get('email'),
                'phone'=> $request->get('phone'),
                'address'=> $request->get('address'),
                'created_at'=> $this->current_date,
                'access_type' => $request->get('privilege'),

            ]);

            DB::commit();

        } catch (\Exception $ex) {

            return $this->sendBadRequestResponse($ex->getMessage());
        }

        return $this->sendSuccessResponse('Staff created successfully');
        
    }

    public function staffsView()
    {
        return view('StaffDashboard.viewstaffs');
    }

    public function all_staff()
    {
        $staff = DB::table('users')
                            ->join('staffs', 'users.id', '=', 'staffs.user_id')
                            ->where('users.id','!=', Auth::user()->id)
                            ->select(
                                'users.id',
                                'users.first_name',
                                'users.last_name',
                                'users.email',
                                'staffs.phone as phone',
                                'users.status',
                                'users.access_type',
                                'staffs.address'
                            )
                            ->orderByDesc('id')
                            ->get();
        
        return $this->sendSuccessResponse('', $staff);
    }

    public function disable()
    {
        $user_id = request()->user_id;
        
        $user = $this->user->findItem(['id'=> $user_id]);

        if(is_null($user)){
            return $this->sendBadRequestResponse('User not found');
        }

        if($user->status == 1){
            
            $this->user->updateItem(['id'=> $user->id], [
                'status'=> 0
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

    public function transfer_money(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_name'=> 'required|string',
            // 'sender_account_number'=> 'required|numeric',
            'receiver_account_number'=> 'required|numeric',
            'depositor_name'=> 'required|string',
            'amount'=> 'required|numeric',
            'currency'=> 'required|integer'
            
        ]);

        if($validator->fails()){
            return $this->sendBadRequestResponse("Validation Error - {$validator->errors()->first()}");
        }

        $staff = Auth::user();

        // // if both account number is exist
        // $send_account = $this->user->account_detail($request->get('sender_account_number'));

        // if(is_null($send_account)){
        //     return $this->sendBadRequestResponse("Sender Account number does not exist");
        // }

        $reciever_account = $this->user->account_detail($request->get('receiver_account_number'));

        if(is_null($reciever_account)){
            return $this->sendBadRequestResponse("Account number for reciever not found");
        }

        // if ($request->get('amount') > $send_account->account_balance) {
        //     return $this->sendBadRequestResponse("Insufficient balance");
        // }

        DB::beginTransaction();

        try {
            DB::table('money_transfers')->insert([
                'staff_id'=> $staff->id,
                'account_name'=> $request->get('account_name'),
                'sender_account_number'=> $request->get('sender_account_number'),
                'receiver_account_number'=> $request->get('receiver_account_number'),
                'depositor_name'=> $request->get('depositor_name'),
                'amount'=> $request->get('amount')
            ]);

        
            //deduct money
          // $deduct_balance =  $this->deductBalance($request->get('amount'), $send_account->account_balance, $send_account->id);

            //store transaction
        //    $tran_sender_id =  DB::table('transactions')->insertGetId([
        //         'user_id' => $send_account->user_id,
        //         'account_name' => $request->get('account_name'),
        //         'account_number' => $request->get('receiver_account_number'),
        //         'account_type' => $reciever_account->account_type,
        //         'depositor_name' => $request->get('depositor_name'),
        //         'amount' => $request->get('amount'),
        //         'currency' => $request->get('currency'),
        //         'phone_number' => $send_account->contact,
        //         'transfer_type' => $request->get('transfer_type') ?? 0,
        //         'transfer_option' => $request->get('transfer_option') ?? 0,
        //         'month' => $this->current_date->format('F'),
        //         'year' => $this->current_date->format('Y'),

        //     ]);

            // DB::table('transaction_ledger')->insert([
            //     'user_id' => $send_account->user_id,
            //     'tran_id' => $tran_sender_id,
            //     'tran_type' => 2,
            //     'balance' => $deduct_balance
            // ]);


            $update_balance = $this->updateBalance($request->get('amount'), $reciever_account->account_balance, $reciever_account->id);

            $tran_reciever_id =  DB::table('transactions')->insertGetId([
                'user_id' => $reciever_account->user_id,
                'account_name' => $request->get('depositor_name'),
                'account_number' => $reciever_account->account_number,
                'account_type' => $reciever_account->account_type,
                'depositor_name' => $request->get('depositor_name'),
                'amount' => $request->get('amount'),
                'currency' => $request->get('currency'),
                'phone_number' => $reciever_account->contact,
                'transfer_type' => $request->get('transfer_type') ?? 0,
                'transfer_option' => $request->get('transfer_option') ?? 0,
                'month' => $this->current_date->format('F'),
                'year' => $this->current_date->format('Y'),
                'status'=> 1

            ]);

            DB::table('transaction_ledger')->insert([
                'user_id' => $reciever_account->user_id,
                'tran_id' => $tran_reciever_id,
                'tran_type' => 1,
                'balance' => $update_balance,
                'currency'=> $request->get('currency')
            ]);


            DB::commit();

        } catch (\Exception $ex) {

            DB::rollBack();
            return $this->sendBadRequestResponse($ex->getMessage());

            
        }

        // if($deduct_balance){
        //     //send mail to sender
          
        // }

        // if($update_balance){
        //     //send mail to reciever
        // }

        return $this->sendSuccessResponse('Transaction successfully done');
    }


    private function deductBalance($amount, $prev_bal, $id)
    {
        $newbalance = $prev_bal - $amount;

        DB::table('customer_details')->where('id', $id)->update([
            'account_balance' => $newbalance
        ]);

        return $newbalance;
    }


    private function updateBalance($amount, $prev_bal, $id)
    {
        $newbalance = $prev_bal + $amount;

        DB::table('customer_details')->where('id', $id)->update([
            'account_balance' => $newbalance
        ]);

        return $newbalance;

       
    }

    
}
