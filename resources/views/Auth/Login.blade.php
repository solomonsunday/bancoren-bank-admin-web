<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="csrf-token" content="{{@csrf_token()}}" />
	<meta name="" content="">
	<meta name="" content="">
	<title>Coventry Metro Credit Union Admin</title>
	<link href="{{asset('assets/css/styles.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/admin-style.css')}}" rel="stylesheet">
	
	<!-- Vendor Stylesheets -->
	<link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
</head>


    <body class="bg-sign">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header card-sign-header">
                                        <h3 class="text-center font-weight-light my-4">Login</h3>
                                         <div class="alert" id="errorMsg" style="display:none;"></div>
									</div>
                                    <div class="card-body">
                                        <form id="login-form" method="POST" action="{{route('signin')}}">
                                            <div class="form-group">
												<label class="form-label" for="inputEmailAddress">Email*</label>
												<input class="form-control py-3" id="email" type="email" placeholder="Enter email address" required>
											</div>
                                            <div class="form-group">
												<label class="form-label" for="inputPassword">Password*</label>
												<input class="form-control py-3" id="password" type="password" placeholder="Enter password" required    >
											</div>
                                            {{-- <div class="form-group">
                                                <div class="custom-control custom-checkbox">
													<input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
													<label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
												</div>
                                            </div> --}}
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button type="submit" class="btn btn-sign" style="background-color:#2196F3;">
                                                    <i class="fa fa-spinner fa-spin" style="display:none;"></i>
                                                    <span id="msg">Login</span>
                                                   
                                                </button>
												{{-- <a class="btn btn-sign hover-btn" href="index.html">Login</a> --}}
											</div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

    <script src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/js/scripts.js')}}"></script>
     <script src="{{mix('/assets/pages/utility.js')}}"></script>
     <script src="{{mix('/assets/pages/login.js')}}"></script>		
		
    </body>
</html>