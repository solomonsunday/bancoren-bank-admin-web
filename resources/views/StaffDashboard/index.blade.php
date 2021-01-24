@extends('layouts.app')

@section('main-content')
    
    <div class="container-fluid">
         <h2 class="mt-30 page-title">Dashboard</h2>
         <ol class="breadcrumb mb-30">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        <div class="row">

            <div class="col-xl-12 col-md-12">
                <div class="card card-static-2 mb-30">
                    <div class="card-title-2">
                        <h4>Recent Deposit</h4>
                        <a href="" class="view-btn hover-btn">View All</a> 
                    </div>
                    
                    <div class="card-body-table">
                            <div class="table-responsive">
                                <table class="table ucp-table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Account Name</th>
                                            <th>Sender Account Number</th>
                                            <th>Reciever Account Number</th>
                                            <th>Depositor</th>
                                            <th>Amount</th>
                                            {{-- <th>Phone</th> --}}
                                            <th>Date/Time</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                         @foreach ($deposits as $deposit)
                                        <tr>
                                           
                                                <td>{{$deposit->account_name}}</td>
                                                <td>{{$deposit->sender_account_number}}</td>
                                                <td>{{$deposit->receiver_account_number}}</td>
                                                <td>{{$deposit->depositor_name}}</td>
                                                <td>{{$deposit->amount}}</td>
                                                <td>{{$deposit->created_at}}</td>
                                           
                                        </tr>
                                         @endforeach
                                    </tbody>
                                </table>
                            </div>
                    	</div>
                </div>
            </div>
            

            <div class="col-xl-12 col-md-12">
                <div class="card card-static-2 mb-30">
                    <div class="card-title-2">
                        <h4>Recent Bill Payment</h4>
                        <a href="" class="view-btn hover-btn">View All</a> 
                    </div>
                    
                    <div class="card-body-table">
                            <div class="table-responsive">
                                <table class="table ucp-table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Account no</th>
                                            <th>Bill Type</th>
                                            <th>Amount</th>
                                            <th>Date/Time</th>                                                                                     
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            @foreach ($bills as $bill)
                                                <td>{{$bill->depositor_name}}</td>
                                                <td>{{$bill->ac_number}}</td>
                                                <td>{{$bill->bill_name}}</td>
                                                <td>{{$bill->amount}}</td>
                                                <td>{{$bill->created_at}}</td>

                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    	</div>
                </div>
            </div>


        </div>

    </div>
@endsection