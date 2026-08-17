@extends('layouts.backend.master')
@section('content')
{{-- <style>
    .custom__textDecoration{
        color: red !important;
    }
</style> --}}

<style>
    .btn-group {
        margin-bottom: -2rem;
    }
</style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Sales Report</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="introduction-box mx-auto">
                            <h5 class="text-center">Automart</h5>
                            <p class="text-center">Sales Report</p>
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
                               <div class="col-sm-3">
                                   <label for="">Search By</label>
                                   <select class="form-control" id="searchBy">
                                       <option value="invoice">Invoice</option>
                                       <option value="item">Item</option>
                                   </select>
                               </div>
                                <div class="col-sm-3" style="margin-top: 1.8rem!important;">
                                    <button class="btn btn-primary mr-2" onclick="ajaxCall();">Search</button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive py-5" id="dataTableForInvoice">
                            <table class="table table-bordered" id="ajaxLoad">
                                <thead class="text-center">
                                    <tr>
                                        <th>SL</th>
                                        <th>Invoice No</th>
                                        <th>Completed AT</th>
                                        <th>Customer Name</th>
                                        <th>Phone</th>
                                        <th>Invoice Date</th>
                                        <th>Created AT</th>
                                        <th>Sold By</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                
                                <tfoot>
                                    <tr>
                                        <td colspan="8" class="text-right">sub-total</td>
                                        <td class="text-right"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="8" class="text-right font-weight-bold">Total</td>
                                        <td class="text-right font-weight-bold" id="grandTotalCell"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="table-responsive py-5" id="dataTableForItem" style="display: none">
                            <table class="table table-bordered" id="ajaxLoadForItem">
                                <thead class="text-center">
                                    <tr>
                                        <th>SL</th>
                                        <th>Barcode</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-right">Sub-total</td>
                                        <td class="text-right" id="subTotalItemCell"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-right font-weight-bold">Total</td>
                                        <td class="text-right font-weight-bold" id="grandTotalItemCell"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalTitle"
        aria-hidden="true">
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

    <div class="modal fade" id="invoiceListModal" tabindex="-1" role="dialog" aria-labelledby="invoiceListModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" style="font-size: 18px;">Invoice List</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="invoice_list_modal">
                    <div class="table-responsive" id="dataTableForInvoice">
                        <table class="table table-bordered" id="selectionForTest">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Invoice No</th>
                                </tr>
                            </thead>
                            <tbody id="invoiceList">

                            </tbody>
                        </table>
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

