@extends('layouts.app')

@section('main-content')
     <div class="container-fluid">
         <h2 class="mt-30 page-title">Dashboard</h2>
         <ol class="breadcrumb mb-30">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        {{-- super admin only --}}
        <div class="row">
             <div class="col-xl-3 col-md-6">
                <div class="dashboard-report-card purple">
                    <div class="card-content">
                        <span class="card-title">Total Customers</span>
                        <span class="card-count">{{$total_customers}}</span>
                    </div>
                    <div class="card-media">
                        <i class="fab fa-rev"></i>
                    </div>
                </div>
            </div>


             <div class="col-xl-3 col-md-6">
                <div class="dashboard-report-card info">
                    <div class="card-content">
                        <span class="card-title">Total Staffs</span>
                        <span class="card-count">{{$total_staffs}}</span>
                    </div>
                    <div class="card-media">
                        <i class="fas fa-sync-alt rpt_icon"></i>
                    </div>
                </div>
             </div>

              <div class="col-xl-3 col-md-6">
                    <div class="dashboard-report-card success">
                        <div class="card-content">
                            <span class="card-title">Incoming Request</span>
                            <span class="card-count">{{$total_requests}}</span>
                        </div>
                        <div class="card-media">
                            <i class="fas fa-sync-alt rpt_icon"></i>
                        </div>
                    </div>
             </div>

             
            <div class="col-xl-12 col-md-12">
                <div class="card card-static-2 mb-30">
                    <div class="card-title-2">
                        <h4>Recently Added Staffs</h4>
                        <a href="{{route('view.staff')}}" class="view-btn hover-btn">View All</a> 
                    </div>
                    
                    <div class="card-body-table">
                            <div class="table-responsive">
                                <table class="table ucp-table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Tel</th>
                                            <th>Address</th>
                                            {{-- <th>Status</th> --}}
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($staffs as $staff)
                                        <tr>
                                           
                                               <td>{{$staff->first_name}} {{$staff->last_name}}</td>
                                               <td>{{$staff->email}}</td>
                                               <td>{{$staff->phone}}</td>
                                               <td>{{$staff->address}}</td>
                                          
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
                        <h4>Recently Added Customers</h4>
                        <a href="{{route('view.customers')}}" class="view-btn hover-btn">View All</a> 
                    </div>
                    
                    	<div class="card-body-table">
                            <div class="table-responsive">
                                <table class="table ucp-table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Tel</th>
                                            <th>Address</th>
                                            {{-- <th>Status</th> --}}
                                        </tr>
                                    </thead>

                                   <tbody>
                                        @foreach ($customers as $customer)
                                        <tr>
                                          
                                               <td>{{$customer->first_name}} {{$customer->last_name}}</td>
                                               <td>{{$customer->email}}</td>
                                               <td>{{$customer->phone}}</td>
                                               <td>{{$customer->address}}</td>
                                         
                                        </tr>
                                          @endforeach 
                                    </tbody>
                                </table>
                            </div>
                    	</div>
                </div>
            </div>

            

             
        </div>
         
    </div>
@endsection