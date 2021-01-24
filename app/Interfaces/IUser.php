<?php

namespace App\Interfaces;

interface IUser extends IBase
{
    public function user_requests();
    public function approve_request($id);
    public function createStaff(array $data);
    public function createCustomer(array $data);
    public function user_ac_balance(int $user_id);
    public function account_detail($account_number);
}