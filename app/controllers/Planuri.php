<?php

class Planuri extends BaseController {

    public $cost;
    public $durata;
    public $nume;

    public function InitBronze() {
        $this->cost = 3; // In euro;
        $this->durata = 7; // In zile;
        $this->nume = "Bronze Bird"; // Numele pachetului;
    }
    public function InitSilver() {
        $this->cost = 5; // In euro;
        $this->durata = 14; // In zile;
        $this->nume = "Silver Coin"; // Numele pachetului;
    }
    public function InitGold() {
        $this->cost = 7; // In euro;
        $this->durata = 30; // In zile;
        $this->nume = "Gold Gun"; // Numele pachetului;
    }
    public function Bronze($code) {
        $this->InitBronze();
        $anunt = Anunt::find($code);
        if (Auth::check() && Auth::user()->credit >= $this->cost && Auth::user()->id==$anunt->user) {
            $anunt->created_at = Carbon::now();
            $anunt->expired_at = Carbon::now()->addDays($this->durata);
            $anunt->promovat = 1;
            $anunt->pachet = $this->nume." (".$this->durata." zile)";
            Auth::user()->credit = Auth::user()->credit-$this->cost;
            Auth::user()->save();
            $anunt->save();
        }
    }
    public function Silver($code) {
        $this->InitSilver();
        $anunt = Anunt::find($code);
        if (Auth::check() && Auth::user()->credit >= $this->cost && Auth::user()->id==$anunt->user) {
            $anunt->created_at = Carbon::now();
            $anunt->expired_at = Carbon::now()->addDays($this->durata);
            $anunt->promovat = 1;
            $anunt->pachet = $this->nume." (".$this->durata." zile)";
            Auth::user()->credit = Auth::user()->credit-$this->cost;
            Auth::user()->save();
            $anunt->save();
        }
    }
    public function Gold($code) {
        $this->InitGold();
        $anunt = Anunt::find($code);
        if (Auth::check() && Auth::user()->credit>=$this->cost && Auth::user()->id==$anunt->user) {
            $anunt->created_at = Carbon::now();
            $anunt->expired_at = Carbon::now()->addDays($this->durata);
            $anunt->promovat = 1;
            $anunt->pachet = $this->nume." (".$this->durata." zile)";
            Auth::user()->credit = Auth::user()->credit-$this->cost;
            Auth::user()->save();
            $anunt->save();
        }
    }
    public function ExecPachet($code) {
        $anunt = Anunt::find($code);
        if (Auth::check() && Auth::user()->credit >= $this->cost && Auth::user()->id==$anunt->user) {
            $anunt->created_at = Carbon::now();
            $anunt->expired_at = Carbon::now()->addDays($this->durata);
            $anunt->promovat = 1;
            $anunt->pachet = $this->nume." (".$this->durata." zile)";
            Auth::user()->credit = Auth::user()->credit-$this->cost;
            Auth::user()->save();
            $anunt->save();
        }
    }
    public function BronzeCheckForUser() {
        $this->InitBronze();
        $code = Input::get('code');
        $anunt = Anunt::find($code);
        if (Auth::check() && Auth::user()->credit >= $this->cost && $anunt->user==Auth::user()->id) { return json_encode(array('rez'=>'1', 'titlu'=>$anunt->titlu, 'code'=>$anunt->id, 'pachet'=>$this->nume)); }
        else return json_encode(array('rez'=>'0'));
    }
    public function SilverCheckForUser() {
        $this->InitSilver();
        $code = Input::get('code');
        $anunt = Anunt::find($code);
        if (Auth::check() && Auth::user()->credit >= $this->cost && $anunt->user==Auth::user()->id) { return json_encode(array('rez'=>'1', 'titlu'=>$anunt->titlu, 'code'=>$anunt->id, 'pachet'=>$this->nume)); }
        else return json_encode(array('rez'=>'0'));
    }
    public function GoldCheckForUser() {
        $this->InitGold();
        $code = Input::get('code');
        $anunt = Anunt::find($code);
        if (Auth::check() && Auth::user()->credit >= $this->cost && $anunt->user==Auth::user()->id) { return json_encode(array('rez'=>'1', 'titlu'=>$anunt->titlu, 'code'=>$anunt->id, 'pachet'=>$this->nume)); }
        else return json_encode(array('rez'=>'0'));
    }
    public function CumparaPachet() {
        if (Request::ajax() && Auth::check()) {
            $value['pachet'] = Input::get('pachet');
            $value['anunt'] = Input::get('code');
            $value['parola'] = Input::get('parola');
            $rules = array('pachet'=>'numeric', 'anunt'=>'exists:anunts,id', 'parola'=>'passcheck');
            $validator = Validator::make($value, $rules);
            if (!empty($value['parola'])) {
                if (!$validator->fails()) {
                    if ($value['pachet']==1) $this->InitBronze();
                    else if ($value['pachet']==2) $this->InitSilver();
                    else if ($value['pachet']==3) $this->InitGold();
                    if (Auth::user()->credit >= $this->cost) {
                        $this->ExecPachet($value['anunt']);
                        $this->CreazaPlata(-$this->cost, $this->nume);
                        return 'Anuntul a fost promovat cu succes !';
                    }
                    else {
                        return 'Ne pare rau, dar nu ai suficient credit in cont !<br /><div class="adauga-credit">Adauga Credit</div>';
                    }
                }
                else {
                    $mesaj = $validator->messages()->all();
                    if (empty($mesaj)) $mesaj=array('');
                    return $mesaj[0];
                }
            }
            else return 'Te rugam sa completezi parola pentru a confirma actiunea dorita !';
        }
        else return Redirect::to('/');
    }
    public function CreazaPlata($suma, $pentru) {
        $pay = new Pay();
        $pay->id = Core::genereaza(10);
        $pay->suma = $suma;
        $pay->user = Auth::user()->id;
        $pay->pentru = $pentru;
        $pay->save();
    }
}