
@extends('layouts.backend.master')
@section('content')
@php
$userid=Auth::user()->id;
@endphp
<style>
    .footer{
            position: fixed !important;
            left: 0px !important;
            bottom: 0 !important;
        }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> All Sold Items </div>
            <div class="card-body">
                <div class="clearfix"></div>
                <div class="table-responsive">
                    {{-- <table id="soldItemsDataTable" class="table table-bordered" style="width: 100% !important;"> --}}
                    <table id="salesCompletedTable" class="table table-bordered" style="width: 100% !important;">
                        <thead class="text-center">
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th>Cost Price</th>
                                <th>Invoice ID</th>
                                <th>Invoice Date</th>
                                <th>Barcode</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                            <tr>
                                <td>
                                    <a class="custom_textDecoration" href="{{url('completedOrderDetailsView',@$order->order_id)}}" style="cursor: pointer">
                                        {{$order->product->name}}
                                    </a>
                                </td>
                                <td>{{$order->quantity}}</td>
                                <td>{{$order->unit_price}}</td>
                                <td>{{$order->price}}</td>
                                <td>{{$order->cost_price}}</td>
                                <td>#0202{{$order->order_id}}</td>
                                <td>{{$order->sales->invoice_date}}</td>
                                <td>{{($order->barcode) ? $order->barcode->barcode : "Not found"}}</td>
                                <td>
                                    <a onclick="invoiceModal({{ @$order->order_id }})"
                                    style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary"
                                    data-toggle="tooltip" title="" data-original-title="Invoice">
                                    Invoice
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                            </tr>
                        </tbody>
                    </table>
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


<script>
    $(document).ready(function () {

         function modalHide(){
             $('#invoiceModal').modal('hide');
         }

         var table = $('#salesCompletedTable').DataTable({
            "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
            scrollY: 500,
            scrollX: true,
            scrollCollapse: true,
        });


        //  const csrf_token = "{{ csrf_token() }}";
        //  var table = $('#soldItemsDataTable').DataTable({
        //     // "aLengthMenu": [[ 10,50,100,500,1000,-1], [10,50,100,500,1000,"ALL"]],
        //     responsive: true,
        //     lengthMenu: [5, 10, 25, 50, 100, 500],
        //     pageLength: 10,
        //     stateSave: true,
        //     language: {
        //         'lengthMenu': 'Display _MENU_',
        //         processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw processingColor"></i>'
        //     },
        //     scrollY: 500,
        //     scrollX: true,
        //     scrollCollapse: true,
        //     searchDelay: 500,
        //     processing: true,
        //     serverSide: true,
        //     order: ['2'],
        //     ajax: {
        //         url: route('listAllSoldItems'),
        //         data: function(data) {
        //             data._token = csrf_token;
        //         },
        //         type: 'post',
        //     },
        //     columns: [
        //         {
        //             data: 'item_name',
        //             name: 'item_name',
        //             "orderable": true,
        //             "searchable": true,
        //             width: "10%"
        //         },
        //         {
        //             data: 'quantity',
        //             name: 'quantity',
        //             "orderable": true,
        //             "searchable": true,
        //             width: "10%"
        //         },
        //         {
        //             data: 'unit_price',
        //             name: 'unit_price',
        //             "orderable": true,
        //             "searchable": true,
        //             width: "10%"
        //         },
        //         {
        //             data: 'price',
        //             name: 'price',
        //             "orderable": true,
        //             "searchable": true,
        //             width: "10%"
        //         },
        //         {
        //             data: 'cost_price',
        //             name: 'cost_price',
        //             "orderable": true,
        //             "searchable": true,
        //             width: "10%"
        //         },
        //         {
        //             data: 'invoice_id',
        //             name: 'invoice_id',
        //             "orderable": true,
        //             "searchable": true,
        //             width: "10%"
        //         },
        //         {
        //             data: 'invoice_date',
        //             name: 'invoice_date',
        //             "orderable": true,
        //             "searchable": true,
        //             width: "10%"
        //         },
        //         {
        //             data: 'barcode',
        //             name: 'barcode',
        //             "orderable": true,
        //             "searchable": true,
        //             width: "10%"
        //         },
        //         {
        //             data: 'action',
        //             name: 'action',
        //             "orderable": false,
        //             searchable: false,
        //             width: "10%"
        //         },
        //     ],
        //     dom: '<"top-toolbar row"<"top-left-toolbar col-md-9"lB><"top-right-toolbar col-md-3"f>>rt<"bottom-toolbar"<"bottom-left-toolbar"i><"bottom-right-toolbar"p>>',
        //     buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
        // });

    });

    //  invoice modal
     function invoiceModal(id) {
         console.log(id);
        $.get(`invoicePrintViewUser/${id}`, function (data) {

            $('#invoice_detail_modal').html(data);
        });

        $("#invoiceModal").modal('show');
    }



</script>
@endsection
