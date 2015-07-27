<div class="aftermesaj">
    <div class="inchide-login close-white"></div>
    <div class="afterbarsus">
        <h2>Editeaza Tichet</h2>
    </div>
    <input type="text" id="subiect" class="mod-subiect" value="{{$ticket->subiect}}" />
    <br />
    <textarea class="mod-ticket">{{$ticket->mesaj}}</textarea>
    <br /><br />
    <div class="confirm2"><div class="tick-white"></div>Modifica</div>
    <div class="refuz2"><div class="close-white cls-x"></div>Abandoneaza</div>
</div>