@extends('layouts.backend.master')
@section('content')
<style>
    .icon__size{
        font-size: 16px;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h2 style="font-size: 23px;text-align: center">CASHFLOW APPROVAL BY CEO</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav nav-tabs nav-tabs-primary">
                            <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#tabe-1"><span class="hidden-xs">Pending</span></a>
                            </li>
                            <li class="nav-item">
                              <a class="nav-link" data-toggle="tab" href="#tabe-2"><span class="hidden-xs">Approved</span></a>
                            </li>
                            
                            
                          </ul>
          
                          <!-- Tab panes -->
                          <div class="tab-content">
                            <div id="tabe-1" class="tab-pane active">
                              <div class="table-responsive">
                                  <table class="table table-bordered CeoTable">
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
                                          @foreach($ceoInfo as $info)
                                          <tr>
                                              <td>{{ $info->user->first_name." ".$info->user->last_name }}</td>
                                              <td>{{ $info->date }}</td>
                                              <td>{{ $info->description}}</td>
                                              <td>{{ $info->type }}</td>
                                              <td>{{ $info->payable_amount }}</td>
                                              <td>
                                                <button class="btn btn-outline-secondary"
                                                    onclick="approveByCeo({{ $info->id }})">
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
                                    <table class="table table-bordered CeoTable">
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
                                            @foreach($ceoapproved as $info)
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


{{-- <div class="modal fade" id="addNewCashFlow" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle"
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
                <form action="">
                    <div class="form-group">
                        <label for="">User</label>
                        <input type="text" class="form-control" name="" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" class="form-control" name="" placeholder="Date">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <input type="text" class="form-control" name="" placeholder="Description">
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="cash" checked>
                        <label class="form-check-label" for="cash">Cash</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="advance">
                        <label class="form-check-label" for="advance">Advance</label>
                      </div>
                      
                    <div class="form-group">
                        <label for="">Paid</label>
                        <input type="text" class="form-control" name="" placeholder="Paid">
                    </div>
                    <div class="form-group">
                        <label for="">Received</label>
                        <input type="text" class="form-control" name="" placeholder="Received">
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                </div>
                
            </div>
        </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle"
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
                <form action="">
                    <div class="form-group">
                        <label for="">User</label>
                        <input type="text" class="form-control" name="" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" class="form-control" name="" placeholder="Date">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <input type="text" class="form-control" name="" placeholder="Description">
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="cash" checked>
                        <label class="form-check-label" for="cash">Cash</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="advance">
                        <label class="form-check-label" for="advance">Advance</label>
                      </div>
                      
                    <div class="form-group">
                        <label for="">Paid</label>
                        <input type="text" class="form-control" name="" placeholder="Paid">
                    </div>
                    <div class="form-group">
                        <label for="">Received</label>
                        <input type="text" class="form-control" name="" placeholder="Received">
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                </div>
                
            </div>
        </div>
</div>
<div class="modal fade" id="viewCashFlowInfo" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 style="color: #585858;">Cashflow Information</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="">
                    <div class="form-group">
                        <label for="">User</label>
                        <input type="text" class="form-control" name="" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="">Date</label>
                        <input type="date" class="form-control" name="" placeholder="Date">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <input type="text" class="form-control" name="" placeholder="Description">
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="cash" checked>
                        <label class="form-check-label" for="cash">Cash</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="inlineRadioOptions" id="advance">
                        <label class="form-check-label" for="advance">Advance</label>
                      </div>
                      
                    <div class="form-group">
                        <label for="">Paid</label>
                        <input type="text" class="form-control" name="" placeholder="Paid">
                    </div>
                    <div class="form-group">
                        <label for="">Received</label>
                        <input type="text" class="form-control" name="" placeholder="Received">
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
                </div>
                
            </div>
        </div>
</div> --}}

<script>
    $(document).ready(function () {
        var table = $('.CeoTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
        });
    });
    //function addNewModal(){
    //    $('#addNewCashFlow').modal('show');
    //}
    //function editNewModal(){
    //    $('#editModal').modal('show');
    //}
    //function cashFlowModalShow(){
    //    $('#viewCashFlowInfo').modal('show');
    //}

    function approveByCeo(id) {
        alertify.confirm("Are you sure to approve this?",
            function () {
                $.ajax({
                    type: 'post',
                    url: '{{ URL("approveByCeo") }}',
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
    
</script>
@endsection