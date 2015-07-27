$(function() {
    $( document ).tooltip();
});
$('.meniu').height($(window).height()-50);
$('.content').css('min-height', $(window).height()-80);
$('.alert').css('height', $(window).height());
$(function() {
    $('.panoucontent').perfectScrollbar();
});
$(document).on('click', '.buton', function() {
    $.post('/admin/IntretineAplicatie', function(data) { alert(data); });
});
$(document).on('click', '.edituser', function() {
    $(document).on('click', '.alertcon', function(e) {
        e.stopPropagation();
        e.preventDefault();
    });
    $(document).one('click', '.alert', function() {
        $('.alert').hide();
    });
    $('.alertcon').css('height', $(window).height()-80);
    var user = $(this).parent().parent().attr('id');
    $.post('/admin/FormeditUser', { user: user }, function(data) {
        $('.alertcon').html(data);
        $('.alert').show();
    });
});
$(document).on('click', '.raspticket', function() {
    $(document).on('click', '.alertcon', function(e) {
        e.stopPropagation();
        e.preventDefault();
    });
    $(document).one('click', '.alert', function() {
        $('.alert').hide();
    });
    $('.alertcon').css('height', $(window).height()-80);
    var ticket = $(this).parent().parent().attr('id');
    $.post('/admin/RaspTicket', { ticket: ticket }, function(data) {
        $('.alertcon').html(data);
        $('.alert').show();
    });
});
$(document).on('click', '.stergeuser', function() {
    var r = confirm('Esti sigur ca vrei sa sterge utilizatorul ? ACESTE DATE NU POT FI RECUPERATE ! Vor fi sterse pe langa utilizator si anunturile, imaginile, ticketele, modificarile de anunturi si tot ce e legat de acest utilizator');
    if (r==true) {
        var code = $(this).parent().parent().attr('id');
        $.post('/admin/stergeUser', {code: code}, function() {
            window.location.reload();
        });
    }
});
$(document).on('click', '.stergeanunt', function() {
    var r = confirm('Esti sigur ca vrei sa sterge anuntul ? ACESTE DATE NU POT FI RECUPERATE !');
    if (r==true) {
        var code = $(this).parent().parent().attr('id');
        $.post('/admin/stergeAnunt', {code: code}, function() {
            window.location.reload();
        });
    }
});
$(document).on('click', '.stergepay', function() {
    var r = confirm('Esti sigur ca vrei sa sterge aceasta plata ? ACESTE DATE NU POT FI RECUPERATE !');
    if (r==true) {
        var code = $(this).parent().parent().attr('id');
        $.post('/admin/stergePay', {code: code}, function() {
            window.location.reload();
        });
    }
});
$(document).on('click', '.stergeticket', function() {
    var r = confirm('Esti sigur ca vrei sa sterge aceast ticket ? ACESTE DATE NU POT FI RECUPERATE !');
    if (r==true) {
        var code = $(this).parent().parent().attr('id');
        $.post('/admin/stergeTicket', {code: code}, function() {
            window.location.reload();
        });
    }
});
$(document).on('click', '.logout', function() {
    $.post('/ajax/logout', function() { window.location='/'; });
});
$(document).on('click', '.accepta', function() {
    alert(1);
    var code = $(this).parent().parent().attr('id');
    $.post('/admin/acceptaAnunt', {code: code}, function() { window.location.reload(); })
});
$(document).on('click', '.refuza', function() {
    var code = $(this).parent().parent().attr('id');
    $.post('/admin/refuzaAnunt', {code: code}, function() { window.location.reload(); })
});
$(document).on('click', '.acceptamodanunt', function() {
    var code = $(this).parent().parent().attr('id');
    $.post('/ajax/AcceptModAnunt', { code: code }, function(data) {
        window.location.reload();
    });
});
$(document).on('click', '.refuzamodanunt', function() {
    var code = $(this).parent().parent().attr('id');
    $.post('/ajax/RefuzaModAnunt', { code: code }, function(data) {
        window.location.reload();
    });
});
$(document).on('keypress', '.utilizatori-search', function(e) {
    var p = e.which;
    var g=0;
    var pagina = 1;
    if(p==13 && $(this).val()!="" && g!=1){
        g=1;
        $('.utilizatori-table tbody').html('<img src="/img/loader.gif" alt="Loading..." />');
        var keyword = $(this).val();
        $.post('/admin/getUtilizatori', { pagina: pagina, keyword: keyword }, function(data) {
            $('.utilizatori-table tbody').html(data);
            setTimeout(function() { g=0; }, 1000);
        });
    }
    else {
        if ($(this).val()=="") $.post('/admin/getUtilizatori', { pagina: pagina}, function(data) {
        $('.utilizatori-table tbody').html(data);
    }); }
});
$(document).on('keypress', '.anunturi-search', function(e) {
    var p = e.which;
    var g=0;
    var pagina = 1;
    if(p==13 && $(this).val()!="" && g!=1){
        g=1;
        $('.anunturi-table tbody').html('<img src="/img/loader.gif" alt="Loading..." />');
        var keyword = $(this).val();
        $.post('/admin/getAnunturi', { pagina: pagina, keyword: keyword }, function(data) {
            $('.anunturi-table tbody').html(data);
            setTimeout(function() { g=0; }, 1000);
        });
    }
    else {
        if ($(this).val()=="") $.post('/admin/getAnunturi', { pagina: pagina}, function(data) {
            $('.anunturi-table tbody').html(data);
        }); }
});
$(document).on('click', '.saveuser', function() {
    var nume = $('#nume').val();
    var email = $('#email').val();
    var judet = $('#judet').val();
    var oras = $('#oras').val();
    var telefon = $('#telefon').val();
    var skype = $('#skype').val();
    var yahoo = $('#yahoo').val();
    var id = $('#iduser').text();
    var credit = $('#credit').val();
    var json = '{"id":"'+id+'", "nume":"'+nume+'", "email":"'+email+'", "judet":"'+judet+'", "credit":"'+credit+'", "oras":"'+oras+'", "telefon":"'+telefon+'", "skype":"'+skype+'", "yahoo":"'+yahoo+'"}';
    var JsonObj = JSON.parse(json);
    $.post('/admin/editUser', {data: JsonObj}, function(data) {
        if (data==1) window.location.reload();
        else alert(data);
    });
});
$(document).on('click', '.raspundeticket', function() {
    var stare = $('.stare').val();
    var mesaj = $('#mesaj').val();
    var ticket = $('.stare').attr('id');
    if (mesaj!="") {
        $.post('/admin/raspundeTicket', { stare: stare, mesaj:mesaj, ticket: ticket }, function() {
            window.location.reload();
        });
    }
});