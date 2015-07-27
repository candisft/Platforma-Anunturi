<div class="header">
    <h2>Editare Utilizatori</h2>
</div>
<div class="zonainfo">
    Inregistrat in data de: {{$user['created_at']}}<br/>
    Credit: {{$user['credit']}} &euro;<br/>
    Email: {{$user['confirm']==1 ? 'Confirmat' : 'Neconfirmat'}}<br/>
    Anunturi: {{Anunt::where('user', $user['id'])->count()}}<br />
    Id: <span id="iduser">{{$user['id']}}</span>
</div>
<div class="zona">
    <span>Nume Utilizator</span><br />
    <input type="text" name="nume" id="nume" value="{{$user['nume']}}" />
    <div class="clearfloat"></div>
</div>
<div class="zona">
    <span>Email Utilizator</span><br />
    <input type="text" name="email" id="email" value="{{$user['email']}}" />
    <div class="clearfloat"></div>
</div>
<div class="zona">
    <span>Judet</span><br />
    <input type="text" name="judet" id="judet" value="{{$user['oras']}}" />
    <div class="clearfloat"></div>
</div>
<div class="zona">
    <span>Oras/Localitate</span><br />
    <input type="text" name="oras" id="oras" value="{{$user['cartier']}}" />
    <div class="clearfloat"></div>
</div>
<div class="zona">
    <span>Telefon</span><br />
    <input type="text" name="telefon" id="telefon" value="{{$user['telefon']}}" />
    <div class="clearfloat"></div>
</div>
<div class="zona">
    <span>Skype</span><br />
    <input type="text" name="skype" id="skype" value="{{$user['skype']}}" />
    <div class="clearfloat"></div>
</div>
<div class="zona">
    <span>Yahoo</span><br />
    <input type="text" name="yahoo" id="yahoo" value="{{$user['yahoo']}}" />
    <div class="clearfloat"></div>
</div>
<div class="zona">
    <span>Credit</span><br />
    <input type="text" name="credit" id="credit" value="{{$user['credit']}}" />
    <div class="clearfloat"></div>
</div>
<div class="zona">
    <div class="salveaza saveuser">Salveaza</div>
    <div class="clearfloat"></div>
</div>