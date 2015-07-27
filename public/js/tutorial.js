/**
 * Created by Stoian Catalin on 10.09.2014.
 */
function resetTutorial() {
    $('.tutorialcon').html('').hide();
    $('.toppart').css('z-index', 1000);
    $('.categ').css('z-index', 0);
    $('.trei').css('z-index', 0);
    $('.tutorial-pas').css('top', '30px').css('position', 'relative');
    $(".camp").css('z-index', 0);
    $(".help-blue").css('z-index', 0);
    $('.part2').css('z-index', 0);
    $('.part1').css('z-index', 0);
    $('.categorishow').css('z-index', 0);
    $(document).off('click', '.tuto-accept');
}
function tut_primapagina() {
    $('.tutorialcon').html('<div class="tutorial-pas animated rotateIn"><img src="/img/logo.png" alt="Logo" /><br /><div class="pas">Doriti ajutor pentru Prima pagina ?</div><div class="tuto-accept animated">Da, desigur.</div><div class="tuto-refuze animated">Nu, inchide.</div></div>');
    $(document).one('click', '.tuto-refuze', function() { resetTutorial(); });
    $(document).one('click', '.tuto-accept', function() { $('.tutorialcon').html('<div class="tutorial-pas animated flipInY"><div class="pas">eRapid.ro este o aplicatie web de anunturi gratuite online special dedicata judetelor Galati si Braila.</div><div class="tuto-accept animated">Urmatorul</div><div class="tuto-refuze animated">Inchide.</div></div>');
        $(document).one('click', '.tuto-accept', function() {
            $('.toppart').css('z-index', 10000);
            $('.tutorialcon').html('<div class="tutorial-pas animated flipInX"><div class="pas">Aplicatia este usor accesibila indiferent de varsta utilizatorului. Se poate cauta in baza de date folosind sectiunea evidentiata.</div><div class="tuto-accept animated">Urmatorul</div><div class="tuto-refuze animated">Inchide.</div></div>');
            $('.tutorial-pas').css('top', '250px');
            $(document).one('click', '.tuto-accept', function() {
                $('.toppart').css('z-index', 0);
                $('.categ').css('z-index', 10000);
                $('.tutorialcon').html('<div class="tutorial-pas animated fadeInRight"><div class="pas">Daca vrei sa cumperi sau sa vinzi ceva anume, poti ajunge foarte usor la categoria dorita: Un simplu click pe una din categoriile de mai jos !</div><div class="tuto-accept animated">Urmatorul</div><div class="tuto-refuze animated">Inchide.</div></div>');
                $('.tutorial-pas').css('top', '40px');
                $(document).one('click', '.tuto-accept', function() {
                    $('.categ').css('z-index', 0);
                    $('.trei').css('z-index', 10000);
                    $('.tutorialcon').html('<div class="tutorial-pas animated bounceIn"><div class="pas">Pentru a adauga un anunt trebuie doar sa dai click pe unul din butoanele inscriptionate cu "Adauga Anunt". Dureaza doar 5 minute, si e GRATUIT !</div><div class="tuto-accept animated">Urmatorul</div><div class="tuto-refuze animated">Inchide.</div></div>');
                    $('.tutorial-pas').css('top', '200px');
                    $(document).one('click', '.tuto-accept', function() {
                        $('.trei').css('z-index', 0);
                        $('.tutorialcon').html('<div class="tutorial-pas animated bounceIn"><div class="pas">Oridecateori ai nevoie de ajutor poti apasa butonul "Ajutor", iar daca tutorialul nu te lamureste, poti trimite un email cu orice intrebare la suport@erapid.ro !</div><div class="tuto-refuze animated">Inchide.</div></div>');
                        $('.tutorial-pas').css('top', '200px');
                    });
                });
            });
        });
    });
}
function tut_adaugaanunt() {
    $('.tutorialcon').html('<div class="tutorial-pas animated rotateIn"><img src="/img/logo.png" alt="Logo" /><br /><div class="pas">Doriti ajutor pentru sectiunea Adauga Anunt ?</div><div class="tuto-accept animated">Da, desigur.</div><div class="tuto-refuze animated">Nu, inchide.</div></div>');
    $(document).one('click', '.tuto-refuze', function() { resetTutorial(); });
    $(document).one('click', '.tuto-accept', function() { $('.tutorialcon').html('<div class="tutorial-pas animated flipInY"><div class="pas">Pe eRapid.ro sa adaugi un anunt e foarte simplu ! Dureaza 5 min, nu iti trebuie cont si e GRATIS !</div><div class="tuto-accept animated">Urmatorul</div><div class="tuto-refuze animated">Inchide.</div></div>');
        $(document).one('click', '.tuto-accept', function() {
            $('.tutorialcon').html('<div class="tutorial-pas animated flipInY"><div class="pas">Tot ce trebuie sa faci e sa completezi campurile. Cele care sunt marcate cu * inseamna ca sunt obligatorii.</div><div class="tuto-accept animated">Urmatorul</div><div class="tuto-refuze animated">Inchide.</div></div>');
            $('.tutorial-pas').css('top', '300px').css('left', '25%');
            $(document).one('click', '.tuto-accept', function() {
                $('.tutorialcon').html('<div class="tutorial-pas animated flipInY"><div class="pas">Pentru ajutor individual legat de fiecare camp, poti acoperi cercul albastru cu  cursor-ul.</div><div class="tuto-accept animated">Urmatorul</div><div class="tuto-refuze animated">Inchide.</div></div>');
                $('.tutorial-pas').css('top', '300px').css('left', '25%');
                $(document).one('click', '.tuto-accept', function() {
                    $('.tutorialcon').html('<div class="tutorial-pas animated bounceIn"><div class="pas">Oridecateori ai nevoie de ajutor poti apasa butonul "Ajutor", iar daca tutorialul nu te lamureste, poti trimite un email cu orice intrebare la suport@erapid.ro !</div><div class="tuto-refuze animated">Inchide.</div></div>');
                    $('.tutorial-pas').css('top', '200px');
                });
            });
        });
    });
}
function tut_categorii() {
    $('.tutorialcon').html('<div class="tutorial-pas animated rotateIn"><img src="/img/logo.png" alt="Logo" /><br /><div class="pas">Doriti ajutor pentru sectiunile Categorii ?</div><div class="tuto-accept animated">Da, desigur.</div><div class="tuto-refuze animated">Nu, inchide.</div></div>');
    $(document).one('click', '.tuto-refuze', function() { resetTutorial(); });
    $(document).one('click', '.tuto-accept', function() { $('.tutorialcon').html('<div class="tutorial-pas animated flipInY"><div class="pas">E simplu sa cauti un anunt dupa o anumita categorie sau subcategorie ! Tot ce trebuie sa faci este sa fi atent la fiecare anunt in parte, iar cand gasesti ceva ce iti place apasa click pe anuntul respectiv.</div><div class="tuto-accept animated">Urmatorul</div><div class="tuto-refuze animated">Inchide.</div></div>');
        $('.part2').css('z-index', 10000);
        $('.tutorial-pas').css('top', '200px').css('position', 'absolute').css('left', '5%');
        $(document).one('click', '.tuto-accept', function() {
            $('.part2').css('z-index', 0);
            $('.categorishow').css('z-index', 10000);
            $('.tutorialcon').html('<div class="tutorial-pas animated bounceIn"><div class="pas">Acesta este panoul de navigare in categorii. De aici poti alege o subcategorie a categoriei in care te afli, sau te poti intoarce inapoi la categorii, alegand o alta categorie.</div><div class="tuto-accept animated">Urmatorul</div><div class="tuto-refuze animated">Inchide.</div></div>');
            $('.tutorial-pas').css('position', 'relative').css('top', '200px');
            $(document).one('click', '.tuto-accept', function() {
                $('.categorishow').css('z-index', 0);
                $('.tutorialcon').html('<div class="tutorial-pas animated bounceIn"><div class="pas">Pentru a vedea anunturile de pe pagina 2,3,4 s.a.m.d, trebuie doar sa scroll-ati in jos. <img class="scrolldown animated pulse" src="/img/scroll-down.png" alt="Scroll Down" /></div><div class="tuto-accept animated">Urmatorul</div><div class="tuto-refuze animated">Inchide.</div></div>');
                $('.tutorial-pas').css('top', '200px');
                $(document).one('click', '.tuto-accept', function() {
                    $('.tutorialcon').html('<div class="tutorial-pas animated bounceIn"><div class="pas">Oridecateori ai nevoie de ajutor poti apasa butonul "Ajutor", iar daca tutorialul nu te lamureste, poti trimite un email cu orice intrebare la suport@erapid.ro !</div><div class="tuto-refuze animated">Inchide.</div></div>');
                    $('.tutorial-pas').css('top', '200px');
                });
            });
        });
    });
}
function tut_anunt() {
    $('.tutorialcon').html('<div class="tutorial-pas animated rotateIn"><img src="/img/logo.png" alt="Logo" /><br /><div class="pas">Doriti ajutor pentru sectiunea Anunt ?</div><div class="tuto-accept animated">Da, desigur.</div><div class="tuto-refuze animated">Nu, inchide.</div></div>');
    $(document).one('click', '.tuto-refuze', function() { resetTutorial(); });
    $(document).one('click', '.tuto-accept', function() { $('.tutorialcon').html('<div class="tutorial-pas animated flipInY"><div class="pas">Prin intermediul aplicatiei eRapid.ro poti lua foarte usor legatura cu cel care a postat anuntul. In dreapta ai toate modalitatile de contact pe care patronul anuntului a fost de acord sa fie afisate.</div><div class="tuto-accept animated">Urmatorul</div><div class="tuto-refuze animated">Inchide.</div></div>');
        $('.part1').css('z-index', 10000);
        $('.tutorial-pas').css('top', '200px');
        $(document).one('click', '.tuto-accept', function() { $('.tutorialcon').html('<div class="tutorial-pas animated flipInY"><div class="pas">Noi iti punem la dispozitie informatii utile despre anunt, pecum Data postarii, numarl de vizualiari, si o interfata prietenoasa. De aici poti vizualiza imaginile atasate anuntului, si poti modifica, dezactiva sau promova anutul tau.</div><div class="tuto-accept animated">Urmatorul</div><div class="tuto-refuze animated">Inchide.</div></div>');
            $('.part1').css('z-index', 0);
            $('.part2').css('z-index', 10000);
            $('.tutorial-pas').css('top', '100px').css('right', '30%');
            $(document).one('click', '.tuto-accept', function() {
                $('.part2').css('z-index', 0);
                $('.tutorialcon').html('<div class="tutorial-pas animated bounceIn"><div class="pas">Oridecateori ai nevoie de ajutor poti apasa butonul "Ajutor", iar daca tutorialul nu te lamureste, poti trimite un email cu orice intrebare la suport@erapid.ro !</div><div class="tuto-refuze animated">Inchide.</div></div>');
                $('.tutorial-pas').css('top', '200px');
            });
        });
    });
}
function elseFunction() {
    $('.tutorialcon').html('<div class="tutorial-pas animated rotateIn"><img src="/img/logo.png" alt="Logo" /><br /><div class="pas">Nu exista un tutorial pentru aceasta pagina ! Daca ai o nelamurire sau vrei sa ne intrebi orice legat de eRapid.ro o poti face trimitand un email la adesa suport@erapid.ro. Multumim!</div><div class="tuto-refuze animated">Inchide.</div></div>');
    $(document).one('click', '.tuto-refuze', function() { resetTutorial(); });
}
$(document).on('mouseover', '.tuto-accept, .tuto-refuze', function() {
    $(this).addClass('tada');
    $(this).one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() { $(this).removeClass('tada'); });
});
$(document).ready(function() {
    $('.tutorialcon').height($(window).height());
    $(document).on('click', '.tuto', function() {
        var pagina = window.location.pathname.substr(1);
        pagina = pagina.split('/');
        pagina = pagina[0];
        var categorii = ["auto", "adult", "imobiliare", "electronice", "moda-si-frumusete", "casa-si-gradina", "mama-si-copilul", "sport-si-arta", "animate", "industrie", "servicii-si-afaceri", "locuri-de-munca"];
        $('.tutorialcon').show();
        if (pagina=="") tut_primapagina();
        else if (pagina=="adauga-anunt") tut_adaugaanunt();
        else if (categorii.indexOf(pagina) >= 0) { tut_categorii(); }
        else if (pagina == "anunt") { tut_anunt(); }
        else { elseFunction(); }
    });
});
