@if (count($datas['mesaje'])>0)
@if ($datas['locatie']=="Sterse")
@foreach ($datas['mesaje'] as $mesaj)
<div class="mesaje">
    <ul>
        <li>{{$mesaj['nume']}}</li>
        <li>{{$mesaj['email']}}</li>
        <li>{{$mesaj['telefon']}}</li>
        <li>{{$mesaj['created_at']}}</li>
        <li>
            <div class="cat-dezactiveaza2 dez-mesaj" id="{{$mesaj['id']}}" title="Sterge Mesajul"></div>
            <div class="cat-muta-inapoi muta-mesaj" id="{{$mesaj['id']}}" title="Muta Mesajul"></div>
        </li>
    </ul>
    <h2>Anuntul <a href="/anunt/{{preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $mesaj['anunt']['titlu'])).'-'.$mesaj['anunt']['id']}}">"{{$mesaj['anunt']['titlu']}}"</a></h2>
    <p>{{$mesaj['mesaj']}}</p>
</div>
@endforeach
@elseif ($datas['locatie']=="New")
@foreach ($datas['mesaje'] as $mesaj)
<div class="mesaje">
    <ul>
        <li>{{$mesaj['nume']}}</li>
        <li>{{$mesaj['email']}}</li>
        <li>{{$mesaj['telefon']}}</li>
        <li>{{$mesaj['created_at']}}</li>
        <li>
            <div class="cat-dezactiveaza2 dez-mesaj" id="{{$mesaj['id']}}" title="Sterge Mesajul"></div>
            <div class="cat-promoveaza2 rasp-mesaj" id="{{$mesaj['id']}}" title="Raspunde"></div>
        </li>
    </ul>
    <div class="nwm">
        <textarea id="newmsg" class="newmsg"></textarea>
        <div class="trimitemesajnew" id="{{$mesaj['id']}}">Trimite</div>
    </div>
    <h2>Anuntul <a href="/anunt/{{preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $mesaj['anunt']['titlu'])).'-'.$mesaj['anunt']['id']}}">"{{$mesaj['anunt']['titlu']}}"</a></h2>
    <p>{{$mesaj['mesaj']}}</p>
    <div class="clearfloat"></div>
</div>
@endforeach
@elseif ($datas['locatie']=="Trimise")
@foreach ($datas['mesaje'] as $mesaj)
<div class="mesaje">
    <ul>
        <li>De la {{$mesaj['nume']}}</li>
        <li>Pentru {{User::where('id', $mesaj['user2'])->pluck('nume')}}</li>
        <li>{{$mesaj['email']}}</li>
        <li>{{$mesaj['telefon']}}</li>
        <li>{{$mesaj['created_at']}}</li>
    </ul>
    <h2>Anuntul <a href="/anunt/{{preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $mesaj['anunt']['titlu'])).'-'.$mesaj['anunt']['id']}}">"{{$mesaj['anunt']['titlu']}}"</a></h2>
    <p>{{$mesaj['mesaj']}}</p>
</div>
@endforeach
@endif
@else
Nu sunt mesaje !
@endif