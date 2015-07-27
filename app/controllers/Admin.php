<?php

class Admin extends BaseController {

    public $data;

    public function InitDashboard() {
        $sumaminus = Pay::where('suma', '<', '0')->get();
        $minus = 0;
        foreach ($sumaminus as $sm) { $minus = $minus + $sm['suma']; }
        $this->data['minus'] = $minus;
        $sumaplus = Pay::where('suma', '>', '0')->get();
        $plus = 0;
        foreach ($sumaplus as $sp) { $plus = $plus + $sp['suma']; }
        $this->data['plus'] = $plus;
        $this->data['anunt'] = Anunt::where('confirm', '0')->where('confirm_code', '')->get();
        $this->data['user'] = User::orderBy('created_at', 'desc')->take(10)->get();
        $this->data['modanunt'] = ModAnunt::orderBy('created_at', 'desc')->get();
    }
    public function InitUtilizatori() {
        $this->data['utilizatori'] = User::orderBy('created_at')->get();
    }
    public function GetAdminPanel($ramura) {
        $this->data['ramura']=$ramura;
        if ($ramura=="dashboard") { $this->InitDashboard(); }
        else if ($ramura=="utilizatori") { $this->InitUtilizatori(); }
        return View::make('dashboard.callindex')->with('data', $this->data);
    }
    public function GetAdminPanelIndex() {
        $this->InitDashboard();
        $this->data['ramura']='dashboard';
        return View::make('dashboard.callindex')->with('data', $this->data);
    }
    public function acceptaAnunt() {
        if (Request::ajax() && Auth::check() && Auth::user()->admin==1) {
            $code = Input::get('code');
            $anunt = Anunt::find($code);
            if (isset($anunt)) {
                $anunt->created_at = Carbon::now();
                $anunt->expired_at = Carbon::today()->addDays(30);
                $anunt->confirm = 1;
                $anunt->confirm_code = Core::genereaza(30);
                $anunt->save();
                return 1;
            }
        }
    }
    public function getUtilizatori() {
        $pagina = Input::get('pagina');
        $keyword = Input::get('keyword');
        Paginator::setCurrentPage($pagina);
        if ($keyword!="") {
            $utilizatori = User::where('nume', 'LIKE', '%'.$keyword.'%')->orWhere('email', 'LIKE', '%'.$keyword.'%')->orderBy('created_at', 'desc')->get();
        }
        else { $utilizatori = User::orderBy('created_at', 'desc')->paginate(20); }
        return View::make('dashboard.utilizatori')->with('utilizatori', $utilizatori);
    }
    public function RefuzaAnunt() {
        $code = Input::get('code');
        $anunt = ModAnunt::find($code);
        $anunt->delete();
    }
    public function FormEditUser() {
        $code = Input::get('user');
        $user = User::where('id', $code)->first();
        return View::make('dashboard.useredit')->with('user', $user);
    }
    public function EditUser() {
        $values = Input::get('data');
        $rules = array('id'=>'exists:users,id', 'nume'=>'alpha_spaces|required', 'email'=>'email', 'judet'=>'exists:orases,nume', 'oras'=>'exists:cartieres,nume', 'telefon'=>'numeric', 'credit'=>'numeric');
        $validator = Validator::make($values, $rules);
        if (!$validator->fails()) {
            $user = User::find($values['id']);
            $user->nume = $values['nume'];
            $user->email = $values['email'];
            $user->oras = $values['judet'];
            $user->cartier = $values['oras'];
            $user->telefon = $values['telefon'];
            $user->skype = $values['skype'];
            $user->yahoo = $values['yahoo'];
            $user->credit = $values['credit'];
            $user->save();
            return 1;
        }
        else {
            $mesaj = $validator->messages()->all();
            return $mesaj[0];
        }
    }
    public function stergeUser() {
        $code = Input::get('code');
        $user = User::find($code);
        if (isset($user)) {
            $anunturi = Anunt::where('user', $user->id)->get();
            foreach ($anunturi as $anunt) {
                ModAnunt::where('id', $anunt->id)->delete();
            }
            Anunt::where('user', $user->id)->delete();
            Imagine::where('user', $user->id)->delete();
            Mesaj::where('user', $user->id)->delete();
            Mesaj::where('user2', $user->id)->delete();
            Savead::where('user', $user->id)->delete();
            $tickete = Ticket::where('user', $user->id)->get();
            foreach ($tickete as $ticket) {
                Reply::where('ticket', $ticket->id)->delete();
            }
            Ticket::where('user', $user->id)->delete();
            $user->delete();
        }
    }
    public function stergeAnunt() {
        $code = Input::get('code');
        $anunt = Anunt::find($code);
        if (isset($anunt)) {
            Imagine::where('anunt', $anunt->id)->delete();
            ModAnunt::where('id', $anunt->id)->delete();
            $anunt->delete();
            return 1;
        }
    }
    public function getAnunturi() {
        $pagina = Input::get('pagina');
        $keyword = Input::get('keyword');
        Paginator::setCurrentPage($pagina);
        if ($keyword!="") {
            $anunturi = Anunt::where('titlu', 'LIKE', '%'.$keyword.'%')->orWhere('continut', 'LIKE', '%'.$keyword.'%')->orderBy('created_at', 'desc')->get();
            foreach ($anunturi as $anunt) {
                $anunt['imagine'] = Imagine::where('anunt', $anunt->id)->where('first', '1')->first();
            }
        }
        else { $anunturi = Anunt::orderBy('created_at', 'desc')->paginate(20);
            foreach ($anunturi as $anunt) {
                $anunt['imagine'] = Imagine::where('anunt', $anunt->id)->where('first', '1')->first()['link_mini'];
            }
        }
        return View::make('dashboard.anunturi')->with('anunturi', $anunturi);
    }
    public function getPays() {
        $pagina = Input::get('pagina');
        Paginator::setCurrentPage($pagina);
        $plati = Pay::orderBy('created_at', 'desc')->paginate(20);
        return View::make('dashboard.plati')->with('plati', $plati);
    }
    public function stergePay() {
        $code = Input::get('code');
        $pay = Pay::find($code);
        if (isset($pay)) {
            $pay->delete();
        }
    }
    public function getTickets() {
        $pagina = Input::get('pagina');
        Paginator::setCurrentPage($pagina);
        $tickets = Ticket::orderBy('created_at', 'desc')->paginate(20);
        return View::make('dashboard.tickets')->with('tickets', $tickets);
    }
    public function stergeTickets() {
        $code = Input::get('code');
        $ticket = Ticket::find($code);
        if (isset($ticket)) {
            Reply::where('ticket', $ticket->id)->delete();
            $ticket->delete();
        }
    }
    public function RaspTicket() {
        $code = Input::get('ticket');
        $ticket = Ticket::where('id', $code)->first();
        $ticket['user']=User::where('id', $ticket->user)->first();
        return View::make('dashboard.ticketrasp')->with('ticket', $ticket);
    }
    public function AnunturiDataLimita() {
        $anunturi = Anunt::where('expired_at', '<', Carbon::today())->where('confirm', '1')->get();
        foreach ($anunturi as $anunt) {
            $anunt->confirm = '0';
            $anunt->promovat = '0';
            $anunt->pachet = '';
            $anunt->confirm_code = Core::genereaza(30);
            $anunt->save();
            $user = User::find($anunt->user);
            $view_data=array('nume'=>$user->nume, 'link'=>$anunt->confirm_code, 'titlu'=>$anunt->titlu);
            $email_data=array('to'=>$user->email, 'titlu'=>$anunt->titlu);
            Mail::send('mail.reactualizeaza', $view_data, function($message) use ($email_data) {
                $message->from('oficial@erapid.ro', 'Echipa eRapid.ro');
                $message->subject('Reactualizeaza-ti anuntul "'.$email_data['titlu'].'"');
                $message->to($email_data['to']);
            });
        }
    }
    public function DeleteImgNorecord() {
        $files = glob(public_path().'/tmp/*'); // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file))
                unlink($file); // delete file
        }
    }
    public function setReinoire() {
        $anunturi = Anunt::get();
        foreach ($anunturi as $anunt) {
            if ($anunt->reinoieste_at <= Carbon::now() && $anunt->created_at < $anunt->reinoieste_at) { $anunt->created_at=$anunt->reinoieste_at; $anunt->save(); }
        }
    }
    public function ReinoiesteAnunturiPromovate() {
        $anunturi = Anunt::where('promovat', '1')->get();
        foreach ($anunturi as $anunt) {
            if ($anunt->reinoieste_at <= $anunt->created_at) {
                $dt = Carbon::today()->addDays(1);
                $dt->hour = $anunt->created_at->format('H');
                $dt->minute = $anunt->created_at->format('i');
                $dt->second = $anunt->created_at->format('s');
                $anunt->reinoieste_at = $dt;
                $anunt->save();
            }
        }
        $this->AnunturiDataLimita();
        $this->setReinoire();
    }
    public function ActiuneForApp() {
        $this->AnunturiDataLimita();
        $this->DeleteImgNorecord();
        $this->ReinoiesteAnunturiPromovate();
        return 'Operatiune cu succes !';
    }
    public function RaspundeTicket() {
        $stare = Input::get('stare');
        $mesaj = Input::get('mesaj');
        $ticket = Input::get('ticket');
        $reply = new Reply();
        $reply->mesaj = $mesaj;
        $reply->ticket = $ticket;
        $reply->send = 1;
        $reply->save();
        $ticket = Ticket::find($ticket);
        $ticket->stare = $stare;
        $ticket->save();
    }
}