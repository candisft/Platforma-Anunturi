@yield('header')
@yield(((!Auth::check()) ? 'loginregister' : '' ))
@yield('addanuntmesaje')
@yield(((!Auth::check()) ? 'fixedbar' : 'fixedbarlogat' ))
@yield('toppart')
<div class="continut">
    <div class="alegepachet-banner">
        <h2>Promoveaza-ti anuntul, si gasesti cumparator garantat !</h2>
        Pachetele sunt fixe si nu pot fi modificate !
    </div>
    <div class="pachetprezent">
        <table>
            <thead>
            <tr>
                <td class="pachet1">Bronze Bird<h2>3 &euro;</h2><span>fara TVA</span></td>
                <td class="pachet2">Silver Coin<h2>5 &euro;</h2><span>fara TVA</td>
                <td class="pachet3">Gold Gun<h2>7 &euro;</h2><span>fara TVA</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>7 zile de promovare</td>
                <td>14 zile de promovare</td>
                <td>30 de zile de promovare</td>
            </tr>
            <tr>
                <td>Design special</td>
                <td>Design special</td>
                <td>Design special</td>
            </tr>
            <tr>
                <td>apare in primele pozitii</td>
                <td>apare in primele pozitii</td>
                <td>apare in primele pozitii</td>
            </tr>
            <tr>
                <td>reinoire automata si zilnica a anuntului</td>
                <td>reinoire automata si zilnica a anuntului</td>
                <td>reinoire automata si zilnica a anuntului</td>
            </tr>
            <tr>
                <td class="cumpara" id="pachet1">Cumpara</td>
                <td class="cumpara" id="pachet2">Cumpara</td>
                <td class="cumpara" id="pachet3">Cumpara</td>
            </tr>
            </tbody>
        </table>
        <div class="confirma-pachet">
        </div>
        <div class="intrebari1">
            <h2>Pachetele pot fi modificate ?</h2>
            <span>Nu, pachetele de mai sus sunt fixe si nu pot fi modificate. Daca doriti un altfel de reclama trimiteti un mail la adresa rober.andrei@yahoo.com.</span><br />
            <h2>Unde apare anuntul promovat ?</h2>
            <span>Anunturile care beneficiaza de unul din pachetele de mai sus  o sa apara in primele pozitii a categoriei si subcategoriei specifice lui, dar si in lista de anunturi, avand un design special.</span>
            <h2>Ce inseamna reinoire automata ?</h2>
            <span>Reinoirea automata inseamna ca sistemul reactualizeaza anuntul zilnic, aducandul in primele pozitii din lista de anunturi.</span>
        </div>
        <div class="intrebari2">
            <h2>Ce inseamna reinoire zilnica ?</h2>
            <span>Reinoirea zilnica este o reinoirea automata executata in fiecare zi, pe toata durata pachetului cumparat.</span>
            <h2>Dupa ce cumpar un pachet, in cat timp se asociaza pachetul cu anuntul ?</h2>
            <span>Aceasta operatiune se face instant, imediat dupa confirmare.</span>
            <h2>Pot avea 2 pachede in acelasi timp pe acelasi anunt?</h2>
            <span>Acest lucru nu e posibil, dar poti cumpara un pachet mai mare, iar pacetul anterior este inlocuit.</span>
        </div>
        <div class="clearfloat"></div>
    </div>
    @yield('footer')