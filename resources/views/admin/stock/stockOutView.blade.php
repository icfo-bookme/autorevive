@extends('layouts.backend.master')

@section('content')
@php
    $userid = Auth::user()->id;
@endphp

<style>
    #modal_image {
        max-width: 250px;
        max-height: 250px;
        object-fit: contain;
    }

    .table td { padding: 5px; }

    img {
        max-height: 50px;
        min-height: 50px;
        object-fit: contain;
    }

    .card-body { padding-top: 0 !important; }

    div.dataTables_wrapper div.dataTables_processing {
        background-color: transparent !important;
        z-index: 1 !important;
        box-shadow: none !important;
    }

    .processingColor { color: #7934f3; }

    #modal_details table { width: 100% !important; }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-table"></i> Stock Out View
            </div>

            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-3">
                        <label><strong>Status Filter</strong></label>
                        <select id="publicFilter" class="form-control">
                            <option value="">All</option>
                            <option value="1">Public</option>
                            <option value="0">Private</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label><strong>Price Display Filter</strong></label>
                        <select id="priceDisplayFilter" class="form-control">
                            <option value="">All</option>
                            <option value="1">Contact For Price</option>
                            <option value="0">Stock Out</option>
                        </select>
                    </div>

                       <div class="col-md-3">
                        <label><strong>Sort</strong></label>
                        <select id="sortFilter" class="form-control">
                            <option value="">All</option>
                            <option value="1">Oldest</option>
                            <option value="0">Latest</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary mr-2" id="filterBtn">
                            <i class="fa fa-filter"></i> Filter
                        </button>

                        <button class="btn btn-secondary" id="resetBtn">
                            <i class="fa fa-refresh"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="stockTable" class="table table-bordered table-hover table-checkable">
                        <thead class="text-center">
                            <tr>
                                <th>Barcode</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>UOM</th>
                                <th>Cost Price</th>
                                <th>Category</th>
                                <th>Section</th>
                                <th>Regular Price</th>
                                <th>Offer Price</th>
                                <th>Wholesale Price</th>
                                <th>Status</th>
                                <th>Price Display</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


 <div class="modal fade bd-example-modal-lg" id="itemDetailsModal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" style="overflow: scroll" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card" style="box-shadow: none;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-5">
                                <img src="" alt="" id="modal_image">
                            </div>
                            <div class="col-sm-7">
                                <h4 id="modal_header"></h4>
                                <h6 id="modal_price" class="text-danger"></h6>
                                <h6 id="modal_stock" class="text-info"></h6>
                                <p id="modal_details" style="overflow-x: auto"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Purchase edit from Stock modal --}}
    <div class="modal fade" id="editPurchaseModal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content animated flipInX">
                <div class="modal-header">
                    <h4 class="modal-title " style="font-size: 18px;">Purchase Edit From Stock</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                   <h6 class="form-header text-uppercase text-center"> Invoice Number: <span id = "invoiceNumber"></span> </h6>
                   <p class="text-center">Invoice Date: <span id = "invoiceDate"></span></p>
                   <form class="form" method="POST" id="editPurchaseForm">
                       <div class="form-body">
                           <input type="hidden" id="update_purchase_id" name="purchase_id">
                           <input type="hidden" id="update_purchase_details_id" name="purchase_details_id">
                           <input type="hidden" id="update_purchase_item_barcode_id" name="purchase_item_barcode_id">
                           <input type="hidden" id="update_item_id" name="item_id">

                           <div class="form-group row">
                               <div class="col-md-4">
                                   <label>Total Amount</label>
                                   <input type="number" id="update_total_amount" name="total_amount" class="form-control square" readonly>
                               </div>
                               <div class="col-md-4">
                                   <label>Paid</label>
                                   <input type="number" id="update_paid_amount" name="paid_amount" class="form-control square"
                                        oninput="paidAmount(this)">
                               </div>
                               <div class="col-md-4">
                                   <label>Due</label>
                                   <input type="number" id="update_due_amount" name="due_amount" class="form-control square" readonly>
                               </div>
                           </div>
                           <div class="form-group row d-flex justify-content-start align-items-center">
                               <label class="col-md-3">Item name :</label>
                               <div class="col-md-5">
                                   <input id="item_name" name="item_name" class="form-control square" readonly>
                               </div>
                           </div>
                           <div class="form-group row justify-content-start align-items-center">
                                <label class="col-md-3">Quantity :</label>
                                <div class="col-md-5">
                                    <input type="number" step="any" min="1" class="form-control" id="update_quantity" name="quantity"
                                        oninput="setTotalAmount(this)">
                                </div>
                            </div>
                            <div class="form-group row justify-content-start align-items-center">
                                    <label class="col-md-3">Already Sold:</label>
                                    <div class="col-md-5">
                                        <input type="number" class="form-control" id="sold_quantity" readonly>
                                    </div>
                            </div>
                            <div class="form-group row d-flex justify-content-start align-items-center">
                                <label class="col-md-3">Cost price :</label>
                                <div class="col-md-5">
                                    <input type="number" id="update_cost_price" name="cost_price" class="form-control square" readonly>
                                </div>
                            </div>

                            <div class="form-group row justify-content-start align-items-center">
                                    <label class="col-md-3">Regular Price :</label>
                                    <div class="col-md-5">
                                        <input type="number" min="1" id="update_regular_price" name="regular_price" class="form-control square">
                                    </div>
                            </div>
                            <div class="form-group row justify-content-start align-items-center">
                                <label class="col-md-3">Offer price :</label>
                                <div class="col-md-5">
                                    <input type="number" min="1" id="update_sales_price" name="sales_price" class="form-control square">
                                </div>
                            </div>
                            <div class="form-group row justify-content-start align-items-center">
                                <label class="col-md-3">Wholesale price :</label>
                                <div class="col-md-5">
                                    <input type="number" min="1" id="update_wholesale_price" name="wholesale_price" class="form-control square">
                                </div>
                            </div>

                            </div>

                           <div class="modal-footer">
                               <div class="col text-center">
                                @if ($userid==env('SUPERADMIN_ID'))
                                   <button type="button" class="btn btn-primary" onclick="purchaseUpdateFromStock()">
                                       <i class="icon-cross2"></i> save
                                   </button>

                                   <button type="button" class="btn btn-danger" data-dismiss="modal">
                                       <i class="icon-cross2"></i> Cancel
                                   </button>
                                @endif
                               </div>
                           </div>
                       </div>
                   </form>
                </div>

            </div>
        </div>


