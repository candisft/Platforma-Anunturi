@if (count($anunturi['promo'])>0 && $anunturi['first']==0)
<div class="adspromo"><span>Anunturi Promovate</span></div>
@foreach ($anunturi['promo'] as $anunt)
@if ($anunt['confirm']==1 || $anunturi['work']==1 && $anunt['titlu']!="")
<a href="/anunt/{{preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $anunt['titlu'])).'-'.$anunt['id']}}">
<div class="anunturi promovat">
    <div class="data-ant">{{$anunt['data']}}<br />{{substr($anunt['ora'], 0, -3)}}</div>
    <div class="preview"><img {{$anunt['orientare']==1 ? 'class="height"' : ''}} src="{{isset($anunt['preview']) ? $anunt['preview'] : '/img/default.png'}}" alt="Imagine" /></div>
    <div class="anuntcon">
        <span>{{$anunt['titlu']}}</span><br /><br />
        <span class="categorie">{{$anunt['categorie'].' -> '.$anunt['subcategorie']}}</span><br/>
        <span class="orasanunt">{{$anunt['oras']}}, {{$anunt['cartier']}}</span>
    </div>
    <div class="anuntpret">
        {{$anunt['pret']}} {{$anunt['moneda']==0 ? 'Lei.' : '&euro;'}}<br />
        @if ($anunt['negociabil']==1)        <span>Negociabil.</span>
        @else <span></span>
        @endif
    </div>
</div>
</a>
@endif
@endforeach
@endif
@if (count($anunturi['anunturi'])>0)
@if ($anunturi['first']==0) <div class="clearfloat"></div><div class="adspromo"><span>Anunturi</span></div><div class="clearfloat"></div> @endif
@foreach ($anunturi['anunturi'] as $anunt)
@if ($anunt['confirm']==1 || $anunturi['work']==1 && $anunt['titlu']!="")
<a href="/anunt/{{preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $anunt['titlu'])).'-'.$anunt['id']}}">
<div class="anunturi @if ($anunt['promovat']==1) promovat2  @endif">
    <div class="data-ant">{{$anunt['data']}}<br />{{substr($anunt['ora'], 0, -3)}}</div>
    <div class="preview"><img {{$anunt['orientare']==1 ? 'class="height"' : ''}} src="{{isset($anunt['preview']) ? $anunt['preview'] : '/img/default.png'}}" alt="Imagine" /></div>
    <div class="anuntcon">
        <span>{{$anunt['titlu']}}</span><br /><br />
        <span class="categorie">{{$anunt['categorie'].' -> '.$anunt['subcategorie']}}</span><br/>
        <span class="orasanunt">{{$anunt['oras']}}, {{$anunt['cartier']}}</span>
    </div>
    <div class="anuntpret">
        {{$anunt['pret']}} {{$anunt['moneda']==0 ? 'Lei.' : '&euro;'}}<br />
@if ($anunt['negociabil']==1)        <span>Negociabil.</span>
@else <span></span>
@endif
    </div>
</div>
</a>
@endif
@endforeach
@endif