@yield('header')
@yield(((!Auth::check()) ? 'loginregister' : '' ))
@yield('addanuntmesaje')
@yield(((!Auth::check()) ? 'fixedbar' : 'fixedbarlogat' ))
@yield('toppart')
<div class="continut">
    <div class="contactpage">
        <h2>Contacteaza echipa eRapid.ro</h2>
        <h3>Ai nevoie de ajutor ? Ne poti contacta oricand completand formularul de mai jos, sunand la numarul de telefon <strong>0734 263 872</strong> sau trimitand un email la suport@erapid.ro .</h3>
        <div class="clearfloat"></div>
        <div class="contactform">
            <div class="mesage">

            </div>
            <div class="input">
                <p>Subiect<span>*</span></p><input type="text" name="subiect" id="subiect" />
                <div class="clearfloat"></div>
            </div>
            <div class="input">
                <p>Mesajul tau<span>*</span></p><textarea name="mesaj" id="mesaj"></textarea>
                <div class="clearfloat"></div>
            </div>
            <div class="input">
                <p>Cod anunt</p><input type="text" name="cod-anunt" id="cod-anunt" />
                <div class="clearfloat"></div>
            </div>
            <div class="input">
                <p>Email<span>*</span></p><input type="text" name="email" id="email" />
                <div class="clearfloat"></div>
            </div>
            <div class="input">
                <img src="/ajax/getCpachaImg" alt="Click for Refresh" class="capcha" />
                <input type="text" id="capcha" name="capcha" class="capcha-input" placeholder="Codul capcha..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Codul capcha...'" />
            </div>
            <div class="input">
                <div class="trimitecontact">Trimite</div>
            </div>
        </div>
    </div>
    <div class="clearfloat"></div>
    @yield('footer')