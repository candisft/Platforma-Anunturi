@if (count($plati)>0)
<table class="ticket ads">
    <thead>
    <tr><td>Id</td><td>Suma</td><td>Descriere</td><td>In data de</td></tr>
    </thead>
    <tbody>
    @foreach ($plati as $plata)
    <tr><td>#{{$plata['id']}}</td><td @if ($plata['suma']>=0) class="maimare" @else class="maimic" @endif>{{$plata['suma']}} &euro;</td><td>{{$plata['pentru']}}</td><td>{{$plata['created_at']}}</td></tr>
    @endforeach
    </tbody>
</table>
@endif