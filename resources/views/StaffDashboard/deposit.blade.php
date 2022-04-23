@extends('layouts.app')

@section('main-content')
    
    <div class="container-fluid">

        <h2 class="mt-30 page-title">Payment</h2>
         <ol class="breadcrumb mb-30">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Staff</a></li>
            <li class="breadcrumb-item active">Deposit</li>
        </ol>

         <div class="row">
               <div class="col-lg-12 col-md-12">
                		<div class="card card-static-2 mb-30">
                        <div class="card-title-2">
                            <h4>Make Deposit</h4>
                        </div>
                        <div class="card-body-table">
                            <form action="{{route('deposit')}}" method="post" id="deposit">
                                    <div class="post-form">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Account Name*</label>
                                                    <input type="text" class="form-control" id="account_name" placeholder="Enter Account name of reciever">
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">LastName*</label>
                                                    <input type="text" class="form-control" placeholder="Enter lastname">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Email*</label>
                                                    <input type="email" class="form-control" placeholder="Enter email">

                                                </div>

                                            </div> --}}

                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Account Number*</label>
                                                    <input type="text" class="form-control" id="receiver_account_number" placeholder="Enter account number of reciever">
                                                </div>

                                            </div>

                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Depositor Name*</label>
                                                    <input type="text" class="form-control" id="depositor_name" placeholder="Enter depositor name">
                                                </div>
                                            </div>

                                             {{-- <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Depositor Account Number*</label>
                                                    <input type="text" class="form-control" id="sender_account_number" placeholder="Enter account number of depositor">
                                                </div>

                                            </div> --}}

                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Currency*</label>
                                                   <select name="currency" id="currency" class="form-control">
                                                       
                                                       @foreach ($currencies as $currency)
                                                             <option value="{{$currency->id}}">{{$currency->currency_name}}</option>
                                                       @endforeach
                                                      
                                                   </select>
                                                </div>
                                            </div>

                                             <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Amount*</label>
                                                    <input type="number" class="form-control" placeholder="Enter amount" id="amount">
                                                </div>
                                            </div>

                                            

                                            

                                            
                                        </div>


                                        <div class="row">

                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <button type="submit" class="save-btn hover-btn">Submit</button>
                                                </div> 
                                            </div>
                                        </div>
                                
                                    
                                

                                
                                </div>
                            </form>
                           
                        </div>
                    </div>
               </div>

           </div>

    </div>
@endsection


@section('scripts')

    <script>
    
        $('#deposit').submit(function(e){
             e.preventDefault();

            const formData = getFormAsJsonData('#deposit')
            const actionUrl = $(this).attr('action')

             $.ajax({
                    url: actionUrl,
                    type: "POST",
                    data:formData,
                    
                    beforeSend: function () {
                          toggleFullPageLoader(false, 'Submit');
                    },
                    success: function (data, status, xhr) {
                        $('#deposit')[0].reset()
                        fireAlert({
                            title: "Success",
                            text: data.message
                        });

                        

                    },
                    error: function (jqXhr, textStatus, errorMessage) {
                        const data = jqXhr.responseJSON;
                        const errors = data.errors || data.message || data.data || data;

                        if (jqXhr.status == 401) {
                            redirectTo('../');
                        }


                        fireAlert({
                            icon: "error",
                            title: "Request Failed!",
                            text: errors
                        });

                    
                    },
                    complete: function () {
                         toggleFullPageLoader(false, 'Submit');
                    }
                })
        })
    </script>
@endsection