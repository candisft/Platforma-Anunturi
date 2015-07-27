@if (count($anunturi)>0)
<table class="ticket ads">
    <thead>
    <tr><td>Titlu</td><td>Publicat la data</td><td>Expira la data</td><td>Promovat</td><td>Pret</td><td>Actiuni</td></tr>
    </thead>
    <tbody>
@foreach ($anunturi as $anunt)
@if ($anunt['confirm']==1 || $anunturi['work']==1 && $anunt['titlu']!="")
<tr id="{{$anunt['id']}}"><td><a href="/anunt/{{preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $anunt['titlu'])).'-'.$anunt['id']}}">{{$anunt['titlu']}}</a></td><td>{{$anunt['created_at']}}</td><td>{{$anunt['expired_at']}}</td><td>{{$anunt['promovat']==1 ? $anunt['pachet'] : 'Nu'}}</td><td>{{$anunt['pret']}} Lei.</td><td><a href="/modifica/anunt/{{$anunt['id']}}"><div class="cat-edit" title="Modifica Anunt"></div></a><div class="cat-dezactiveaza @if ($anunt['confirm']==0) sterge-anunt @else dezactiveaza-anunt @endif" title="@if ($anunt['confirm']==0) Sterge Anunt @else Dezactiveaza Anunt @endif"></div>@if ($anunt['confirm']==0) <div class="cat-reactualizeaza reanunt" title="Reactiveaza Anunt"></div> @else <a href="/promoveaza/alege-pachet/{{$anunt['id']}}"><div class="cat-promoveaza" title="Promoveaza Anunt"></div></a> @endif</td></tr>
@endif
@endforeach
</tbody>
</table>
@endif