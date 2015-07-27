/**
 * Created by Stoian Ioan-Catalin on 8/13/14.
 */
function resetFormAdd() {
    $('#titlu').removeClass('ok').val('');
    $('#categoriselect').removeClass('ok').val('');
    $('#subcategoriselect').removeClass('ok').val('');
    $('#cartierselect').removeClass('ok').val('');
    $('#orasselect').removeClass('ok').val('');
    $('#anunt').removeClass('ok').val('');
    $('#pret').removeClass('ok').val('');
    $('#nume').removeClass('ok').val('');
    $('#persselect').removeClass('ok').val('');
    $('#email').removeClass('ok').val('');
    $('#telefon').removeClass('ok').val('');
    $('#skype').removeClass('ok').val('');
    $('#yahoo').removeClass('ok').val('');
    $('.addimagine').html('<input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine');
}
$(document).on('click', '.logeazamate', function() {
    $.post("/ajax/request-login-form", function( data ) {
        $('.logincon').html( data );
    });
});
$(document).on('click', '.promoanunt', function() {
    var anunt = window.location.pathname.substr(1);
    anunt = anunt.split('-');
    $.post('/ajax/checkLoginForPromo', {anunt: anunt[anunt.length-1]}, function(data) {
       if (data==2) { $('.promoanunt').removeClass('promoanunt'); }
       else if (data==1) {
           window.location="/promoveaza/alege-pachet/"+anunt[anunt.length-1];
       }
       else {
           $.post("/ajax/request-login-form", function( data ) {
               $('.logincon').html( data).show();
           });
       }
    });
});
$(document).on('click', '.modificaanunt23', function() {
    $.post('/ajax/checkLogin', function(data) {
        if (data==1) {
            var anunt = window.location.pathname.substr(1);
            anunt = anunt.split('-');
            window.location="/modifica/anunt/"+anunt[anunt.length-1];
        }
        else {
            $.post("/ajax/request-login-form", function( data ) {
                $('.logincon').html( data).show();
            });
        }
    });
});
$(document).on('click', '.dezactiveazaanunt23', function() {
    var anunt = window.location.pathname.substr(1);
    var code = anunt.split('-');
    $.post('/ajax/checkLoginForPromo', { anunt: code[code.length-1] }, function(data) {
        if (data==2) { $('.dezactiveazaanunt23').removeClass('dezactiveazaanunt23'); }
        else if (data==1) {
            $('.afteradd').height($(window).height()).show().html( '<div class="aftermesaj"><div class="inchide-login close-white"></div><div class="afterbarsus"><h2>Confirma Actiunea</h2></div>Esti sigur ca vrei sa stergi acest anunt ?<br /><br /><span class="mesajpass">Pentru confirmare te rugam sa iti introduci parola</span><br /><input class="confirm_pass" id="parola" name="parola" type="password" /><br /><div class="confirm"><div class="tick-white"></div>Da, sunt sigur.</div><div class="refuz"><div class="close-white cls-x"></div>Nu, abandoneaza.</div><div class="clearfloat"></div></div>' );
            var g=1;
            $(document).on('click', '.confirm', function() {
                if (g==1) {
                    g=0;
                    $.post('/ajax/dezactiveazaAnunt', { code: code[code.length-1], parola: $('#parola').val() }, function(data) {
                        if (data==1) window.location.reload();
                        else $('.mesajpass').html(data);
                        setTimeout(function() { g=1; }, 1000); });
                }
            });
            $(document).one('click', '.refuz', function() {
                $('.afteradd').html('').hide();
            });
        }
        else {
            $.post("/ajax/request-login-form", function( data ) {
                $('.logincon').html( data).show();
            });
        }
    });
});
$(document).on('click', '.login-forms', function(e) {
    e.stopPropagation();
    e.preventDefault();
    $.post("/ajax/request-login-form", function( data ) {
        $('.logincon').html( data );
    });
});
$(document).on('click', '.inregistreaza-te', function(e) {
    e.stopPropagation();
    e.preventDefault();
    $.post("/ajax/request-register-form", function( data ) {
        $('.logincon').html( data );
    });
});
$(document).on('click', '.resetpar', function(e) {
    e.stopPropagation();
    e.preventDefault();
    $.post("/ajax/request-reset-form", function( data ) {
        $('.logincon').html( data );
    });
});
$(document).on('click', '.inregistreazama', function(e) {
    $('.inplog input').removeClass('wrong');
    var email = $('#email').val();
    var nume = $('#nume').val();
    var parola = $('#parola').val();
    var repetaparola = $('#repeta-parola').val();
    if (parola!=repetaparola || parola=="" || repetaparola=="") {
        $('#parola').addClass('wrong');
        $('#repeta-parola').addClass('wrong');
    }
    else if (nume.length<6) { $('#nume').addClass('wrong'); }
    else if (email.search('@')<0 || email=="" || email.length<=6) { $('#email').addClass('wrong'); }
    else {
        $('.mesajannouce').show().html('<img src="/img/loader.gif" ald="Loading..." />')
        $.post("/ajax/inregistreazama", { nume: nume, email: email, parola: parola, repetaparola: repetaparola }, function( data ) {
            $('.mesajannouce').show();
            $('.mesajannouce').html( data );
            if ($('.mesajannouce').children('.okmesaje')[0]) {  $('#email').val(''); $('#nume').val(''); $('#parola').val(''); $('#repeta-parola').val(''); }
            setTimeout(function() { $('.mesajannouce').fadeOut(); $('.mesajannouce').html( '' ); }, 4000);
        });
    }
});
$(document).on('click', '.logheazama', function() {
    $('.inplog input').removeClass('wrong');
    var email = $('#email').val();
    var parola = $('#parola').val();
    if (email=="") { $('#email').addClass('wrong'); }
    else if (parola=="") { $('#parola').addClass('wrong'); }
    else {
        $.post("/ajax/logheazama", { email: email, parola: parola }, function( data ) {
            $('.mesajannouce').show();
            $('.mesajannouce').html( data );
            if ($('.mesajannouce').children('.error')[0]) {  $('#email').val(''); $('#parola').val(''); setTimeout(function() { $('.mesajannouce').fadeOut(); $('.mesajannouce').html( '' ); }, 2500); }
            else setTimeout(function() { $('.mesajannouce').fadeOut(); $('.mesajannouce').html( '' ); window.location.reload(); }, 2500);
        });
    }
});
$(document).on('keypress', '.loginform', function(e) {
    var p = e.which;
    if(p==13){
        $('.inplog input').removeClass('wrong');
        var email = $('#email').val();
        var parola = $('#parola').val();
        if (email=="") { $('#email').addClass('wrong'); }
        else if (parola=="") { $('#parola').addClass('wrong'); }
        else {
            $.post("/ajax/logheazama", { email: email, parola: parola }, function( data ) {
                $('.mesajannouce').show();
                $('.mesajannouce').html( data );
                if ($('.mesajannouce').children('.error')[0]) {  $('#email').val(''); $('#parola').val(''); setTimeout(function() { $('.mesajannouce').fadeOut(); $('.mesajannouce').html( '' ); }, 2500); }
                else setTimeout(function() { $('.mesajannouce').fadeOut(); $('.mesajannouce').html( '' ); window.location.reload(); }, 2500);
            });
        }
    }
});
$(document).on('click', '#logout', function() {
    $.post("/ajax/logout", function() { window.location.reload(); });
});
$(document).on('click', '.trimite', function() {
    var titlu = $('#titlu').val().replace(/"/gi, "&quot;").replace(/'/gi, "&quot;");
    var categorie = $('#categoriselect').val();
    var subcategorie = $('#subcategoriselect').val();
    var cartier = $('#cartierselect').val();
    var oras = $('#orasselect').val();
    var anunt = $('#anunt').val().replace(/"/gi, "&quot;").replace(/'/gi, "&quot;");;
    var pret = $('#pret').val().replace(' Lei.', '');
    pret = pret.replace(/\D/g,'');
    var moneda = $('.choes-activ').text();
    if (moneda=="Leu") moneda = 0;
    else moneda = 1;
    var negociabil = $('#negociabil').is(':checked');
    var nume = $('#nume').val();
    var tip_persoana = $('#persselect').val();
    var email = $('#email').val();
    var showemail = $('#showemail').is(':checked');
    var telefon = $('#telefon').val();
    var skype = $('#skype').val();
    var yahoo = $('#yahoo').val();
    if ((titlu) && (categorie) && (anunt) && (pret)) {
        $('.afteradd').height($(window).height()).show().html( '<div class="aftermesaj"><div class="inchide-login close-white"></div><div class="afterbarsus"><h2>Se incarca...</h2></div><img src="/img/loader.gif" alt="Loading..."></div>' );
        if (showemail==true) showemail = 1;
        else showemail = 0;
        if (negociabil==true) negociabil = 1;
        else negociabil = 0;
        anunt = anunt.replace(/(?:\r\n|\r|\n)/g, '<br />');
        var json = '{"titlu":"'+titlu+'", "categorie":"'+categorie+'", "subcategorie":"'+subcategorie+'", "cartier":"'+cartier+'", "oras":"'+oras+'", "anunt":"'+anunt+'", "pret":"'+pret+'", "moneda":"'+moneda+'", "negociabil":"'+negociabil+'", "nume":"'+nume+'", "persoana":"'+tip_persoana+'", "email":"'+email+'", "showemail":"'+showemail+'", "telefon":"'+telefon+'", "skype":"'+skype+'", "yahoo":"'+yahoo+'"}';
        var JsonObj = JSON.parse(json);
        $.post("/ajax/adauga-anunt", { data: JsonObj }, function( data) {
            $('.afteradd').height($(window).height()).show().html( data );
            if ($('.afterbarsus').text()=="Felicitari ! Anuntul tau a fost trimis cu succes !") {
                resetFormAdd();
            }
        });
    }
});
$(document).on('click', '.ready', function() {
    var parola = $('#parola').val();
    var repeta_parola = $('#repetaparola').val();
    if (parola!="" && parola==repeta_parola) {
        $('.conn h2').html('Se incarca...');
        $('.conn .mess').html('<img src="/img/loader.gif" alt="Loading..." />');
        var json = '{"parola":"'+parola+'", "repetaparola":"'+repeta_parola+'"}';
        var JsonObj = JSON.parse(json);
        $.post("/ajax/setparola", { setparola: JsonObj }, function( data ) {
            $('.conn h2').html('Parola Setata!');
            $('.conn .mess').html(data);
            setTimeout(function() { window.location='/'; }, 5000)
        });
    }
    else { $('#parola').addClass('wrong'); $('#repetaparola').addClass('wrong'); }
})
$(document).on('click', '.reseteaza', function() {
    var email = $('#email').val();
    if (email.search('@')<1) { $('#email').addClass('wrong'); }
    else {
        $('.loginform img').attr('src', '/img/loader.gif');
        $.post("/ajax/trimite-reset-parola", { email: email }, function( data ) {
            $('.loginform img').attr('src', '/img/avatar.png');
            $('.mesajannouce').show();
            $('.mesajannouce').html( data );
            $('#email').val('');
            setTimeout(function() { $('.mesajannouce').fadeOut(); $('.mesajannouce').html( '' ); }, 4000);
        });
    }
});
$(document).on('keypress', '.cautare', function(e) {
    var p = e.which;
    if(p==13 && $(this).val()!=""){
        $('.conn').html('<div class="continut"><img src="/img/loader.gif" alt="Loading..." /></div>');
        var keyword = $(this).val();
        $(this).val('');
        var oras = $('.orasactiv').text();
        if (oras=="") oras = 0;
        var pretdela = $('.pret-de-la').val(); if (pretdela=="") pretdela = 0;
        var pretpanala = $('.pret-la').val(); if (pretpanala=="") pretpanala = 0;
        if ($('.texbox-cat').hasClass('este-categorie')) { var isCat = 1; }
        else var isCat = 0;
        var categorie = $('.texbox-cat').text();
        if (categorie=="Toate Categoriile") categorie = 0;
        var cartier = $('.texbox-cart').text();
        if (cartier=="Toate Localitatile") cartier = 0;
        var json = '{"keyword":"'+keyword+'", "pagina":"1", "isCat":"'+isCat+'", "oras":"'+oras+'", "pretdela":"'+pretdela+'", "pretpanala":"'+pretpanala+'", "categorie":"'+categorie+'", "cartier":"'+cartier+'"}';
        var JsonObj = JSON.parse(json);
        var h = 1;
        var pagina = 1;
        var z = 0;
        $.post('/ajax/cauta', { data : JsonObj }, function ( data ) {
            $('.conn').html(data);
            catoffset = $('.categorishow').offset();
            $(document).scroll(function() {
                if($(window).scrollTop() + $(window).height() >= $(document).height() - 100 && h==1 && z==0) {
                    z=1;
                    pagina=pagina+1;
                    setTimeout(function() { z=0; }, 1000);
                    var json = '{"keyword":"'+keyword+'", "pagina":"'+pagina+'", "isCat":"'+isCat+'", "oras":"'+oras+'", "pretdela":"'+pretdela+'", "pretpanala":"'+pretpanala+'", "categorie":"'+categorie+'", "cartier":"'+cartier+'"}';
                    var JsonObj = JSON.parse(json);
                    $.post('/ajax/cauta', { data: JsonObj }, function(data) { if (data=="") h=0; $('.part2').append( data ); });
                }
            });
        });
    }
});
$(document).on('change', '.addimagine', function() {
    $(this).html('<img src="/img/loader.gif" alt="Loading..." />');
    var pozitie = $(this).parent();
    var form = $(this).closest("form");
    $.ajax(form.prop('action'), {
        data: form.find('textarea').serializeArray(),
        files: form.find(':file'),
        iframe: true,
        processData: false
    }).done(function(data) {
            data = data.replace('<head></head><body>', '').replace('</body>', '');
            if (data==1) pozitie.html('<input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine');
            else if (data!="") { pozitie.html('<div class="close-white delete-img"></div><img src="'+data+'" alt="Imagine" />'); }
        });
});
$(document).on('click', '.delete-img', function() {
    var obj = $(this).parent();
    $.post('/ajax/deleteimg',{ img: obj.children('img').attr('src')}, function(data) { obj.html('<input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine'); });
});
$(document).on('click', '.delete-imgFromDB', function() {
    var obj = $(this).parent();
    $.post('/ajax/deleteimgFromDB',{ img: obj.children('img').attr('src')}, function() { obj.html('<input class="addimagine" name="img1" type="file" accept="image/*" >+<br />Imagine'); });
});
$(document).on('click', '.vezi-telefon', function() {
    var anunt = window.location.pathname.substr(1);
    anunt = anunt.split('-');
    var type = 'telefon';
    var code = anunt[anunt.length-1];
    var obj = $(this);
    $.post('/ajax/extrageinfo', { code: code, type: type }, function(data) {
        obj.parent().children('p').html(data);
        obj.remove();
    });
});
$(document).on('click', '.vezi-email', function() {
    var anunt = window.location.pathname.substr(1);
    anunt = anunt.split('-');
    var type = 'email';
    var code = anunt[anunt.length-1];
    var obj = $(this);
    $.post('/ajax/extrageinfo', { code: code, type: type }, function(data) {
        obj.parent().children('p').html(data);
        obj.remove();
    });
});
$(document).on('click', '.vezi-yahoo', function() {
    var anunt = window.location.pathname.substr(1);
    anunt = anunt.split('-');
    var type = 'yahoo';
    var code = anunt[anunt.length-1];
    var obj = $(this);
    $.post('/ajax/extrageinfo', { code: code, type: type }, function(data) {
        obj.parent().children('p').html(data);
        obj.remove();
    });
});
$(document).on('click', '.vezi-skype', function() {
    var anunt = window.location.pathname.substr(1);
    anunt = anunt.split('-');
    var type = 'skype';
    var code = anunt[anunt.length-1];
    var obj = $(this);
    $.post('/ajax/extrageinfo', { code: code, type: type }, function(data) {
        obj.parent().children('p').html(data);
        obj.remove();
    });
});
$(document).on('click', '.persoana', function() {
    $('.mesaj-form2').slideToggle();
})
$(document).on('click', '.trimite-mesaj', function() {
    var anunt = window.location.pathname.substr(1);
    anunt = anunt.split('-');
    var code = anunt[anunt.length-1];
    var telefon = "";
    var email = "";
    var nume = "";
    if ($('#telefon')[0])
        if ($('#telefon').val().length==10 && $.isNumeric($('#telefon').val()))
        { $('#telefon').removeClass('wrong').addClass('ok'); telefon = $('#telefon').val(); }
        else { $('#telefon').removeClass('ok').addClass('wrong'); }
    if ($('#email')[0])
        if ($('#email').val().length>6 && $('#email').val().search('@')>1)
        { $('#email').removeClass('wrong').addClass('ok'); email = $('#email').val(); }
        else { $('#email').removeClass('ok').addClass('wrong'); }
    if ($('#nume')[0])
        if ($('#nume').val().length>6)
        { $('#nume').removeClass('wrong').addClass('ok'); nume = $('#nume').val(); }
        else { $('#nume').removeClass('ok').addClass('wrong'); }
    var mesaj = $('.mesaj-form2 textarea').val().replace(/(?:\r\n|\r|\n)/g, '<br />');
    if (mesaj && $('.wrong').length==0) {
        $('.mesaj-form-ann').html('<img src="/img/loader.gif" alt="Loading..." />');
        var json = '{"code":"'+code+'", "mesaj":"'+mesaj+'", "nume":"'+nume+'", "email":"'+email+'", "telefon":"'+telefon+'"}';
        var JsonObj = JSON.parse(json);
        $.post('/ajax/trimitemesaj', { data: JsonObj }, function(data) {
            $('.mesaj-form-ann').html(data);
            if ($('.mesaj-form-ann').text()=="Mesaj trimis cu succes !") {
                $('.mesaj-form2 input').val('').removeClass('ok');
                $('.mesaj-form2 textarea').val('');
            }
            setTimeout(function() { $('.mesaj-form-ann').html(''); }, 5000);
        });
    }
});
$(document).on('click', '.tabs li', function() {
    if (!$(this).hasClass('active')) {
        $('.tabs li').removeClass('active');
        $(this).addClass('active');
        if ($(this).text()=="Anunturi Active") { $.post('/ajax/getMyAdsActive', function(data) { $('.tabs-content').html(data); $('.anunturi').append('<div class="anuntpanel forcp"><ul><li><div class="cat-promoveaza"></div></li><li><div class="cat-edit"></div></li><li><div class="cat-dezactiveaza"></div></li><li><div class="cat-print"></div></li></ul><div class="clearfloat"></div></div>'); }); }
        else if ($(this).text()=="Anunturi Inactive") { $.post('/ajax/getMyAdsInactive', function(data) { $('.tabs-content').html(data); }); }
        else if ($(this).text()=="Mesaje Noi") { $.post('/ajax/getMesajeNew', function(data) { $('.tabs-content').html(data); }); }
        else if ($(this).text()=="Mesaje Sterse") { $.post('/ajax/getMesajeSterse', function(data) { $('.tabs-content').html(data); }); }
        else if ($(this).text()=="Mesaje Trimise") { $.post('/ajax/getMesajeTrimise', function(data) { $('.tabs-content').html(data); }); }
    }
});
var interval;
$(document).on('keyup', '.search-in-myads', function() {
    clearTimeout(interval);
    if ($(this).val()!="") {
        $('.tabs-content').html('<img src="/img/loader.gif" alt="Loading..." />')
        var keyword = $(this).val();
        interval = setTimeout(function() { $.post('/ajax/SearchInMyAds', {data: keyword}, function(data) { $('.tabs-content').html(data); }); }, 500);
    }
    else { interval = setTimeout(function() { $.post('/ajax/getMyAdsActive', function(data) { $('.tabs-content').html(data); }); }, 1000); }
});
var rupe=1;
$(document).on('click', '.dez-mesaj', function() {
    if (rupe==1) {
        rupe=0;
        setTimeout(function() { rupe=1; }, 2000);
        var id = $(this).attr('id');
        $.post('/ajax/MesajDeletePreventiv', { id: id }, function(data) { if (data==1) $.post('/ajax/getMesajeNew', function(data) { $('.tabs-content').html(data); });
                                                                          else $.post('/ajax/getMesajeSterse', function(data) { $('.tabs-content').html(data); });
    });
}
});
$(document).on('click', '.muta-mesaj', function() {
    if (rupe==1) {
        rupe=0;
        setTimeout(function() { rupe=1; }, 2000);
        var id = $(this).attr('id');
        $.post('/ajax/MesajRepune', { id: id }, function(data) { $.post('/ajax/getMesajeSterse', function(data) { $('.tabs-content').html(data); }); });
    }
});
$(document).on('click', '.salveaza-anunt', function() {
    if ($(this).text()!="Anunt Salvat") {
        var anunt = window.location.pathname.substr(1);
        anunt = anunt.split('-');
        var code = anunt[anunt.length-1];
        $.post('/ajax/seveAds', { anunt: code }, function() { $('.salveaza-anunt').html('<div class="cat-saveads"></div>Anunt Salvat'); });
    }
});
$(document).on('click', '.add-new-ticket', function() {
    $(this).html('Vezi Lista Tichete');
    $(document).on('click', '.add-new-ticket', function() { window.location.reload(); });
    $('.tabs-content').html('<img src="/img/loader.gif" alt="Loading..." />');
    $.post('/ajax/getAddTicketForm', function(data) { $('.tabs-content').html(data); });
});
$(document).on('click', '.capcha', function() {
    img=$(this);
    $(this).attr('src', "/ajax/getCpachaImg?rand_number=" + Math.random());
});
$(document).on('click', '.trimite-ticket', function() {
    var subiect = $('#subiect').val();
    var mesaj = $('#mesaj').val();
    var capcha = $('#capcha').val();
    if (subiect!="" && mesaj!="" && capcha!="") {
        $('.loader-mesaj').show();
        mesaj = mesaj.replace(/(?:\r\n|\r|\n)/g, '<br />');
        var json = '{"subiect":"'+subiect+'", "mesaj":"'+mesaj+'", "capcha":"'+capcha+'"}';
        var JsonObj = JSON.parse(json);
        $.post('/ajax/trimiteTicket', {data: JsonObj}, function(data) {
            if (data==1) { $('#subiect').val(''); $('#capcha').val(''); $('#mesaj').val(''); $('.loader-mesaj').html('Ticket trimis cu succes !'); setTimeout(function(){ $('.loader-mesaj').hide(); }, 5000); }
            else { $('.loader-mesaj').html('Codul capcha nu a fost scris corect !'); $('#capcha').val('').addClass('wrong'); }
        });
    }
    else {
        if (subiect=="") $('#subiect').addClass('wrong');
        else { $('#subiect').removeClass('wrong').addClass('ok'); }
        if (mesaj=="") $('#mesaj').addClass('wrong');
        else { $('#mesaj').removeClass('wrong').addClass('ok'); }
        if (capcha=="") $('#capcha').addClass('wrong');
        else { $('#capcha').removeClass('wrong').addClass('ok'); }
    }
});
$(document).on('click', '.openTicket', function(e) {
    e.stopPropagation();
    e.preventDefault();
    var code = $(this).text().substr(1);
    $('.afteradd').height($(window).height()).show().html( '<div class="aftermesaj"><div class="inchide-login close-white"></div><div class="afterbarsus"><h2>Se incarca...</h2></div><img src="/img/loader.gif" alt="Loading..."></div>' );
    $.post('/ajax/openTicket',{ code: code}, function(data) {
        $('.afteradd').height($(window).height()).show().html( data );
        $('.aftermesaj').addClass('ticketopen');
        $('.aftermesajcon').perfectScrollbar();
    });
});
$(document).on('click', '.sendreply', function() {
    if (!$(this).hasClass('inactiv')) {
        var mesaj = $('.send-reply textarea').val();
        mesaj = mesaj.replace(/(?:\r\n|\r|\n)/g, '<br />');
        $.post('/ajax/replyTicket', { mesaj: mesaj}, function(data) {
            $('.afteradd').height($(window).height()).show().html( data );
            $('.aftermesaj').addClass('ticketopen');
            $('.aftermesajcon').perfectScrollbar();
        });
    }
});
$(document).on('click', '.sterge-ticket', function() {
    $('.afteradd').height($(window).height()).show().html( '<div class="aftermesaj"><div class="inchide-login close-white"></div><div class="afterbarsus"><h2>Confirma Actiunea</h2></div>Esti sigur ca vrei sa stergi acest tichet ?<br /><br /><div class="confirm"><div class="tick-white"></div>Da, sunt sigur.</div><div class="refuz"><div class="close-white cls-x"></div>Nu, abandoneaza.</div><div class="clearfloat"></div></div>' );
    var ticket = $(this).attr('id');
    $(document).one('click', '.confirm', function() {
        $.post('/ajax/deleteTicket', {ticket: ticket}, function() { window.location.reload(); });
    });
    $(document).one('click', '.refuz, .refuz2', function() {
        $('.afteradd').html('').hide();
    });
});
$(document).on('click', '.edit-ticket', function() {
    $('.afteradd').height($(window).height()).show().html( '<div class="aftermesaj"><div class="inchide-login close-white"></div><div class="afterbarsus"><h2>Se incarca...</h2></div><img src="/img/loader.gif" alt="Loading..." /><div class="clearfloat"></div></div>' );
    var ticket = $(this).attr('id');
    $.post('/ajax/getTicketMesajMod', {ticket: ticket}, function(data) { $('.afteradd').html(data); });
    $(document).one('click', '.confirm2', function() {
        var subiect = $('.mod-subiect').val();
        var mesaj = $('.mod-ticket').val();
        mesaj = mesaj.replace(/(?:\r\n|\r|\n)/g, '<br />');
        var json = '{"subiect":"'+subiect+'", "mesaj":"'+mesaj+'", "code":"'+ticket+'"}';
        var JsonObj = JSON.parse(json);
        $.post('/ajax/modificaTicket', {data: JsonObj}, function() { window.location.reload(); });
    });
    $(document).one('click', '.refuz, .refuz2', function() {
        $('.afteradd').html('').hide();
    });
});
$(document).on('click', '#galati, #braila', function() {
    if (!$(this).hasClass('choes-activ')) {
        $('#galati').removeClass('choes-activ');
        $('#braila').removeClass('choes-activ');
        $('#galati .tick-green').remove();
        $('#braila .tick-green').remove();
        $(this).addClass('choes-activ').append('<div class="tick-green"></div>');
        $('#cartierselect').val('');
        $.post("/ajax/chosetown", { oras: $(this).text() }, function( data ) { $('.cartierechose ul').html(data); });
    }
});
$(document).on('click', '#fizica, #juridica', function() {
    if (!$(this).hasClass('choes-activ')) {
        $('#fizica').removeClass('choes-activ');
        $('#juridica').removeClass('choes-activ');
        $('#fizica .tick-green').remove();
        $('#juridica .tick-green').remove();
        $(this).addClass('choes-activ').append('<div class="tick-green"></div>');
    }
});
g=0;
$(document).on('click', '.salveaza', function() {
    if (g==0) {
        g=1;
        if ($('#fizica').hasClass('choes-activ')) var persoana = "Persoana Fizica";
        else  var persoana = "Persoana Juridica";
        var nume = $('#nume').val();
        var email = $('#email').val();
        var showemail = $('#showemail').is(':checked');
        if (showemail==true) showemail = 1;
        else showemail = 0;
        var telefon = $('#telefon').val();
        if ($('#galati').hasClass('choes-activ')) var oras = "Galati";
        else  var oras = "Braila";
        var cartier = $('#cartierselect').val();
        var skype = $('#skype').val();
        var yahoo = $('#yahoo').val();
        var parola = $('#parola').val();
        var json = '{"persoana":"'+persoana+'", "nume":"'+nume+'", "email":"'+email+'", "showemail":"'+showemail+'", "telefon":"'+telefon+'", "oras":"'+oras+'", "cartier":"'+cartier+'", "skype":"'+skype+'", "yahoo":"'+yahoo+'", "parola":"'+parola+'"}';
        var JsonObj = JSON.parse(json);
        $.post('/ajax/modficaUser', { data: JsonObj }, function(data) {
            setTimeout(function() { $('.mesages').html(''); g=0; }, 4000);
            if (data!=1) $('.mesages').html('<div class="mesages-error"><div class="close-white cls-x"></div>'+data+'</div>');
            else { $('.mesages').html('<div class="mesages-ok"><div class="tick-white"></div>Modificarile au fost salvate cu succes !</div>'); }
        });
    }
});
$(document).on('click', '.trimite2', function() {
    if (g==0) {
        g=1;
        var titlu = $('#titlu').val();
        var categorie = $('#categoriselect').val();
        var subcategorie = $('#subcategoriselect').val();
        var anunt = $('#anunt').val();
        anunt = anunt.replace(/(?:\r\n|\r|\n)/g, '<br />');
        var pret = $('#pret').val();
        pret = pret.replace(/\D/g,'');
        var moneda = $('.choes-activ').text();
        if (moneda=="Leu") moneda = 0;
        else moneda = 1;
        var negociabil = $('#negociabil').is(':checked');
        if (negociabil==true) negociabil = 1;
        else negociabil = 0;
        var code = window.location.pathname.substr(1);
        code = code.split('/');
        code = code[code.length-1];
        if (code && titlu && categorie && subcategorie && anunt && pret) {
            var json = '{"code":"'+code+'", "titlu":"'+titlu+'", "categorie":"'+categorie+'", "subcategorie":"'+subcategorie+'", "anunt":"'+anunt+'", "pret":"'+pret+'", "moneda":"'+moneda+'","negociabil":"'+negociabil+'"}';
            var JsonObj = JSON.parse(json);
            $.post('/ajax/modificaAnunt', {data : JsonObj }, function(data) {
                setTimeout(function() { $('.mesages').html(''); g=0; }, 4000);
                if (data!=1) $('.mesages').html('<div class="mesages-error"><div class="close-white cls-x"></div>'+data+'</div>');
                else { $('.mesages').html('<div class="mesages-ok"><div class="tick-white"></div>Te rugam sa astepti confirmarea unui moderator !</div>'); }
            });
        }
        else {
            if (!titlu) { $('#titlu').removeClass('ok').addClass('gresit'); }
            if (!categorie) { $('#categoriselect').removeClass('ok').addClass('gresit'); }
            if (!subcategorie) { $('#subcategoriselect').removeClass('ok').addClass('gresit'); }
            if (!anunt) { $('#anunt').removeClass('ok').addClass('gresit'); }
            if (!pret) { $('#pret').removeClass('ok').addClass('gresit'); }
        }
    }
});
$(document).on('click', '.sterge-anunt', function() {
    var code = $(this).parent().parent().attr('id');
    $('.afteradd').height($(window).height()).show().html( '<div class="aftermesaj"><div class="inchide-login close-white"></div><div class="afterbarsus"><h2>Confirma Actiunea</h2></div>Esti sigur ca vrei sa stergi acest anunt ?<br /><br /><span class="mesajpass">Pentru confirmare te rugam sa iti introduci parola</span><br /><input class="confirm_pass" id="parola" name="parola" type="password" /><br /><div class="confirm"><div class="tick-white"></div>Da, sunt sigur.</div><div class="refuz"><div class="close-white cls-x"></div>Nu, abandoneaza.</div><div class="clearfloat"></div></div>' );
    var g=1;
    $(document).on('click', '.confirm', function() {
        if (g==1) {
        g=0;
        $.post('/ajax/stergeAnunt', { code: code, parola: $('#parola').val() }, function(data) {
            if (data==1) window.location.reload();
            else $('.mesajpass').html(data);
            setTimeout(function() { g=1; }, 1000); });
        }
    });
    $(document).one('click', '.refuz', function() {
        $('.afteradd').html('').hide();
    });
});
$(document).on('click', '.dezactiveaza-anunt', function() {
    var code = $(this).parent().parent().attr('id');
    $('.afteradd').height($(window).height()).show().html( '<div class="aftermesaj"><div class="inchide-login close-white"></div><div class="afterbarsus"><h2>Confirma Actiunea</h2></div>Esti sigur ca vrei sa stergi acest anunt ?<br /><br /><span class="mesajpass">Pentru confirmare te rugam sa iti introduci parola</span><br /><input class="confirm_pass" id="parola" name="parola" type="password" /><br /><div class="confirm"><div class="tick-white"></div>Da, sunt sigur.</div><div class="refuz"><div class="close-white cls-x"></div>Nu, abandoneaza.</div><div class="clearfloat"></div></div>' );
    var g=1;
    $(document).on('click', '.confirm', function() {
        if (g==1) {
            g=0;
            $.post('/ajax/dezactiveazaAnunt', { code: code, parola: $('#parola').val() }, function(data) {
                if (data==1) window.location.reload();
                else $('.mesajpass').html(data);
                setTimeout(function() { g=1; }, 1000); });
        }
    });
    $(document).one('click', '.refuz', function() {
        $('.afteradd').html('').hide();
    });
});
$(document).on('click', '.cumpara', function() {
    var code = window.location.pathname.substr(1);
    code = code.split('/');
    code = code[code.length-1];
    var pachet; var parola;
    $('.confirma-pachet').html('<img src="/img/loader.gif" alt="Loading..." />').show();
    if ($(this).attr('id')=="pachet1") $.post('/pachete/bronze', { code: code }, function(data) {
        data = JSON.parse(data);
        if (data.rez==1) {
            $('.confirma-pachet').html('Doresti sa adaugi pachetul <strong>'+data.pachet+'</strong> la anuntul <strong>'+data.titlu+'</strong> ? <br /><input class="confirm_pass2" id="parola" name="parola" type="password" placeholder="Scrie parola pentru confirmare ..." onfocus="this.placeholder = \'\'" onblur="this.placeholder = \'Scrie parola pentru confirmare ...\'" /><br /><div class="cumpara2">Cumpara</div>').show();
            pachet = 1;
        }
        else {
            $('.confirma-pachet').html('Ne pare rau, dar nu ai suficient credit in cont !<br /><a href="/adauga-credit"><div class="adauga-credit">Adauga Credit</div></a>').show();
        }
    });
    else if ($(this).attr('id')=="pachet2") $.post('/pachete/silver', { code: code }, function(data) {
        data = JSON.parse(data);
        if (data.rez==1) {
            $('.confirma-pachet').html('Doresti sa adaugi pachetul <strong>'+data.pachet+'</strong> la anuntul <strong>'+data.titlu+'</strong> ?<br /><input class="confirm_pass2" id="parola" name="parola" type="password" placeholder="Scrie parola pentru confirmare ..." onfocus="this.placeholder = \'\'" onblur="this.placeholder = \'Scrie parola pentru confirmare ...\'" /><br /><div class="cumpara2">Cumpara</div>').show();
            pachet = 2;
        }
        else {
            $('.confirma-pachet').html('Ne pare rau, dar nu ai suficient credit in cont !<br /><a href="/adauga-credit"><div class="adauga-credit">Adauga Credit</div></a>').show();
        }
    });
    else if ($(this).attr('id')=="pachet3") $.post('/pachete/gold', { code: code }, function(data) {
        data=JSON.parse(data);
        if (data.rez==1) {
            $('.confirma-pachet').html('Doresti sa adaugi pachetul <strong>'+data.pachet+'</strong> la anuntul <strong>'+data.titlu+'</strong> ?<br /><input class="confirm_pass2" id="parola" name="parola" type="password" placeholder="Scrie parola pentru confirmare ..." onfocus="this.placeholder = \'\'" onblur="this.placeholder = \'Scrie parola pentru confirmare ...\'" /><br /><div class="cumpara2">Cumpara</div>').show();
            pachet = 3;
        }
        else {
            $('.confirma-pachet').html('Ne pare rau, dar nu ai suficient credit in cont !<br /><a href="/adauga-credit"><div class="adauga-credit">Adauga Credit</div></a>').show();

        }
    });
    $(document).one('click', '.cumpara2', function() {
        parola = $('#parola').val();
        $.post('/pachete/cumpara', { code: code, pachet: pachet, parola: parola }, function(data) {
            $('.confirma-pachet').html(data);
            if (data=="Anuntul a fost promovat cu succes !") setTimeout(function() { window.location='/contul-meu/anunturile-mele'; }, 4000);
        });
    });
});
$(document).on('click', '.reanunt', function() {
    var code = $(this).parent().parent().attr('id');
    $.post('/ajax/reactualizeazaAnunt', { code: code }, function() {
        window.location.reload();
    });
});
$(document).on('click', '.mesajanuntinactiv', function() {
    var anunt = window.location.pathname.substr(1);
    anunt = anunt.split('-');
    var code = anunt[anunt.length-1];
    $.post('/ajax/activezaanunt', { code: code }, function() {
      window.location.reload();
    });
});
$(document).on('click', '.mesajanuntmodificat', function() {
    var anunt = window.location.pathname.substr(1);
    anunt = anunt.split('-');
    var code = anunt[anunt.length-1];
    $.post('/ajax/AcceptModAnunt', { code: code }, function(data) {
        window.location='/anunt/'+data;
    });
});
$(document).on('click', '.reqpasstrim', function() {
    var password = $('.reqpass').val();
    $.post('/ajax/addAnuntWithLogin', { password: password }, function(data) {
        $('.afteradd').html(data);
    });
});
$(document).on('click', '.trimitecontact', function() {
    var subiect = $('#subiect').val();
    var mesaj = $('#mesaj').val();
    var codanunt = $('#cod-anunt').val();
    var email = $('#email').val();
    var capcha = $('#capcha').val();
    if (subiect!="") {
        $('#subiect').removeClass('gresit');
        if (mesaj!="") {
            $('#mesaj').removeClass('gresit');
            if (email!="") {
                $('#email').removeClass('gresit');
                if (capcha!="") {
                    $('#capcha').removeClass('gresit');
                    $('.mesage').html('<img src="/img/loader.gif" alt="Loading..." />')
                    var json = '{"subiect":"'+subiect+'", "mesaj":"'+mesaj+'", "codanunt":"'+codanunt+'", "email":"'+email+'", "capcha":"'+capcha+'"}';
                    var JsonObj = JSON.parse(json);
                    $.post('/ajax/trimiteContact', { data: JsonObj}, function(data){
                        if (data=="Codul capcha nu este corect!") {
                            $('.mesage').html('<div class="mesages-error">'+data+'</div>');
                        }
                        else if (data=="Mesajul tau a fost inregistrat. Multumim ca folosesti eRapid.ro!") {
                            $('.mesage').html('<div class="mesages-ok">'+data+'</div>');
                        }
                        else {
                            $('.mesage').html('<div class="mesages-error">'+data+'</div>');
                        }
                    });
                }
                else { $('#capcha').addClass('gresit'); }
            }
            else { $('#email').addClass('gresit'); }
        }
        else { $('#mesaj').addClass('gresit'); }
    }
    else { $('#subiect').addClass('gresit'); }
});
$(document).on('click', '.trimitemesajnew', function() {
    if ($(this).parent().children('#newmsg').val()!="") {
        var mesaj = $(this).parent().children('#newmsg').val();
        var id = $(this).attr('id');
        var obj = $(this).parent();
        $(this).parent().html('<img src="/img/loader.gif" alt="Loading..." />');
        $.post('/ajax/RapundeMesaj', {id:id, mesaj:mesaj}, function() {
            obj.html('Mesaj trimis cu succes!');
        });
    }
});