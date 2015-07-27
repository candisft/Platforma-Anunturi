<div class="loginform">
    <div class="close-white inchide-login"></div>
    <h2>Logheaza-te</h2>
    <div class="clearfloat"></div>
    <span>Nu ai inca un cont ? <a href="" class="inregistreaza-te">Inregistreaza-te</a></span>
    <div class="clearfloat"></div>
    <div class="mesajannouce"></div><br />
    <table><tr><td>
    <div class="loginwithfacebook">
        <img src="/img/facebook.png" alt="Facebook" title="Logheaza-te cu facebookul." />
    </div>
            </td>
            <td>
    <img src="/img/avatar.png" alt="Avatar" /><br />
    </td></td></tr></table>
    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
    <div class="inplog"><div class="user-email"></div><label><input type="text" placeholder="Email ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email ...'" id="email" ></label></div>
    <div class="inplog"><div class="user-pass"></div><label><input type="password" placeholder="Parola ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Parola ...'" id="parola" ></label></div>
    <div class="inlines"><div class="logheazate logheazama">Login</div><div class="resetpar"><a href="">Resetare Parola</a></div><div class="clearfloat"></div></div>
</div>