
@extends('layouts.backend.master')
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Net Profit Loss Report</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="introduction-box mx-auto">
                            <h5 class="text-center">Automart</h5>
                            <p class="text-center">Net Profit Loss Report</p>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label for="">From</label>
                                    <input type="date" class="form-control" id="fromDate">
                                </div>
                                <div class="col-sm-4">
                                    <label for="">To</label>
                                    <input type="date" class="form-control" id="toDate">
                                </div>
                                <div class="col-sm-3" style="margin-top: 1.8rem!important;">
                                    <button class="btn btn-primary mr-2" onclick="ajaxCall();">Search</button>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <ul class="list-group top-left-calculation-part" style="box-shadow: none;display: flex">
                            <li class="list-group-item mb-1"><b class="text-uppercase">Total Orders(+) :</b> <span
                                    class="float-right" id="totalOrders">৳0</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Total Funds(+) :</b> <span
                                    class="float-right" id="totalFunds">৳0</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Added Costs(-) :</b> <span
                                    class="float-right" id="totalCosts">৳0</span></li>
                            <li class="list-group-item mb-1"><b class="text-uppercase">Net Profit(=) :</b> <span
                                    class="float-right" id="netProfit">৳0</span></li>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Orders</h4>
            </div>
            <div class="card-body" style="max-height: 400px;min-height: 400px;overflow:auto;">
                <div class="row">
{{--                    <div class="introduction-box mx-auto">--}}
{{--                        <h5 class="text-center">Automart</h5>--}}
{{--                        <p class="text-center">Net Profit Loss Report</p>--}}
{{--                    </div>--}}

                    <div class="table-responsive py-2">
                        <table class="table table-bordered">
                            <thead class="text-center">
                                <tr>
                                    <th>SL</th>
                                    <th>Invoice No</th>
                                    <th>Profit/Loss</th>

                                </tr>
                            </thead>
                            <tbody id="ordersDataLoad">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Funds</h4>
            </div>
            <div class="card-body" style="max-height: 400px;min-height: 400px;overflow:auto;">
                <div class="row">
                    <div class="table-responsive py-2">
                        <table class="table table-bordered" id="tableId2">
                            <thead class="text-center">
                                <tr>
                                    <th>SL</th>
                                    <th>Amount</th>
                                    <th>Created At</th>

                                </tr>
                            </thead>
                            <tbody id="fundsDataLoad">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Costs</h4>
            </div>
            <div class="card-body" style="max-height: 400px;min-height: 400px;overflow:auto;">
                <div class="row">

                    <div class="table-responsive py-2">
                        <table class="table table-bordered" id="tableId3">
                            <thead class="text-center">
                                <tr>
                                    <th>SL</th>
                                    <th>Amount</th>
                                    <th>Created At</th>

                                </tr>
                            </thead>
                            <tbody id="costsDataLoad">

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
    const _token = "{{csrf_token()}}";
    function ajaxCall() {
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();

        $('#preloader').modal('show');
        $("#ordersDataLoad").load("./netProfitOrdersDataReportAjax/" + fromDate + "/" + toDate, function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                $('#preloader').modal('hide');
            }
            else if(statusTxt == "error"){
                $('#preloader').modal('hide');
                alertify.error('Something went wrong');
            };
        });

        $("#fundsDataLoad").load("./netProfitFundsDataReportAjax/" + fromDate + "/" + toDate, function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                $('#preloader').modal('hide');
            }
            else if(statusTxt == "error"){
                $('#preloader').modal('hide');
                alertify.error('Something went wrong');
            };
        });

        $("#costsDataLoad").load("./netProfitCostsDataReportAjax/" + fromDate + "/" + toDate, function(responseTxt, statusTxt, xhr){
            if(statusTxt == "success"){
                $('#preloader').modal('hide');
            }
            else if(statusTxt == "error"){
                $('#preloader').modal('hide');
                alertify.error('Something went wrong');
            };
        });

        viewCount(fromDate,toDate);
    }

    function viewCount(fromDate,toDate)
    {
        $.ajax({
            type: 'post',
            url: '{{URl("viewCountNetProfitReportAjax")}}',
            data: {
                fromDate : fromDate,
                toDate : toDate,
                _token : _token,
            },
            dataType: 'json',
            success: function (response) {
                $('#totalOrders').text(parseInt(response.totalProfit));
                $('#totalFunds').text(parseInt(response.totalFunds));
                $('#totalCosts').text(parseInt(response.totalCostInserts));
                $('#netProfit').text(parseInt(response.netProfits));
            }
        });
    }

    //  invoice modal
    function invoiceModal(id) {
        $('#invoiceListModal').modal('hide');
        $.get(`invoicePrintViewUser/${id}`, function(data) {
            $('#invoice_detail_modal').html(data);
        })
        $("#invoiceModal").modal('show');
    }

</script>
