<div class="aftermesaj">
    <div class="inchide-login close-white"></div>
    <div class="afterbarsus">
        <h2>Ticket #{{$data['ticket']['subiect']}}</h2>
    </div>
    <div class="aftermesajcon">
        <ul class="ticket-mesaj">
            <li>{{$data['ticket']['mesaj']}}<span class="ora">{{$data['ticket']['created_at']}}</span></li>
            @foreach ($data['replys'] as $reply)
            <li @if ($reply['send']==1) class="admin" @endif >{{$reply['mesaj']}}<span class="ora">{{$reply['created_at']}}</span></li>
            @endforeach
        </ul>
    </div>
    <div class="send-reply">
        <textarea></textarea>
        <div class="sendreply {{$data['work']}}">Trimite</div>
    </div>
    <div class="clearfloat"></div>
</div>
