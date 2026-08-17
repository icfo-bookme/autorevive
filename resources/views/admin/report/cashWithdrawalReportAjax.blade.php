@php
 $total = 0;
@endphp

@foreach ($cashWithdrawalDetails as $cash)
    <tr style="text-align:center;">
        <td>{{$loop->iteration}}</td>
        <td>{{$cash->user->name}}</td>
        <td>{{$cash->user->phone}}</td>
        <td>{{$cash->date}}</td>
        <td>{{$cash->description}}</td>
        <td>{{$cash->withdraw_by}}</td>
        <td>{{$cash->created_at}}</td>
        <td>{{$cash->amount}}</td>
        @php
        $total+= $cash->amount;
        @endphp
    </tr>
@endforeach

<tr>
    <th colspan="7" class="text-center">Total</th>
    <td class="text-center">{{$total}}</td>
</tr>
    