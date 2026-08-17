@extends('layouts.backend.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Pending Payment Collection Report</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="introduction-box mx-auto">
                        <h5 class="text-center">Automart</h5>
                        <p class="text-center">Pending Payment Report</p>
                    </div>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="">From</label>
                                <input type="date" class="form-control" id="fromDate">
                            </div>
                            <div class="col-sm-3">
                                <label for="">To</label>
                                <input type="date" class="form-control" id="toDate">
                            </div>
                            {{-- <div class="col-sm-3">
                                <label for="">Delivery Man</label>
                                <select class="form-control" id="teamId">
                                    @foreach($deliveryTeam as $team)
                                    <option value="{{$team->user->id}}">{{$team->user->name}}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="col-sm-3" style="margin-top: 1.8rem!important;">
                                <button class="btn btn-primary mr-2" onclick="ajaxCall();">Search</button>

                            </div>
                        </div>
                    </div>

                    <div class="table-responsive py-5">
                        <table class="table table-bordered" id="selectionForTest">
                            <thead class="text-center">
                                <tr>
                                    <th>SL</th>
                                    <th>Invoice No</th>
                                    <th>Customer Name</th>
                                    <th>Phone</th>
                                    {{-- <th>Email</th> --}}
                                    <th>Created AT</th>
                                    <th>Collected Amount</th>

                                </tr>
                            </thead>
                            <tbody id="ajaxLoad">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- loader modal -->
<div class="modal" id="preloader" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <img src="{{ asset('assets/images/preloader.gif') }}"
            style="display: block;margin: auto;margin-top:50%;width: 10%;">
    </div>
</div>
@endsection

<script>
    function ajaxCall() {
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();
        // $("#ajaxLoad").load("./collectionReportAjax/" + fromDate + "/" + toDate);
        $('#preloader').modal('show');
        $("#ajaxLoad").load("./collectionReportAjax/" + fromDate + "/" + toDate, function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                $('#preloader').modal('hide');
            }
            else if(statusTxt == "error"){
                $('#preloader').modal('hide');
                alertify.error('Something went wrong');
            };
           
        });
    }

// function ajaxCall() {
//     var fromDate = $('#fromDate').val();
//     var toDate = $('#toDate').val();

//     var teamId = $("#teamId").val();
//     $("#ajaxLoad").load("./deliveryTeamReportAjax/" + fromDate + "/" + toDate  + "/" + teamId);
// }
</script>
