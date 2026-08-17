@extends('layouts.backend.master')
@section('content')

<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form id="purchaseInsertForm">
                    @csrf
                    <h4 class="form-header text-uppercase text-center">
                        <i class="fa fa-user-circle-o"></i>
                        Purchase Info View
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
                                    <th scope="col">Qty</th>
                                    <th scope="col">Uom</th>
                                    {{-- <th scope="col">Expired Date</th> --}}
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($purchaseDetails as $details)

                                <tr>
                                    <td>
                                        <!-- <input type="text" id="dynamic-width" class="form-control" value="{{$details->item->name}}" readonly> -->
                                        <p class="full-width">{{$details->item->name}}</p>
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

@endsection

<style>
    #itemInfo td,
    #itemInfo th{
        padding: 10px 5px;
    }
    .full-width{
        width: 260px;
        background-color:rgba(158, 158, 158, 0.33);
        border: 1px solid #ced4da;
        padding: 8px 10px;
        border-radius: 5px;
        white-space: break-spaces; 
    }
</style>