<script>

    let invoiceId;

    function ajaxCall() {
        var fromDate = $('#fromDate').val();
        var toDate = $('#toDate').val();
        var getFilterType = $('#searchBy').val();

        if (getFilterType == 'invoice') {
            // $('#preloader').modal('show');
            $('#dataTableForInvoice').css('display', 'block');
            $('#dataTableForItem').css('display', 'none');

            // Initialize DataTable for invoice
            $('#ajaxLoad').DataTable({
                processing: true,
                serverSide: true,
                destroy: true, 
                ajax: {
                    url: '{{route ("dailySalesReportAjax") }}',
                    type: 'POST',
                    data: {
                        fromDate: fromDate,
                        toDate: toDate
                    },
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'invoice_no', name: 'invoice_no' },
                    { data: 'completed_at', name: 'completed_at' },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'phone_number', name: 'phone_number' },
                    { data: 'invoice_date', name: 'invoice_date' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'sales_by', name: 'sales_by' },
                    { data: 'total', name: 'total', className: 'text-right' },
                ],
                lengthMenu: [
                    [10, 25, 50, 100, 500, -1],  // Page length values
                    [10, 25, 50, 100, 500, "All"]  // Labels for the dropdown
                ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();

                    // Check if total_collected_payment is provided by the server
                    var totalCollectedPayment = api.ajax.json()?.total_collected_payment;

                    // Calculate the total for the visible page
                    var pageTotal = api.column(8, { page: 'current' }).data().reduce(function (a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    // Update the Total row with the current page's total
                    $(api.column(8).footer()).html(pageTotal.toFixed(2));

                    // Update the Grand Total row with the server-side total
                    if (totalCollectedPayment !== undefined) {
                        $('#grandTotalCell').html(totalCollectedPayment.toFixed(2));
                    } else {
                        $('#grandTotalCell').html(pageTotal.toFixed(2));
                    }
                },
                dom: 'lBfrtip',  // The layout of the DataTable
                buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
            });
        } else {
            // $('#preloader').modal('show');
            $('#dataTableForInvoice').css('display', 'none');
            $('#dataTableForItem').css('display', 'block');

            // Initialize DataTable for item
            $('#ajaxLoadForItem').DataTable({
                processing: true,
                serverSide: true,
                destroy: true,
                ajax: {
                    url: '{{route ("dailySalesReportByItemAjax") }}', 
                    type: 'POST',
                    data: {
                        fromDate: fromDate,
                        toDate: toDate
                    },
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'barcode', name: 'barcode' },
                    { data: 'item_name', name: 'item_name' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'total', name: 'total', className: 'text-right' },
                ],
                lengthMenu: [
                    [10, 25, 50, 100, 500, -1],  // Page length values
                    [10, 25, 50, 100, 500, "All"]  // Labels for the dropdown
                ],
                footerCallback: function (row, data, start, end, display) {
                    var api = this.api();

                    // Check if total_collected_payment is provided by the server
                    var totalCollectedSum = api.ajax.json()?.totalCollectedSum;

                    // Calculate the subtotal for the current page
                    var pageSubTotal = api.column(4, { page: 'current' }).data().reduce(function (a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    // Update the Sub-total row with the current page's total
                    $('#subTotalItemCell').html(pageSubTotal.toFixed(2));

                    // Update the Grand Total row with the server-side total
                    if (totalCollectedSum !== undefined) {
                        $('#grandTotalItemCell').html(totalCollectedSum.toFixed(2));
                    } else {
                        // Fallback to the subtotal if the server-side total is unavailable
                        $('#grandTotalItemCell').html(pageSubTotal.toFixed(2));
                    }
                },
                dom: 'lBfrtip',  // The layout of the DataTable
                buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
            });
        }
    }

    //  invoice modal
    function invoiceModal(id, barcode) {
        $('#invoiceListModal').modal('hide');
        console.log(id);
        $.get(`invoicePrintViewUser/${id}`, function(data) {
            $('#invoice_detail_modal').html(data);
        })
        $("#invoiceModal").modal('show');
        // invoiceId = barcode;
        getUserData(barcode)
    }


    // //  invoice modal
    // function invoiceModal(id) {
    //     console.log(id);
    //     $.get(`invoicePrintViewUser/${id}`, function (data) {
    //         $('#invoice_detail_modal').html(data);
    //     })
    //     $("#invoiceModal").modal('show');
    // }


    function getinvoiceListHistory(barcode_id,fromDate,toDate) {
        console.log(barcode_id,fromDate,toDate);
        $.ajax({
            url: '{{ URL('getinvoiceListHistoryAjax') }}',
            type: 'POST',
            data: {
                barcode_id: barcode_id,
                fromDate: fromDate,
                toDate: toDate
            },
            success: data => {
                count = 0;
                $('#invoiceList').html('');
                $.each(data, (key, val) => {
                    $('#invoiceList').append(`
                <tr>
                    <td>${++count}</td>
                    <td><a style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary" onclick='invoiceModal(${val.order_id}, ${barcode_id})'>
                        #0202${val.order_id}</a></td>
                </tr>`);
                });
                $('#invoiceListModal').modal('show');

                // $('.invoice_id').click((e) => showOrderHistory(e.target.dataset.id));
            },
            error: err => {
                console.error(err);
            }
        });
    }
</script>
@endsection
