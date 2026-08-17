@extends('layouts.backend.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Due Sales Report</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="introduction-box mx-auto">
                        <h5 class="text-center">Automart</h5>
                        <p class="text-center">Due Sales Report</p>
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
                                    <th>Created AT</th>
                                    <th>Customer Name</th>
                                    <th>Phone</th>
                                    <th>Invoice Date</th>
                                    <th>Payment Due</th>
                                    <th>Due Paid</th>
                                    <th>Remaining Due</th>


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
        // $("#ajaxLoad").load("./dueSalesReportAjax/" + fromDate + "/" + toDate);

        $('#preloader').modal('show');
        $("#ajaxLoad").load("./dueSalesReportAjax/" + fromDate + "/" + toDate, function(responseTxt, statusTxt, xhr){
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
//     $("#ajaxLoad").load("./dailySalesReportAjax/" + fromDate + "/" + toDate);
// }

    //  invoice modal
    function invoiceModal(id) {
        console.log(id);
        $.get(`invoicePrintViewUser/${id}`, function (data) {
            $('#invoice_detail_modal').html(data);
        })
        $("#invoiceModal").modal('show');
    }
</script>
