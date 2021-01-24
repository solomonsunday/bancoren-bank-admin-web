@extends('layouts.app')

@section('Customstyles')
    <link rel="stylesheet" href="{{asset("assets/datatables.net-bs4/dataTables.bootstrap4.css")}}">
@endsection

@section('main-content')
      <div class="container-fluid">
            <h2 class="mt-30 page-title">Add Customers</h2>
            <ol class="breadcrumb mb-30">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Requests</a></li>
                <li class="breadcrumb-item active">All Requests</li>
            </ol>

            <div class="row">
                 <div class="col-lg-12 col-md-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-12">
                                <h6 class="card-title">View Requests</h6>
                                <p class="text-muted">View all requests made by users</p>

                            </div>
                            {{-- <div class="col-12 col-md-2 justify-content-end">
                                <button style="background-color: #81C041; border: none;" type="submit" class="btn btn-primary">Create Client</button>
                            </div> --}}
                        </div>

                        <div class="row">
                            <div class="col-12 grid-margin">
                                <div class="">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                       <div style="overflow-x:scroll">
                                                            <table id="request-datatable" class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>S/N</th>
                                                            <th>Date</th>
                                                            <th>User Details</th>
                                                            <th>Phone</th>
                                                            <th>Email</th>
                                                            <th>Request Type</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
{{-- 
                                                            @php
                                                                $counter = 1;
                                                            @endphp

                                                            @foreach ($requests as $request)
                                                                <tr>
                                                                    <td>{{$counter++}}</td>
                                                                    <td>{{$request->created_at}}</td>
                                                                    <td>{{$request->user_details}}</td>
                                                                    <td>{{$request->phone}}</td>
                                                                    <td>{{$request->email}}</td>
                                                                    <td>{{$request->request_name}}</td>
                                                                    @if ($request->status == 0)
                                                                         <td><label class="badge badge-info">Awaiting Approval</label></td>
                                                                    @else
                                                                         <td><label class="badge badge-success">Approved</label></td>
                                                                    @endif

                                                                    
                                                                    @if ($request->status == 0)
                                                                         <td><button type="button" class="btn btn-outline-info" id="approve_request" data-id="{{$request->id}}" data-url="{{route('request.approve')}}">Approve</button></td>
                                                                    @else
                                                                    <td></td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach --}}

                                                        </tbody>
                                                    </table>
                                                       </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                 </div>

            </div>
      </div>
@endsection

@section('scripts')
     <script src="{{asset("assets/datatables.net/jquery.dataTables.js")}}"></script>
    <script src="{{asset("assets/datatables.net-bs4/dataTables.bootstrap4.js")}}"></script>
    <script>

        $(document).ready(function() {
             let table = $('#request-datatable')
                      
                        .DataTable({
                            "ajax": {
                                "url": "{{route('made.requests')}}",
                                dataSrc: function(json){
                                    
                                    return json.data
                                }
                            },
                            "order":[
                                [1, "asc"]
                            ],
                            columns: [
                                {
                                    data: null
                                },
                                {
                                    data: "created_at"
                                },
                                {
                                    data: "user_details"
                                },
                                {
                                    data: "phone"
                                },
                                {
                                    data: "email"
                                },
                                {
                                    data: "request_name"
                                },
                                  {
                data: null,
                render: function (data, type, row, meta) {

                    return type === 'display' ?
                        `<label class="badge ${data.status===1?"badge-success":
                            "badge-info"}">${data.status===1?"Approved":"Awaiting Approval"}</label>` :
                        data;
                }
            },
            {
                data: null,
                render: function (data, type, row, meta) {

                    return type === 'display' ?
                        `${data.status===0?
                            `<button type="button" data-id="${data.id}" ` +
                            ' class="approve_request btn  btn-outline-info btn-fw  mr-1">Approve</button>'
                            : ` ` +
                            ' '
                            }` :
                        data;
                }
            },

            
                            ],
                             "aLengthMenu": [
                                    [5, 10, 15, -1],
                                    [5, 10, 15, "All"]
                                ],
                                "iDisplayLength": 10,
                                "language": {
                                    search: ""
                                }
                        })


                         table.on('order.dt search.dt', function () {
                            table.column(0, {
                                search: 'applied',
                                order: 'applied'
                            }).nodes().each(function (cell, i) {
                                cell.innerHTML = i + 1;
                            });
                        }).draw();



                        
                        $('#request-datatable').on('click', 'button.approve_request', function(){

                           const request_id = $(this).data('id')
                           const action_url = "{{route('request.approve')}}"

                            Swal.fire({
                            icon: "info",
                            title: "Request Approval",
                            text: "Approve Request",
                            button: {
                                text: "Close",
                                value: true,
                                visible: true,
                                className: "btn btn-alert-btn",
                            },
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: `Yes Approve it`
                        }).then((result) => {

                            if (result.value) {
                                $.ajax({
                                    url: action_url,
                                    type: "POST",
                                    data:{request_id},
                                    beforeSend: function () {
                                       // toggleFullPageLoader(true);
                                    },
                                    success: function (data, status, xhr) {

                                        fireAlert({
                                            title: "Success",
                                            text: data.message
                                        });

                                        $("#request-datatable").DataTable().ajax.reload();

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
                                        //toggleFullPageLoader(false);
                                    }
                                })
                            }

                         })


                        })



        })
       
       
        

        


    </script>
@endsection