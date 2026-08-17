@extends('layouts.backend.master')
@section('content')
    <style>
        .icon__size{
            font-size: 16px;
        }

        .alertify-notifier .ajs-message.ajs-error{
            color: #fff !important;
            background: rgba(217, 92, 92, 0,95);
            text-shadow: -1px -1px 0 rgba(0, 0, 0, 0,5);
        }
    </style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h2 style="font-size: 23px;text-align: center">Cash Flow</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-right">
                            <button class="btn btn-info " onclick="addCashFlow()">Add New</button>
                        </div>
                        <ul class="nav nav-tabs nav-tabs-primary">
                            <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#tabe-1"><span class="hidden-xs">Newly Added</span></a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" data-toggle="tab" href="#tabe-2"><span class="hidden-xs">Approved By ALl</span></a>
                            </li>                          
                          </ul>
          
                          <!-- Tab panes -->
                          <div class="tab-content">
                            <div id="tabe-1" class="tab-pane active">
                              <div class="table-responsive">
                                  <table class="table table-bordered cashflowTable">
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
                                          @foreach($allinfo as $info)
                                                <tr>
                                                    <td>{{ $info->user->first_name." ".$info->user->last_name }}</td>
                                                    <td>{{ $info->date }}</td>
                                                    <td>{{ $info->description}}</td>
                                                    <td>{{ $info->type }}</td>
                                                    <td>{{ $info->payable_amount }}</td>
                                                    <td>
                                                        <button class="btn btn-outline-secondary"
                                                            onclick="editCashFlowInfo({{ $info->id }})">
                                                            <i class="fa fa-pencil icon__size"></i>
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
                                    <table class="table table-bordered cashflowTable">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Type</th>
                                                <th>Payable Amount</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($doneinfo as $info)
                                            <tr>
                                                <td>{{ $info->user->first_name." ".$info->user->last_name }}</td>
                                                <td>{{ $info->date }}</td>
                                                <td>{{ $info->description}}</td>
                                                <td>{{ $info->type }}</td>
                                                <td>{{ $info->payable_amount }}</td>
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











{{-- ADD MODAL --}}
<div class="modal fade" id="addCashFlowModal" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="color: #585858;">Enter Cashflow Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="cashFlowInsertForm" method="POST">
                    <div class="form-group">
                        <label for="">User</label>
                        <input type="text" class="form-control" value="{{$username}}" id="user_id" name="user_id" placeholder="" readonly>
                        {{-- <input type="text" class="form-control"  id="name" name="user" placeholder="Name"> --}}
                        {{-- <select class="form-control valid" id="user_id" name="user_id" required="" aria-invalid="false">
                            <option value=""> Select User </option>
                            @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->first_name." ".$user->last_name}}</option>
                            @endforeach
                        </select> --}}
                    </div>
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" class="form-control"  id="date" name="date" placeholder="Date">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <input type="text" class="form-control"  id="description" name="description" placeholder="Description">
                    </div>
                    <div class="form-group mb-0">
                        <label for="">Type</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="cash" name="type" value="Cash">
                        <label class="form-check-label" for="cash">Cash</label>
                      </div>
                      <div class="form-check form-check-inline mb-2">
                        <input class="form-check-input" type="radio" id="advance" name="type" value="Advance">
                        <label class="form-check-label" for="advance">Advance</label>
                      </div>
                      
                    <div class="form-group">
                        <label for="">Payable Amount</label>
                        <input type="text" class="form-control" id="payable_amount" name="payable_amount"
                            placeholder="payable_amount">
                    </div>
                    {{-- <div class="form-group">
                        <label for="">Received</label>
                        <input type="text" class="form-control"  id="received" name="received" placeholder="Received">
                    </div> --}}
                    <div class="text-center">
                        <button type="button" class="btn btn-primary" onclick="storeCashFlowInfo()">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
                </div>
                
            </div>
        </div>
</div>









