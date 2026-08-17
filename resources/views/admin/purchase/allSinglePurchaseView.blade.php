@extends('layouts.backend.master')
@section('content')
<style>
    .alertify-notifier .ajs-message.ajs-error{
        color: #fff !important;
        background: rgba(217, 92, 92, 0,95);
        text-shadow: -1px -1px 0 rgba(0, 0, 0, 0,5);
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> All Purchased Items </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="itemTable" class="table table-bordered" style="width: 100% !important">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Cost Price</th>
                                <th>Vendor</th>
                                <th>Invoice No.</th>
                                {{-- <th>Current Stock</th> --}}
                                <th>Invoice Date</th>
                                <th>Barcode</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($singlePurchases as $singlePurchase)

                            <tr>
                                <td>{{$singlePurchase->item->name}}</td>
                                <td>{{$singlePurchase->purchase_details->cost_price}}</td>
                                <td>{{$singlePurchase->purchase_details->purchase->vendor->name}}</td>
                                <td>{{$singlePurchase->purchase_details->purchase->invoice_number}}</td>
                                <td>{{$singlePurchase->purchase_details->purchase->purchase_date}}</td>
                                <td>{{$singlePurchase->barcode}}</td>
                                {{-- <td>{{$singlePurchase->stock->quantity}}</td> --}}
                            </tr>

                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function () {

        var table = $('#itemTable').DataTable({
            lengthChange: false,
            stateSave: true,
            buttons: ['copy', 'excel', 'pdf', 'print', 'colvis'],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true
        });

        table.buttons().container().appendTo('#itemTable_wrapper .col-md-6:eq(0)');

    });
    
</script>

@endsection
