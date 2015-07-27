<form method="post" class="ticketform" action="">
    <label>
        Subiect<br/>
        <input type="text" name="Subject" id="subiect" />
    </label>
    <br /><br />
    <div class="loader-mesaj"><img src="/img/loader.gif" alt="Loading..."/></div>
    <label>
        Mesaj<br/>
        <textarea id="mesaj"></textarea>
    </label>
    <br />
    <label>
        <img src="/ajax/getCpachaImg" alt="Click for Refresh" class="capcha" />
        <input type="text" id="capcha" name="capcha" class="capcha-input" placeholder="Codul capcha..." onfocus="this.placeholder = ''" onblur="this.placeholder = 'Codul capcha...'" />
    </label>
    <div class="clearfloat"></div>
    <div class="trimite-ticket">Trimite</div>
</form>