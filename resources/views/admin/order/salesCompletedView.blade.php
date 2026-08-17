
@extends('layouts.backend.master')
@section('content')
@php
    $userid=Auth::user()->id;
@endphp
<style>
    .footer{
        position: fixed !important;
        left: 0px !important;
        bottom: 0 !important;
    }

    .dataTables_length {
        margin-top: 1rem;
        margin-bottom: -2.75rem;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Completed Sales View</div>
            <div class="card-body">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    <table id="salesCompletedTable" class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th style="display: none;">Customer Name Plain</th>
                                <th>Invoice ID</th>
                                <th>Invoice Date</th>
                                <th>Completed At</th>
                                <th>Phone Number</th>
                                <th>Order Notes</th>
                                <th>City</th>
                                <th>Created At</th>
                                <th>Invoice</th>
                                <th>Action</th>
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
    $(document).ready(function() {
        $('.order-notes-popover').popover();
    });

    $(document).ready(function () {

        function modalHide(){
            $('#invoiceModal').modal('hide');
        }

        $('#salesCompletedTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('getCompletedOrders') }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'customer_name',
                    name: 'customer_name',
                    searchable: true,
                },
                {
                    data: 'customer_name_plain',
                    name: 'customer_name_plain', 
                    searchable: true,  
                    visible: false  
                },
                {
                    data: 'invoice_id',
                    name: 'invoice_id'
                },
                {
                    data: 'invoice_date',
                    name: 'invoice_date'
                },
                {
                    data: 'completed_at',
                    name: 'completed_at'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'order_notes',
                    name: 'order_notes',
                    render: function (data, type, row) {
                        // Ensure 'order_notes' is not null or undefined
                        var notes = data ? data :
                        ''; // If data is null/undefined, set to an empty string

                        if (notes.length < 30) {
                            return notes; // Show the truncated notes if it's less than 30 characters
                        } else {
                            // Add "See More" button and create modal for longer notes
                            return `
                                <span>${notes.substring(0, 30)}</span>
                                <a href="#" class="see-more" data-toggle="modal" 
                                data-target="#orderNotesModal${row.DT_RowIndex}">See More</a>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="orderNotesModal${row.DT_RowIndex}" tabindex="-1" role="dialog"
                                    aria-labelledby="orderNotesModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="orderNotesModalLabel">Full Order Notes</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body" style="white-space: normal; padding: 10px">
                                                ${notes}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'city',
                    name: 'city'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'invoice',
                    name: 'invoice'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            dom: 'Blfrtip',  // The layout of the DataTable
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
            order: [[ 4, "desc" ]]
        });

    });

    //  invoice modal
    function invoiceModal(id) {
        console.log(id);
        $.get(`invoicePrintViewUser/${id}`, function (data) {

            $('#invoice_detail_modal').html(data);
        });

        $("#invoiceModal").modal('show');
    }






</script>
@endsection
