@section('fixedbar')
<div class="tutorialcon">
</div>
<div class="fb">
    <div class="fixedbar">
        <a href="/"><img class="logo" src="/img/logo.png" alt="Logo" /></a>
        <div class="meniu">
            <div class="meniu-icon"><div class="spanaux"><div class="menu25"></div></div>
                <ul class="meniu-responsive">
                    <li class="buton tuto">Ajutor !<div class="tutorial"></div></li>
                    <li class="buton log logeazamate"><div class="userlogin"></div>Logheaza-te</li>
                    <li class="buton add"><a href="/adauga-anunt"><div class="addads"></div>Adauga Anunt</a></li>
                </ul>
                <div class="clearfloat"></div>
            </div>
        </div>
    </div>
</div>
@stop
@section('toppart')
<div class="toppart">
    <div class="bottomtoppart">
        <input class="cautare" type="text" placeholder="Portal de anunturi prin Galati si Braila ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Portal de anunturi prin Galati ...'"  />
        <div class="clearfloat"></div>
        <div class="chosetown">
            Alege Judetul: <span>Galati</span> \ <span>Braila</span>
        </div>
        <div class="pretul">
            Cu pretul cuprins intre <input class="pret-de-la" type="text" > si <input class="pret-la" type="text" >
        </div>
        <div class="clearfloat"></div>
        <div class="cauta-cat">
            <span>Categorii:</span>
            <div class="cat-lista">
                <div class="texbox-cat">Toate Categoriile</div>
                <ul class="scrollable">
                    <li>Toate Categoriile</li>
                    @foreach($data['categorii'] as $categorie)
                    <li class="categorie">{{$categorie->nume}}</li>
                    @foreach($categorie->subcategorie as $subcategorie)
                    <li>{{$subcategorie->nume}}</li>
                    @endforeach
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="cauta-cart">
            <span>Oras/Localitate:</span>
            <div class="cart-lista">
                <div class="texbox-cart">Toate Localitatile</div>
                <ul class="scrollable">
                    <li>Toate Localitatile</li>
                    @foreach($data['cartiere'] as $cartier)
                    <li>{{$cartier->nume}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="clearfloat"></div>
    </div>
</div>
@if (Auth::check() && Auth::user()->password=="")
<div class="message-necom"><a href="/contul-meu/setari">Nu ai setata o parola ! Click pentru a seta parola contului tau.</a></div>
@endif
<div class="conn">
    @stop
    @section('header')
    <!DOCTYPE html>
    <html lang="ro">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>{{isset($data['titlu']) ? $data['titlu'].' ' : ''}}Anunturi Gratuite - Portalul anunturilor gratuite din Galati si Braila</title>
        <meta name="robots" content="nofollow" />
        <meta name="description" content="Anunturi Gratuite pentru judetele Galati si Braila. Este un portal de anunturi gratuite, dedicat oraselor Galati si Braila, si localitatilor din jurul lor.">
        <meta name="keywords" content="anunturi,anunturi gratuite,anunturi gratis,anunturi online,anunt,anunturi galati,anunturi braila,anunturi galati braila">
        <meta name="viewport" content="width=device-width">
        <meta name="fl-verify" content="0f56c7420953dc738017e45e72c63184">
        <meta property="og:title" content="{{isset($data['titlu']) ? $data['titlu'].' ' : ''}}Anunturi Gratuite - Portalul anunturilor gratuite din Galati si Braila"/>
        <meta property="og:description" content="{{isset($data['descriere']) ? $data['descriere'] : 'Anunturi Gratuite pentru judetele Galati si Braila. Este un portal de anunturi gratuite, dedicat oraselor Galati si Braila, si localitatilor din jurul lor.'}}"/>
        <meta property="fb:app_id" content="544725312340549"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="/css/animate.css" >
        <link rel="stylesheet" href="/css/perfect-scrollbar.min.css" >
        <link rel="stylesheet" href="/css/jquery-ui.min.css" >
        <link rel="stylesheet" href="/css/jquery-ui.structure.min.css" >
        <link rel="stylesheet" href="/css/jquery-ui.theme.min.css" >
        <link rel="stylesheet" href="/css/app.css" >
        <link rel="stylesheet" href="/css/icon.css" >
        <link rel="stylesheet" href="/css/app-responsive.css" media="screen and (max-width: 655px)" >
        <link rel="shortcut icon" type="image/x-icon" href="/img/favicon.ico">
        <script src="/js/jquery-1.10.2.min.js"></script>
        <script src="/js/jquery.iframe-transport.js"></script>
        <script src="/js/perfect-scrollbar.with-mousewheel.min.js"></script>
        <script src="/js/perfect-scrollbar.min.js"></script>
        <script src="/js/jquery-ui.min.js"></script>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-55024539-1', 'auto');
            ga('send', 'pageview');

        </script>
    </head>
    <body>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '544725312340549',
                xfbml      : true,
                version    : 'v2.1'
            });
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
    @stop
    @section('primapagina')
    <div class="continut index">
        <ul class="indexcat">
            <li class="categ"><a href="auto"><div class="caticon cat-auto"></div><br />Auto</a></li>
            <li class="categ"><a href="imobiliare"><div class="caticon cat-imobiliare"></div><br />Imobiliare</a></li>
            <li class="categ"><a href="electronice"><div class="caticon cat-electronice"></div><br />Electronice</a></li>
            <li class="categ"><a href="moda-si-frumusete"><div class="caticon cat-moda-si-frumusete"></div><br />Moda si Frumusete</a></li>
            <li class="categ"><a href="casa-si-gradina"><div class="caticon cat-gradina"></div><br />Casa si Gradina</a></li>
            <li class="categ"><a href="mama-si-copilul"><div class="caticon cat-mama-si-copilul"></div><br />Mama si Copilul</a></li>
            <li class="categ"><a href="sport-si-arta"><div class="caticon cat-sport-si-arta"></div><br />Sport si Arta</a></li>
            <li class="categ"><a href="animale"><div class="caticon cat-animal"></div><br />Animale</a></li>
            <li class="categ"><a href="industrie"><div class="caticon cat-industrie"></div><br />Industrie</a></li>
            <li class="categ"><a href="servicii-si-afaceri"><div class="caticon cat-servicii"></div><br />Servicii si Afaceri</a></li>
            <li class="categ"><a href="locuri-de-munca"><div class="caticon cat-locuri-de-munca"></div><br />Locuri de Munca</a></li>
            <li class="categ" style="height: 70px; line-height: 65px;"><a href="#other">No more...</li>
        </ul>
        <div class="clearfloat"></div>
        <div class="trei">
            <a href="adauga-anunt"><div class="addanunt-index">+ Adauga Anunt</div></a>
            <ul>
                <li><div class="tick-green"></div>Gratuit si <strong>fara cont pe site</strong> !</li>
                <li><div class="tick-green"></div>Posibilitatea de a modifica oricand anuntul !</li>
                <li><div class="tick-green"></div>Valabil <strong>30 de zile</strong> cu posibilitatea de reinnoire!</li>
            </ul>
        </div>
        <div class="trei">
            <div class="promanunt">Promoveaza</div>
            <ul>
                <li><div class="tick-green"></div>3 pachete facute special pentru tine.</li>
                <li><div class="tick-green"></div>Design special pentru fiecare anunt promovat.</li>
                <li><div class="tick-green"></div>Anuntul beneficiaza de reinnoire zilnica !</li>
            </ul>
        </div>
        <div class="trei">
            <div class="promanunt">Pachete Promo</div>
            <ul>
                <li><div class="tick-green"></div>Bronze Bird (7 zile de promovare) <br />3 euro</li>
                <li><div class="tick-green"></div>Silver Coin (14 zile de promovare) <br /> 5 euro</li>
                <li><div class="tick-green"></div>Gold Gun (30 de zile de promovare)<br /> 7 euro</li>
            </ul>
        </div>
        <div class="clearfloat"></div>
        @stop
        @section('footer')
        <div class="footer">
            <img class="footerlogo" src="/img/footerlogo.png" alt="Logo" />
            <span>&copy; Platforma Anunturi 2014</span>
            <a href="/sitemap.xml">Sitemap</a><a href="/adauga-anunt">Adauga Anunt</a><a href="/contact">Contact</a><a href="/termeni-si-conditii">Termeni si Conditii</a><a href="/ajutor">Ajutor</a>
            <div class="clearfloat"></div>
        </div>
    </div>
