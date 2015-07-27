@yield('header')
@yield(((!Auth::check()) ? 'loginregister' : '' ))
@yield('addanuntmesaje')
@yield(((!Auth::check()) ? 'fixedbar' : 'fixedbarlogat' ))
@yield('toppart')
<div class="continut">
    <ul class="cpanel">
        <a href="/contul-meu/anunturile-mele"><li><div class="cat-cpads"></div><br />Anunturile Mele</li></a>
        <a href="/contul-meu/mesaje"><li><div class="cat-messages"></div><br />Mesaje</li></a>
        <a href="/contul-meu/anunturi-salvate"><li><div class="cat-saveads"></div><br />Anunturi Salvate</li></a>
        <a href="/contul-meu/tichete"><li><div class="cat-ticket"></div><br />Tichete Suport</li></a>
        <a href="/contul-meu/plati"><li><div class="cat-plati"></div><br />Plati</li></a>
        <a href="/contul-meu/setari"><li><div class="cat-cpsetari"></div><br />Setari Cont</li></a>
    </ul>
@if ($data['tab']=="setari")
    <div class="titlecp"><h2>Setari Cont</h2></div>
    <div class="clearfloat"></div>
    <div class="mesages"></div>
    <div class="camp">
        <span></span><br />
        @if (Auth::user()->persoana=='Persoana Fizica')
        <div class="clickchoes choes-activ" id="fizica">Persoana Fizica<div class="tick-green"></div></div><div class="clickchoes chadj" id="juridica">Persoana Juridica</div>
        @else
        <div class="clickchoes" id="fizica">Persoana Fizica</div><div class="clickchoes chadj choes-activ" id="juridica">Persoana Juridica<div class="tick-green"></div></div>
        @endif
    </div>
    <div class="camp">
        <span class="cont-set">Nume</span><br />
        <input class="setting-input" type="text" id="nume" value="{{Auth::user()->nume}}" placeholder="Nume si Prenume ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nume si Prenume ...'"  />
    </div>
    <div class="camp">
        <span class="cont-set">Email</span><br />
        <input class="setting-input" type="text" id="email" value="{{Auth::user()->email}}" placeholder="Email ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email ...'" />
        <div class="nrramas2">Email-ul poate fi facut public ?<input type="checkbox" id="showemail" @if (Auth::user()->showemail==1) checked @endif ></div>
    </div>
    <div class="camp">
        <span class="cont-set">Telefon</span><br />
        <input class="setting-input" type="text" id="telefon" value="{{Auth::user()->telefon}}" placeholder="Numar telefon ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Numar telefon ...'" />
    </div>
    <div class="camp">
        <span class="cont-set">Judet</span><br />
        @if (Auth::user()->oras=='Galati')
        <div class="clickchoes choes-activ" id="galati">Galati<div class="tick-green"></div></div><div class="clickchoes chadj" id="braila">Braila</div>
        <script>$.post("/ajax/chosetown", { oras: 'Galati' }, function( data ) { $('.cartierechose ul').html(data); });</script>
        @else
        <div class="clickchoes" id="galati">Galati</div><div class="clickchoes chadj choes-activ" id="braila">Braila<div class="tick-green"></div></div>
        <script>$.post("/ajax/chosetown", { oras: 'Braila' }, function( data ) { $('.cartierechose ul').html(data); });</script>
        @endif
    </div>
    <div class="camp">
        <span class="cont-set">Oras/Localitate</span><br />
        <input class="setting-input" type="text" id="cartierselect" value="{{Auth::user()->cartier}}"  >
        <div class="cartierechose">
            <ul></ul>
            <div class="clearfloat"></div>
        </div>
    </div>
    <div class="camp">
        <span class="cont-set">Skype</span><br />
        <input class="setting-input" type="text" id="skype" value="{{Auth::user()->skype}}" placeholder="ID Skype ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'ID Skype ...'" />
    </div>
    <div class="camp">
        <span class="cont-set">Yahoo</span><br />
        <input class="setting-input" type="text" id="yahoo" value="{{Auth::user()->yahoo}}" placeholder="ID Yahoo ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'ID Yahoo ...'" />
    </div>
    <div class="camp">
        <span class="cont-set">Parola</span><br />
        <input class="setting-input" type="password" id="parola" placeholder="Parola ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Parola ...'" />
    </div>
    <div class="camp">
        <div class="salveaza">Salveaza</div>
    </div>
    <div class="clearfloat"></div>
@elseif ($data['tab']=="anunturile-mele")
    <div class="titlecp"><h2>Anunturile Mele</h2></div>
    <div class="clearfloat"></div>
    @if ($data['nrads']>0)
    <ul class="tabs">
        <li class="active">Anunturi Active</li>
        <li>Anunturi Inactive</li>
    </ul>
    <input class="search-in-myads" type="text" placeholder="Cauta anunt..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Cauta anunt...'" />
    <div class="tabs-content">
       <script>
           $.post('/ajax/getMyAdsActive', function(data) { $('.tabs-content').html(data); });
       </script>
    </div>
    <div class="clearfloat"></div>
    @else
    Nu ai nici un anunt activ !<br />
    <a href="/adauga-anunt"><div class="addanunt2">+ Adauga Anunt</div></a>
    @endif
@elseif ($data['tab']=="mesaje")
    <div class="titlecp"><h2>Mesaje</h2></div>
    <div class="clearfloat"></div>
    @if ($data['nrmsg']>0)
    <ul class="tabs">
        <li class="active">Mesaje Noi</li>
        <li>Mesaje Sterse</li>
        <li>Mesaje Trimise</li>
    </ul>
    <div class="tabs-content">
        <script>
            $.post('/ajax/getMesajeNew', function(data) { $('.tabs-content').html(data); });
        </script>
    </div>
    <div class="clearfloat"></div>
    @else
    Nu ai nici un mesaj nou !<br />
    @endif
@elseif ($data['tab']=="anunturi-salvate")
    <div class="titlecp"><h2>Anunturi Salvate</h2></div>
    <div class="clearfloat"></div>
    <div class="tabs-content">
        <script>
            $.post('/ajax/getAnunturiSalvate', function(data) { $('.tabs-content').html(data);
                $(document).on('click', '.sterge-adssave', function() {
                    var code = $(this).attr('id');
                    $.post('/ajax/StergeAdssave', { code: code }, function() { window.location.reload(); });
                });
            });
        </script>
    </div>
@elseif ($data['tab']=="tichete")
    <div class="titlecp"><h2>Tichete Suport</h2></div>
    <div class="clearfloat"></div>
    <div class="add-new-ticket">Scrie Tichet</div>
    <div class="clearfloat"></div>
    <div class="tabs-content">
        <table class="ticket">
            <thead>
            <tr><td>ID</td><td>Stare</td><td>Trimis de</td><td>Trimis la data</td><td>Actiuni</td></tr>
            </thead>
            <tbody>
            <script> $.post('/ajax/getTickete', function(data) { $('.ticket tbody').html(data); }); </script>
            </tbody>
        </table>
    </div>
    <div class="clearfloat"></div>
@elseif ($data['tab']=="plati")
    <div class="titlecp"><h2>Plati</h2></div>
    <div class="clearfloat"></div>
    <div class="tabs-content">
        <script>
            $.post('/ajax/getPlati', function(data) { $('.tabs-content').html(data); });
        </script>
    </div>
    @endif

@yield('footer')