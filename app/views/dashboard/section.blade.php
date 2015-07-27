@section('index')
<div class="header">
    <h2>Dashboard</h2>
</div>
<div class="fonduri-disponibile animated zoomIn"><span>Banii intrati</span><br />{{$data['plus'] or ""}} &euro;</div>
<div class="fonduri-cheltuite animated zoomIn"><span>Banii iesiti</span><br />{{$data['minus']  or ""}} &euro;</div>
<div class="utilizatori-inregistrati animated zoomIn"><span>Utilizatori</span><br />{{User::count()}}</div>
<div class="total-anunturi animated zoomIn"><span>Anunturi</span><br />{{Anunt::count()}}</div>
<div class="clearfloat"></div>
<div class="panou">
    <div class="panouheader"><span>Anunturi Noi</span></div>
    <div class="panoucontent">
        <div class="panoucontinut">
            <ul>
                @if (isset($data['anunt']))
                @foreach ($data['anunt'] as $anunt)
                <li id="{{$anunt['id']}}"><div class="titlu"><a href="/anunt/{{preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $anunt['titlu'])).'-'.$anunt['id']}}">{{$anunt['titlu']}}</a></div><div class="actiuni"><div class="accepta tick-white" title="Accepta Anuntul"></div><div class="refuza close-white" title="Refuza Anuntul"></div></div><div class="clearfloat"></div></li>
                @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
<div class="panou">
    <div class="panouheader"><span>Utilizatori Noi</span></div>
    <div class="panoucontent">
        <div class="panoucontinut">
            @if (isset($data['user']))
            @foreach ($data['user'] as $user)
            <li><div class="titlu">{{$user->nume}}</div><div class="actiuni">{{$user->created_at}}</div><div class="clearfloat"></div></li>
            @endforeach
            @endif
        </div>
    </div>
</div>
<div class="panou">
    <div class="panouheader"><span>Modificari Anunturi</span></div>
    <div class="panoucontent">
        <div class="panoucontinut">
            @if (isset($data['modanunt']))
            @foreach ($data['modanunt'] as $anunt)
            <li id="{{$anunt['id']}}"><div class="titlu"><a href="/modanunt/{{preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $anunt['titlu'])).'-'.$anunt['id']}}">{{$anunt['titlu']}}</a></div><div class="actiuni"><div class="acceptamodanunt tick-white" title="Accepta Anuntul"></div><div class="refuzamodanunt close-white" title="Refuza Anuntul"></div></div><div class="clearfloat"></div></li>
            @endforeach
            @endif
            </div>
    </div>
</div>
<div class="panou">
    <div class="panouheader"><span>Tichete Noi</span></div>
    <div class="panoucontent">
        <div class="panoucontinut">
            <li><div class="titlu"><a href="">Subiect Tichet</a></div><div class="actiuni"><a href="">Vezi Tichet</a></div><div class="clearfloat"></div></li>

        </div>
    </div>
</div>
<div class="clearfloat"></div>
@stop
@section('utilizatori')
        <div class="header">
            <h2>Utilizatori</h2>
        </div>
        <input class="utilizatori-search" name="search" type="text" placeholder="Cauta dupa Nume sau Email ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Cauta dupa Nume sau Email ...'" />
        <table class="utilizatori-table">
            <thead>
            <tr><td>Id</td><td>Nume</td><td>Email</td><td>Judet</td><td>Oras/Localitate</td><td>Telefon</td><td>Skype</td><td>Yahoo</td><td>Actiuni</td></tr>
            </thead>
            <tbody>
            <script>
                var pagina = 1;
                $.post('/admin/getUtilizatori', { pagina: pagina}, function(data) {
                    $('.utilizatori-table tbody').html(data);
                });
                var g = 1; var h = 1;
                $(document).scroll(function() {
                    if (g==1 && h==1 && ($(window).scrollTop() + $(window).height() >= ($(document).height()-200))) {
                        pagina = pagina+1;
                        h=0;
                        $.post('/admin/getUtilizatori', { pagina: pagina }, function(data) {
                            if (data!="") $('.utilizatori-table tbody').append(data);
                            else { g=0; }
                        }).done(function() { h=1; });
                    }
                });
            </script>
            </tbody>
        </table>
        <div class="clearfloat"></div>
@stop
@section('anunturi')
<div class="header">
    <h2>Anunturi</h2>
</div>
<input class="anunturi-search" name="search" type="text" placeholder="Cauta dupa titlu, continut..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Cauta dupa Nume sau Email ...'" />
<table class="anunturi-table">
    <thead>
    <tr><td>Id</td><td>Titlu</td><td>Utilizator</td><td>Categorie</td><td>Promovat</td><td>Imagini</td><td>Actiuni</td></tr>
    </thead>
    <tbody>
    <script>
        var pagina = 1;
        $.post('/admin/getAnunturi', { pagina: pagina}, function(data) {
            $('.anunturi-table tbody').html(data);
        });
        var g = 1; var h = 1;
        $(document).scroll(function() {
            if (g==1 && h==1 && ($(window).scrollTop() + $(window).height() >= ($(document).height()-200))) {
                pagina = pagina+1;
                h=0;
                $.post('/admin/getAnunturi', { pagina: pagina }, function(data) {
                    if (data!="") $('.utilizatori-table tbody').append(data);
                    else { g=0; }
                }).done(function() { h=1; });
            }
        });
    </script>
    </tbody>
</table>
<div class="clearfloat"></div>
@stop
@section('plati')
<div class="header">
    <h2>Tranzactii</h2>
</div>
<table class="plati-table">
    <thead>
    <tr><td>Id</td><td>Suma</td><td>Utilizator</td><td>Descriere</td><td>In data de</td><td>Actiuni</td></tr>
    </thead>
    <tbody>
    <script>
        var pagina = 1;
        $.post('/admin/getPays', { pagina: pagina}, function(data) {
            $('.plati-table tbody').html(data);
        });
        var g = 1; var h = 1;
        $(document).scroll(function() {
            if (g==1 && h==1 && ($(window).scrollTop() + $(window).height() >= ($(document).height()-200))) {
                pagina = pagina+1;
                h=0;
                $.post('/admin/getPays', { pagina: pagina }, function(data) {
                    if (data!="") $('.plati-table tbody').append(data);
                    else { g=0; }
                }).done(function() { h=1; });
            }
        });
    </script>
    </tbody>
</table>
<div class="clearfloat"></div>
@stop
@section('tickete')
<div class="header">
    <h2>Tickete</h2>
</div>
<table class="ticket-table">
    <thead>
    <tr><td>Id</td><td>Subiect</td><td>Stare</td><td>Utilizator</td><td>In data de</td><td>Actiuni</td></tr>
    </thead>
    <tbody>
    <script>
        var pagina = 1;
        $.post('/admin/getTickets', { pagina: pagina}, function(data) {
            $('.ticket-table tbody').html(data);
        });
        var g = 1; var h = 1;
        $(document).scroll(function() {
            if (g==1 && h==1 && ($(window).scrollTop() + $(window).height() >= ($(document).height()-200))) {
                pagina = pagina+1;
                h=0;
                $.post('/admin/getTickets', { pagina: pagina }, function(data) {
                    if (data!="") $('.ticket-table tbody').append(data);
                    else { g=0; }
                }).done(function() { h=1; });
            }
        });
    </script>
    </tbody>
</table>
<div class="clearfloat"></div>
@stop