</div>
<script src="/js/app.js"></script>
<script src="/js/app-action.js"></script>
<script src="/js/tutorial.js"></script>
</body>
</html>
@stop
@section('loginregister')
<div class="logincon">
</div>
@stop
@section('addanuntmesaje')
<div class="afteradd"></div>
@stop
@section('fixedbarlogat')
<div class="tutorialcon">
</div>
<div class="fb">
    <div class="fixedbar">
        <a href="/"><img class="logo" src="/img/logo.png" alt="Logo" /></a>
        <div class="meniu">
            <div class="meniu-icon"><div class="spanaux"><div class="menu25"></div></div>
                <ul class="meniu-responsive">
                    <li class="buton tuto">Ajutor !<div class="tutorial"></div></li>
                    <li class="buton log autentificat"><a href="/contul-meu/setari"><div class="userlogin"></div>{{ isset($data['nume']) ? $data['nume'] : 'Contul meu'}}{{isset($data['nottotal']) && $data['nottotal']>0 ? '<div class="notificare notnume">'.$data['nottotal'].'</div>' : ''}}</a>
                        <ul class="meniu-user">
                            <li><a href="/adauga-credit"><span><div class="cat-myfounds"></div>Credit: {{isset($data['credit']) ? $data['credit'] : 'Contul meu'}} &euro;</span></a></li>
                            <li><a href="/contul-meu/anunturile-mele"><span><div class="cat-myads"></div>Anunturile Mele</span></a></li>
                            <li><a href="/contul-meu/setari"><span><div class="cat-settings"></div>Setari</span></a></li>
                            <li><a href="/contul-meu/mesaje"><span><div class="cat-minimessages"></div>Mesaje{{isset($data['numarmesaje']) && $data['numarmesaje']>0 ? '<div class="notificare">'.$data['numarmesaje'].'</div>' : ''}}</span></a></li>
                            <li><a href="/contul-meu/plati"><span><div class="cat-miniplati"></div>Plati</span></a></li>
                            <li><a href="/contul-meu/tichete"><span><div class="cat-miniticket"></div>Tichete</span></a></li>
                            <li><a href="/contul-meu/anunturi-salvate"><span><div class="cat-minisaveads"></div>Anutnuri Salvate</span></a></li>
                            {{ (Auth::check() && Auth::user()->admin==1) ? '<li><a href="/administrator"><span><div class="cat-miniadmin"></div>Admin Panel<div class="notificare">'.$data['numaradmin'].'</div></span></a></li>' : '' }}
                            <li id="logout"><span><div class="cat-logout"></div>Logout</span></li>
                        </ul>
                    </li>
                    <li class="buton add"><a href="/adauga-anunt"><div class="addads"></div>Adauga Anunt</a></li>
                </ul>
                <div class="clearfloat"></div>
            </div>
        </div>
    </div>
