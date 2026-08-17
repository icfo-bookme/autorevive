
@extends('layouts.backend.master')
@section('content')

<style>
    .btn-group {
        margin-bottom: -2rem;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Profit Loss Report</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="introduction-box mx-auto">
                        <h5 class="text-center">Automart</h5>
                        <p class="text-center">Profit Loss Report</p>
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
                        <!-- <table class="table table-bordered" id="selectionForTest">
                            <thead class="text-center">
                                <tr>
                                    <th>SL</th>
                                    <th>Invoice No</th>
                                    <th>Completed AT</th>
                                    <th>Invoice Date</th>
                                    <th>Created At</th>
                                    <th>Delivery (+)</th>
                                    <th>Discount (-)</th>
                                    <th>Total Sale</th>
                                    <th>Total Cost</th>
                                    <th>Profit/Loss</th>

                                </tr>
                            </thead>

                        </table> -->
                        <table class="table table-bordered" id="profitLossTable" style="display: none; border-collapse: collapse !important;">
                            <thead class="text-right">
                                <tr>
                                    <th>SL</th>
                                    <th>Invoice No</th>
                                    <th>Completed At</th>
                                    <th>Invoice Date</th>
                                    <th>Created At</th>
                                    <th>Delivery (+)</th>
                                    <th>Discount (-)</th>
                                    <th>Total Sale</th>
                                    <th>Total Cost</th>
                                    <th>Profit/Loss</th>
                                </tr>
                            </thead>
                            <tbody  class="text-right"></tbody>
                            <tfoot class="text-right">
                                <tr>
                                    <th colspan="5">Sub Total</th>
                                    <th id="subTotalShipping">0</th>
                                    <th id="subTotalDiscount">0</th>
                                    <th id="subTotalSale">0</th>
                                    <th id="subTotalCost">0</th>
                                    <th id="subTotalProfit">0</th>
                                </tr>
                                <tr>
                                    <th colspan="5">Total</th>
                                    <th id="totalShipping">0</th>
                                    <th id="totalDiscount">0</th>
                                    <th id="totalSale">0</th>
                                    <th id="totalCost">0</th>
                                    <th id="totalProfit">0</th>
                                </tr>
                            </tfoot>
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
        $('#profitLossTable').DataTable().destroy();
        $('#profitLossTable').css('display', 'block');

        var table = $('#profitLossTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('profitLossReportAjax') }}",
                type: "POST",
                data: function (d) {
                    d.fromDate = $('#fromDate').val();
                    d.toDate = $('#toDate').val();
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'invoice_button', name: 'invoice_button' },
                { data: 'completed_at', name: 'completed_at' },
                { data: 'invoice_date', name: 'invoice_date' },
                { data: 'created_at', name: 'created_at' },
                { data: 'shipping', name: 'shipping' },
                { data: 'discount', name: 'discount' },
                { data: 'sale', name: 'sale' },
                { data: 'cost', name: 'cost' },
                { data: 'profit', name: 'profit' },
            ],
            lengthMenu: [
                [10, 25, 50, 100, 500, -1],  // Page length values
                [10, 25, 50, 100, 500, "All"]  // Labels for the dropdown
            ],
            drawCallback: function (settings) {
                var total = settings.json.totals;
                var subTotal = settings.json.subTotals;
                console.log(total);
                console.log(subTotal);

                $('#totalShipping').text(total.totalShipping.toFixed(2));
                $('#totalDiscount').text(total.totalDiscount.toFixed(2));
                $('#totalSale').text(total.totalSale.toFixed(2));
                $('#totalCost').text(total.totalCost.toFixed(2));

                // Calculate and display profit percentage
                var profitPercentage = total.totalCost > 0 ? (total.totalProfit / total.totalCost) * 100 : 0;


                $('#totalProfit').text(total.totalProfit.toFixed(2) + ' (' + profitPercentage.toFixed(2) + '%)');


                $('#subTotalShipping').text(subTotal.subTotalShipping.toFixed(2));
                $('#subTotalDiscount').text(subTotal.subTotalDiscount.toFixed(2));
                $('#subTotalSale').text(subTotal.subTotalSale.toFixed(2));
                $('#subTotalCost').text(subTotal.subTotalCost.toFixed(2));
                $('#subTotalProfit').text(subTotal.subTotalProfit.toFixed(2));
            },
            dom: 'lBfrtip',  // The layout of the DataTable
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
        });

        // Refresh table on filter
        $('#filterButton').click(function () {
            table.ajax.reload();
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


// function ajaxCall() {
//     var fromDate = $('#fromDate').val();
//     var toDate = $('#toDate').val();

//     var teamId = $("#teamId").val();
//     $("#ajaxLoad").load("./deliveryTeamReportAjax/" + fromDate + "/" + toDate  + "/" + teamId);
// }
</script>