<script>
$(document).ready(function () {

    const csrf_token = "{{ csrf_token() }}";

    let dataTable = $('#stockTable').DataTable({
        responsive: true,
        lengthMenu: [5, 10, 25, 50, 100, 500],
        pageLength: 10,
        stateSave: true,
        processing: true,
        serverSide: true,
        scrollY: 450,
        scrollX: true,
        searchDelay: 500,

        language: {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw processingColor"></i>'
        },

        ajax: {
            url: "{{ route('listAllStockOut') }}",
            type: "GET",
            data: function (data) {
                data._token = csrf_token;
                data.ispublic = $('#publicFilter').val();
                data.priceDisplay = $('#priceDisplayFilter').val();
                data.sortOrder = $('#sortFilter').val();
            }
        },

        columns: [
            {data: 'barcode', name: 'barcode'},
            {data: 'data_item_name', name: 'item.name'},
            {data: 'quantity', name: 'quantity'},
            {data: 'uom', name: 'uom'},
            {data: 'cost_price', name: 'cost_price'},
            {data: 'data_item_category_name', name: 'item.category.name'},
            {data: 'data_item_section_name', name: 'item.section.name'},
            {data: 'purchase_item_barcode.regular_price'},
            {data: 'purchase_item_barcode.sales_price'},
            {data: 'data_wholesale_price'},
            {data: 'action', orderable: false, searchable: false},
            {data: 'stock_out_display', orderable: false, searchable: false}
        ],

        dom: '<"top-toolbar row"<"col-md-9"lB><"col-md-3"f>>rtip',
        buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
    });

    // FILTER BUTTON (FIXED)
    $('#filterBtn').on('click', function () {
        dataTable.ajax.reload();
    });

    // RESET BUTTON
    $('#resetBtn').on('click', function () {
        $('#publicFilter').val('');
        $('#priceDisplayFilter').val('');
        $('#sortFilter').val('');
        dataTable.ajax.reload();
    });

});


// FIXED itemDetails FUNCTION
function itemDetails(stockId) {
    $.ajax({
        url: "{{ url('getItemDetailsForStockView') }}/" + stockId,
        type: 'GET',
        success: function (response) {
            if (response.status) {
                let stockData = response.data;

                $('#modal_image').attr('src', stockData.item.thumbnail);
                $('#modal_header').text(stockData.item.name);
                $('#modal_price').text('৳' + stockData.purchase_item_barcode.sales_price);
                $('#modal_stock').text(stockData.quantity + ' ' + stockData.uom + ' in stock.');
                $('#modal_details').html(stockData.item.details);

                $('#itemDetailsModal').modal('show');
            }
        },
        error: function () {
            alert('Failed to load item details');
        }
    });
}


// FIX quantity input
$(document).on("input", "#update_quantity", function () {
    if (/^0/.test(this.value)) {
        this.value = this.value.replace(/^0/, "1");
    }
});

function changeStatus(id) {
    $.ajax({
        url: '/change-status/' + id,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            alertify.success(response.message);
            $('#stockTable').DataTable().ajax.reload();
        },
        error: function () {
            alert('Something went wrong!');
        }
    });
}

function priceDisplaySatusChange(id) {
    $.ajax({
        url: '/change-price-display/' + id,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            alertify.success(response.message);
            $('#stockTable').DataTable().ajax.reload();
        },
        error: function () {
            alert('Something went wrong!');
        }
    });
}



</script>

@endsection