</div>
@stop
@section('categorie')
<div class="continut">
<div class="part1">
    <div class="categorishow">
        <div class="categorishowheader">Anunturi Galati/Braila</div>
        <div class="showcat">
        <div class="catshownavigator vezisubcategori">Vezi Subcategorii</div>
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
        </ul>
        <div class="clearfloat"></div>
        </div>
        <div class="showsubcat">
            <div class="catshownavigator vezicategori">Inapoi la Categorii</div>
            <ul>
                <li class="cattt">{{str_replace('-', ' ', ucfirst($data['categorie']))}}</li>
                @foreach ($data['subcategorie'] as $subcategorie)
                <li><a href="/{{$data['categorie']}}/{{$subcategorie->codunic}}"><span>{{ucfirst($subcategorie->nume)}}</span></a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="part2">
    {{isset($data['listaanunturi']) ? $data['listaanunturi'] : ''}}
    <script>
        function getCateLengh() { return $('.categorieon').size(); }
        $('.part2').before('<div class="categorieon"></div>');
        var categorie = window.location.pathname.split('/');
        if (categorie.length==2) var path = '0';
        else if (categorie.length==3) var path = '1';
        categorie = categorie[categorie.length-1];
        var pagina = 1;
        var h=1;
        var z=0;
        $.post('/ajax/code-to-name',{ code: categorie }, function(data) { data = data.split('***'); $('.texbox-cat').html(data[1]); if (data[0]==1) $('.texbox-cat').addClass('este-categorie'); });
        //$.post('/ajax/first-ads', { categorie: categorie, path: path, pagina: pagina }, function(data) { $('.part2').html( data ); });
        $(document).scroll(function() {
            if(($(window).scrollTop() + $(window).height() >= ($(document).height()-200)) && h==1 && z==0 && getCateLengh()!=0) {
                z=1;
                pagina=pagina+1;
                $.post('/ajax/first-ads', { categorie: categorie, path: path, pagina: pagina }, function(data) { if (data!="") $('.part2').append( data ); else h=0; }).done(function() { z=0; });
            }
        });
    </script>
