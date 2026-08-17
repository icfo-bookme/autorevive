@extends('layouts.backend.master')
@section('content')


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div style="display: flex; justify-content: center; align-items: center; margin-top: 20px;flex-direction: column;">
                    <div style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
                        <div class="text-center">
                            <h6 style="margin: 0px">Automart</h6>
                            <h5><b>Discrepancy Report</b></h5>
                        </div>
                    </div>
                    <div style="width: 80%; border: 1px dashed #dee2e6;"></div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="discrepancyReportTable" class="table table-bordered" style="width: 100% !important;">
                            <thead>
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th>Name</th>
                                    <th>Barcode</th>
                                    <th>Counted Quantity</th>
                                    <th>System Quantity</th>
                                    <th>Difference</th>
                                    <th>Updated By</th>
                                </tr>
                            </thead>
                            
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>










    <script>
        $(document).ready(function() {
            const csrf_token = "{{ csrf_token() }}";
            // ## DATATABLE
            var dataTable = $('#discrepancyReportTable').DataTable({
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
                    url: route('listAllForDiscrepancyReport'),
                    data: function (data) {
                        data._token = csrf_token;
                    },
                    type: 'post',
                },
                columns: [
                    
                    {
                        data: 'data_item_name',
                        name: 'item_name',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'barcode_name',
                        name: 'barcode',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'counted_quantity',
                        name: 'quantity',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                        data: 'system_quantity',
                        name: 'systemQty',
                        "orderable": true,
                        "searchable": true,
                        width: "10%"
                    },
                    {
                     data: 'difference',
                     name: 'difference',
                     "orderable": true,
                     "searchable": true,
                     width: "10%",
                     
                    },
                    {data: 'updated_by', name: 'updated_by', "orderable": false, searchable: false, width: "10%"},
                ],
                createdRow: function( row, data, dataIndex ) {
                    if (data.difference < 0) {
                        $( row ).find('td:eq(4)').css({'background': 'red','color': '#fff'});
                    }
                },
                dom: '<"top-toolbar row"<"top-left-toolbar col-md-9"lB><"top-right-toolbar col-md-3"f>>rt<"bottom-toolbar"<"bottom-left-toolbar"i><"bottom-right-toolbar"p>>',
                buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            });

        })

        
    </script>
@endsection
