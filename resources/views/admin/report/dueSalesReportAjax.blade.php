@php
 $total = 0;
@endphp
@foreach ($dueSalesDetails as $dueSale)
{{-- <tr style="text-align:center;" onclick="window.open('{{url('saleDetailsView',$dueSale->order_id)}}');"> --}}
<tr style="text-align:center;">

    <td>{{$loop->iteration}}</td>
    <td>
        <a onclick="invoiceModal({{ @$dueSale->order_id }})"
           style="padding: 5px 10px;color: #fff;cursor: pointer;" class="btn badge badge-primary"
           data-toggle="tooltip" title="" data-original-title="Invoice">
            #0202{{$dueSale->order_id}}
        </a>
    </td>
    <td>{{$dueSale->created_at}}</td>
    <td>
        <a class="custom_textDecoration" style="cursor: pointer;color:#C70909" onclick="window.open('{{url('completedOrderDetailsView',$dueSale->order_id)}}');">
            {{$dueSale->first_name}} {{$dueSale->last_name}}
        </a>
    </td>
    <td>{{$dueSale->phone_number}}</td>
    <td>{{$dueSale->invoice_date}}</td>
    <td>{{$dueSale->payment_due}}</td>
    <td>{{$dueSale->sales_due_payment->sum('paid_amount')}}</td>
    <td>{{$dueSale->payment_due - $dueSale->sales_due_payment->sum('paid_amount')}}</td>


    @php
    $total+= $dueSale->payment_due - $dueSale->sales_due_payment->sum('paid_amount');
    @endphp
</tr>
@endforeach
<tr>
    <th colspan="8" class="text-center">Total</th>
    <td class="text-center">{{$total}}</td>
</tr>
