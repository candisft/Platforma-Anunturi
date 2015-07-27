<h2>3. Finalizeaza Comanda</h2>
<h3>Ai ales plata prin {{$data['metplata']}}, suma de {{$data['suma']}} euro, apasa pe "Continuare" pentru a efectua plata prin platforma securizata MobilPay</h3>
<form action="{{$data['link']}}" method="post" name="frmPaymentRedirect">
    <input type="hidden" name="env_key" value="{{$data['obj']->getEnvKey()}}" />
    <input type="hidden" name="data" value="{{$data['obj']->getEncData() }}" />
    <input type="submit" value="Continuare" />
</form>