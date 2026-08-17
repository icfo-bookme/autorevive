@foreach ($fundDetails as $detail)
    <tr style="text-align:center;">
        <td>{{$loop->iteration}}</td>
        <td>{{$detail->amount}}</td>
        <td>{{$detail->created_at}}</td>
    </tr>
@endforeach

