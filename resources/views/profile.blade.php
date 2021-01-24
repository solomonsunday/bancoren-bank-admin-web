@extends('layouts.app')

@section('main-content')
    
    <div class="container-fluid">

        <h2 class="mt-30 page-title">User Profile</h2>
         <ol class="breadcrumb mb-30">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javascript:void(0)">Setting</a></li>
            <li class="breadcrumb-item active">User Profile</li>
        </ol>

         <div class="row">
               <div class="col-lg-12 col-md-12">
                		<div class="card card-static-2 mb-30">
                        <div class="card-title-2">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body-table">
                            <form action="{{route('update.profile', Auth::user()->id)}}" method="post" id="updateprofile">
                                    <div class="post-form">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">FirstName*</label>
                                                    <input type="text" class="form-control" id="first_name" placeholder="Enter firstname" value="{{Auth::user()->first_name}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">LastName*</label>
                                                    <input type="text" class="form-control" id="last_name" placeholder="Enter lastname" value="{{Auth::user()->last_name}}">
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Email*</label>
                                                    <input type="email" class="form-control" id="email" placeholder="Enter email" value="{{Auth::user()->email}}">

                                                </div>

                                            </div>

                                            <div class="col-md-6 col-lg-6 col-12">
                                                <div class="form-group">
                                                    <label class="form-label">Tel No*</label>
                                                    <input type="number" class="form-control" id="phone" placeholder="Enter phone number" value="{{Auth::user()->phone}}">
                                                </div>
                                            </div>
                                            
                                            
                                        </div>


                                        <div class="row">

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
       
            $('#updateprofile').submit(function(e)  {

                e.preventDefault();
                
                const formData = getFormAsJsonData('#updateprofile')
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