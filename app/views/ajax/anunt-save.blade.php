@foreach ($anunturi as $anunt)
@if ($anunt['confirm']==1 || $anunturi['work']==1 && $anunt['titlu']!="")
<div class="anunturi @if ($anunt['promovat']==1) promovat  @endif">
    <div class="data-ant">{{$anunt['data']}}<br />{{substr($anunt['ora'], 0, -3)}}</div>
    <div class="preview"><img {{$anunt['orientare']==1 ? 'class="height"' : ''}} src="{{isset($anunt['preview']) ? $anunt['preview'] : '/img/default.png'}}" alt="Imagine" /></div>
    <div class="anuntcon">
        <a href="/anunt/{{preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $anunt['titlu'])).'-'.$anunt['id']}}"><span>{{$anunt['titlu']}}</span></a><br /><br />
        <span class="categorie">{{$anunt['categorie'].' -> '.$anunt['subcategorie']}}</span><br/>
        <span class="orasanunt">{{$anunt['oras']}}, {{$anunt['cartier']}}</span>
    </div>
    <div class="anuntpret">
        {{$anunt['pret']}} {{$anunt['moneda']==0 ? 'Lei.' : '&euro;'}}<br />
        @if ($anunt['negociabil']==1)        <span>Negociabil.</span>
        @else <span></span>
        @endif
    </div>
    <div class="close-white sterge-adssave" title="Sterge Anunt Salvat" id="{{$anunt['id']}}"></div>
</div>
@endif
@endforeach