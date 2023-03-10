@extends('layouts.app')

@section('Customstyles')
    <link rel="stylesheet" href="{{asset('assets/css/datepicker.min.css')}}">
@endsection

@section('main-content')

     <div class="container-fluid">
         <h2 class="mt-30 page-title">Customer</h2>
          <ol class="breadcrumb mb-30">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">customer</a></li>
                <li class="breadcrumb-item active">Customer details</li>
          </ol>

          <div class="row">
              	<div class="col-lg-4 col-md-5">
                      <div class="card card-static-2 mb-30">
                        <div class="card-body-table">
                            <div class="shop-content-left pd-20" style="width:200px;">
                                 <img src="{{env('customer_endpoint').'/'.$customer->image_path}}" alt="" style="width:100px;">
                                {{-- <div class="shop_img" style="">
                                   
                                </div> --}}
                                {{-- <div class="shop-dt-left">
                                    <h4>Shop Name</h4>
                                    <span>Ludhiana, Punjab</span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    
                    <div class="card card-static-2 mb-30">
                            <div class="card-body-table">
                                <div class="shopowner-content-left pd-20">
                                    <div class="shopowner-dt-left">
                                        <h4>{{$customer->first_name}} {{$customer->last_name}}</h4>
                                        <span>Customer User</span>
                                    </div>
                                    <div class="shopowner-dts">
                                        {{-- <div class="shopowner-dt-list">
                                            <span class="left-dt">Username</span>
                                            <span class="right-dt">Joginder1991</span>
                                        </div> --}}
                                        <div class="shopowner-dt-list">
                                            <span class="left-dt">Phone</span>
                                            <span class="right-dt">{{$customer->contact}}</span>
                                        </div>
                                        <div class="shopowner-dt-list">
                                            <span class="left-dt">Email</span>
                                            <span class="right-dt">{{$customer->email}}</span>
                                        </div>
                                        <div class="shopowner-dt-list">
                                            <span class="left-dt">Address</span>
                                            <span class="right-dt">{{$customer->address}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                  </div>
                  

                  <div class="col-lg-8 col-md-7">
                        <div class="card card-static-2 mb-30">
                            <div class="card-body-table">
                                <form action="{{route('customer.update', $customer->id)}}" method="POST" id="update-customer">
                                 <div class="post-form">
                                      <div class="row">
                                        <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">FirstName</label>
                                                    <input type="text" id="first_name" class="form-control" placeholder="Enter firstname" value="{{$customer->first_name}}">
                                            </div>
                                        </div>

                                         <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">LastName</label>
                                                    <input type="text" id="last_name" class="form-control" placeholder="Enter lastname" value="{{$customer->last_name}}">
                                                </div>
                                        </div>

                                          <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Email*</label>
                                                    <input type="email" id="email" class="form-control" placeholder="Enter email" value="{{$customer->email}}">

                                                </div>
                                        </div>

                                         <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Other name</label>
                                                    <input type="text" class="form-control" id="other_name" placeholder="Enter other name" value="{{$customer->other_name}}" required>
                                                </div>

                                        </div>
                                         <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Maiden Name</label>
                                                    <input type="text" class="form-control" id="maiden_name" placeholder="Enter amdien name" value="{{$customer->maiden_name}}" required>
                                                </div>

                                        </div>
                                        <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Address*</label>
                                                    <input type="text" class="form-control" id="address" placeholder="Enter address" value="{{$customer->address}}">
                                                </div>

                                        </div>
                                         <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Tel No*</label>
                                                    <input type="number" class="form-control" id="contact" placeholder="Enter phone number" value="{{$customer->contact}}">
                                                </div>
                                            </div>

                                              <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Occupation*</label>
                                                    <input type="text" class="form-control" id="occupation" placeholder="Enter address" required value="{{$customer->address}}">
                                                </div>

                                            </div>

                                            

                                            <div class="col-md-6 col-lg-6 col-12" style="margin-top:10px;">
                                                <div class="form-group">
                                                    <label for="form-label">Date of Birth*</label>
                                                    <input type="text" class="form-control datepicker-here" id="dateOfbirth" data-language="en" placeholder="DOB" autocomplete="off" value="{{$customer->DOB}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Account Type*</label>
                                                    <select name="account_type" id="account_type" class="form-control">
                                                        
                                                         @foreach($account_types as $type)
                                                            <option value="{{$type->id}}" {{$type->name == $customer->name ? 'selected="selected"' : ''}}>{{$customer->name}}</option>
                                                        @endforeach
                                                        
                                                    </select>
                                                </div>

                                            </div>


                                             <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label for="" class="form-label">Gender</label>
                                                    <select name="gender" id="gender" class="form-control">
                                                            <option value="1">Male</option>
                                                            <option value="2">Female</option>
                                                    </select>

                                                </div>

                                            </div>

                                              <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label for="" class="form-label">Personal ID</label>
                                                    <select name="personal" id="personal_id" class="form-control">
                                                        @foreach ($verfication_id as $id)
                                                            <option value="{{$id->id}}" {{$id->id == $customer->personal_id ? 'selected="selected"':''}}>{{$id->id_name}}</option>
                                                        @endforeach
                                                    </select>

                                                </div>

                                            </div>

                                               <div class="col-md-6 col-lg-6 col-12" style="margin-top:10px;">
                                                        <div class="form-group">
                                                            <label for="form-label">Expiry Date *</label>
                                                            <input type="text" class="form-control datepicker-here" id="valid_date" data-language="en" placeholder="DOB" autocomplete="off" value="{{$customer->valid_date}}">
                                                        </div>
                                                

                                                 </div>



                                          


                                  </div>
                                   <div class="row">

                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    {{-- <button type="submit" class="save-btn hover-btn">Submit</button> --}}

                                                     <button type="submit" class="save-btn hover-btn login-btn">
                                                            <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                                                            <span id="msg">update</span>
                                                    </button>
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
    <script src="{{asset('assets/js/datepicker.min.js')}}"></script>
    <script src="{{asset('assets/js/i18n/datepicker.en.js')}}"></script>
    <script>
         $('#update-customer').submit(function(e){

            e.preventDefault()

             const formData = getFormAsJsonData('#update-customer')
            const actionUrl = $(this).attr('action')

        
            $.ajax({
                    url: actionUrl,
                    type: "POST",
                    data:formData,
                    
                    beforeSend: function () {
                          toggleFullPageLoader(false, 'Submit');
                    },

                    success: function (data, status, xhr) {

                        //$('#add-customer')[0].reset()

                        fireAlert({
                            title: "Success",
                            text: data.message
                        });

                        // $("#request-datatable").DataTable().ajax.reload();

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

