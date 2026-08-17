@extends('layouts.backend.master')
@section('content')
    <style>
        .table th, .table td {
            padding: 5px !important;
            font-size: 14px;
            line-height: 1.2;
            white-space: nowrap; 
            text-align: center; 
            vertical-align: middle;
        }
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 5px 0 !important;
        }
        .table-responsive {
            overflow-x: auto;
        }
        th, td {
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .table th {
            padding: 15px !important;
        }
        .custom-align{
            text-align:left !important;
        }
    </style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Due Collection History</div>
            <div class="card-body">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="allDueSalesTable" class="table table-bordered w-100">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th><span class="d-block">Invoice Id</span><span class="d-block">(#0202)</span></th>
                                <th>Phone Number</th>
                                <th>City</th>
                                <th>Due Amount</th>
                                <th>Due Status</th>
                                <th class="text-center">Invoice</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: none">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="modalHide()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="invoice_detail_modal">
                <h6>Invoice details will go here...</h6>
            </div>
        </div>
    </div>
</div>

                       
                        <script>
                                $(document).ready(function () {

                                        function modalHide(){
                                            $('#invoiceModal').modal('hide');
                                        }
                                        
                                        const csrf_token = "{{ csrf_token() }}";
                                        // console.log(csrf_token);
                                        var dataTable = $('#allDueSalesTable').DataTable({
                                            responsive: true,
                                            lengthMenu: [5, 10, 25, 50, 100, 500],
                                            pageLength: 10,
                                            language: {
                                                'lengthMenu': 'Display _MENU_',
                                            },
                                            searchDelay: 500,
                                            processing: true,
                                            serverSide: true,
                                            ajax: {
                                                url: route('due_collection_history.list') ,
                                                data: function (data) {
                                                   data._token = csrf_token;
                                                },
                                                type: 'post',
                                            },
                                            columns: [
                                                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                                                {data: 'customer_name', name: 'customer_name', className: 'custom-align'},
                                                {data: 'invoice_id', name: 'invoice_id', "orderable": true},
                                                {data: 'phone_number', name: 'phone_number'},
                                                {data: 'city', name: 'city'},
                                                {data: 'due', name: 'due', "orderable": true},
                                                {data: 'is_due_paid', name: 'is_due_paid', "orderable": true},
                                                {data: 'invoice', name: 'invoice'},
                                                {data: 'action', name: 'action', orderable: false, searchable: false},
                                            ],
                                            dom: 'Blfrtip',
                                            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
                                        });
                                });

                                function invoiceModal(id) {
                                    const baseUrl = '{{ env('APP_URL') }}';
                                    let url = `${baseUrl}/invoicePrintViewUser/${id}`;
                                    
                                    $.get(url, function (data) {
                                        $('#invoice_detail_modal').html(data);
                                    });

                                    $("#invoiceModal").modal('show');
                                }
                        </script>
@endsection
