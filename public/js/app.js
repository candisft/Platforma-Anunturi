/**
 * Created by Stoian Ioan-Catalin on 8/13/14.
 */
function responsivebar(responsive) {
    if (responsive < 640 ) {
        $('.meniu-responsive').hide();
        $(document).on('mouseover', '.meniu-icon', function () {
            $('.menu25').addClass('menuactiv');
            $('.meniu-responsive').show();
        }).on('mouseleave', '.meniu-icon', function () {
                $('.menu25').removeClass('menuactiv');
                $('.meniu-responsive').hide();
            });
    }
    else { $('.meniu-responsive').show();  $(document).on('mouseover', '.meniu-icon', function () {
        $('.meniu-responsive').show();
    }).on('mouseleave', '.meniu-icon', function () {
            $('.meniu-responsive').show();
        }); }
}
function check(element) {

    document.getElementById(element).checked = true;
}
function uncheck(element) {
    document.getElementById(element).checked = false;
}
$(document).on('click', "[type='checkbox']", function() {
    if ($(this).is(':checked')) uncheck(this);
    else check(this);
});
function backfbscroll() {
    var scroll = $(document).scrollTop();
    if (scroll!=0) { if (!$('.fb').hasClass('fbscroll')) $('.fb').addClass('fbscroll'); }
    else { if ($('.fb').hasClass('fbscroll')) $('.fb').removeClass('fbscroll'); }
}
$(document).on('keyup', '.pretul input', function(e) {
    var myString = $(this).val();
    myString = myString.replace(/\D/g,'');
    $(this).val(myString);
});
catoffset = 1;
if ($('.categorishow').size()) { catoffset = $('.categorishow').offset(); }
$(document).scroll(function() {
    if (!responsive) responsive = 1024;
    backfbscroll();
    var scroll = $(document).scrollTop();
    if (typeof catoffset.top != 'undefined' && $('.categorishow').size()) {
        if (scroll>(catoffset.top-40) && responsive>640 ) { $('.categorishow').css('top', (scroll-catoffset.top)+50);  }
        else { $('.categorishow').css('top', '0'); } }
});
$(document).ready(function() {
    $(function() {
        $( document ).tooltip();
    });
    $('.scrollable').perfectScrollbar();
    var link = window.location.pathname.substr(1);
    link = link.split('/');
    if (link[link.length-1]!='setari' && link[link.length-2]!='anunt') $('input').val('');
    backfbscroll();
    $('.logincon').height($(window).height());
    $('.galshow').height($(window).height());
    responsive = $(window).width();
    responsivebar(responsive);
    window.onresize = function() { $('.logincon').height($(window).height()); responsive = $(window).width();  responsivebar(responsive); };

    $(document).on('mouseover', '.cat-lista', function () {
        $(this).children('ul').show();
    }).on('mouseleave', '.cat-lista', function () {
            $(this).children('ul').hide();
        });
    $(document).on('click', '.cat-lista ul li', function () {
        $('.texbox-cat').text($(this).text());
        if ($(this).hasClass('categorie')) $('.texbox-cat').addClass('este-categorie');
        else $('.texbox-cat').removeClass('este-categorie');
        $('.cat-lista').children('ul').hide();
    });

    $(document).on('mouseover', '.cart-lista', function () {
        $(this).children('ul').show();
    }).on('mouseleave', '.cart-lista', function () {
            $(this).children('ul').hide();
        });
    $(document).on('click', '.cart-lista ul li', function () {
        $('.texbox-cart').text($(this).text());
        $('.cart-lista').children('ul').hide();
    });
    var g=1;
    $(document).on('click', '.chosetown span', function () {
        if (g) {
            if (!$(this).hasClass('orasactiv')) { $('.chosetown span').removeClass('orasactiv'); $(this).addClass('orasactiv'); $.post("/ajax/chosetown", { oras: $(this).text() }, function( data ) { $('.cart-lista ul').html(data); }); g=0; }
            else { $(this).removeClass('orasactiv'); $.post("/ajax/chosetown", { oras: '' }, function( data ) { $('.cart-lista ul').html(data);}); g=0;  }
            setTimeout(function() { g=1; }, 4000);
        }
    });
    $(document).on('focus', '#categoriselect', function() {
        $('.cartierechose').hide();
        $('.chose').hide();
        var obj = $(this);
        $(this).parent().children('.chose').show();
        $(document).on('keypress', '#categoriselect', function() {
            return false;
        });
        $(document).one('click', '.chose li', function() {
            obj.val($(this).text());
            if (obj.val()!="") { obj.removeClass('gresit').addClass('ok'); }
            $.post("/ajax/chosecategorie", { categorie: $(this).text() }, function( data ) { $('.subcategoriechose ul').html(data); });
            $(this).parent().parent().hide();
            $('#subcategoriselect').val('').removeClass('ok');
        });
    });
    $(document).on('focus', '#subcategoriselect', function() {
        $('.cartierechose').hide();
        $('.chose').hide();
        var obj = $(this);
        $(this).parent().children('.chose').show();
        $(document).on('keypress', '#subcategoriselect', function() {
            return false;
        });
        $(document).one('click', '.chose li', function() {
            obj.val($(this).text());
            if (obj.val()!="") { obj.removeClass('gresit').addClass('ok'); }
            $(this).parent().parent().hide();
        });
    });
    $(document).on('focus', '#orasselect', function() {
        $('.cartierechose').hide();
        var obj = $(this);
        $('.chose').hide();
        $(this).parent().children('.chose').show();
        $(document).on('keypress', '#orasselect', function() {
            return false;
        });
        $(document).one('click', '.chose li', function() {
            obj.val($(this).text());
            if (obj.val()!="") { obj.removeClass('gresit').addClass('ok'); }
            $.post("/ajax/chosetown", { oras: $(this).text() }, function( data ) { $('.cartierechose ul').html(data); });
            $(this).parent().parent().hide();
            $('#cartierselect').val('').removeClass('ok');
        });
    });
    $(document).on('focus', '#persselect', function() {
        $('.cartierechose').hide();
        var obj = $(this);
        $('.chose').hide();
        $(this).parent().children('.chose').show();
        $(document).on('keypress', '#persselect', function() {
            return false;
        });
        $(document).one('click', '.chose li', function() {
            obj.val($(this).text());
            if (obj.val()!="") { obj.removeClass('gresit').addClass('ok'); }
            $(this).parent().parent().hide();
        });
    });
    $(document).on('focus', '#cartierselect', function() {
        $('.cartierechose').hide();
        var obj = $(this);
        $('.chose').hide();
        $(this).parent().children('.cartierechose').show();
        $(document).on('keypress', '#cartierselect', function() {
            return false;
        });
        $(document).one('click', '.cartierechose li', function() {
            obj.val($(this).text());
            if (obj.val()!="") { obj.removeClass('gresit').addClass('ok'); }
            $(this).parent().parent().hide();
        });
    });
    $(document).on('blur', '.camp input', function() {
        if ($(this).attr('id')=="titlu") if (($(this).val().length<4) || ($(this).val()=="")) { $(this).removeClass('ok');  $(this).addClass('gresit'); }
        else { $(this).removeClass('gresit').addClass('ok');  }
        if ($(this).attr('id')=="nume") if (($(this).val().length<6) || ($(this).val()=="")) { $(this).removeClass('ok'); $(this).addClass('gresit'); }
        else { $(this).removeClass('gresit').addClass('ok'); }
        else if ($(this).attr('id')=="email") if ($(this).val().search('@')<1) {  $(this).removeClass('ok'); $(this).addClass('gresit'); }
        else { $(this).removeClass('gresit').addClass('ok');  }
        else if ($(this).attr('id')=="pret")  if ($(this).val()!="") { $(this).addClass('ok'); }
        else { $(this).removeClass('ok').addClass('gresit');  }
        else if ($(this).attr('id')=="telefon")  if ($(this).val().length==10 && !isNaN($(this).val())) {  $(this).removeClass('gresit').addClass('ok'); }
        else if ($(this).val()!="") { $(this).removeClass('ok').addClass('gresit');  }
        else { $(this).removeClass('ok').removeClass('gresit'); }
        else if ($(this).attr('id')=="skype")  if ($(this).val()!="") {  $(this).addClass('ok'); }
        else {  $(this).removeClass('ok'); }
        else if ($(this).attr('id')=="yahoo")  if ($(this).val()!="") { $(this).addClass('ok'); }
        else {  $(this).removeClass('ok'); }
    });
    $(document).on('blur', '.camp textarea', function() {
        if ($(this).attr('id')=="anunt") if ($(this).val().length<20) { $(this).addClass('gresit'); }
        else { $(this).removeClass('gresit').addClass('ok'); }
    });
    $(document).on('click', '.clickchoes', function() {
        $('.clickchoes').removeClass('choes-activ');
        $('.tick-green').remove();
        $(this).addClass('choes-activ').append('<div class="tick-green"></div>');
    });
    $(document).on('keyup', '#pret', function(e) {
        var myString = $(this).val();
        myString = myString.replace(/\D/g,'');
        $(this).val(myString);
    });
    $(document).on('keyup', '#anunt', function(e) {
        $('#nrramas').text(1000-$(this).val().length);
    });
    $(document).on('keyup', '#titlu', function(e) {
        $('#nrramas2').text(70-$(this).val().length);
    });
    $(document).on('click', '.log', function() {
        $('.logincon').show();
        $('.tutorialcon').html('').hide();
        $('.afteradd').html('').hide();
    });
    $(document).on('click', '.logincon, .inchide-login', function() {
        $('.logincon').hide();
    });
    $(document).on('click', '.loginform', function(e) {
        e.stopPropagation();
        e.preventDefault();
    });
    $(document).on('click', '.afteradd, .inchide-login', function() {
        $('.afteradd').hide();
    });
    $(document).on('click', '.aftermesaj', function(e) {
        e.stopPropagation();
        e.preventDefault();
    });
    $(document).on('click', '.galcon img', function() {
        $('body').before('<div class="galshow"><div class="galshowcon"><div class="galclose close-white"></div><img src="/img/loader.gif" class="loader" alt="img" /></div></div>');
        $('.galshow').height($(window).height()).show();
        $.post('/ajax/extractimg', { link: $(this).attr('id'), first: $(this).attr('alt') }, function(data) {
            var obj = JSON.parse(data);
            $('.galshowcon img').removeClass('loader');
            if (obj[obj.fir].orientare==1) { $('.galshowcon img').addClass('vertical'); }
            $('.galshowcon img').attr('src', obj[obj.fir].img);
            $(document).on('click', '.galshowcon img', function() {
                if (obj.fir < obj.length-1) {
                    obj.fir++;
                    if (obj[obj.fir].orientare==1) { $(this).addClass('vertical'); }
                    else  { $(this).removeClass('vertical'); }
                    $(this).attr('src', obj[obj.fir].img);
                }
                else {
                    obj.fir=0;
                    if (obj[obj.fir].orientare==1) { $(this).addClass('vertical'); }
                    else  { $(this).removeClass('vertical'); }
                    $(this).attr('src', obj[obj.fir].img);
                }
            });
            $(document).on('keypress', function(evt) {
                evt = evt || window.event;
                switch (evt.keyCode) {
                    case 37:
                        if (obj.fir < obj.length-1) {
                            obj.fir++;
                            if (obj[obj.fir].orientare==1) { $('.galshowcon img').addClass('vertical'); }
                            else  { $('.galshowcon img').removeClass('vertical'); }
                            $('.galshowcon img').attr('src', obj[obj.fir].img);
                        }
                        else {
                            obj.fir=0;
                            if (obj[obj.fir].orientare==1) { $('.galshowcon img').addClass('vertical'); }
                            else  { $('.galshowcon img').removeClass('vertical'); }
                            $('.galshowcon img').attr('src', obj[obj.fir].img);
                        }
                        break;
                    case 39:
                        if (obj.fir > 0) {
                            obj.fir--;
                            if (obj[obj.fir].orientare==1) { $('.galshowcon img').addClass('vertical'); }
                            else  { $('.galshowcon img').removeClass('vertical'); }
                            $('.galshowcon img').attr('src', obj[obj.fir].img);
                        }
                        else {
                            obj.fir=obj.length-1;
                            if (obj[obj.fir].orientare==1) { $('.galshowcon img').addClass('vertical'); }
                            else  { $('.galshowcon img').removeClass('vertical'); }
                            $('.galshowcon img').attr('src', obj[obj.fir].img);
                        }
                        break;
                }
            });
        });
    });
    $(document).on('click', '.galshow, .galclose', function() {
        $('.galshow').hide();
        $('.galshow').remove();
    });
    $(document).on('click', '.galshowcon', function(e) {
        e.stopPropagation();
        e.preventDefault();
    });
   /* $(document).on('mouseover', '.categ a', function() {
        var obj = $(this).children('.caticon');
        var clas = $(obj).attr('class').split(' ');
        $(obj).addClass(clas[1]+'2');
    }).on('mouseleave', '.categ a', function() {
            var obj = $(this).children('.caticon');
            var clas = $(obj).attr('class').split(' ');
            $(obj).removeClass(clas[2]);

        }); */
    $(document).on('mouseover', '.autentificat', function() {
        if (responsive>640) $(this).children('.meniu-user').show();
    }).on('mouseleave', '.log', function() {
            $(this).children('.meniu-user').hide();
        });
    $(document).on('click', '.vezicategori', function() {
        $('.showsubcat').hide();
        $('.showcat').show();
    });
    $(document).on('click', '.vezisubcategori', function() {
        $('.showcat').hide();
        $('.showsubcat').show();
    });
    $(document).on('click', '.rasp-mesaj', function() {
        $(this).parent().parent().parent().children('.nwm').slideToggle();
    });
});
$(document).on('mouseover', '.anunturi', function() {
    $(this).children('.forcp').show();
}).on('mouseleave', '.anunturi', function() {
    $(this).children('.forcp').hide();
    });
