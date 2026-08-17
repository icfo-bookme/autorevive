@extends('layouts.backend.master')
@section('content')
<style>
    .table td, .table th {
    white-space: normal !important;
}
.minWidth{
    min-width: 150px !important;
}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Requested Product List</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="productRequestTable" class="table table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>#</th>
                                <th class="minWidth">Product Detail</th>
                                <th class="minWidth">Product Image</th>
                                <th class="minWidth">User's Name</th>
                                <th class="minWidth">Phone</th>
                                <th class="minWidth">Email</th>
                                <th class="minWidth">Created At</th>
                                <th class="minWidth">Status</th>
                                <th class="minWidth">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($requests as $request)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="minWidth">{{ $request->product_detail }}</td>
                                <td class="minWidth">
                                    @if ($request->product_image)
                                        <img src="{{ asset($request->product_image) }}" class="img-thumbnail" style="height:80px;width:80px">
                                    @endif
                                </td>
                                <td class="minWidth text-center">{{ $request->user_name }}</td>
                                <td class="minWidth">{{ $request->user_phone }}</td>
                                <td class="minWidth">{{ $request->user_email }}</td>
                                <td class="minWidth">{{ $request->created_at }}</td>
                                <td class="minWidth">
                                    @if ($request->is_approved)
                                        <button class="btn badge badge-success">Approved</button>
                                    @else
                                        <button class="btn badge badge-info">Pending</button>
                                    @endif
                                </td>
                                <td class="minWidth">
                                    <a href="javascript:void(0)" onclick="approveRequest({{ $request->id }})"
                                        style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                        data-toggle="tooltip" title="Hooray!" data-original-title="Edit"
                                        data-target="#exampleModal">
                                        <i class="fa fa-check"></i>
                                    </a>

                                    <a href="javascript:void(0)" onclick="deleteRequest({{ $request->id }})"
                                        style="padding: 5px 10px;" class="btn btn-default btn-xs border"
                                        data-toggle="tooltip" title="" data-original-title="Delete">
                                        <i class="fa fa-trash-o"></i>
                                    </a>

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








<!-- modal new subject -->
<div class="modal fade" id="modal-brand-insert" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated flipInX">
            <div class="modal-header" style="border-bottom: none;">
                <h4 class="modal-title" style="font-size: 18px;">New Brand</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="brandInsertForm">
                    <div class="form-group">
                        <label for="input-1">Brand Name</label>
                        <input type="text" class="form-control" placeholder="brand name" name="name" required>
                    </div>
                </div>
            <div class="modal-footer justify-content-center">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> -->
                <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> Save</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- reply product request modal -->
<div class="modal fade" id="replyProductRequest" tabindex="-1" role="dialog"
    aria-labelledby="replyProductRequestCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Product Request Reply</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="replyRequestForm">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Mail Body</label>
                        <input type="hidden" name="request_id" id="request_id">
                        <textarea class="form-control" id="mail_body" placeholder="message" name="mail_body"
                            rows="3"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Send</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>


<form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>

































<script>
    $(document).ready(function () {

        var table = $('#productRequestTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
            stateSave: true,
        });

    });

    function approveRequest(id) {
        alertify.confirm("Are you sure to approve this?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{ URL("admin/approveRequest") }}',
                    data: {
                        request_id: id
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


    /**
     * @name deleteClass
     * @role send ajax request to delete a class
     * @param role id
     * @return json response
     *
     */
    function deleteRequest(id) {
        alertify.confirm("Are You Sure To Delete This?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{ URL("admin/deleteRequest") }}',
                    data: {
                        request_id: id
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

    // function mailSendModal (id) {
    //     $('#request_id').val(id);
    //     $('#replyProductRequest').modal('show');
    // }

</script>
@endsection
