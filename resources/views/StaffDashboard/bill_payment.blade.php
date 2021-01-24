@extends('layouts.app')

@section('main-content')

    <div class="container-fluid">
         <h2 class="mt-30 page-title"></h2>
         <ol class="breadcrumb mb-30">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Bill Payment</a></li>
            <li class="breadcrumb-item active">Make Payment</li>
        </ol>

        <div class="row">
             <div class="col-lg-12 col-md-12">
                 <div class="card card-static-2 mb-30">
                    <div class="card-title-2">
                        <h4>Pay Bills</h4>
                    </div>

                     <div class="card-body-table">
                         <form action="{{route('bills.payment')}}" method="post" id="pay-bills">
                            <div class="post-form">
                                 <div class="row">
                                      <div class="col-md-6 col-lg-6 col-12">
                                            <div class="form-group">
                                                <label class="form-label">Account Number*</label>
                                                <input type="number" class="form-control" id="account_number" placeholder="Enter Account number">
                                            </div>
                                    </div>


                                          <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Name*</label>
                                                    <input type="text" class="form-control" id="name" placeholder="Enter name">
                                                </div>
                                            </div>


                                              <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Email*</label>
                                                    <input type="email" class="form-control" id="email" placeholder="Enter email">
                                                </div>
                                            </div>

                                              <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Amount*</label>
                                                    <input type="number" class="form-control" id="amount" placeholder="Enter amount">
                                                </div>
                                            </div>

                                             <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Bill Type*</label>
                                                    <select name="bill_type" id="bill_type" class="form-control">
                                                        @foreach ($bills as $bill)
                                                            <option value="{{$bill->id}}">{{$bill->bill_name}}</option>
                                                        @endforeach
                                                    </select>
                                                  
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
       
        $('#pay-bills').submit(function(e) {

            e.preventDefault();

            const formData = getFormAsJsonData('#pay-bills')
            const actionUrl = $(this).attr('action')

             $.ajax({
                    url: actionUrl,
                    type: "POST",
                    data:formData,
                    
                    beforeSend: function () {
                          toggleFullPageLoader(false, 'Submit');
                    },
                    success: function (data, status, xhr) {
                        $('#pay-bills')[0].reset()
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