@php
$total = 0;
@endphp
@foreach ($deliveries as $delivery)
{{-- <tr style="text-align:center;" onclick="window.open('{{url('shipmentOrderDetailsView',$delivery->id)}}');"> --}}
<tr style="text-align:center;" onclick="window.open('{{url('pendingOrderDetailsView',$delivery->id)}}');">

    <td>{{$loop->iteration}}</td>
    <td>#0101{{$delivery->id}}</td>
    <td>
        <a class="custom_textDecoration" style="cursor: pointer">
            {{$delivery->first_name}} {{$delivery->last_name}}
        </a>
    </td>
    <td>{{$delivery->phone_number}}</td>
    {{-- <td>{{$delivery->email}}</td> --}}
    <td>{{$delivery->created_at}}</td>
    <td>{{$delivery->total_price[0]->total}}</td>

    @php
    $total+= $delivery->total_price[0]->total;
    @endphp

</tr>
@endforeach
<tr>
    <td colspan="5" class="text-right">Total =</td>
    <td class="text-center">{{$total}}</td>
</tr>
