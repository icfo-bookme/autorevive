@extends('layouts.backend.master')
@section('content')
<style>
    div.dataTables_wrapper div.dataTables_processing{
        background-color: transparent !important;
        z-index: 1 !important;
        box-shadow:none !important;
    }
    .processingColor{
       color: #7934f3;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Purchase View</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="purchaseLogTable" class="table table-bordered table-hover table-checkable" style="width: 100% !important;">
                    <thead>
                            <tr>
                                <th>Purchase ID</th>
                                <th>Vendor Name</th>
                                <th>Invoice Number</th>
                                <th>Purchase Date</th>
                                <th>Total Amount</th>
                                <th>Paid Amount</th>
                                <th>Due Amount</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                    </thead>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    $(document).ready(function () {
        const csrf_token = "{{ csrf_token() }}";
            // #### DATATABLE
            var dataTable = $('#purchaseLogTable').DataTable({
                responsive: true,
                lengthMenu: [5, 10, 25, 50, 100, 500],
                pageLength: 10,
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
                    url: route('purchase-logs.list') ,
                    data: function (data) {
                       data._token = csrf_token;
                    },
                    type: 'post',
                },
                columns: [
                    {data: 'purchase_id', name: 'purchase_id',"orderable": true, "searchable": true, width: "10%"},
                    {data: 'data_vendor_name', name: 'vendor.name', "orderable": true, "searchable": true,width:"10%"},
                    {data: 'invoice_number', name: 'invoice_number', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'purchase_date', name: 'purchase_date', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'total_amount', name: 'total_amount', "orderable": true, "searchable": true, width: "10%"},
                    {data: 'paid_amount', name: 'paid_amount', "orderable": false, searchable: true, width: "10%"},
                    {data: 'due_amount', name: 'due_amount', "orderable": false, searchable: false, width: "10%"},
                    {data: 'created_at', name: 'created_at', "orderable": false, searchable: false, width: "10%"},
                    {data: 'updated_at', name: 'updated_at', "orderable": false, searchable: false, width: "10%"},
                    {data: 'action', name: 'action', "orderable": false, searchable: false, width: "10%"},
                ],
                dom: '<"top-toolbar row"<"top-left-toolbar col-md-9"lB><"top-right-toolbar col-md-3"f>>rt<"bottom-toolbar"<"bottom-left-toolbar"i><"bottom-right-toolbar"p>>'
            });
    });
</script>

@endsection
