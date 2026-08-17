@php
$totalAmount = 0;
$totalPaidAmount = 0;
$totalDueAmount = 0;
@endphp
@foreach ($purchases as $purchase)
<tr style="text-align:center;" onclick="window.open(`{{ URL('purchaseInfoView', $purchase->id) }}`)">
{{-- <tr style="text-align:center;" onclick="window.open('{{url('pendingOrderDetailsView',$purchase->id)}}');"> --}}

    <td>{{ $loop->iteration }}</td>
    <td>{{ $purchase->invoice_number }}</td>
    <td>{{ $purchase->vendor->name }}</td>
    <td>
        <img width="60" src="{{ asset($purchase->challan_img) }}" alt="">
    </td>
    <td>{{ $purchase->purchase_date }}</td>
    <td>{{ $purchase->total_amount }}</td>
    <td>{{ $purchase->paid_amount }}</td>
    <td>{{ $purchase->due_amount }}</td>
    {{-- <td>{{$purchase->created_at}}</td> --}}
    @php
    $totalAmount+= $purchase->total_amount;
    $totalPaidAmount+= $purchase->paid_amount;
    $totalDueAmount+= $purchase->due_amount;
    @endphp
</tr>
@endforeach
<tr>
    <th colspan="5" class="text-right">Total</th>
    <td class="text-center">{{$totalAmount}}</td>
    <td class="text-center">{{$totalPaidAmount}}</td>
    <td class="text-center">{{$totalDueAmount}}</td>
</tr>