@extends('layouts.backend.master')
@section('content')
    <style>
        .footer {
            position: fixed !important;
            left: 0px !important;
            bottom: 0 !important;
        }
        .status-icon{
            color: green;
            cursor: pointer;
        }

    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><i class="fa fa-table"></i> All bookings</div>
                <div class="card-body">
                    <div class="clearfix"></div>
                    <div class="table-responsive">
                        <table id="bookingTable" class="table table-bordered" style="width: 100% !important;">
                            <thead class="text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Customer Name</th>
                                    <th>Invoice ID</th>
                                    <th>Invoice Date</th>
                                    <th>Status</th>
                                    <th>Advance Payment</th>
                                    <th>Payment Due</th>
                                    {{-- <th>Email</th>
                                    <th>Booking Notes</th> --}}
                                    <th>Phone Number</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($bookings as $booking)

                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
                                        <td>#0303{{ $booking->id }}</td>
                                        <td>{{ $booking->invoice_date }}</td>
                                        <td>
                                            @if($booking->status == BOOKING__STATUS_INACTIVE)
                                                <span class="badge badge-dark m-3">Inactive</span>
                                                <i class="fa fa-pencil status-icon" title="Click to change" onclick="openChangeStatusModal({{$booking->id}})"></i>
                                            @elseif($booking->status == BOOKING__STATUS_ADVANCE_CASH_RECEIVED)
                                                <span class="badge badge-warning  m-3">Advance Received</span>
                                                <i class="fa fa-pencil status-icon" title="Click to change" onclick="openChangeStatusModal({{$booking->id}})"></i>
                                            @elseif($booking->status == BOOKING__STATUS_READY_TO_DELIVER)
                                                <span class="badge badge-info  m-3">Ready To Deliver</span>
                                                <i class="fa fa-pencil status-icon" title="Click to change" onclick="openChangeStatusModal({{$booking->id}})"></i>
                                            @elseif($booking->status == BOOKING__STATUS_DELIVERED)
                                                <span class="badge badge-success  m-3"> Delivered </span>
                                            @elseif($booking->status == BOOKING__STATUS_CANCELED)
                                                <span class="badge badge-danger  m-3"> Canceled </span>
                                            @endif
                                        </td>
                                        <td>{{ $booking->advance_payment }}</td>
                                        <td>{{ $booking->payment_in_advance->payable_amount }}</td>
                                        {{-- <td>{{ $booking->email }}</td>
                                        <td>{{ $booking->booking_notes }}</td> --}}
                                        <td>{{ $booking->phone_number }}</td>
                                        <td>{{ $booking->created_at }}</td>
                                        <td>
                                            @if($booking->status == BOOKING__STATUS_INACTIVE || $booking->status == BOOKING__STATUS_ADVANCE_CASH_RECEIVED || $booking->status == BOOKING__STATUS_READY_TO_DELIVER)
                                                <a onclick=" editBooking({{ $booking->id }})"
                                                    style="padding: 5px 10px;color: #fff;cursor: pointer;"
                                                    class="btn badge badge-primary" data-toggle="tooltip" title=""
                                                    data-original-title="Edit">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- modal body goes here -->
<div class="modal fade" id="booking-status-update-modal" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">Update booking status</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="bookingStatusUpdateForm">
                    <input type="hidden" class="form-control" id="booking_id" name="booking_id">

                    <div class="form-group">
                        <label for="input-1">Status</label>
                        <select name="booking_status" id="booking_status" class="form-control">
                            <option value="0">Inactive</option>
                            <option value="1">Advance Received</option>
                            <option value="2">Ready To Deliver</option>
                            <option value="4">Cancel</option>
                            {{--<option value="3">Delivered</option>--}}
                        </select>

                    </div>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save
                    changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

    <script>
        $(document).ready(function() {

            var table = $('#bookingTable').DataTable({
                "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
                scrollY: 500,
                scrollX: true,
                scrollCollapse: true,
            });
        });

        //  invoice modal
        function editBooking(id) {
            // window.location.href = '/editBooking/' + id;
            window.location.href = "{{ url('/editBooking') }}/" + id;
        }

        // Open modal for changing booking status
        function openChangeStatusModal(id)
        {
            $.ajax({
            type: 'post',
            url: '{{URL("getBookingDetails")}}',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (response) {
                if(response.status === true){
                    $('#booking_id').val(response.data.id);
                    $('#booking-status-update-modal').modal('show');
                    $('#booking_status').val(response.data.status);
                }else{
                    alertify.error(response.message);
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
        }


        $('#bookingStatusUpdateForm').submit(function () {
            event.preventDefault();
            alertify.confirm("Are You Sure To Change The Status?",
                function () {
                    var formData = new FormData($('#bookingStatusUpdateForm')[0]);
                    $.ajax({
                        type: 'post',
                        url: './changeBookingStatus',
                        data: formData,
                        dataType: 'json',
                        enctype: 'multipart/form-data',
                        processData: false,
                        cache: false,
                        contentType: false,
                        timeout: 600000,
                        success: function (response) {
                            if(response.status === true){
                                alertify.success(response.message);
                                location.reload();
                            }else{
                                alertify.error(response.message);
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
                    alertify.error('Cancel');
                }).setHeader('<em> CONFIRM </em> ');
        });

    </script>
@endsection
