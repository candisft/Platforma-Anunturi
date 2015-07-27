@if (count($tickete)>0)
@foreach ($tickete as $ticket)
<tr>
    <td><a href="" class="openTicket">#{{$ticket['id']}}</a></td>
    <td>
        @if ($ticket['stare']==0)
        <span class="padding">In asteptare</span>
        @elseif ($ticket['stare']==1)
        <span class="padding">In pregres</span>
        @elseif ($ticket['stare']==2)
        <span class="vazut">Rezolvat</span>
        @elseif ($ticket['stare']==3)
        <span class="sters">Nu s-a rezolvat</span>
        @endif
    </td>
    <td>
        {{$ticket['user']['nume']}}
    </td>
    <td>
        {{$ticket['created_at']}}
    </td>
    <td>
        @if ($ticket['stare']==0)
        <div class="cat-edit edit-ticket" id="{{$ticket['id']}}" title="Editeaza Tichet"></div>
        @endif
        <div class="cat-dezactiveaza sterge-ticket" id="{{$ticket['id']}}" title="Sterge Tichet"></div>
    </td>
</tr>
@endforeach
@else
Nu sunt tickete noi.
@endif