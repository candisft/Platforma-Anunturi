@yield('header')
@yield(((!Auth::check()) ? 'loginregister' : '' ))
@yield('addanuntmesaje')
@yield(((!Auth::check()) ? 'fixedbar' : 'fixedbarlogat' ))
@yield('toppart')
<div class="continut">
    <div class="mesages"></div>
    <div class="camp">
        <span class="cont-set">Titlu</span><br />
        <input class="setting-input" type="text" id="titlu" value="{{$data['anunt']['titlu']}}" placeholder="Titlu Anunt ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Titlu Anunt ...'"  />
        <div class="nrramas2">Numar ramas de caractere <span id="nrramas2">{{70-strlen($data['anunt']['titlu'])}}</span></div>
    </div>
    <div class="camp">
        <span class="cont-set">Categorie</span><br />
        <input class="setting-input" id="categoriselect" value="{{$data['anunt']['categorie']}}" type="text"  >
        <div class="chose">
            <ul>
                @foreach($data['categorii'] as $categorie)
                <li>{{$categorie->nume}}</li>
                @endforeach
            </ul>
            <div class="clearfloat"></div>
        </div>
    </div>
    <div class="camp">
        <span class="cont-set">Subcategorie</span><br />
        <input class="setting-input" id="subcategoriselect" type="text" value="{{$data['anunt']['subcategorie']}}" >
        <div class="chose subcategoriechose">
            <ul>
                <li>Selecteaza Categoria Intai</li>
            </ul>
            <div class="clearfloat"></div>
        </div>
    </div>
    <div class="camp">
        <span class="cont-set">Descriere Anunt</span><br />
        <textarea class="anuntaddarea" maxlength="1000" id="anunt">{{$data['anunt']['continut']}}</textarea>
        <div class="nrramas">Numar ramas de caractere <span id="nrramas">{{1000-strlen($data['anunt']['continut'])}}</span></div>
    </div>
    <div class="camp">
        <span class="cont-set">Pret</span><br />
        <input class="setting-input" type="text" id="pret" value="{{$data['anunt']['pret']}} Lei." placeholder="Pret ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Pret ...'"  />
        <div class="nrramas2">Pretul este negociabil ?<input type="checkbox" id="negociabil" @if ($data['anunt']['negociabil']==1) checked @endif  ></div>
    </div>
    <div class="camp">
        <label>Moneda<span class="obl">*</span></label><br />
        {{$data['anunt']['moneda']==0 ? '<div class="clickchoes choes-activ" id="lei">Leu<div class="tick-green"></div></div><div class="clickchoes chadj" id="euro">Euro</div>' : '<div class="clickchoes" id="lei">Leu</div><div class="clickchoes chadj choes-activ" id="euro">Euro<div class="tick-green"></div></div>'}}
    </div>
    <div class="camp">
        <span>Imagini</span><br />
        @foreach ($data['imagini'] as $imagine)
        {{ Form::open( [ 'url' => '/ajax/uploadimage', 'method' => 'post', 'files' => true, 'id'=>'addimg' ] ) }}
        <div class="addimagine"><div class="close-white delete-imgFromDB"></div><img src="{{$imagine['link_mini']}}" alt="Imagine" /></div>
        {{ Form::close() }}
        @endforeach
        @for ($i=1; $i<=5-count($data['imagini']); $i++)
        {{ Form::open( [ 'url' => '/ajax/uploadimage', 'method' => 'post', 'files' => true, 'id'=>'addimg' ] ) }}
        <div class="addimagine"><input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine</div>
        {{ Form::close() }}
        @endfor
        <div class="clearfloat"></div>
    </div>
    <div class="camp">
        <span>Apasand pe butonul "Trimite" de mai jos declari ca esti de acord cu Termenii si Conditiile</span><br />
        <span>Modificarile facute necesita aprobarea unui moderator. Acest proces poate dura maxim 12 de ore.</span>
        <div class="trimite2">Modifica</div>
    </div>
    <div class="clearfloat"></div>

@yield('footer')