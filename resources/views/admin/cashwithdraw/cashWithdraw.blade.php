@extends('layouts.backend.master')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center mb-0" style="font-size: 22px;">Cash Withdraw List</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="float-right my-3">
                                <button class="btn btn-info" onclick="cashWithdrawAdd()">Add New</button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="widthdrawList" style="width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>User</th>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($withdrawls as $withdrawl)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $withdrawl->user->first_name." ".$withdrawl->user->last_name }}</td>
                                            <td>{{ $withdrawl->date }}</td>
                                            <td>{{ $withdrawl->description }}</td>
                                            <td>{{ $withdrawl->amount }}</td>
                                            
                                            {{-- <td>
                                              <button class="btn btn-outline-secondary"  onclick="editCashWithdrawInfo()">Edit</button>
                                              <button class="btn btn-outline-secondary"  onclick="deleteCashWithdrawInfo()">Delete</button>
                                            </td> --}}
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addCashWithdrawModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="color: #585858;">Cash Withdraw Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="cashWithdrawInsertForm" method="POST">
                        <div class="form-group">
                            <label for="">User</label>
                            <select class="form-control valid" id="username" name="username" required=""
                                aria-invalid="false">
                                <option value=""> Select User </option>
                                @foreach ($users as $user)
                                  <option value="{{$user->id}}"> {{$user->first_name." ".$user->last_name}} </option>
                 
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="date" class="form-control" id="date" name="date" placeholder="Date">
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <input type="text" class="form-control" id="description" name="description"
                                placeholder="Description">
                        </div>

                        <div class="form-group">
                            <label for="">Withdraw Amount</label>
                            <input type="text" class="form-control" id="withdraw_amount" name="withdraw_amount"
                                placeholder="payable_amount">
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="storeCashWithdrawInfo()">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="editCashWithdrawModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="color: #585858;">Edit Cash Withdraw Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateCashWithdrawInsertForm" method="POST">
                        <div class="form-group">
                            <label for="">User</label>
                            <select class="form-control valid" id="update_username" name="username" required=""
                                aria-invalid="false">
                                <option value=""> Select User </option>
                                <option value="Kawsar">Kawsar</option>
                                <option value="Himel">Himel</option>
                                <option value="Galib">Galib</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Date</label>
                            <input type="date" class="form-control" id="update_date" name="date" placeholder="Date">
                        </div>
                        <div class="form-group">
                            <label for="">Description</label>
                            <input type="text" class="form-control" id="update_description" name="description"
                                placeholder="Description">
                        </div>

                        <div class="form-group">
                            <label for="">Withdraw Amount</label>
                            <input type="text" class="form-control" id="update_withdraw_amount" name="withdraw_amount"
                                placeholder="payable_amount">
                        </div>

                        <div class="text-center">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="storeCashWithdrawInfo()">Save</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>

    $(document).ready(function(){
      $('#widthdrawList').DataTable({
        scrollY: 500,
        scrollX: true,
        scrollCollapse: true,
      });
    })
        function cashWithdrawAdd() {

            $("#addCashWithdrawModal").modal('show');
        }

        function storeCashWithdrawInfo() {
            event.preventDefault();
            alertify.confirm('Are You Sure ?', 'Data Will Be Inserted', function() {
                $('#preloader').modal('show');
                let form_data = $('#cashWithdrawInsertForm').serialize();
                console.log(form_data);
                
                $.ajax({
                    url: "./cashWithDrawInsert",
                    method: "POST",
                    data: form_data,
                    success: function(result) {
                        console.log(result)
                        alertify.success('Successfully Data Inserted');
                        $('#preloader').modal('hide');
                        $('#addCashFlowModal').modal('hide');

                        setTimeout(function() {
                            location.reload(true);
                        }, 1000);
                    },
                    error: function(jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.Verify Network.';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            alertify.warning(msg);
                            $('#preloader').modal('hide');
                        }

                    }
                });
            }, function() {
                alertify.error('Cancel')
            });
        }

        function editCashWithdrawInfo(id) {
        $('#updateCashWithdrawInsertForm')[0].reset();
        $.ajax({
            url: "{{ URL('getCashFlowInfo') }}",
            method: "POST",
            data: {
                id: id
            },
            dataType:"json",
            success: function (result) {
                console.log(result);
                
                $("#update_username").val(result.id);
                $("#update_date").val(result.date);
                $("#update_description").val(result.description);
                $("#update_withdraw_amount").val(result.withdraw_amount);
                $("#editCashFlowModal").modal('show');
                
                
            
            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.Verify Network.';
                    alertify.warning(msg);
                    $('#preloader').modal('hide');

                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                    alertify.warning(msg);
                    $('#preloader').modal('hide');
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                    alertify.warning(msg);
                    $('#preloader').modal('hide');
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                    alertify.warning(msg);
                    $('#preloader').modal('hide');
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                    alertify.warning(msg);
                    $('#preloader').modal('hide');
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                    alertify.warning(msg);
                    $('#preloader').modal('hide');
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    alertify.warning(msg);
                    $('#preloader').modal('hide');
                }

            }
        });

    }

    </script>
@endsection
