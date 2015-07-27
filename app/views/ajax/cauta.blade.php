<div class="continut">
    <div class="part1">
        <div class="categorishow">
            <div class="categorishowheader">Anunturi Galati/Braila</div>
            <ul>
                <li class="categ"><a href="/auto"><div class="caticon cat-auto"></div><br />Auto</a></li>
                <li class="categ"><a href="/imobiliare"><div class="caticon cat-imobiliare"></div><br />Imobiliare</a></li>
                <li class="categ"><a href="/electronice"><div class="caticon cat-electronice"></div><br />Electronice</a></li>
                <li class="categ"><a href="/moda-si-frumusete"><div class="caticon cat-moda-si-frumusete"></div><br />Moda si Frumusete</a></li>
                <li class="categ"><a href="/casa-si-gradina"><div class="caticon cat-gradina"></div><br />Casa si Gradina</a></li>
                <li class="categ"><a href="/mama-si-copilul"><div class="caticon cat-mama-si-copilul"></div><br />Mama si Copilul</a></li>
                <li class="categ"><a href="/sport-si-arta"><div class="caticon cat-sport-si-arta"></div><br />Sport si Arta</a></li>
                <li class="categ"><a href="/animale"><div class="caticon cat-animal"></div><br />Animale</a></li>
                <li class="categ"><a href="/industrie"><div class="caticon cat-industrie"></div><br />Industrie</a></li>
                <li class="categ"><a href="/servicii-si-afaceri"><div class="caticon cat-servicii"></div><br />Servicii si Afaceri</a></li>
                <li class="categ"><a href="/locuri-de-munca"><div class="caticon cat-locuri-de-munca"></div><br />Locuri de Munca</a></li>
                <li class="categ"><a href="/adult"><div class="caticon cat-adult"></div><br />Adult (+18)</a></li>
            </ul>
            <div class="clearfloat"></div>
        </div>
    </div>
    <div class="part2">
        @if (count($anunturi['anunturi']) == 0 && count($anunturi['promo']) == 0)
        Nu exista rezultate !
        @else
        @if (count($anunturi['promo'])>0)
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
        <div class="anunturi @if ($anunt['promovat']==1) promovat  @endif">
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
        @endif
    </div>
    <div class="clearfloat"></div>
</div>
