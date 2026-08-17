@extends('layouts.backend.master')
@section('content')
<style>
    .icon__size {
        font-size: 16px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h2 style="font-size: 23px;text-align: center">CASHFLOW APPROVAL BY HOP</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-primary">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabe-1"><span
                                        class="hidden-xs">Pending</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabe-2"><span
                                        class="hidden-xs">Approved</span></a>
                            </li>


                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div id="tabe-1" class="tab-pane active">
                                <div class="table-responsive">
                                    <table class="table table-bordered HOPTable">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Type</th>
                                                <th>Payable Amount</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($hopInfo as $info)
                                            <tr>
                                                <td>{{ $info->user->first_name." ".$info->user->last_name }}</td>
                                                <td>{{ $info->date }}</td>
                                                <td>{{ $info->description}}</td>
                                                <td>{{ $info->type }}</td>
                                                <td>{{ $info->payable_amount }}</td>
                                                <td>
                                                    <button class="btn btn-outline-secondary"
                                                        onclick="approvedByHop({{ $info->id }})">
                                                        <i class="fa fa-check icon__size"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="tabe-2" class="tab-pane fade">
                                <div class="table-responsive">
                                    <table class="table table-bordered HOPTable">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Type</th>
                                                <th>Payable Amount</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($hopapproved as $info)
                                            <tr>
                                                <td>{{ $info->user->first_name." ".$info->user->last_name }}</td>
                                                <td>{{ $info->date }}</td>
                                                <td>{{ $info->description}}</td>
                                                <td>{{ $info->type }}</td>
                                                <td>{{ $info->payable_amount }}</td>
                                                {{-- <td>
                                                      <button class="btn btn-outline-secondary"
                                                          onclick="editCashFlowInfo({{ $info->id }})">
                                                <i class="fa fa-pencil icon__size"></i>
                                                </button>
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
    </div>
</div>




<script>
    $(document).ready(function () {
        var table = $('.HOPTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
        });
    });

    function approvedByHop(id) {
        alertify.confirm("Are you sure to approve this?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{ URL("approvedByHop") }}',
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

    //function addNewModal(){
    //    $('#addNewCashFlow').modal('show');
    //}
    //function editNewModal(){
    //    $('#editModal').modal('show');
    //}
    //function cashFlowModalShow(){
    //    $('#viewCashFlowInfo').modal('show');
    //}
</script>
@endsection