$(document).on('click', '.intrebare span', function() {
    $(this).parent().children('.raspuns').slideToggle();
});
$(document).on('click', '.loginwithfacebook img', function() {
    FB.getLoginStatus(function(response) {
        if (response.status=="not_authorized") {
            FB.login(function(response) {
                FB.api('/me', function(response) {
                    var data = JSON.parse(JSON.stringify(response));
                    $.post('/ajax/getSecretKey',{email: data.email}, function(secret) {
                        $.post('/ajax/LoginFacebook', {data: data, secret_key: secret}, function() {
                            window.location.reload();
                        });
                    });
                });
            }, {scope: 'public_profile,email'});
        }
        else if (response.status=="connected") {
            FB.api('/me', function(response) {
                var data = JSON.parse(JSON.stringify(response));
                $.post('/ajax/getSecretKey',{email: data.email}, function(secret) {
                    $.post('/ajax/LoginFacebook', {data: data, secret_key: secret}, function() {
                        window.location.reload();
                    });
                });
            });
        }
        else {
            FB.login(function(response) {
                if (response.status=="connected")
                FB.api('/me', function(response) {
                    var data = JSON.parse(JSON.stringify(response));
                    $.post('/ajax/getSecretKey',{email: data.email}, function(secret) {
                        $.post('/ajax/LoginFacebook', {data: data, secret_key: secret}, function() {
                            window.location.reload();
                        });
                    });
                });
            }, {scope: 'public_profile,email'});
        }
    });
});
$(document).on('click', '.alegemetplata td', function() {
    $('.alegesuma').html('').hide();
    $('.finalieazacomanda').html('').hide();
    var metplata = $(this).attr('id');
    if (metplata=="platasms") $('.alegesuma').html('<h2>2. Alege suma pe care vrei sa o adaugi in cont</h2><h3>Ai ales plata prin SMS.</h3><table class="alegesuma"><tr><td id="3euro">3 &euro;</td><td id="5euro">5 &euro;</td><td id="6euro">6 &euro;</td><td id="7euro">7 &euro;</td><td id="10euro">10 &euro;</td><td id="15euro">15 &euro;<br /><span>Doar VODAFONE</span></td></tr></table>');
    else if (metplata=="creditcard") $('.alegesuma').html('<h2>2. Alege suma pe care vrei sa o adaugi in cont</h2><h3>Ai ales plata prin Cardul de credit.</h3> <input type="number" min="1" class="sumacard" title="Alege suma dorita in EUR." /><div class="nextcard">Urmatorul</div>');
    $('.alegesuma').show();
    $(document).on('click', '.alegesuma td', function() {
        $('.finalieazacomanda').html('').hide();
        var valoare = $(this).attr('id');
        $.post('/adauga-credit/getFormRedirect', { metplata: metplata, valoare: valoare }, function(data) {
            $('.finalieazacomanda').html(data).show();
        });
    });
    $(document).on('click', '.nextcard', function() {
        $('.finalieazacomanda').html('').hide();
        var valoare = $('.sumacard').val();
        if (!isNaN(parseInt(valoare))) {
            $.post('/adauga-credit/getFormRedirect', { metplata: metplata, valoare: valoare }, function(data) {
                $('.finalieazacomanda').html(data).show();
            });
        }
    });
});