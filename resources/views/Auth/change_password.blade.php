@extends('layouts.app')

@section('main-content')

    <div class="container-fluid">
           <h2 class="mt-30 page-title">Reset Password</h2>
         <ol class="breadcrumb mb-30">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Setting</a></li>
            <li class="breadcrumb-item active">Change Password</li>
        </ol>


        <div class="row">
            <div class="col-lg-12 col-md-12">
                	<div class="card card-static-2 mb-30">
                         <div class="card-title-2">
                            <h4>Change Password</h4>
                        </div>

                         <div class="card-body-table">
                            <form action="{{route('new.password')}}" method="post" id="change-password">
                                <div class="post-form">

                                     <div class="col-md-6 col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">current Password*</label>
                                            <input type="password" class="form-control" id="old_password" placeholder="Enter current password" value="" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">New Password*</label>
                                            <input type="password" class="form-control" id="password" placeholder="Enter current password" value="" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-6 col-12">
                                        <div class="form-group">
                                            <label class="form-label">Confirm Password*</label>
                                            <input type="password" class="form-control" id="password_confirmation" placeholder="confirm password" value="" required>
                                        </div>
                                    </div>


                                    

                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    {{-- <button type="submit" class="save-btn hover-btn">Submit</button> --}}

                                                     <button type="submit" class="save-btn hover-btn" style="background-color:#2196F3;">
                                                            <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                                                            <span id="msg">Submit</span>
                                                   
                                                    </button>
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
       
            $('#change-password').submit(function(e)  {

                e.preventDefault();
                
                const formData = getFormAsJsonData('#change-password')
                const actionUrl = $(this).attr('action')

               // console.log(formData)

                 $.ajax({
                    url: actionUrl,
                    type: "POST",
                    data:formData,
                    
                    beforeSend: function () {
                          toggleFullPageLoader(false, 'Submit');
                    },
                    success: function (data, status, xhr) {
                        const login = "{{route('login')}}"
                        $('#change-password')[0].reset();
                      
                        fireAlert({
                            title: "Success",
                            text: data.message
                        });

                        if(data.status == 1){
                            redirectTo(login)
                        }
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