@extends('layouts.backend.master')
@section('content')
<style>
    .alertify-notifier .ajs-message.ajs-error{
        color: #fff !important;
        background: rgba(217, 92, 92, 0,95);
        text-shadow: -1px -1px 0 rgba(0, 0, 0, 0,5);
    }
</style>
@php
$getData = array();
foreach ($purchaseDetails as $details) {
    array_push($getData, $details->item_id);
}

@endphp
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="purchaseUpdateForm">
                        @csrf
                        <h4 class="form-header text-uppercase text-center">
                            <i class="fa fa-user-circle-o"></i>
                            Purchase Edit
                        </h4>

                        <div class="row my-3">
                            <div class="col-lg-12 col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                            <tr>
                                                <td class="py-3">
                                                    <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                                                    <label class="d-block">Vendor</label>
                                                    <select class="form-control form-control-sm js-select2" name="vendor_id"
                                                        id="vendor_id">
                                                        <option disabled selected value="">---select vendor---</option>
                                                        @foreach ($vendors as $vendor)
                                                            <option value="{{ $vendor->id }}" @if ($vendor->id == $purchase->vendor_id) selected @endif>{{ $vendor->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td class="py-3">
                                                    <label>Invoice Number</label>
                                                    <input type="text" class="form-control" id="input-1"
                                                        name="invoice_number" value="{{ $purchase->invoice_number }}"
                                                        placeholder="invoice number" required readonly>
                                                </td>

                                                <td class="py-3">
                                                    <label>Invoice Date</label>
                                                    <input type="date" class="form-control" id="input-1"
                                                        name="purchase_date" value="{{ $purchase->purchase_date }}"
                                                        required readonly>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="py-3">
                                                    <label>Total Amount </label>
                                                    <input type="number" step="any" min="0" class="form-control"
                                                        onkeyup="totalAmount()" id="total_amount" name="total_amount"
                                                        value="{{$purchase->total_amount}}" placeholder="Total Amount"
                                                        required readonly>
                                                </td>
                                                <td class="py-3">
                                                    <label>Paid Amount </label>
                                                    <input type="number" step="any" min="0" class="form-control"
                                                    oninput="paidAmount(this)" id="paid_amount" name="paid_amount"
                                                        value="{{ $purchase->paid_amount }}" placeholder="Paid Amount"
                                                        required>
                                                </td>
                                                <td class="py-3">
                                                    <label>Due Amount </label>
                                                    <input type="number" step="any" min="0" class="form-control"
                                                        id="due_amount" name="due_amount"
                                                        value="{{ $purchase->due_amount }}" placeholder="Due Amount"
                                                        required readonly>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="itemInfo">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">Item</th>
                                                <th scope="col">Cost Price</th>
                                                <th scope="col">Regular Price</th>
                                                <th scope="col">Offer Price</th>
                                                <th scope="col">Wholesale Price</th>
                                                <th scope="col">Mrp</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Uom</th>
                                                <th scope="col">Sold Quan</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($purchaseDetails as $details)
                                                <tr>
                                                    <td class="py-3">
                                                        <input type="hidden" name="purchase_details_id" id="purchase_details_id"
                                                            value="{{ $details->id }}">
                                                        <select class="form-control form-control-sm js-select2 item-select-dropdown"
                                                            name="item_id[]" id="itemSelect{{ $loop->iteration }}"
                                                            onclick="selectTo({{ $loop->iteration }})" disabled>
                                                            <option selected value="">---select Item---</option>
                                                            @foreach ($items as $item)
                                                                <option value="{{ $item->id }}" @if ($item->id == $details->item_id) selected @endif>
                                                                    {{ $item->name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </td>

                                                    <td class="py-3">
                                                        <input type="number" step="any" min="0" class="form-control"
                                                            id="input-1" name="cost_price[]" oninput="setTotalAmount(this)"
                                                            value="{{ $details->cost_price }}" placeholder="Cost Price"
                                                            required>
                                                    </td>

                                                    {{-- is readonly because items barcode already generated using it. --}}
                                                    <td class="py-3">
                                                        <input type="number" step="any" min="0" class="form-control"
                                                               id="input-1" name="regular_price[]"
                                                               value="{{ $details->item->regular_price }}"
                                                               placeholder="Regular price" required readonly>
                                                    </td>

                                                    {{-- sales price is the offer price & is readonly because items barcode already generated using it.--}}
                                                    <td class="py-3">
                                                        <input type="number" step="any" min="0" class="form-control"
                                                            id="input-1" name="sales_price[]"
                                                            value="{{ $details->item->sales_price }}"
                                                            placeholder="sales pmount" required readonly>
                                                    </td>

                                                    <td class="py-3">
                                                        <input type="number" step="any" min="0" class="form-control"
                                                            id="input-1" name="wholesale_price[]"
                                                            value="{{ $details->wholesale_price }}"
                                                            placeholder="wholesale Price" required>
                                                    </td>

                                                    <td class="py-3" style="min-width: 150px">
                                                        <input type="number" step="any" min="0" class="form-control"
                                                            id="input-1" name="mrp[]" value="{{ $details->mrp }}"
                                                            placeholder="mrp" required>
                                                    </td>


                                                    <td class="py-3">
                                                        <input type="number" step="any" min="0" class="form-control"
                                                            id="input-1" name="quantity[]" oninput="setTotalAmount(this)"
                                                            value="{{ $details->quantity }}" placeholder="quantity"
                                                            required>
                                                    </td>


                                                    <td class="py-3" style="min-width: 150px">
                                                        <select name="uom[]" id="uom" class="form-control">
                                                            <option value="" selected disabled>--SELECT--</option>
                                                            <option value="Kg" @if ($details->uom == 'Kg') selected @endif>Kg</option>
                                                            <option value="gm" @if ($details->uom == 'gm') selected @endif>gm</option>
                                                            <option value="Lt" @if ($details->uom == 'Lt') selected @endif>Lt</option>
                                                            <option value="ml" @if ($details->uom == 'ml') selected @endif>ml</option>
                                                            <option value="Pound" @if ($details->uom == 'Pound') selected @endif>Pound</option>
                                                            <option value="Pieces" @if ($details->uom == 'Pieces') selected @endif>Pieces</option>
                                                            <option value="Box" @if ($details->uom == 'Box') selected @endif>Box</option>
                                                            <option value="Dozen" @if ($details->uom == 'Dozen') selected @endif>Dozen</option>
                                                            <option value="Sqft" @if ($details->uom == 'Sqft') selected @endif>Sqft</option>
                                                            <option value="Set" @if ($details->uom == 'Set') selected @endif>Set</option>
                                                        </select>
                                                    </td>

                                                    <td class="py-3">
                                                        <input type="number" class="form-control" value="{{ $details->quantity - $details->purchase_item_barcode->stock->quantity }}" readonly>
                                                    </td>

                                                    <td class="py-3" style="min-width: 80px"  id="{{ $details->id }}" onclick="deletedRowId(this.id)">
                                                        <span class="badge badge-danger py-3 px-2 delete-row_{{ $details->id }}" style="cursor: pointer;min-width:45px">
                                                            X
                                                        </span>
                                                    </td>

                                                    {{-- <td class="py-3">
                                                        <input type="date" class="form-control" id="input-1"
                                                            name="expired_date[]" value="{{ $details->expired_date }}"
                                                            placeholder="Expired Date" required>
                                                    </td> --}}

                                                </tr>
                                            @endforeach
                                           {{-- @foreach ( $getData as $data)
                                               {{ $data }}
                                           @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-12 my-3">
                                <button type="button" class="btn btn-primary" id="add-row" onclick="addRow()">
                                    <div class="fonticon-wrap"><i class="fa fa-plus"></i></div>
                                </button>
                                {{-- <button type="button" class="btn btn-danger" id="delete-row" onclick="deleteRow()">
                                    <div class="fonticon-wrap"><i class="icon-minus"></i></div>
                                </button> --}}
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-4 mb-3">
                                <label for="remarks" class="col-form-label">Remarks</label>
                                <textarea class="form-control" rows="2" id="remarks" name="remarks" spellcheck="true" placeholder="Add Notes Here...">{{$purchase->remarks}}</textarea>
                            </div>
                        </div>

                        <div class="form-footer text-center">
                            <button type="button" class="btn btn-success" onclick="submitPurchase();"><i class="fa fa-check-square-o"></i> SAVE</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" onclick="window.history.back()"><i class="fa fa-times"></i>Cancel</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="preloader" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <img src="{{ asset('assets/images/preloader.gif') }}"
                 style="display: block;margin: auto;margin-top:50%;width: 10%;">
        </div>
    </div>
    <div class="modal fade" id="alertModal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" style="overflow: scroll" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title " style="font-size: 18px;">Warning</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <h6 class="text-danger">Please DELETE this PURCHASE and SETUP a new one.</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="warningModal" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" style="overflow: scroll" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 12px;">
                <div class="modal-header" style="padding: 3px 15px !important;">
                    <h4 class="modal-title " style="font-size: 18px;">Warning</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                     <div style="display:flex;justify-content: center;align-items:center;">
                        <img src="{{asset('assets/images/warning.jpg')}}" alt="" style="width: 130px;height: 130px;">
                     </div>
                    <h6 class="text-danger text-center">Please SELECT any item from the dropdown option to update purchase. Empty input filled cannot be submitted.</h6>
                </div>
            </div>
        </div>
    </div>
    <script>
        var count = 0;
        var dataArr = [];
        var itemIdCount = [];
        var getDatas = @php echo json_encode($getData) @endphp;

        $(document).ready(function() {
            $(function () {
                $('#itemSelect').select2({
                    matcher: function (params, data) {
                        if ($.trim(params.term) === '') {
                            return data;
                        }

                        keywords=(params.term).split(" ");

                        for (var i = 0; i < keywords.length; i++) {
                            if (((data.text).toUpperCase()).indexOf((keywords[i]).toUpperCase()) == -1)
                            return null;
                        }
                        return data;
                    }
                });
            });

            $(".js-select2").select2({
                closeOnSelect: true
            });
            $(".js-select2-multi").select2({
                closeOnSelect: false
            });
            $("input[type=number]").on('wheel.disableScroll', function (e) {
                    e.preventDefault()
            });
        });
        console.log("getDatas", getDatas);
        function addRow() {
            var markup = "";
            markup += "<tr>";
            markup += '<td class="py-3">';
            markup += '<select class="form-control form-control-sm js-select2" id="itemSelectMarkUp' + count +
                '" name="item_id[]">';
            markup += '<option selected value="">---select Item---</option>';
            markup +='@foreach ($items as $item)';

            markup += '<option value="{{ $item->id }}" {{in_array($item->id, $getData) ? 'disabled':''}} >{{ $item->name }}</option>';
            markup += '@endforeach ';
            markup += '</select>';
            markup += '</td>';

            markup += '<td class="py-3">';
            markup +=
                '<input type="number" step="any" min="0" class="form-control cost_price" oninput="setTotalAmount(this)" id="cost_price" name="cost_price[]" placeholder="Cost Price" required>';
            markup += '</td>';

            markup += '<td class="py-3">';
            markup +=
                '<input type="number" step="any" min="0" class="form-control" id="regular_price" name="regular_price[]" placeholder="Regular price" required>';
            markup += '</td>';

            markup += '<td class="py-3">';
            markup +=
                '<input type="number" step="any" min="0" class="form-control" id="sales_price" name="sales_price[]" placeholder="Offer price" required>';
            markup += '</td>';

            markup += '<td class="py-3">';
            markup +=
                '<input type="number" step="any" min="0" class="form-control" id="wholesale_price" name="wholesale_price[]" placeholder="Wholesale Price" required>';
            markup += '</td>';

            markup += '<td class="py-3">';
            markup +=
                '<input type="number" step="any" min="0" class="form-control" id="input-1" name="mrp[]" placeholder="mrp" required>';
            markup += '</td>';


            markup += '<td class="py-3">';
            markup +=
                '<input type="number" step="any" min="0" class="form-control quantity" oninput="setTotalAmount(this)" id="input-1" name="quantity[]" placeholder="quantity" required>';
            markup += '</td>';

            // markup +=
            //     '<td class="py-3"><select class="form-control" name="is_published[]"><option value="1">Publish</option><option value="0">Pending</option></select></td>';

            markup += '<td class="py-3">';
            markup += '<select name="uom[]" id="uom" class="form-control">';
            markup += '<option value="" selected>--SELECT--</option>';
            markup += '<option value="Kg">Kg</option>';
            markup += '<option value="gm">gm</option>';
            markup += '<option value="Lt">Lt</option>';
            markup += '<option value="ml">ml</option>';
            markup += '<option value="Pound">Pound</option>';
            markup += '<option value="Pieces" selected>Pieces</option>';
            markup += '<option value="Box">Box</option>';
            markup += '<option value="Dozen">Dozen</option>';
            markup += '<option value="Sqft">Sqft</option>';
            markup += '<option value="Set">Set</option>';
            markup += '</select>';
            markup += '</td>';

            markup += '<td class="py-3">';
            markup +=
                '<input type="number" class="form-control" placeholder="NA" readonly>';
            markup += '</td>';

             markup +=
                '<td class="py-3" style="min-width: 80px"  id="'+ count+ '" onclick="deleteRow(this.id)"><span class="badge badge-danger py-3 px-2 delete-row_'+ count +'" style="cursor: pointer;min-width:45px">X</span></td>';
            // markup += '<td>';
            // markup +=
            //     '<input type="date" class="form-control" id="input-1" name="expired_date[]" placeholder="Expired Date" required>';
            // markup += '</td>';


            markup += "</tr>";
            $("#itemInfo table tbody").append(markup);
            itemIdCount.push(count);
            $('#itemSelectMarkUp' + count).select2();
            $('#itemSelectMarkUp' + count).select2().on('select2:select', function (e) {
                var data = e.params.data;
                console.log("mark update....", data);
                dataArr.push(data);
            });
            $('#itemSelectMarkUp'+count).select2({
                matcher: function (params, data) {
                    if ($.trim(params.term) === '') {
                        return data;
                    }

                    keywords=(params.term).split(" ");

                    for (var i = 0; i < keywords.length; i++) {
                        if (((data.text).toUpperCase()).indexOf((keywords[i]).toUpperCase()) == -1)
                            return null;
                    }
                    return data;
                }
            });

            count++;
        }



        var deleted_items = [];
        function deletedRowId(id){
            $(`.delete-row_${id}`).parent().parent().remove();
            setTotalAmount();
            deleted_items.push(id);
        }


        function submitPurchase() {
            console.log("in data array", dataArr.length);
            console.log("in item id array ", itemIdCount);

            let due = $('#due_amount').val();
            if(due == 0){
                if(dataArr.length == itemIdCount.length){
                    if(deleted_items.length != getDatas.length){
                    alertify.confirm("Are You Sure To Update This?",
                    function() {
                        $('#preloader').modal('show');
                        $('.item-select-dropdown').removeAttr('disabled');
                        var formData = $('#purchaseUpdateForm').serialize() + '&deletedItems=' + deleted_items;
                        console.log("form data console......", formData);
                        $.ajax({
                            type: 'post',
                            url: '{{ url('purchaseUpdateAjax') }}',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                console.log("Response",response);
                                if(response.status === true){
                                    alertify.success(response.message);

                                    let a,fileName;
                                    response.data.forEach(image => {
                                        console.log(image);
                                        // create link, set href to blob
                                        fileName = image.split('/')[1];
                                        a = document.createElement('a');
                                        a.title = fileName;
                                        a.href = image;
                                        a.style.display = 'none';
                                        a.setAttribute("download", fileName);
                                        a.setAttribute("target", "_blank");
                                        // document.body.appendChild(a);

                                        // click item
                                        a.click();
                                    })
                                    setTimeout(function() {
                                            location.reload();
                                        }, 4000);

                                } else if (response.status === 'validation-error') {
                                    $.each(response.data, function(index, value){
                                            alertify.error(value[0]);
                                        })

                                } else if(response.status === false) {
                                    alertify.error(response.message);
                                    setTimeout(function() {
                                            location.reload();
                                        }, 4000);

                                }  else {
                                    alertify.error(response.message);

                                }
                            },

                            error: function(jqXHR, exception) {
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
                    function() {
                        alertify.error('Cancel');
                    }).setHeader('<em> CONFIRM </em> ')
                }else{
                    $('#alertModal').modal('show');
                    // alertify.confirm("Please DELETE this PURCHASE and SETUP a new one.");
                    // alertify.error("Please go back and delete the PURCHASE");
                }
                }else{
                    $('#warningModal').modal('show');
                }
            }else{
                alertify.error('Clear Due Amount');
            }
        }
        function deleteRow(id) {
            $(`.delete-row_${id}`).parent().parent().remove();
            setTotalAmount();
            itemIdCount.pop();
            // dataArr.pop();
        }

        function selectTo(id) {
            $('#itemSelect' + id).select2();
        }

        function totalAmount() {
            var totalAmount = $('#total_amount').val();
            var paidAmount = $('#paid_amount').val()
            if (paidAmount == 0) {
                $('#due_amount').val(totalAmount)
            } else {

            }
        }

        function paidAmount() {
            var totalAmount = $('#total_amount').val();
            var paidAmount = $('#paid_amount').val()
            $('#due_amount').val(totalAmount - paidAmount)
        }

        function setTotalAmount(jqElem) {
            let total = 0;
            // get total of each row
            $.each($("#itemInfo table tbody tr"), (k, v) => {
                let cost = Number($(v).find('td:nth-child(2) input')[0].value);
                let quantity = Number($(v).find('td:nth-child(7) input')[0].value);
                let row_total = cost * quantity;
                total += row_total;
            });

            $('#total_amount').val(total);
            totalAmount();
            paidAmount();
        }

    </script>
@endsection
