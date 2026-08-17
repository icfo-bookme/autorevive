{{-- @dd($orders) --}}
@extends('layouts.backend.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> Wellcome Call </div>

                <div class="card-body">
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs nav-tabs-primary">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabe-1"><span class="hidden-xs">Pending</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabe-2"><span class="hidden-xs">Approved</span></a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div id="tabe-1" class="tab-pane active">
                                    <div class="table-responsive">
                                        <table id="welcomePendingDataTable" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                            {{-- <tbody class="drag_able">
                                                @foreach($pendingCalls as $pending)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $pending->customer->first_name }}</td>
                                                    <td>{{ $pending->customer->last_name }}</td>
                                                    <td>{{ $pending->customer->email }}</td>
                                                    <td>{{ $pending->customer->phone }}</td>
                                                    <td>{{ $pending->created_by }}</td>
                                                    <td>{{ $pending->created_at }}</td>
                                                    <td>
                                                        <button class="btn btn-default btn-xs border"
                                                            onclick="approve({{ $pending->id }})">
                                                            <i class="fa fa-check icon__size"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody> --}}

                                        </table>
                                    </div>
                                </div>
                                <div id="tabe-2" class="tab-pane fade">
                                    <div class="table-responsive">
                                        <table id="welcomeApprovedDataTable" class="table table-bordered" style="width: 100% !important">
                                            <thead style="width: 100% !important;table-layout: fixed">
                                                <tr>
                                                    <th>#</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    <th>Phone Number</th>
                                                    <th>Created By</th>
                                                    <th>Created At</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                            {{-- <tbody class="drag_able">
                                                @foreach($approvedCalls as $approved)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $approved->customer->first_name }}</td>
                                                    <td>{{ $approved->customer->last_name }}</td>
                                                    <td>{{ $approved->customer->email }}</td>
                                                    <td>{{ $approved->customer->phone }}</td>
                                                    <td>{{ $approved->created_by }}</td>
                                                    <td>{{ $approved->created_at }}</td>
                                            
                                                </tr>
                                                @endforeach
                                            </tbody> --}}

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












    
    <script>
    const csrf_token = "{{ csrf_token() }}";
    $(document).ready(function () {
        listAllPendingWecomeCallData();
        listAllApprovedWelcomeCallData();
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
            });
        // var table = $('.dataTableClass').DataTable({
        //     "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
        // });
    });
    function listAllPendingWecomeCallData(){
        var dataTable = $('#welcomePendingDataTable').DataTable({
                "bDestroy": true,
                responsive: true,
                lengthMenu: [5, 10, 25, 50, 100, 500],
                pageLength: 10,
                stateSave: true,
                language: {
                    'lengthMenu': 'Display _MENU_',
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw processingColor"></i>'
                },
                scrollY: 450,
                scrollX: true,
                scrollCollapse: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                ajax: {
                    url: route('listAllPendingWelcomeCallData'),
                    data: function(data) {
                        data._token = csrf_token;
                        // data.thana = thana;
                    },
                    type: 'post',
                },
                columns: [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'data_first_name',
                        name: 'customer.first_name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'data_last_name',
                        name: 'customer.last_name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'data_email',
                        name: 'customer.email',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'data_phone',
                        name: 'customer.phone',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'created_by',
                        name: 'created_by',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'action',
                        name: 'action',
                        "orderable": false,
                        searchable: false,
                        width: "10%"
                    },
                ],
                dom: '<"top-toolbar row"<"top-left-toolbar col-md-9"lB><"top-right-toolbar col-md-3"f>>rt<"bottom-toolbar"<"bottom-left-toolbar"i><"bottom-right-toolbar"p>>',
                buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            });
    }
    function listAllApprovedWelcomeCallData(){
        var dataTable = $('#welcomeApprovedDataTable').DataTable({
                "bDestroy": true,
                responsive: true,
                lengthMenu: [5, 10, 25, 50, 100, 500],
                pageLength: 10,
                stateSave: true,
                language: {
                    'lengthMenu': 'Display _MENU_',
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw processingColor"></i>'
                },
                scrollY: 450,
                scrollX: true,
                scrollCollapse: true,
                searchDelay: 500,
                processing: true,
                serverSide: true,
                ajax: {
                    url: route('listAllApprovedWelcomeCallData'),
                    data: function(data) {
                        data._token = csrf_token;
                        // data.thana = thana;
                    },
                    type: 'post',
                },
                columns: [
                    {
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: "10%"
                    },
                    {
                        data: 'data_first_name',
                        name: 'customer.first_name',
                        "orderable": true,
                        "searchable": true,
                         width: "10%"
                    },
                    {
                        data: 'data_last_name',
                        name: 'customer.last_name',
                        "orderable": true,
                        "searchable": true,
                         width: "10%"
                    },
                    {
                        data: 'data_email',
                        name: 'customer.email',
                        "orderable": true,
                        "searchable": true,
                         width: "10%"
                    },
                    {
                        data: 'data_phone',
                        name: 'customer.phone',
                        "orderable": true,
                        "searchable": true,
                         width: "10%"
                    },
                    {
                        data: 'created_by',
                        name: 'created_by',
                        "orderable": true,
                        "searchable": true,
                         width: "10%"
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        "orderable": true,
                        "searchable": true,
                         width: "10%"
                    },
                ],
                dom: '<"top-toolbar row"<"top-left-toolbar col-md-9"lB><"top-right-toolbar col-md-3"f>>rt<"bottom-toolbar"<"bottom-left-toolbar"i><"bottom-right-toolbar"p>>',
                buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            });
    }


    function approve(id) {
        alertify.confirm("Are you sure to approve this?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{ URL("approveWelcomeCall") }}',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function (data) {
                        if (typeof data.errors !== 'undefined') {

                            alertify.warning('Something Went Wrong');
                        } else {
                            alertify.success(data);
                            setTimeout(function () {
                                location.reload(true);
                            }, 1000)
                        }
                    },

                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.Verify Network.';
                            alertify.warning(msg);

                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                            alertify.warning(msg);
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                            alertify.warning(msg);
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                            alertify.warning(msg);
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                            alertify.warning(msg);
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                            alertify.warning(msg);
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            alertify.warning(msg);
                        }
                    }
                });
            },
            function () {
                alertify.error('Canceled');
            }).setHeader('<em> CONFIRM </em> ');
    }



    </script>

@endsection
