@foreach($tickets as $ticket)
<tr id="{{$ticket->id}}"><td>{{$ticket->id}}</td><td>{{$ticket->subiect}}</td><td>@if ($ticket['stare']==0)
        <span class="padding">In asteptare</span>
        @elseif ($ticket['stare']==1)
        <span class="padding">In pregres</span>
        @elseif ($ticket['stare']==2)
        <span class="vazut">Rezolvat</span>
        @elseif ($ticket['stare']==3)
        <span class="sters">Nu s-a rezolvat</span>
        @endif</td><td>{{User::where('id', $ticket->user)->first()->nume}}</td><td>{{$ticket->created_at}}</td><td><div class="cat-promoveaza raspticket" title="Raspunde"></div><div class="cat-dezactiveaza stergeticket" title="Sterge Ticket"></div></td></tr>
@endforeach