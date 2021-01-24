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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Vendor Stylesheets -->
	<link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    @yield('Customstyles')
	
</head>
<body class="sb-nav-fixed">
    
     <nav class="sb-topnav navbar navbar-expand navbar-light bg-clr">
            <a class="navbar-brand logo-brand" href="index.html">Covmetrocu</a>
			<button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <a href="" class="frnt-link"><i class="fas fa-external-link-alt"></i>Home</a>
            <ul class="navbar-nav ml-auto mr-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item admin-dropdown-item" href="{{route('profile')}}">Edit Profile</a>
						<a class="dropdown-item admin-dropdown-item" href="{{route('change.password')}}">Change Password</a>
                        <a class="dropdown-item admin-dropdown-item" href="{{route('logout')}}">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>


         <div id="layoutSidenav">
              <div id="layoutSidenav_nav">

                  <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                     <div class="sb-sidenav-menu">
                          <div class="nav">

                            @if (Auth::user()->access_type == 1)
                                <a class="nav-link active" href="{{route('admin.home')}}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Dashboard
                                </a>

                               

                                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#staff" aria-expanded="false" aria-controls="collapseSettings">
                                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                    Staff Management
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                 <div class="collapse" id="staff" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link sub_nav_link" href="{{route('view.staff')}}">View Staff</a>
                                        <a class="nav-link sub_nav_link" href="{{route('add.staff')}}">Add Staff</a>
                                       
                                    </nav>
                                </div>

                                 
                                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#customers" aria-expanded="false" aria-controls="collapseSettings">
                                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                    Customer Management
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                 <div class="collapse" id="customers" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link sub_nav_link" href="{{route('view.customers')}}">View Customers</a>
                                        <a class="nav-link sub_nav_link" href="{{route('create.customer')}}">Add Customers</a>
                                       
                                    </nav>
                                </div>

                                <a class="nav-link active" href="{{route('all.request')}}">
								    <div class="sb-nav-link-icon"><i class="fas fa-layer-group"></i></div>
                                     Requests
                                </a>

                            @elseif(Auth::user()->access_type == 2)
                                <a class="nav-link active" href="{{route('staff.home')}}">
                                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                    Dashboard
                                </a>
                                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#customers" aria-expanded="false" aria-controls="collapseSettings">
                                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                    Customer Management
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                                 <div class="collapse" id="customers" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link sub_nav_link" href="{{route('view.customers')}}">View Customers</a>
                                        <a class="nav-link sub_nav_link" href="{{route('create.customer')}}">Add Customers</a>
                                       
                                    </nav>
                                </div>

                                 <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#makeTransactions" aria-expanded="false" aria-controls="collapseSettings">
                                    <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                    Make Transaction
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                </a>
                            
                                <div class="collapse" id="makeTransactions" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                    <nav class="sb-sidenav-menu-nested nav">
                                        <a class="nav-link sub_nav_link" href="{{route('make.deposit')}}">Deposit</a>
                                        <a class="nav-link sub_nav_link" href="{{route('pay.bills')}}">Bill Payment</a>
                                        {{-- <a class="nav-link sub_nav_link" href="email_setting.html">Email Settings</a> --}}
                                    </nav>
                                </div>

                            @endif
                                
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSettings" aria-expanded="false" aria-controls="collapseSettings">
								<div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                                Setting
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            
                            <div class="collapse" id="collapseSettings" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
									<a class="nav-link sub_nav_link" href="{{route('profile')}}">Edit Profile</a>
									<a class="nav-link sub_nav_link" href="{{route('change.password')}}">Change Password</a>
									{{-- <a class="nav-link sub_nav_link" href="email_setting.html">Email Settings</a> --}}
								</nav>
                            </div>

                            {{-- <a class="nav-link active" href="index.html">
								<div class="sb-nav-link-icon"><i class="fas fa-signout"></i></div>
                                Logout
                            </a> --}}

                            
                            
                          </div>
                     </div>
                  </nav>
              </div>


              <div id="layoutSidenav_content">
                  <main>
                       @yield('main-content')
                     
                  </main>
              </div>
         </div>


    <script src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset("assets/sweetalert2/sweetalert2.min.js")}}"></script>
    {{-- <script src="{{asset('assets/vendor/chart/highcharts.js')}}"></script>
    <script src="{{asset('assets/vendor/chart/exporting.js')}}"></script>
    <script src="{{asset('assets/vendor/chart/export-data.js')}}"></script>
    <script src="{{asset('assets/vendor/chart/accessibility.js')}}"></script> --}}
    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="{{mix('/assets/pages/utility.js')}}"></script>

    @yield('scripts')
    {{-- <script src="{{asset('assets/js/chart.js')}}"></script> --}}
       
    </body>
</html>
