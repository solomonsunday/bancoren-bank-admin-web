<?php

namespace App\Repos;

use App\Interfaces\IUser;
use App\Repos\Base;
use Illuminate\Support\Facades\DB;

class User extends Base implements IUser
{

    public function __construct($tablename ="users")
    {
        parent::__construct($tablename);
    }

    public function user_requests()
    {
        return DB::table('requests')
                        ->leftJoin('request_types', 'requests.request_type', '=', 'request_types.id')
                        ->select(
                            'requests.id',
                            'requests.user_details',
                            'requests.phone',
                            'requests.email',
                            'request_types.request_name',
                            'requests.status',
                            'requests.created_at'
                        )
                        ->orderByDesc('requests.id')
                        ->get();
    }

    public function approve_request($id)
    {
        return DB::table('requests')
                    ->where('id', $id)
                    ->update([
                        'status'=> 1
                    ]);
    }

    public function createStaff(array $data)
    {
        return DB::table('staffs')->insert($data);
    }

    public function createCustomer(array $data)
    {
        return DB::table('customer_details')->insert($data);
    }

    public function user_ac_balance(int $user_id)
    {
        return DB::table("customer_details")->where('user_id', $user_id)->value('account_balance');
    }

    public function account_detail($account_number)
    {
        return DB::table('customer_details')->where('account_number', $account_number)->first();
    }
}