</div>
<div class="clearfloat"></div>
@stop
@section('addanunt')
<div class="continut">
<div class="addanunt">
    <h2>Adauga Anunt</h2>
    <div class="clearfloat"></div>
    <div class="camp">
            <label>Titlu Anunt<span class="obl">*</span></label><br />
            <input class="annouce-input" maxlength="70" type="text" id="titlu"  >
            <div class="help-blue" title="Foloseste un titlu atractiv pentru anuntul tau. Te rugam sa nu folosesti majuscule in exces."></div>
            <div class="nrramas2">Numar ramas de caractere <span id="nrramas2">70</span></div>
        </div>
    <div class="camp">
        <label>Categorie<span class="obl">*</span></label><br />
        <input class="annouce-input" id="categoriselect" type="text"  >
        <div class="chose">
            <ul>
                @foreach($data['categorii'] as $categorie)
                <li>{{$categorie->nume}}</li>
                @endforeach
            </ul>
            <div class="clearfloat"></div>
        </div>
        <div class="help-blue" title="Incadreaza anuntul tau intr-o categorie potrivita, astfel cumparatorului ii v-a fi mai usor sa gaseasca anuntul tau."></div>
    </div>
    <div class="camp">
        <label>Subcategorie<span class="obl">*</span></label><br />
        <input class="annouce-input" id="subcategoriselect" type="text"  >
        <div class="chose subcategoriechose">
            <ul>
                <li>Selecteaza Categoria Intai</li>
            </ul>
            <div class="clearfloat"></div>
        </div>
        <div class="help-blue" title="Incadreaza anuntul tau intr-o categorie potrivita, astfel cumparatorului ii v-a fi mai usor sa gaseasca anuntul tau."></div>
    </div>
    <div class="camp">
        <label>Judet<span class="obl">*</span></label><br />
        <input class="annouce-input" type="text" id="orasselect"  >
        <div class="chose">
            <ul>
                <li>Braila</li>
                <li>Galati</li>
            </ul>
            <div class="clearfloat"></div>
        </div>
        <div class="help-blue" title="Selecteaza judetul in care locuiesti."></div>
    </div>
    <div class="camp">
        <label>Oras/Localitate<span class="obl">*</span></label><br />
        <input class="annouce-input" type="text" id="cartierselect"  >
        <div class="cartierechose">
            <ul>
                @foreach($data['cartiere'] as $cartier)
                <li>{{$cartier->nume}}</li>
                @endforeach
            </ul>
            <div class="clearfloat"></div>
        </div>
        <div class="help-blue" title="Alege localitatea in care locuiesti."></div>
    </div>
    <div class="camp">
        <label>Descriere Anunt<span class="obl">*</span></label><br />
        <textarea class="anuntaddarea" maxlength="1000" id="anunt"></textarea>
        <div class="help-blue" title="Descrie cat mai detaliat produsul sau serviciul pe care il oferi. Incearca sa fi realist pentru a nu induce in eroare clientul."></div>
        <div class="nrramas">Numar ramas de caractere <span id="nrramas">1000</span></div>
    </div>
    <div class="camp">
        <label>Pret<span class="obl">*</span></label><br />
        <input type="text" id="pret" class="annouce-input" >
        <div class="help-blue" title="Scrie pretul in lei sau euro."></div>
        <div class="nrramas2">Pretul este negociabil ?<input type="checkbox" id="negociabil" ></div>
    </div>
    <div class="camp">
        <label>Moneda<span class="obl">*</span></label><br />
        <div class="clickchoes" id="lei">Leu</div><div class="clickchoes chadj" id="euro">Euro</div>
    </div>
    <div class="camp">
        <label>Nume<span class="obl">*</span></label><br />
        <input class="annouce-input" type="text" id="nume"  >
        <div class="help-blue" title="Numele persoanei de contact. Se afiseaza pe website."></div>
    </div>
    <div class="camp">
        <label>Tipul de persoana<span class="obl">*</span></label><br />
        <input class="annouce-input" type="text" id="persselect"  >
        <div class="chose">
            <ul>
                <li>Persoana Fizica</li>
                <li>Persoana Juridica</li>
            </ul>
            <div class="clearfloat"></div>
        </div>
        <div class="help-blue" title="Selecteaza tipul de persoana care esti."></div>
    </div>
    <div class="camp">
        <label>Email<span class="obl">*</span></label><br />
        <input class="annouce-input" type="text" id="email"  >
        <div class="help-blue" title="Este necesar un email valid pentru a confirma anuntul. Dupa trimiterea anuntului vei primii un email de confirmare."></div>
        <div class="nrramas2">Email-ul poate fi facut public ?<input type="checkbox" id="showemail" ></div>
    </div>
    <div class="camp">
        <label>Numar Telefon</label><br />
        <input class="annouce-input" type="text" id="telefon"  >
        <div class="help-blue" title="Completeaza cu numarul de telefon pentru a putea fi contactat mai usor de cumparatori."></div>
    </div>
    <div class="camp">
        <label>Skype</label><br />
        <input class="annouce-input" type="text" id="skype"  >
        <div class="help-blue" title="Completeaza cu id-ul tau de skype pentru a putea fi contactat pe Skype. Se afiseaza pe website."></div>
    </div>
    <div class="camp">
        <label>Yahoo:</label><br />
        <input class="annouce-input" type="text" id="yahoo"  >
        <div class="help-blue" title="Completeaza cu id-ul tau de Yahoo pentru a putea fi contactat pe Yahoo. Se afiseaza pe website."></div>
    </div>
    <div class="camp">
        <label>Imagini<span class="obl">*</span></label><br />
        {{ Form::open( [ 'url' => '/ajax/uploadimage', 'method' => 'post', 'files' => true, 'id'=>'addimg' ] ) }}
        <div class="addimagine"><input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine</div>
        {{ Form::close() }}
        {{ Form::open( [ 'url' => '/ajax/uploadimage', 'method' => 'post', 'files' => true, 'id'=>'addimg' ] ) }}
        <div class="addimagine"><input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine</div>
        {{ Form::close() }}
        {{ Form::open( [ 'url' => '/ajax/uploadimage', 'method' => 'post', 'files' => true, 'id'=>'addimg' ] ) }}
        <div class="addimagine"><input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine</div>
        {{ Form::close() }}
        {{ Form::open( [ 'url' => '/ajax/uploadimage', 'method' => 'post', 'files' => true, 'id'=>'addimg' ] ) }}
        <div class="addimagine"><input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine</div>
        {{ Form::close() }}
        {{ Form::open( [ 'url' => '/ajax/uploadimage', 'method' => 'post', 'files' => true, 'id'=>'addimg' ] ) }}
        <div class="addimagine"><input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine</div>
        {{ Form::close() }}
        <div class="clearfloat"></div>
    </div>
    <div class="camp">
        <span>Apasand pe butonul "Trimite" de mai jos declari ca esti de acord cu <a href="/termeni-si-conditii">Termenii si Conditiile</a></span>
        <div class="trimite">Trimite</div>
    </div>
    <div class="clearfloat"></div>
