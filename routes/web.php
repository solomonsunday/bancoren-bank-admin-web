<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::group(['middleware'=> 'guest'], function(){

    Route::get('/', 'Auth\LoginController@loginForm')->name('login');
    Route::post("/login", 'Auth\LoginController@login')->name('signin');

});


Route::group(['middleware'=> 'auth'], function() {

    Route::get('/dashboard/index', 'DashboardController@Adminindex')->name('admin.home'); //admin user
    Route::get('/dashboard/staff', 'StaffController@index')->name('staff.home'); //staff user


    Route::get('/dashboard/create-customer', 'CustomerController@index')->name('create.customer');
    Route::get('/dashboard/add-staff', 'StaffController@addStaffForm')->name('add.staff');
    Route::get('/dashboard/deposit-money', 'StaffController@depositForm')->name('make.deposit');
    Route::get('/dashboard/request', 'DashboardController@allRequest')->name('all.request');
    Route::get('/dashboard/made-requests', 'DashboardController@madeRequests')->name('made.requests');

    Route::post('/request/approve', 'DashboardController@approve_request')->name('request.approve');


    Route::get('/dashboard/profile', 'UserController@profile')->name('profile');
    Route::post('/dashboard/update-profile/{id}', 'UserController@updateProfile')->name('update.profile');

    Route::get('/dashboard/change-password', 'UserController@changePasswordForm')->name('change.password');
    Route::post('/dashboard/password-change', 'UserController@new_password')->name('new.password');

    Route::post('/dashboard/create-staff', 'StaffController@createStaff')->name('create.staff');
    Route::post('/dashboard/disable-staff', 'StaffController@disable')->name('staff.disable');
    Route::post('/dashboard/enable-staff', 'StaffController@enable')->name('staff.enable');

    Route::get('/dashboard/view-staff', 'StaffController@staffsView')->name('view.staff');
    Route::get('/dashboard/all-staffs', 'StaffController@all_staff')->name('all.staffs');

    Route::get('/dashboard/view-customer', 'CustomerController@customerviews')->name('view.customers');
    Route::get('/dashboard/all-customers', 'CustomerController@all_customers')->name('all.customers');


    Route::post('/dashboard/add-customer', 'CustomerController@addCustomer')->name('add.customer');
    Route::post('/dashboard/disable-customer', 'CustomerController@disable')->name('customer.disable');
    Route::post('/dashboard/enable-customer', 'CustomerController@enable')->name('customer.enable');

    Route::get('/dashboard/customer-details/{id}', 'CustomerController@customer_details')->name('customer.details');
    Route::post('/dashboard/customer-update/{id}', 'CustomerController@update_profile')->name('customer.update');
    
    Route::get('/dashboard/pay-bills', 'PaymentController@billpaymentForm')->name('pay.bills');
    Route::post('/dashboard/make-payment', 'PaymentController@payBill')->name('bills.payment');

    Route::post('/dashboard/make-deposit', 'StaffController@transfer_money')->name('deposit');
    
    
    

    Route::get('/logout', 'DashboardController@Logout')->name('logout');

});



