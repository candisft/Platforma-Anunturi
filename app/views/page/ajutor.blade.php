@yield('header')
@yield(((!Auth::check()) ? 'loginregister' : '' ))
@yield('addanuntmesaje')
@yield(((!Auth::check()) ? 'fixedbar' : 'fixedbarlogat' ))
@yield('toppart')
<div class="continut">
    <div class="part1">
        <div class="ajutor_header">Intrebari puse frecvent</div>
        <ul class="ajutor">
            <li><a href="#anunturi">Anunturi</a></li>
            <li><a href="#promovare">Promovare</a></li>
            <li><a href="#conturi">Conturi</a></li>
            <li><a href="#securitate">Securitate & Parole</a></li>
        </ul>
    </div>
    <div class="part2">
        <div class="ajutor_intrebari">
            <h2 id="anunturi">Anunturi</h2>
            <div class="intrebare">
                <span>Cum pun un anunt pe eRapid.ro ?</span>
                <div class="raspuns">
                    1. Intra pe urmatorul link de <a href="/adauga-anunt">aici</a>.<br />
                    2. Completeaza campurile existente de acolo. Cele marcate cu * sunt obligatori.<br />
                    3. Daca e prima data cand postezi un anunt, v-a trebui sa confirmi printr-un link primit pe email-ul completat.
                </div>
            </div>
            <div class="intrebare">
                <span>Anuntul este total gratuit ?</span>
                <div class="raspuns">
                    Da, pentru a posta un anunt nu trebuie sa platesti absolut nimic. Este gratuit si dureaza doar 3 minunute.
                </div>
            </div>
            <div class="intrebare">
                <span>Cat timp este valabil un anunt din momentul postarii acestuia ?</span>
                <div class="raspuns">
                    Din momentul in care anuntul primeste aprobare, el este valabil 28 de zile (4 saptamani) calendaristice.
                </div>
            </div>
            <div class="intrebare">
                <span>Ce se intamla dupa ce anuntul expira ?</span>
                <div class="raspuns">
                    Acesta trece in stare de inactivitate, iar utilizatorul este informat printr-un email.<br />
                    Daca utilizatorul doreste il poate reinoi, iar anuntului i se vor adauga inca 28 de zile calendaristice de activitate.<br />
                    Anuntul se poate reinoi de <a href="/contul-meu/anunturile-mele">aici</a>, tabul Anunturi Inactive, apasand pe <div class="cat-reactualizeaza"></div>. (Trebuie sa fi autentificat pe contul de utilizator)
                </div>
            </div>
            <div class="intrebare">
                <span>Daca vand sau cumpar produsul pentru care am pus anuntul, acesta nu mai este valabil. Pot sterge anuntul mai devreme ?</span>
                <div class="raspuns">
                    Desigur, acest lucru se poate face cu usurita acesand link-ul de <a href="/contul-meu/anunturile-mele">aici</a>.<br />
                    1. Anuntul se dezactiveaza apasand pe <div class="cat-dezactiveaza"></div>.<br />
                    2. Mergem la tabul Anunturi Inactive si stergem anuntul apasand din nou pe <div class="cat-dezactiveaza"></div>.
                </div>
            </div>
            <div class="intrebare">
                <span>Unde pot sa vad anunturile salvate ?</span>
                <div class="raspuns">
                    Anunturile salvate se pot vizualiza <a href="/contul-meu/anunturi-salvate">aici</a>.
                </div>
            </div>
            <div class="intrebare">
                <span>Daca anuntul a primit aprobare, de ce este necesara din nou atunci cand il modific ?</span>
                <div class="raspuns">
                    Noi vrem sa oferim un mediu placut utilizatorilor nostri, de aceea suntem foarte stricti in ceea ce priveste anunturile care apar pe site.<br />
                    Prin urmare ne asiguram ca orice anunt apare pe site nu incalca Politica site-ului eRapid.ro
                </div>
            </div>
            <h2 id="promovare">Promovare</h2>
            <div class="intrebare">
                <span>Cum promovez un anunt ?</span>
                <div class="raspuns">
                    Pentru a promova un anunt trebuie sa accesati link-ul de <a href="/contul-meu/anunturile-mele">aici</a>.<br />
                    1. Mergeti in dreptul anuntului pe care doriti sa il promovati si apasati <div class="cat-promoveaza"></div><br />
                    2. Alegeti pachetul pe care doriti sa il atribuiti anuntului si asigurativa ca aveti suma necesara in cont.<br />
                    3. Introduceti parola contului dumneavoastra si apasati pe "Cumpara".
                    Anuntului i se atribuie imediat pachetul cumparat.
                </div>
            </div>
            <div class="intrebare">
                <span>Se pot modifica pachetele de promovare ?</span>
                <div class="raspuns">
                    Nu, aceste pachete sunt fixe si nu pot fi modificate.
                </div>
            </div>
            <div class="intrebare">
                <span>Daca am un pachet pentru un anunt, pot cumpara altul pentru acelasi anunt ?</span>
                <div class="raspuns">
                    Da se poate, iar la perioada de promovare se vor adauga numarul de zile.
                </div>
            </div>
            <h2 id="conturi">Conturi</h2>
            <div class="intrebare">
                <span>De ce am nevoie de cont pe eRapid.ro ?</span>
                <div class="raspuns">
                    Conturile pe eRapid.ro se folosesc pentru ca utilizatorii sa aiba acces la administrarea anunturilor proprii.
                </div>
            </div>
            <div class="intrebare">
                <span>Pot posta un anunt fara sa am cont pe eRapid.ro ?</span>
                <div class="raspuns">
                    Desigur, se poate posta un anunt fara a avea cont, insa va trebui activat prin email, iar odata cu activarea se v-a crea si un cont pentru a evita aceasta neplacere pe viitor.
                </div>
            </div>
            <div class="intrebare">
                <span>De ce este necesara o adresa de email valida ?</span>
                <div class="raspuns">
                    Este absolut necesara o astfel de adresa. Conturile de pe eRapid.ro apartin fiecare in parte celor care detin si adresele de email asociate.
                </div>
            </div>
            <div class="intrebare">
                <span>Pot folosi contul daca nu confirm cu link-ul trimis de pe email ?</span>
                <div class="raspuns">
                    Nu, in acest caz contul nu se poate folosii. El are nevoie de confirmarea de pe email.
                </div>
            </div>
            <h2 id="securitate">Securitate & Parola</h2>
            <div class="intrebare">
                <span>Pentru siguranta mea, cum trebuie sa imi pun parola ?</span>
                <div class="raspuns">
                    Parola trebuie sa aiba minim 6 caractere, sa contina litere mici si mari (a-zA-Z), numere (0-9) si caractere speciale. Astfel nivelul de putere a parolei creste.
                </div>
            </div>
            <div class="intrebare">
                <span>Daca un administrator al site-ului eRapid.ro imi cere parola, trebuie sa io spun ?</span>
                <div class="raspuns">
                    Nu, administratorii site-ului eRapid.ro NU vor cere niciodata parolele conturilor.
                </div>
            </div>
            <div class="intrebare">
                <span>Un administrator imi poate vedea parola ?</span>
                <div class="raspuns">
                    Nu. Parolele sunt criptate in baza de date si nu se salveaza in forma initiala. Nimeni nu poate citi parolele conturilor.
                </div>
            </div>
            <div class="intrebare">
                <span>Contul mi-a fost spart. Il pot recupera ?</span>
                <div class="raspuns">
                    Da. Poti cere resetarea parolei in forma de Login.
                </div>
            </div>
            <div class="intrebare">
                <span>Daca las contul deschis si intra cineva pe el, imi poate sterge anunturile promovate ?</span>
                <div class="raspuns">
                    Atat timp cat persoana respectiva nu stie parola contului, nu poate face nici o actiune care sa afecteze.
                </div>
            </div>
        </div>
    </div>
    <div class="clearfloat"></div>
    @yield('footer')