@extends('layouts.app')

@section('Customstyles')
    <link rel="stylesheet" href="{{asset("assets/datatables.net-bs4/dataTables.bootstrap4.css")}}">
@endsection

@section('main-content')
      <div class="container-fluid">
            <h2 class="mt-30 page-title">Customers</h2>
            <ol class="breadcrumb mb-30">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">customers</a></li>
                <li class="breadcrumb-item active">All Customers</li>
            </ol>

            <div class="row">
                 <div class="col-lg-12 col-md-12">
                    <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10 col-lg-10 col-12">
                                <h6 class="card-title">View Customers</h6>
                                <p class="text-muted">View all customers</p>

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
                                                            <table id="customer-datatable" class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>S/N</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Gender</th>
                                                            <th>Account Number</th>
                                                            <th>Account Balance</th>
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
          let table = $('#customer-datatable')
                                .DataTable({
                                    "ajax": {
                                        "url": "{{route('all.customers')}}",
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
                                            data: null,
                                            render : function(data, type, row, meta){
                                                return type === 'display' ?
                                                    `${data.status===1? "Male" : "Female"}`:
                                                    data;
                                            }
                                        },
                                        {
                                            data: "account_number"
                                        },
                                        {
                                            data: "account_balance"
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
                                                 `<button type="button" data-id="${data.id}" class="view btn btn-outline-info btn-fw  mr-1">View</button>` +


                                                `${data.status===0?
                                                    `<button type="button" data-id="${data.id}" ` +
                                                    ' class="enable btn btn-outline-info btn-fw  mr-1">Enable</button>'
                                                    : `<button type="button" data-id="${data.id}" ` +
                                                    ' class="disable btn btn-outline-danger btn-fw  mr-1">Disable</button>'
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


                $('#customer-datatable').on('click', 'button.enable', function() {

                    const user_id = $(this).data('id')
                    const action_url = "{{route('customer.enable')}}"

                     Swal.fire({
                            icon: "info",
                            title: "Enable Customer",
                            text: "You about to enable customer",
                            button: {
                                text: "Close",
                                value: true,
                                visible: true,
                                className: "btn btn-alert-btn",
                            },
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: `Yes enable customer`
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

                                        $("#customer-datatable").DataTable().ajax.reload();

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


                $('#customer-datatable').on('click', 'button.disable', function() {

                    const user_id = $(this).data('id')
                    const action_url = "{{route('customer.disable')}}"

                     Swal.fire({
                            icon: "info",
                            title: "Disable customer",
                            text: "You about to disable customer",
                            button: {
                                text: "Close",
                                value: true,
                                visible: true,
                                className: "btn btn-alert-btn",
                            },
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: `Yes disable customer`
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

                                        $("#customer-datatable").DataTable().ajax.reload();

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

                $('#customer-datatable').on('click', 'button.view', function(){

                     const user_id = $(this).data('id')
                    let url = `{{url('dashboard/customer-details')}}/${user_id} `

                    redirectTo(url)
                })


      </script>

@endsection