{{-- EDIT MODAL --}}
<div class="modal fade" id="editCashFlowModal" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="color: #585858;">Edit Cashflow Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="updateCashFlowForm">
                    <div class="form-group">
                        <input type="hidden" id="cashflow_id" name="cashflow_id">
                        <label for="">User</label>
                        <input type="text" class="form-control" value="{{$username}}" id="user_id" name="user_id" placeholder="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" class="form-control" id="update_date" name="date" placeholder="Date">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <input type="text" class="form-control" id="update_description" name="description" placeholder="Description">
                    </div>
                    <div class="form-group mb-0">
                        <label for="">Type</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" id="updateCash" value="Cash">
                        <label class="form-check-label" for="cash">Cash</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="type" id="updateAdvance" value="Advance">
                        <label class="form-check-label" for="advance">Advance</label>
                      </div>
                      
                    <div class="form-group">
                        <label for="">Payable Amount</label>
                        <input type="text" class="form-control" id="update_payable_amount" name="payable_amount" placeholder="payable amount">
                    </div>
                    
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="cashFlowUpdate()">Save changes</button>
                    </div>
                </form>
                </div>
                
            </div>
        </div>
</div>


<script>

    $(document).ready(function () {
        var table = $('.cashflowTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
        });
    });


    function addCashFlow(){
        $('#addCashFlowModal').modal('show');
    }
    // function editCashFlow(id){
    //     $('#editCashFlowModal').modal('show');
    // }
    function cashFlowModalShow(){
        $('#viewCashFlowInfo').modal('show');
    }

    function storeCashFlowInfo() {
        event.preventDefault();
        alertify.confirm('Are You Sure ?', 'Cash Flow Information Be Inserted', function () {
            $('#preloader').modal('show');
            let form_data = $('#cashFlowInsertForm').serialize();
                               
            $.ajax({
                url: "./cashflowInsertAjax",
                method: "POST",
                data: form_data,
                success: function (response) {
                    if (response.status === true) {
                        alertify.success(response.message);
                        setTimeout(function () {
                            location.reload(true);
                        }, 1000)

                    } else if (response.status === false) {
                        alertify.error(response.message);
                    } else if ( response.status === "validation-error") {
                        $.each(response.data, (index, value) => {
                                    alertify.error(value[0]);
                                });
                    }

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
    }, function () {
        alertify.error('Cancel')
    });
    }

    function editCashFlowInfo(id) {
        // $('#editCashFlowModal').modal('show');
        $('#updateCashFlowForm')[0].reset();
        $.ajax({
            url: "{{ URL('getCashFlowInfo') }}",
            method: "POST",
            data: {
                id: id
            },
            dataType:"json",
            success: function (result) {
                //alert(result);
                console.log(result);
                
                $("#cashflow_id").val(result.id);
                // $("#update_user_id").val(result.user_id);
                $("#update_date").val(result.date);
                $("#update_description").val(result.description);
                if(result.type == 'Cash'){
                  $('#updateCash').attr('checked', 'checked');
                }else if(result.type == 'Advance'){
                    $('#updateAdvance').attr('checked', 'checked')
                }
                else{
                   console.log("value is not found");
                   $("#updateCash").removeAttr('checked');
                   $("#updateAdvance").removeAttr('checked');
                }
               
                $("#update_payable_amount").val(result.payable_amount);
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


    function cashFlowUpdate() {
        event.preventDefault();
        alertify.confirm('Are You Sure ?', 'Data Will Be Updated', function () {
            $('#preloader').modal('show');
            let form_data = $('#updateCashFlowForm').serialize();
            console.log(form_data);
            $.ajax({
                url: "{{ URL('updateCashFlowDetails') }}",
                method: "POST",
                data: $('#updateCashFlowForm').serialize(),
                success: function (result) {
                    //alert(result);
                    console.log("success")
                    if (result == "Success") {
                        alertify.success('Successfully Data Updated');
                        $('#preloader').modal('hide');
                        $("#updateRouteModal").modal('hide');
                        setTimeout(function () {

                            location.reload(true);
                        }, 1000);

                    } else {

                        alertify.error('Error Found!');
                        $('#preloader').modal('hide');
                        setTimeout(function () {

                            //   location.reload(true);
                        }, 1000);

                    }
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
        }, function () {
            alertify.error('Cancel')
        });


    }
    
</script>
@endsection