</div>
@stop
@section('addanuntlogat')
<div class="continut">
<div class="addanunt">
    <h2>Adauga Anunt</h2>
    <div class="clearfloat"></div>
    <div class="camp">
        <label>Titlu Anunt<span class="obl">*</span></label><br />
        <input class="annouce-input" maxlength="70" type="text" id="titlu"  >
        <div class="help-blue" title="Foloseste un titlu atractiv pentru anuntul tau. Te rugam sa nu folosesti majuscule in exces."></div>
        <div class="nrramas2">Numar ramas de caractere <span id="nrramas2">70</span></div>
    </div>
    <div class="camp">
        <label>Categorie<span class="obl">*</span></label><br />
        <input class="annouce-input" id="categoriselect" type="text"  >
        <div class="chose">
            <ul>
                @foreach($data['categorii'] as $categorie)
                <li>{{$categorie->nume}}</li>
                @endforeach
            </ul>
            <div class="clearfloat"></div>
        </div>
        <div class="help-blue" title="Incadreaza anuntul tau intr-o categorie potrivita, astfel cumparatorului ii v-a fi mai usor sa gaseasca anuntul tau."></div>
    </div>
    <div class="camp">
        <label>Subcategorie<span class="obl">*</span></label><br />
        <input class="annouce-input" id="subcategoriselect" type="text"  >
        <div class="chose subcategoriechose">
            <ul>
                <li>Selecteaza Categoria Intai</li>
            </ul>
            <div class="clearfloat"></div>
        </div>
        <div class="help-blue" title="Incadreaza anuntul tau intr-o subcategorie potrivita, astfel cumparatorului ii v-a fi mai usor sa gaseasca anuntul tau."></div>
    </div>
    @if (!$data['campuri']['oras'])
    <div class="camp">
        <label>Judet<span class="obl">*</span></label><br />
        <input class="annouce-input" type="text" id="orasselect"  >
        <div class="chose">
            <ul>
                <li>Braila</li>
                <li>Galati</li>
            </ul>
            <div class="clearfloat"></div>
        </div>
        <div class="help-blue" title="Selecteaza judetul pentru care este valabil anuntul tau."></div>
    </div>
    @endif
    @if (!$data['campuri']['cartier'])
    <div class="camp">
        <label>Oras/Localitate<span class="obl">*</span></label><br />
        <input class="annouce-input" type="text" id="cartierselect"  >
        <div class="cartierechose">
            <ul>
                @foreach($data['cartiere'] as $cartier)
                <li>{{$cartier->nume}}</li>
                @endforeach
            </ul>
            <div class="clearfloat"></div>
        </div>
        <div class="help-blue" title="Alege localitatea in care locuiesti."></div>
    </div>
    @endif
    <div class="camp">
        <label>Descriere Anunt<span class="obl">*</span></label><br />
        <textarea class="anuntaddarea" maxlength="1000" id="anunt"></textarea>
        <div class="help-blue" title="Descrie cat mai detaliat produsul sau serviciul pe care il oferi. Incearca sa fi realist pentru a nu induce in eroare cumparatorul."></div>
        <div class="nrramas">Numar ramas de caractere <span id="nrramas">1000</span></div>
    </div>
    <div class="camp">
        <label>Pret<span class="obl">*</span></label><br />
        <input type="text" id="pret" class="annouce-input" >
        <div class="help-blue" title="Scrie pretul produsului tau in Lei sau Euro."></div>
        <div class="nrramas2">Pretul este negociabil ?<input type="checkbox" id="negociabil" ></div>
    </div>
    <div class="camp">
        <label>Moneda<span class="obl">*</span></label><br />
        <div class="clickchoes" id="lei">Leu</div><div class="clickchoes chadj" id="euro">Euro</div>
    </div>
    @if (!$data['campuri']['persoana'])
    <div class="camp">
        <label>Tipul de persoana<span class="obl">*</span></label><br />
        <input class="annouce-input" type="text" id="persselect"  >
        <div class="chose">
            <ul>
                <li>Persoana Fizica</li>
                <li>Persoana Juridica</li>
            </ul>
            <div class="clearfloat"></div>
        </div>
        <div class="help-blue" title="Daca esti o persoana"></div>
    </div>
    @endif
    @if (!$data['campuri']['telefon'])
    <div class="camp">
        <label>Numar Telefon</label><br />
        <input class="annouce-input" type="text" id="telefon"  >
        <div class="help-blue" title="Completeaza cu numarul de telefon pentru a putea fi contactat mai usor de cumparatori."></div>
    </div>
    @endif
    @if (!$data['campuri']['skype'])
    <div class="camp">
        <label>Skype</label><br />
        <input class="annouce-input" type="text" id="skype"  >
        <div class="help-blue" title="Completeaza cu id-ul tau de skype pentru a putea fi contactat pe Skype. Se afiseaza pe website."></div>
    </div>
    @endif
    @if (!$data['campuri']['yahoo'])
    <div class="camp">
        <label>Yahoo:</label><br />
        <input class="annouce-input" type="text" id="yahoo"  >
        <div class="help-blue" title="Completeaza cu id-ul tau de Yahoo pentru a putea fi contactat pe Yahoo. Se afiseaza pe website."></div>
    </div>
    @endif
    <div class="camp">
        <label>Imagini<span class="obl">*</span></label><br />
        {{ Form::open( [ 'url' => '/ajax/uploadimage', 'method' => 'post', 'files' => true, 'id'=>'addimg' ] ) }}
        <div class="addimagine"><input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine</div>
        {{ Form::close() }}
        {{ Form::open( [ 'url' => '/ajax/uploadimage', 'method' => 'post', 'files' => true, 'id'=>'addimg' ] ) }}
        <div class="addimagine"><input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine</div>
        {{ Form::close() }}
        {{ Form::open( [ 'url' => '/ajax/uploadimage', 'method' => 'post', 'files' => true, 'id'=>'addimg' ] ) }}
        <div class="addimagine"><input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine</div>
        {{ Form::close() }}
        {{ Form::open( [ 'url' => '/ajax/uploadimage', 'method' => 'post', 'files' => true, 'id'=>'addimg' ] ) }}
        <div class="addimagine"><input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine</div>
        {{ Form::close() }}
        {{ Form::open( [ 'url' => '/ajax/uploadimage', 'method' => 'post', 'files' => true, 'id'=>'addimg' ] ) }}
        <div class="addimagine"><input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine</div>
        {{ Form::close() }}
        <div class="clearfloat"></div>
    </div>
    <div class="camp">
        <span>Apasand pe butonul "Trimite" de mai jos declari ca esti de acord cu <a href="/termeni-si-conditii">Termenii si Conditiile</a></span>
        <div class="trimite">Trimite</div>
    </div>
    <div class="clearfloat"></div>
