<div class="loginform">
    <div class="close-white inchide-login"></div>
    <h2>Reseteaza Parola</h2>
    <div class="clearfloat"></div>
    <span>Ti-ai amintit parola ? <a href="" class="login-forms">Logheaza-te</a></span>
    <div class="clearfloat"></div>
    <div class="mesajannouce"></div><br />
        <img src="/img/avatar.png" alt="Avatar" /><br />
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <div class="inplog"><div class="user-email"></div><label><input type="text" placeholder="Email ..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email ...'" id="email" ></label></div>
        <div class="inlines"><div class="logheazate reseteaza">Reseteaza Parola</div><div class="clearfloat"></div></div>
</div>