@extends('layouts.backend.master')
@section('content')


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Sales Log View</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="saleLogsTable" class="table table-bordered">
                        <thead>
                            <tr>

                                <th>Invoice Id (#0202)</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone Number</th>
                                <th>City</th>
                                <th>Subtotal</th>
                                <th>Shipping Charge</th>
                                <th>Discount Amount</th>
                                <th>Collected Payment</th>
                                <th>Due Paid</th>
                                <th>updated by</th>
                                <th>Action</th>
                                

                            </tr>
                        </thead>
                        <tbody>

                       
                            <script>

                                $(document).ready(function () {
                                    const csrf_token = "{{ csrf_token() }}";
                                    console.log(csrf_token);
                                        // #### DATATABLE
                                        var dataTable = $('#saleLogsTable').DataTable({
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
                                                url: route('sale_logs.list') ,
                                                data: function (data) {
                                                   data._token = csrf_token;
                                                },
                                                type: 'post',
                                            },
                                            columns: [

                                                {data: 'order_id', name: 'order_id',"orderable": true, "searchable": true, width: "10%"},
                                                {data: 'first_name', name: 'first_name', "orderable": false, searchable: true, width:"10%"},
                                                {data: 'last_name', name: 'last_name', "orderable": false, searchable: true, width:"10%"},
                                                {data: 'phone_number', name: 'phone_number', "orderable": true, "searchable": true, width: "10%"},
                                                {data: 'city', name: 'city', "orderable": true, "searchable": true, width: "10%"},
                                                {data: 'total_price', name: 'total_price', "orderable": false, searchable: false, width: "10%"},
                                                {data: 'is_shipment_charge_applied', name: 'is_shipment_charge_applied', "orderable": false, searchable: false, width: "10%"},
                                                {data: 'discount_amount', name: 'discount_amount', "orderable": false, searchable: false, width: "10%"},
                                                {data: 'collected_payment', name: 'collected_payment', "orderable": false, searchable: false, width: "10%"},
                                                {data: 'paid_amount', name: 'paid_amount', "orderable": false, searchable: false, width: "10%"},
                                                {data: 'created_by', name: 'created_by', "orderable": false, searchable: false, width: "10%"},
                                                {data: 'action', name: 'action', "orderable": false, searchable: false, width: "10%"},
                                            ],
                                            dom: '<"top-toolbar row"<"top-left-toolbar col-md-9"lB><"top-right-toolbar col-md-3"f>>rt<"bottom-toolbar"<"bottom-left-toolbar"i><"bottom-right-toolbar"p>>'
                                        });
                                });
                            </script>
@endsection