</div>
@stop
@section('confirm')
<div class="continut">
    <div class="conn">
        <h2>Felicitari !</h2>
        <div class="mess">
            Te rugam sa iti setezi o parola, pentru a putea administra anunturile tale oricand doresti.<br/>
            <input type="password" id="parola" placeholder="Parola ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Parola ...'"  ><br />
            <input type="password" id="repetaparola" placeholder="Repeta parola..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Repeta parola ...'" >
            <div class="ready">Gata !</div>
        </div>
    </div>
    @stop
    @section('confirmwithout')
    <div class="continut">
        <div class="conn">
            <h2>Felicitari !</h2>
            <div class="mess">
                Contul tau s-a inregistrat cu succes. Acum este activ, poti incepe prin a adauga primul tau anunt !<br/>
                <a href="/adauga-anunt"><div class="ready">Adauga Anunt !</div></a>
            </div>
        </div>
        @stop
        @section('resetpass')
        <div class="continut">
            <div class="conn">
                <h2>Perfect!</h2>
                <div class="mess">
                    Acum tot ce trebuie sa mai faci este sa iti setezi noua parola:<br />
                    <input type="password" id="parola" placeholder="Parola ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Parola ...'"  ><br />
                    <input type="password" id="repetaparola" placeholder="Repeta parola..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Repeta parola ...'" >
                    <div class="ready">Gata !</div>
                </div>
            </div>
            @stop
            @section('showanunt')
            @if ($data['anunt']['confirm']==1 || (Auth::check() && Auth::user()->admin==1))
             @if ($data['anunt']['confirm']==0 && (Auth::check() && Auth::user()->admin==1))
             <div class="mesajanuntinactiv">Atentie! Acest anunt este inactiv ! Click pentru al activa.</div>
             @endif
            @if (isset($data['anunt']['modificare']) && $data['anunt']['modificare']==1)
            <div class="mesajanuntmodificat">Atentie! Acesta este doar un preview! Click pentru a salva anuntul.</div>
            @endif
            <div class="continut">
                <div class="clearfloat"></div>
                <div class="part1">
                    <div class="date-contact">
                        <div class="pret"><div class="dollar"></div>{{ $data['anunt']['pret'] }} {{$data['anunt']['moneda']==0 ? 'Lei.' : '&euro;'}}<div class="clearfloat"></div></div>
                        <div class="persoana"><div class="email-big"></div>Trimite Mesaj<div class="clearfloat"></div></div>
                        <div class="mesaj-form2">
                            <div class="mesaj-form-ann"></div>
                            @if (!Auth::check())
                            <span>Nume:</span>
                            <input type="text" id="nume" name="nume" />
                            <span>Email:</span>
                            <input type="text" id="email" name="email" />
                            @endif
                            @if (!$data['campuri']['telefon'])
                            <span>Telefon:</span>
                            <input type="text" id="telefon" name="telefon" />
                            @endif
                            <span>Mesaj:</span>
                            <textarea></textarea>
                            <div class="trimite-mesaj">Trimite</div>
                        </div>
                        @if (Auth::check())
                        <div class="salveaza-anunt"><div class="cat-saveads"></div>Salveaza Anunt<div class="clearfloat"></div></div>
                        @endif
                        <div class="contact">
                            <img src="/img/miniavatar.png" alt="" />
                            <span><strong>{{$data['user']['nume']}}</strong></span><br />
                            <span>Pe site din {{explode(' ', $data['user']['created_at'])[0]}}</span><br />
                            @if (isset($data['anunt']['categorie']) && isset($data['anunt']['subcategorie']))
                            <div class="catsh"><a href="/{{Categorii::where('nume', $data['anunt']['categorie'])->pluck('codunic')}}">{{$data['anunt']['categorie']}}</a> / <a class="hrefsecund" href="/{{Categorii::where('nume', $data['anunt']['categorie'])->pluck('codunic').'/'.Subcategorii::where('nume', $data['anunt']['subcategorie'])->pluck('codunic')}}">{{$data['anunt']['subcategorie']}}</a></div>
                            @endif
                        </div>
                        <div class="contact">
                            <div class="cat-location showanuntlocation"></div>
                            <span>{{$data['user']['oras'].','.$data['user']['cartier']}}</span><br />
                        </div>
                        @if ($data['user']['telefon'])
                        <div class="phone"><div class="telefon"></div><p>{{ substr($data['user']['telefon'], 0, 3).'* *** ***' }}</p><span class="vezi-telefon">Vezi Numar</span><div class="clearfloat"></div></div>
                        @endif
                        @if ($data['user']['showemail'])
                        <div class="email"><div class="email-big"></div><p>{{substr($data['user']['email'], 0, 3).'*********'}}</p><span class="vezi-email">Vezi Email</span><div class="clearfloat"></div></div>
                        @endif
                        @if ($data['user']['skype'])
                        <div class="skype"><div class="cat-skype"></div><p>{{substr($data['user']['skype'], 0 , 3).'*********'}}</p><span class="vezi-skype">Vezi Skype</span><div class="clearfloat"></div></div>
                        @endif
                        @if ($data['user']['yahoo'])
                        <div class="yahoo"><div class="cat-yahoo"></div><p>{{substr($data['user']['yahoo'], 0 , 3).'*********'}}</p><span class="vezi-yahoo">Vezi Yahoo</span><div class="clearfloat"></div></div>
                        @endif
                    </div>
                </div>
                <div class="part2">
                    <div class="anunt">
                        <h2>{{$data['anunt']['titlu']}}</h2>
                        <h4>Publicat {{$data['anunt']['alias']}} la ora {{$data['anunt']['ora']}} de {{strtolower($data['user']['persoana'])}} <span class="albastru">{{$data['user']['nume']}}</span><br/>Vizualizari: <strong>{{isset($data['anunt']->vizualizari) ? $data['anunt']->vizualizari : ''}}</strong></h4>
                        <div class="text">
                            {{$data['anunt']['continut']}}
                        </div>
                        @if (count($data['galerie'])>0)
                        <div class="galerie">
                            <div class="galcon">
                                @foreach ($data['galerie'] as $imagine)
                                <img {{$imagine['orientare']==1 ? 'class="height"' : ''}} id="{{$imagine['anunt']}}" src="{{$imagine['link_mini']}}" alt="{{isset($data['nr']) ? $data['nr']++ : '' }}" />
                                @endforeach
                            </div>
                        </div>
                        @endif
                        <div class="anuntpanel anuntpanel2">
                            <ul>
                                <li class="promoanunt"><div class="cat-promoveaza"></div>Promoveaza</li>
                                <li class="modificaanunt23"><div class="cat-edit"></div>Modifica</li>
                                <li class="dezactiveazaanunt23"><div class="cat-dezactiveaza"></div>Dezactiveaza</li>
                                <li><div class="cat-print"></div>Printeaza</li>
                            </ul>
                            <div class="clearfloat"></div>
                        </div>
                        @if (isset($data['anunt_recomand']) && count($data['anunt_recomand'])==4)
                        <div class="random_anunt">
                            <h2>Anunturi care s-ar putea sa te intereseze:</h2>
                            @foreach ($data['anunt_recomand'] as $anunt)
                            <a href="/anunt/{{preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $anunt['titlu'])).'-'.$anunt['id']}}"><div class="anuntrand">
                                <img {{(isset(Imagine::where('anunt', $anunt->id)->where('first', '1')->first()->orientare) && Imagine::where('anunt', $anunt->id)->where('first', '1')->first()->orientare==1) ? 'class="height"' : ''}} src="{{isset(Imagine::where('anunt', $anunt->id)->where('first', '1')->first()->link_mini) ? Imagine::where('anunt', $anunt->id)->where('first', '1')->first()->link_mini : '/img/default.png'}}" alt="Fara Imagine" /><br />
                                <h2>{{(strlen($anunt->titlu) <= 40) ? $anunt->titlu : substr($anunt->titlu, 0, 40).' ...'}}</h2>
                                <span>{{$anunt->pret}} {{$anunt['moneda']==0 ? 'Lei.' : '&euro;'}}</span>
                            </div></a>
                            @endforeach
                            <div class="clearfloat"></div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="clearfloat"></div>
                @else Eroare 404
                @endif
@stop
@section ('contul-meu')
<div class="continut">
    <ul class="cpanel">
        <li><div class="cat-cpads"></div><br />Anunturile Mele</li>
        <li><div class="cat-messages"></div><br />Mesaje</li>
        <li><div class="cat-saveads"></div><br />Anunturi Salvate</li>
        <li><div class="cat-ticket"></div><br />Tichete Suport</li>
        <li><div class="cat-cpsetari"></div><br />Setari Cont</li>
    </ul>
    <div class="titlecp"><h2>Setari Cont</h2></div>
    <div class="clearfloat"></div>
@stop