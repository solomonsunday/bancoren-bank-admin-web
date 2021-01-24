@extends('layouts.app')

@section('Customstyles')
    <link rel="stylesheet" href="{{asset("assets/datatables.net-bs4/dataTables.bootstrap4.css")}}">
@endsection

@section('main-content')
      <div class="container-fluid">
            <h2 class="mt-30 page-title">Staffs</h2>
            <ol class="breadcrumb mb-30">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">staffs</a></li>
                <li class="breadcrumb-item active">All Staffs</li>
            </ol>

            <div class="row">
                 <div class="col-lg-12 col-md-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-12">
                                <h6 class="card-title">View Staffs</h6>
                                <p class="text-muted">View all staffs</p>

                            </div>
                            
                        </div>

                        <div class="row">
                            <div class="col-12 grid-margin">
                                <div class="">
                                    <div class="">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                       <div style="overflow-x:scroll">
                                                            <table id="staff-datatable" class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>S/N</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Address</th>
                                                            <th>Type</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>


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
          let table = $('#staff-datatable')
                      
                        .DataTable({
                            "ajax": {
                                "url": "{{route('all.staffs')}}",
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
                                    data: "first_name"
                                },
                                {
                                    data: "last_name"
                                },
                                {
                                    data: "email"
                                },
                                {
                                    data: "phone"
                                },
                                {
                                    data: "address"
                                },
                                {
                                    data:null,
                                    render: function(data, type, row, meta){
                                         return type === 'display' ?
                                                `<label class="badge ${data.access_type===2?"badge-success":
                                                    "badge-info"}">${data.access_type===1?"Admin":"Staff"}</label>` :
                                                data;
                                    }
                                },
                                {
                                data: null,
                                render: function (data, type, row, meta) {

                                    return type === 'display' ?
                                        `<label class="badge ${data.status===1?"badge-success":
                                            "badge-danger"}">${data.status===1?"Active":"Disabled"}</label>` :
                                        data;
                                }
                            },
                         {
                                data: null,
                                render: function (data, type, row, meta) {

                                    return type === 'display' ?
                                        `${data.status===0?
                                            `<button type="button" data-id="${data.id}" ` +
                                            ' class="enable btn  btn-outline-info btn-fw  mr-1">Enable</button>'
                                            : `<button type="button" data-id="${data.id}" ` +
                                            ' class="disable btn  btn-outline-danger btn-fw  mr-1">Disable</button>'
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



                        

                        $('#staff-datatable').on('click', 'button.enable', function() {

                             const user_id = $(this).data('id')
                            const action_url = "{{route('staff.enable')}}"

                            Swal.fire({
                            icon: "info",
                            title: "Enable User",
                            text: "You about to enable staff user",
                            button: {
                                text: "Close",
                                value: true,
                                visible: true,
                                className: "btn btn-alert-btn",
                            },
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: `Yes enable staff`
                        }).then((result) => {

                            if (result.value) {
                                $.ajax({
                                    url: action_url,
                                    type: "POST",
                                    data:{user_id},
                                    beforeSend: function () {
                                       // toggleFullPageLoader(true);
                                    },
                                    success: function (data, status, xhr) {

                                        fireAlert({
                                            title: "Success",
                                            text: data.message
                                        });

                                        $("#staff-datatable").DataTable().ajax.reload();

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

                        $('#staff-datatable').on('click', 'button.disable', function() {

                             const user_id = $(this).data('id')
                            const action_url = "{{route('staff.disable')}}"

                            Swal.fire({
                            icon: "info",
                            title: "Disable Staff User",
                            text: "You about to disable staff user",
                            button: {
                                text: "Close",
                                value: true,
                                visible: true,
                                className: "btn btn-alert-btn",
                            },
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: `Yes disable staff`
                        }).then((result) => {

                            if (result.value) {
                                $.ajax({
                                    url: action_url,
                                    type: "POST",
                                    data:{user_id},
                                    beforeSend: function () {
                                       // toggleFullPageLoader(true);
                                    },
                                    success: function (data, status, xhr) {

                                        fireAlert({
                                            title: "Success",
                                            text: data.message
                                        });

                                        $("#staff-datatable").DataTable().ajax.reload();

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



    </script>

@endsection