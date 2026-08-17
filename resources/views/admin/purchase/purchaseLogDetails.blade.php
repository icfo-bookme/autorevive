@extends('layouts.backend.master')
@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="purchaseUpdateForm">
                        @csrf
                        <h4 class="form-header text-uppercase text-center">
                            <i class="fa fa-user-circle-o"></i>
                            Purchase Log View
                        </h4>

                        <div class="row my-3">
                            <div class="col-lg-12 col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
                                        <tbody>
                                            <tr>
                                                <td class="py-3">
                                                    <input type="hidden" name="purchase_id" value="{{ $purchaseLog->id }}">
                                                    <label class="d-block">Vendor</label>
                                                    <select class="form-control form-control-sm js-select2" name="vendor_id"
                                                        id="vendor_id" disabled>
                                                        <option  selected value="">---select vendor---</option>
                                                        @foreach ($vendors as $vendor)
                                                            <option value="{{ $vendor->id }}" @if ($vendor->id == $purchaseLog->vendor_id) selected @endif>{{ $vendor->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </td>

                                                <td class="py-3">
                                                    <label>Invoice Number</label>
                                                    <input type="text" class="form-control" id="input-1"
                                                        name="invoice_number" value="{{ $purchaseLog->invoice_number }}"
                                                        placeholder="invoice number" readonly>
                                                </td>

                                                <td class="py-3">
                                                    <label>Invoice Date</label>
                                                    <input type="date" class="form-control" id="input-1"
                                                        name="purchase_date" value="{{ $purchaseLog->purchase_date }}"
                                                        readonly >
                                                </td>
                                            </tr>
                                            <tr>

                                                <td class="py-3">
                                                    <label>Total Amount </label>
                                                    <input type="number" step="any" min="0" class="form-control"
                                                        onkeyup="totalAmount()" id="total_amount" name="total_amount"
                                                        value="{{$purchaseLog->total_amount}}" placeholder="Total Amount"
                                                        readonly>
                                                </td>
                                                <td class="py-3">
                                                    <label>Paid Amount </label>
                                                    <input type="number" step="any" min="0" class="form-control"
                                                        onkeyup="paidAmount()" id="paid_amount" name="paid_amount"
                                                        value="{{ $purchaseLog->paid_amount }}" placeholder="Paid Amount"
                                                        readonly>
                                                </td>
                                                <td class="py-3">
                                                    <label>Due Amount </label>
                                                    <input type="number" step="any" min="0" class="form-control"
                                                        id="due_amount" name="due_amount"
                                                        value="{{ $purchaseLog->due_amount }}" placeholder="Due Amount"
                                                        readonly>
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
                                                {{-- <th scope="col">Expired Date</th> --}}
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($purchaseLogDetails as $details)
                                                <tr>
                                                    <td class="py-3">
                                                        <input type="hidden" name="purchase_details_id"
                                                            value="{{ $details->purchase_id }}">
                                                        <select class="form-control form-control-sm js-select2"
                                                            name="item_id[]" id="itemSelect{{ $loop->iteration }}"
                                                            onclick="selectTo({{ $loop->iteration }})" disabled>
                                                            <option disabled selected value="">---select Item---</option>
                                                            @foreach ($items as $item)
                                                                <option value="{{ $item->id }}" 
                                                                    @if ($item->id == $details->item_id) selected @endif>
                                                                    {{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>

                                                    <td class="py-3">
                                                        <input type="number" class="form-control"
                                                            name="cost_price[]"
                                                            value="{{ $details->cost_price }}"
                                                            readonly>
                                                    </td>
                                                    
                                                    <td class="py-3">
                                                        <input type="number" class="form-control"
                                                            name="regular_price[]"
                                                            value="{{ $details->item->regular_price }}"
                                                            readonly>
                                                    </td>

                                                    {{-- sales price is the offer price --}}
                                                    <td class="py-3">
                                                        <input type="number" class="form-control" 
                                                            name="sales_price[]"
                                                            value="{{ $details->sales_price }}"
                                                            readonly>
                                                    </td>

                                                    <td class="py-3">
                                                        <input type="number" class="form-control" 
                                                            name="wholesale_price[]"
                                                            value="{{ $details->wholesale_price }}"
                                                            readonly>
                                                    </td>

                                                    <td class="py-3" style="min-width: 150px">
                                                        <input type="number" class="form-control"
                                                            name="mrp[]" 
                                                            value="{{ $details->mrp }}"
                                                            readonly>
                                                    </td>


                                                    <td class="py-3">
                                                        <input type="number" class="form-control"
                                                            name="quantity[]"
                                                            value="{{ $details->quantity }}"
                                                            readonly>
                                                    </td>


                                                    <td class="py-3" style="min-width: 150px">
                                                        <select name="uom[]" id="uom" class="form-control" disabled>
                                                            <option value="" selected >--SELECT--</option>
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

                                                    {{-- <td class="py-3">
                                                        <input type="date" class="form-control" id="input-1"
                                                            name="expired_date[]" value="{{ $details->expired_date }}"
                                                            placeholder="Expired Date" required>
                                                    </td> --}}

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4 mb-3 my-5">
                                <label for="remarks" class="col-form-label">Remarks</label>
                                <textarea class="form-control" rows="2" id="remarks" name="remarks" spellcheck="true" placeholder="Add Notes Here..." readonly>{{$purchaseLog->remarks}}</textarea>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>




    <div class="row justify-content-center">
        <div class="col-lg-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <form id="purchaseInsertForm">
                        @csrf
                        <h4 class="form-header text-uppercase text-center">
                            <i class="fa fa-user-circle-o"></i>
                            Present Purchase Info View
                        </h4>
    
                        <div class="row">
                            <table class="table table-sm table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <label>Vendor</label>
                                             <input type="text" class="form-control" id="input-1" value="{{$purchase->vendor->name}}" readonly>
                                        </td>
    
    
                                        <td>
                                            <label>Invoice Number</label>
                                            <input type="text" class="form-control" id="input-1" value="{{$purchase->invoice_number}}"
                                                readonly>
                                        </td>
                                        <td>
                                            <label>Invoice Date</label>
                                            <input type="date" class="form-control" id="input-1" value="{{$purchase->purchase_date}}" readonly>
                                        </td>
                                    </tr>
                                    <tr>
    
                                        <td>
                                            <label>Total Amount </label>
                                            <input type="text" class="form-control" id="input-1" value="{{$purchase->total_amount}}" readonly>
                                        </td>
                                        <td>
                                            <label>Paid Amount </label>
                                            <input type="text" class="form-control" value="{{$purchase->paid_amount}}" readonly>
                                        </td>
                                        <td>
                                            <label>Due Amount </label>
                                            <input type="text" class="form-control" value="{{$purchase->due_amount}}" readonly>
                                        </td>
                                    </tr>
    
                                </tbody>
                            </table>
                        </div>
    
    
    
                        <div class="row" id="itemInfo">
    
                            <table class="table table-sm">
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
                                        {{-- <th scope="col">Expired Date</th> --}}
                                    </tr>
                                </thead>
    
                                <tbody>
    
                                    @foreach($purchaseDetails as $details)
    
                                    <tr>
                                        <td>
                                            <input type="text"  class="form-control" value="{{$details->item->name}}" readonly>
                                        </td>
    
                                        <td>
                                            <input type="number" step="any" class="form-control" value="{{$details->cost_price}}" readonly>
                                        </td>
    
                                        <td>
                                            <input type="number" step="any" class="form-control" value="{{$details->item->regular_price}}" readonly>
                                        </td>
    
                                        <td>
                                            <input type="number" step="any" class="form-control" value="{{$details->sales_price}}" readonly>
                                        </td>
    
                                        <td>
                                            <input type="number" step="any" class="form-control" value="{{$details->wholesale_price}}" readonly>
                                        </td>
    
                                        <td>
                                            <input type="number" step="any" class="form-control" value="{{$details->mrp}}" readonly>
                                        </td>
    
                                        <td>
                                            <input type="number" step="any" class="form-control" value="{{$details->quantity}}" readonly>
                                        </td>
    
                                        <td>
                                            <input type="text" step="any" class="form-control" value="{{$details->uom}}" readonly>
                                        </td>
    
                                        {{-- <td>
                                            <input type="date" class="form-control" id="input-1" value="{{$details->expired_date}}" readonly>
                                        </td> --}}
    
                                    </tr>
    
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
    
                        <div class="row">
                            <div class="col-sm-6 mt-3">
                                <h6 class="text-disabled"><label>Challan Image</label></h6>
                                <img src="{{ asset($purchase->challan_img) }}" height="150" width="150">
                            </div>
                        </div>
    
                        <div class="row">
                            <div class="col-sm-4 mb-3 my-5">
                                <label for="remarks" class="col-form-label">Remarks</label>
                                <textarea class="form-control" rows="2" id="remarks" name="remarks" spellcheck="true" placeholder="Add Notes Here..." readonly>{{$purchase->remarks}}</textarea>
                            </div>
                        </div>
    
                    </form>
                </div>
            </div>
        </div>
    </div>









    <script>
        $(document).ready(function() {
            $(".js-select2").select2({
                closeOnSelect: true
            });
            $(".js-select2-multi").select2({
                closeOnSelect: false
            });
        });

    </script>
@endsection
