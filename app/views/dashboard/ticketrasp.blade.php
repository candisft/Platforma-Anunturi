<div class="header">
    <h2>Ticket "{{$ticket->subiect}}"</h2>
</div>
<select class="stare" id="{{$ticket->id}}"><option {{$ticket->stare==0 ? 'selected' : ''}} value="0">In asteptare</option><option {{$ticket->stare==1 ? 'selected' : ''}} value="1">In progres</option><option {{$ticket->stare==2 ? 'selected' : ''}} value="2">Rezolvat</option><option {{$ticket->stare==3 ? 'selected' : ''}} value="3">Nu s-a rezolvat.</option></select>
<div class="reply">
    <p><strong>{{ $ticket['user']->nume }}</strong>: {{$ticket->mesaj}}</p>
</div>
@foreach (Reply::where('ticket', $ticket->id)->get() as $reply)
 <div class="reply">
     <p><strong>{{$reply->send==1 ? 'Administrator' : $ticket['user']->nume}}</strong>: {{$reply->mesaj}}</p>
 </div>
@endforeach
<textarea id="mesaj"></textarea>
<div class="zona">
    <div class="salveaza raspundeticket">Raspunde</div>
    <div class="clearfloat"></div>
</div>