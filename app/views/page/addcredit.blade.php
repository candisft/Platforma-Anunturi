@yield('header')
@yield(((!Auth::check()) ? 'loginregister' : '' ))
@yield('addanuntmesaje')
@yield(((!Auth::check()) ? 'fixedbar' : 'fixedbarlogat' ))
@yield('toppart')
<div class="continut">
    <div class="add-credit">
        <h2>1. Alege metoda de plata</h2>
        <table class="alegemetplata">
            <tr>
                <td id="platasms"><div class="addcredit-mobil"></div><br />Plata prin SMS</td>
                <td id="creditcard"><div class="addcredit-creditcard"></div><br />Plata cu cardul</td>
            </tr>
        </table>
        <div class="alegesuma">
            <h2>2. Alege suma pe care vrei sa o adaugi in cont</h2>
            <h3>Ai ales plata prin <strong>SMS</strong></h3>
            <table class="alegesuma">
                <tr>
                    <td id="3euro">3 &euro;</td>
                    <td id="5euro">5 &euro;</td>
                    <td id="6euro">6 &euro;</td>
                    <td id="7euro">7 &euro;</td>
                    <td id="10euro">10 &euro;</td>
                    <td id="15euro">15 &euro;<br /><span>Doar VODAFONE</span></td>
                </tr>
            </table>
        </div>
        <div class="finalieazacomanda">
            <!--<h3>Ai ales Plata prin SMS, suma de 5 euro, iar acuma apasa pe "Continuare" pentru a efectua plata.</h3>
            <form action="" method="post">
                <input type="submit" value="Continuare" />
            </form>-->
        </div>
    </div>
    <div class="clearfloat"></div>
    @yield('footer')