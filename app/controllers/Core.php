<?php

class Core extends BaseController {
    protected $data=array();
    private function getVarForTemplate() {
        $campuri=array();
        if (Auth::check()) {
            if (Auth::user()->telefon) $campuri['telefon']=1;
            else $campuri['telefon']=0;
            if (Auth::user()->skype) $campuri['skype']=1;
            else $campuri['skype']=0;
            if (Auth::user()->yahoo) $campuri['yahoo']=1;
            else $campuri['yahoo']=0;
            if (Auth::user()->oras) $campuri['oras']=1;
            else $campuri['oras']=0;
            if (Auth::user()->cartier) $campuri['cartier']=1;
            else $campuri['cartier']=0;
            if (Auth::user()->persoana) $campuri['persoana']=1;
            else $campuri['persoana']=0;
            $this->data['campuri']=$campuri;
        }
        else $this->data['campuri']=array('telefon'=>'', 'skype'=>'', 'yahoo'=>'', 'oras'=>'', 'cartier'=>'', 'persoana'=>'');
        $this->data['anunt']=array('pret'=>'','moneda'=>'','titlu'=>'', 'continut'=>'', 'alias'=>'', 'created_at'=>'', 'ora'=>'', 'confirm'=>'');
        $this->data['user']=array('nume'=>'','yahoo'=>'','skype'=>'','telefon'=>'','created_at'=>'','showemail'=>'', 'persoana'=>'', 'oras'=>'', 'cartier'=>'');
        $this->data['galerie']=array();
        $this->data['subcategorie']=array();
        $this->data['categorie']='';
        $this->data['categorii'] = Categorii::getCategori();
        foreach ($this->data['categorii'] as $categorie) {
            $categorie->subcategorie = Subcategorii::getSubcategoriWithParent(lcfirst($categorie->nume));
        }
        $this->data['cartiere'] = Cartiere::getCartiere('');
        if (Auth::check())  {
            $this->data['nume'] = Auth::user()->nume; $this->data['credit'] = Auth::user()->credit;
            $this->data['numarmesaje'] = Mesaj::where('user', Auth::user()->id)->where('stare', '1')->where('vazut', '0')->count();
            if (Auth::user()->admin==1) $this->data['numaradmin'] = Anunt::where('confirm', '0')->where('confirm_code', '')->count()+ModAnunt::count()+Ticket::count();
            $this->data['nottotal'] = $this->data['numarmesaje'];
        }
    }
    public function AdsCompliment(&$anunturi) {
        foreach ($anunturi as $anunt) {
            $user = User::find($anunt['user']);
            $anunt['oras']=$user['oras'];
            $anunt['cartier']=$user['oras'];
            $anunt['data']=explode(' ', $anunt['created_at'])[0];
            $anunt['ora']=explode(' ', $anunt['created_at'])[1];
            if ($anunt['data']=='20'.date("y-m-d")) $anunt['data']='Azi';
            else if ($anunt['data']=='20'.date('y-m-d',strtotime("-1 days"))) $anunt['data']='Ieri';
            $infoimg = Imagine::where('anunt', '=', $anunt['id'])->where('first', '=', '1')->first();
            if (isset($infoimg)) {
                $anunt['preview'] = $infoimg->link_mini;
                $anunt['orientare'] = $infoimg->orientare;
            }
        }
        return $anunturi;
    }
    public function getIndex() {
        $this->getVarForTemplate();
        return View::make('index.index')->with('data', $this->data);
    }
    public function getLoginForm() {
        if (Request::ajax())
            return View::make('ajax.login');
    }
    public function getRegisterForm() {
        if (Request::ajax())
            return View::make('ajax.register');
        else { return Redirect::to('/'); }
    }
    private function changeXSS($values) {
        if (is_array($values)) {
            foreach ($values as &$value)
            {
                $value=htmlentities($value);
            }
        }
        else $values=htmlentities($values);
        return $values;
    }
    private function removeXSS($values) {
        foreach ($values as $value)
        {
            $value=str_replace("'", "", $value);
            $value=str_replace('"', "", $value);
            $value=str_replace(">", "", $value);
            $value=str_replace("<", "", $value);
            $value=str_replace("\\", "", $value);
            $value=str_replace("/", "", $value);
        }
        return $values;
    }
    public function AdaugaCreditPage() {
        if (Auth::check()) {
            $this->getVarForTemplate();
            return View::make('page.calladdcredit')->with('data', $this->data);
        }
        else return Redirect::to('/');
    }
    public function getFormRedirect() {
        require_once storage_path('mobilpay/Request/Abstract.php');
        require_once storage_path('mobilpay/Request/Sms.php');
        require_once storage_path('mobilpay/Request/Card.php');
        require_once storage_path('mobilpay/Invoice.php');
        require_once storage_path('mobilpay/Address.php');
        $metplata = Input::get('metplata');
        $valoare = Input::get('valoare');
        $paymentUrl = 'https://secure.mobilpay.ro';
        $x509FilePath = storage_path('certificates/public.cer');
        if ($metplata == "creditcard") {
            try
            {
                srand((double) microtime() * 1000000);
                $objPmReqCard 						= new Mobilpay_Payment_Request_Card();
                $objPmReqCard->signature 			= 'EYE1-3C7G-GN3N-9WQR-FKKG';
                $objPmReqCard->orderId 				= md5(uniqid(rand()));
                $objPmReqCard->confirmUrl 			= 'http://erapid.ro/adauga-credit/CardConfirm';
                $objPmReqCard->returnUrl 			= 'http://erapid.ro/contul-meu/plati';

                $objPmReqCard->invoice = new Mobilpay_Payment_Invoice();
                $objPmReqCard->invoice->currency	= 'RON';
                $objPmReqCard->invoice->amount		= $valoare*4.3;
                $objPmReqCard->invoice->details		= 'Adauga credit cu card-ul prin mobilPay';

                $objPmReqCard->params['user'] = Auth::user()->id;
                $objPmReqCard->params['suma'] = $valoare;

                $billingAddress 				= new Mobilpay_Payment_Address();
                $billingAddress->type			= 'person'; //should be "person"
                $billingAddress->firstName		= Auth::user()->nume;
                $billingAddress->email			= Auth::user()->email;
                $billingAddress->mobilePhone		= Auth::user()->telefon;
                $objPmReqCard->invoice->setBillingAddress($billingAddress);
                $objPmReqCard->invoice->setShippingAddress($billingAddress);

                $objPmReqCard->encrypt($x509FilePath);
                $data['obj'] = $objPmReqCard;
                $data['link'] = $paymentUrl;
                $data['suma'] = $valoare;
                $data['metplata'] = 'Credit Card';
                return View::make('plata.smsForm')->with('data', $data);
            }
            catch(Exception $e)
            {
            }
        }
        else if ($metplata=="platasms") {
            try
            {
                $objPmReqSms 				= new Mobilpay_Payment_Request_Sms();
                $objPmReqSms->signature 	= 'EYE1-3C7G-GN3N-9WQR-FKKG';
                $codmobilpay = Valori::where('id', $valoare)->pluck('codmobilpay');
                if (isset($codmobilpay)) {
                    $objPmReqSms->service 		= $codmobilpay;
                    $objPmReqSms->returnUrl 	= 'http://erapid.ro/contul-meu/plati'; //sau $objPmReqSms->returnUrl = '<new return url>';
                    $objPmReqSms->confirmUrl 	= 'http://erapid.ro/adauga-credit/SMSconfirm'; //sau $objPmReqSms->confirmUrl = '<new confirm url>';
                    srand((double) microtime() * 1000000);
                    $objPmReqSms->orderId 		= md5(uniqid(rand()));
                    $valoare = preg_replace('/[^0-9,]|,[0-9]*$/','',$valoare);
                    $objPmReqSms->params['suma'] = $valoare;
                    $objPmReqSms->params['user'] = Auth::user()->id;
                    $objPmReqSms->encrypt($x509FilePath);
                    $data['obj'] = $objPmReqSms;
                    $data['link'] = $paymentUrl;
                    $data['suma'] = $valoare;
                    $data['metplata'] = 'SMS';
                    return View::make('plata.smsForm')->with('data', $data);
                }
                else { return 'A aparut o eroare in fluxul de plata !';  }
            }
            catch(Exception $e)
            {
            }
        }
        else { return 'A aparut o eroare in fluxul de plata !'; }
    }


    public function confirmPlataSMS() {
        require_once storage_path('mobilpay/Request/Abstract.php');
        require_once storage_path('mobilpay/Request/Sms.php');
        require_once storage_path('mobilpay/Request/Notify.php');

        $errorCode 		= 0;
        $errorType		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_NONE;
        $errorMessage	= '';

        if(isset($_POST['env_key']) && isset($_POST['data']))
        {
            #calea catre cheia privata
            #cheia privata este generata de mobilpay, accesibil in Admin -> Conturi de comerciant -> Detalii -> Setari securitate
            $privateKeyFilePath = storage_path('certificates/private.key');
            try
            {
                $objPmReq = Mobilpay_Payment_Request_Abstract::factoryFromEncrypted($_POST['env_key'], $_POST['data'], $privateKeyFilePath);
                switch($objPmReq->objPmNotify->action)
                {
                    case 'confirmed':
                        $errorMessage = $objPmReq->objPmNotify->getCrc();
                        $plata = new Pay();
                        $plata->id = $objPmReq->orderId;
                        $plata->suma = $objPmReq->params['suma'];
                        $plata->user = $objPmReq->params['user'];
                        $plata->pentru = 'Adauga '.$objPmReq->params['suma'].' euro credit prin SMS.';
                        $plata->save();
                        $user = User::find($objPmReq->params['user']);
                        $user->credit = $user->credit + $objPmReq->params['suma'];
                        $user->save();
                        break;
                    case 'trial':
                        $errorMessage = $objPmReq->objPmNotify->getCrc();
                        //update DB with transaction status;
                        break;
                    case 'canceled':
                        $errorMessage = $objPmReq->objPmNotify->getCrc();
                        //update DB with transaction status;
                        break;
                    case 'reversed':
                        $errorMessage = $objPmReq->objPmNotify->getCrc();
                        //update DB with transaction status;
                        break;
                    default:
                        $errorType		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
                        $errorCode 		= Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_ACTION;
                        $errorMessage 	= 'mobilpay_refference_action paramaters is invalid';
                        break;
                }
            }
            catch(Exception $e)
            {
                $errorType 		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_TEMPORARY;
                $errorCode		= $e->getCode();
                $errorMessage 	= $e->getMessage();
            }
        }
        else
        {
            $errorType 		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
            $errorCode		= Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_POST_PARAMETERS;
            $errorMessage 	= 'mobilpay.ro posted invalid parameters';
        }
        $rezultat = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        if($errorCode == 0)
        {
            $rezultat .= "<crc>{$errorMessage}</crc>";
        }
        else
        {
            $rezultat .= "<crc error_type=\"{$errorType}\" error_code=\"{$errorCode}\">{$errorMessage}</crc>";
        }
        $response = Response::make($rezultat);

        $response->header('Content-Type', 'application/xml');

        return $response;
    }

    public function confirmPlataCard() {
        require_once storage_path('mobilpay/Request/Abstract.php');
        require_once storage_path('mobilpay/Request/Card.php');
        require_once storage_path('mobilpay/Request/Notify.php');
        require_once storage_path('mobilpay/Invoice.php');
        require_once storage_path('mobilpay/Address.php');
        $errorCode 		= 0;
        $errorType		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_NONE;
        $errorMessage	= '';
        if(isset($_POST['env_key']) && isset($_POST['data']))
        {
            $privateKeyFilePath = storage_path('certificates/private.key');

            try
            {
                $objPmReq = Mobilpay_Payment_Request_Abstract::factoryFromEncrypted($_POST['env_key'], $_POST['data'], $privateKeyFilePath);
                $errorCode = $objPmReq->objPmNotify->errorCode;
                if ($errorCode == "0") {
                    switch($objPmReq->objPmNotify->action)
                    {
                        case 'confirmed':
                            #cand action este confirmed avem certitudinea ca banii au plecat din contul posesorului de card si facem update al starii comenzii si livrarea produsului
                            //update DB, SET status = "confirmed/captured"
                            $errorMessage = $objPmReq->objPmNotify->errorMessage;
                            $user = User::find($objPmReq->params['user']);
                            $user->credit = $user->credit + $objPmReq->params['suma'];
                            $user->save();
                            $plata = Pay::where('id', $objPmReq->orderId)->first();
                            if (!isset($plata)) $plata = new Pay();
                            $plata->id = $objPmReq->orderId;
                            $plata->suma = $objPmReq->params['suma'];
                            $plata->user = $objPmReq->params['user'];
                            $plata->pentru = 'Adauga '.$objPmReq->params['suma'].' euro credit prin Credit Card.';
                            $plata->save();
                            break;
                        case 'confirmed_pending':
                            #cand action este confirmed_pending inseamna ca tranzactia este in curs de verificare antifrauda. Nu facem livrare/expediere. In urma trecerii de aceasta verificare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
                            //update DB, SET status = "pending"
                            $errorMessage = $objPmReq->objPmNotify->errorMessage;
                            $plata = new Pay();
                            $plata->id = $objPmReq->orderId;
                            $plata->suma = $objPmReq->params['suma'];
                            $plata->user = $objPmReq->params['user'];
                            $plata->pentru = 'Se asteapta confirmarea platii...';
                            $plata->save();
                            break;
                        case 'paid_pending':
                            #cand action este paid_pending inseamna ca tranzactia este in curs de verificare. Nu facem livrare/expediere. In urma trecerii de aceasta verificare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
                            //update DB, SET status = "pending"
                            $errorMessage = $objPmReq->objPmNotify->errorMessage;
                            $plata = Pay::where('id', $objPmReq->orderId)->first();
                            if (!isset($plata)) $plata = new Pay();
                            $plata->id = $objPmReq->orderId;
                            $plata->suma = $objPmReq->params['suma'];
                            $plata->user = $objPmReq->params['user'];
                            $plata->pentru = 'Se asteapta confirmarea platii...';
                            $plata->save();
                            break;
                        case 'paid':
                            #cand action este paid inseamna ca tranzactia este in curs de procesare. Nu facem livrare/expediere. In urma trecerii de aceasta procesare se va primi o noua notificare pentru o actiune de confirmare sau anulare.
                            //update DB, SET status = "open/preauthorized"
                            $errorMessage = $objPmReq->objPmNotify->errorMessage;
                            $plata = Pay::where('id', $objPmReq->orderId)->first();
                            if (!isset($plata)) $plata = new Pay();
                            $plata->id = $objPmReq->orderId;
                            $plata->suma = $objPmReq->params['suma'];
                            $plata->user = $objPmReq->params['user'];
                            $plata->pentru = 'Plata este in curs de procesare...';
                            $plata->save();
                            break;
                        case 'canceled':
                            #cand action este canceled inseamna ca tranzactia este anulata. Nu facem livrare/expediere.
                            //update DB, SET status = "canceled"
                            $plata = Pay::where('id', $objPmReq->orderId)->first();
                            if (isset($plata)) $plata->delete();
                            $errorMessage = $objPmReq->objPmNotify->errorMessage;
                            break;
                        case 'credit':
                            #cand action este credit inseamna ca banii sunt returnati posesorului de card. Daca s-a facut deja livrare, aceasta trebuie oprita sau facut un reverse.
                            //update DB, SET status = "refunded"
                            $errorMessage = $objPmReq->objPmNotify->errorMessage;
                            $plata = Pay::where('id', $objPmReq->orderId)->first();
                            $user = User::find($objPmReq->params['user']);
                            $plata->pentru = 'Tentativa de frauda! Pentru detalii deschideti un tichet.';
                            $plata->save();
                            $user->credit = $user->credit - $objPmReq->params['suma'];
                            $user->save();
                            break;
                        default:
                            $errorType		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
                            $errorCode 		= Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_ACTION;
                            $errorMessage 	= 'mobilpay_refference_action paramaters is invalid';
                            break;
                    }
                }
                else {
                    $errorMessage = $objPmReq->objPmNotify->errorMessage;
                }
            }
            catch(Exception $e)
            {
                $errorType 		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_TEMPORARY;
                $errorCode		= $e->getCode();
                $errorMessage 	= $e->getMessage();
            }
        }
        else
        {
            $errorType 		= Mobilpay_Payment_Request_Abstract::CONFIRM_ERROR_TYPE_PERMANENT;
            $errorCode		= Mobilpay_Payment_Request_Abstract::ERROR_CONFIRM_INVALID_POST_PARAMETERS;
            $errorMessage 	= 'mobilpay.ro posted invalid parameters';
        }
        $rezultat = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        if($errorCode == 0)
        {
            $rezultat .= "<crc>{$errorMessage}</crc>";
        }
        else
        {
            $rezultat .= "<crc error_type=\"{$errorType}\" error_code=\"{$errorCode}\">{$errorMessage}</crc>";
        }
        $response = Response::make($rezultat);

        $response->header('Content-Type', 'application/xml');

        return $response;
    }

    public static function genereaza($numar) {
        $characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $numar; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
    private function dontAllowXSS($values) {
        $g=true;
        if (is_array($values)) {
            foreach ($values as $value)
            {
                if (strpos($value, '"')!==false || strpos($value, "'")!==false || strpos($value, '>')!==false || strpos($value, '<')!==false || strpos($value, '/')!==false || strpos($value, '(')!==false || strpos($value, ')')!==false) {
                    $g=false;
                }
            }
        }
        else { if (strpos($values, '"')!==false || strpos($values, "'")!==false || strpos($values, '>')!==false || strpos($values, '<')!==false || strpos($values, '/')!==false || strpos($values, '(')!==false || strpos($values, ')')!==false) {
            $g=false;
        }
        }
        return $g;
    }
    public function RegisterMe() {
        if (Request::ajax()) {
            $values=Input::all();
            if (Request::ajax() && Core::dontAllowXSS($values))
            {
                $user = new User();
                $user->id=$this->genereaza(10);
                $confirm = $this->genereaza(50);
                $user->confirm_code = $confirm;
                $user->nume=$values['nume'];
                $user->secret_key = $this->genereaza(99);
                $user->password=Hash::make($values['parola']);
                $user->email=$values['email'];
                $rules = array(
                    'nume'=>'min:6|required|alpha_spaces',
                    'parola'=>'required|min:6',
                    'email'=>'required|email|unique:users,email',
                    'repetaparola'=>'required|same:parola');
                $validator = Validator::make($values, $rules);
                if ($validator->fails()) {
                    $mesaj = $validator->messages()->all();
                    return View::make('ajax.error')->with('mesaj', $mesaj[0]);
                }
                else {
                    $this->SendConfirmMessage($user->nume, $confirm, $user->email, 'mail.confirm', 'Bun venit pe eRapid.ro - Anunturi Gratuite pentru Galati si Braila');
                    $user->save();
                    return View::make('ajax.ok')->with('mesaj', 'Un email a fost trimis la adresa "'.$user->email.'" pentru confirmare.');
                }
            }
            else return View::make('ajax.error')->with('mesaj', 'Exista deja un cont inregistrat cu acest email !');
        }
        else { return Redirect::to('/'); }
    }
    public function getSecretKey() {
        $email = Input::get('email');
        $secret_key = User::where('email', $email)->pluck('secret_key');
        return Crypt::encrypt($secret_key);
    }
    public function LoginMe() {
        if (Request::ajax()) {
            $values=array('email'=>Input::get('email'), 'password'=>Input::get('parola'));
            $rules = array('email'=>'required', 'password'=>'required|min:6');
            $validator = Validator::make($values, $rules);
            $confirm=DB::table('users')->where('email', $values['email'])->pluck('confirm');
            if (Core::dontAllowXSS($values) && !$validator->fails()) {
                if ($confirm==1 && Auth::attempt($values))
                {
                    Auth::user()->secret_key = $this->genereaza(99);
                    Auth::user()->save();
                    return View::make('ajax.ok')->with('mesaj', 'Logare efectuata cu succes !');
                }
                else return View::make('ajax.error')->with('mesaj', 'Username sau parola gresit !');
            }
            else { return View::make('ajax.error')->with('mesaj', 'Email sau parola scris gresit !'); }
        }
        else { return Redirect::to('/'); }
    }
    public function AdaugaAnuntView()
    {
        Session::forget('imagini');
        $this->getVarForTemplate();
        return View::make('anunt.calladdanunt')->with('data', $this->data);
    }
    public function ShowCategorie($categorie)
    {
        $this->getVarForTemplate();
        $this->data['titlu'] = ucfirst(str_replace('-', ' ', $categorie)).' - ';
        $this->data['subcategorie']=Subcategorii::where('parent', str_replace('-', ' ', $categorie))->get();
        $this->data['categorie']=$categorie;
        $this->data['listaanunturi']=$this->ShowFirst($categorie, 1, 0);
        return View::make('categorie.categorie')->with('data', $this->data);
    }
    public function ShowSubcategorie($categorie, $subcategorie)
    {
        $this->getVarForTemplate();
        $this->data['titlu'] = ucfirst(str_replace('-', ' ', $subcategorie)).' - ';
        $this->data['subcategorie']=Subcategorii::where('parent', str_replace('-', ' ', $categorie))->get();
        $this->data['categorie']=$categorie;
        $this->data['listaanunturi']=$this->ShowFirst($subcategorie, 1, 1);
        return View::make('categorie.categorie')->with('data', $this->data);
    }
    public function GetCartOfTown() {
        if (Request::ajax()) {
            $oras=array('oras'=>Input::get('oras'));
            $oras = Core::removeXSS($oras);
            $cartiere = Cartiere::getCartiere($oras['oras']);
            $rezultat='';
            foreach ($cartiere as $cartier)
            {
                $rezultat .= '<li>'.$cartier->nume.'</li>';
            }
            return $rezultat;
        }
        else { return Redirect::to('/'); }
    }
    private function BrToNewLine($string, $reverse)
    {
        if (!$reverse) $string = str_ireplace('<br />', "\r\n", $string);
        else $string = str_ireplace("\r\n", '<br />', $string);
        return $string;
    }
    public function SendConfirmMessage($nume, $confirm, $email, $view, $subject) {
        $view_data=array('nume'=>$nume, 'link'=>$confirm);
        $email_data=array('to'=>$email, 'subject'=>$subject);
        Mail::send($view, $view_data, function($message) use ($email_data) {
            $message->from('oficial@erapid.ro', 'Echipa eRapid.ro');
            $message->subject($email_data['subject']);
            $message->to($email_data['to']);
            return 'Mesajul tau a fost inregistrat. Multumim ca folosesti eRapid.ro!';
        });
    }
    public function AdaugaAnunt() {
        if (Request::ajax()) {
            if (Session::has('anunt')) $data = Session::pull('anunt', 'default');
            else $data = Input::get('data');
            $data['anunt']=$this->BrToNewLine($data['anunt'], 0);
            $data = $this->changeXSS($data);
            $data['anunt']=$this->BrToNewLine($data['anunt'], 1);
            if ($data['email']=="undefined") $data['email']='default@erapid.ro';
            $rezultat=array('mesaj'=>'', 'titlu'=>'');
            $email = User::where('email', $data['email'])->first();
            if (Auth::check()) {
                $rules = array(
                    'titlu'=>'max:100|required',
                    'categorie'=>'exists:categoriis,nume|required',
                    'subcategorie'=>'exists:subcategoriis,nume|required',
                    'anunt'=>'max:1000|required',
                    'pret'=>'numeric|required',
                    'moneda'=>'boolean|required',
                    'negociabil'=>'boolean|required');
                if (Auth::user()->cartier!="" && $data['cartier']!="undefined") $rules['cartier']='exists:cartieres,nume';
                if (Auth::user()->oras!="" && $data['oras']!="undefined") $rules['oras']='exists:orases,nume';
                if (Auth::user()->telefon!="" && $data['telefon']!="undefined") $rules['telefon']='numeric';
                if (Auth::user()->persoana!="" && $data['persoana']!="undefined") $rules['persoana']='alpha_spaces|required';
                $validator = Validator::make($data, $rules);
                if (!$validator->fails() && ucfirst(Subcategorii::where('nume', $data['subcategorie'])->first()->parent)==$data['categorie']) {
                    if (!empty($data['cartier']) && $data['cartier']!="undefined") Auth::user()->cartier=$data['cartier'];
                    if (!empty($data['oras']) && $data['oras']!="undefined") Auth::user()->oras=$data['oras'];
                    if (!empty($data['persoana']) && $data['persoana']!="undefined") Auth::user()->persoana=$data['persoana'];
                    if (!empty($data['telefon']) && $data['telefon']!="undefined") Auth::user()->telefon=$data['telefon'];
                    if (!empty($data['skype']) && $data['skype']!="undefined") Auth::user()->skype=$data['skype'];
                    if (!empty($data['yahoo']) && $data['yahoo']!="undefined") Auth::user()->yahoo=$data['yahoo'];
                    Auth::user()->save();
                    $idanunt = $this->genereaza(10);
                    $anunt = new Anunt();
                    $anunt->id = $idanunt;
                    $anunt->titlu = $data['titlu'];
                    $anunt->categorie = $data['categorie'];
                    $anunt->subcategorie = $data['subcategorie'];
                    $anunt->continut = $data['anunt'];
                    $anunt->pret = $data['pret'];
                    $anunt->moneda = $data['moneda'];
                    $anunt->negociabil = $data['negociabil'];
                    $anunt->confirm = 1;
                    $anunt->confirm_code = $this->genereaza(20);
                    $anunt->user = Auth::user()->id;
                    $anunt->expired_at = Carbon::today()->addWeeks(4);
                    $first = true;
                    if (Session::has('imagini'))
                    {
                        $imagini = Session::get('imagini');
                        foreach ($imagini as $imagine)
                        {
                            if (file_exists(public_path($imagine))) {
                                $session = $this->CreateImg(public_path($imagine));
                                $img = new Imagine();
                                $img->id = $session['big'];
                                $img->link_big = $session['big'];
                                $img->link_mini = $session['mini'];
                                $img->orientare = $session['orientare'];
                                $img->user = Auth::user()->id;
                                $img->anunt = $idanunt;
                                if ($first===true) { $img->first = 1; $first = false; }
                                $img->save();
                            }
                        }
                    }
                    $anunt->save();
                    Session::forget('imagini');
                    $rezultat['titlu']='Felicitari ! Anuntul tau a fost trimis cu succes !';
                    $rezultat['mesaj']='Anuntul tau v-a fi verificat de un moderator si daca respecta Termenii si Conditiile noastre, va fi publicat pe website. Acest proces poate dura intre 5 minute si 1 ora.  <br /> Multumim !';
                    return View::make('anunt.afteraddmesaj')->with('mesaj', $rezultat);
                }
                else { $messages = $validator->messages(); foreach ($messages->all() as $message) { $rezultat['mesaj'].='<br />'.$message; } $rezultat['titlu']='Oops ! Ceva nu a mers bine !'; return View::make('anunt.afteraddmesaj')->with('mesaj', $rezultat); }
            }
            else if (isset($email) && $email->password != "") {
                Session::put('anunt', $data);
                $rezultat['titlu']='Email utilizat de altcineva !';
                $rezultat['mesaj'] = 'Acest email apartine deja unui utilizator. Daca tu esti acela te rugam sa iti scri parola<br /> <input class="reqpass" type="password" /><div class="reqpasstrim">Trimite</div>';
                return View::make('anunt.afteraddmesaj')->with('mesaj', $rezultat);
            }
            else {
                $rules = array(
                    'email' =>'unique:users,email|email|required',
                    'titlu'=>'max:100|required',
                    'categorie'=>'exists:categoriis,nume|required',
                    'subcategorie'=>'exists:subcategoriis,nume|required',
                    'cartier'=>'exists:cartieres,nume|required',
                    'oras'=>'exists:orases,nume|required',
                    'anunt'=>'max:1000|required',
                    'pret'=>'numeric|required',
                    'moneda'=>'boolean|required',
                    'negociabil'=>'boolean|required',
                    'nume'=>'min:6|alpha_spaces|required',
                    'persoana'=>'alpha_spaces|required',
                    'showemail'=>'boolean|required',
                    'telefon'=>'numeric');
                $validator = Validator::make($data, $rules);
                if (!$validator->fails() && ucfirst(Subcategorii::where('nume', $data['subcategorie'])->first()->parent)==$data['categorie']) {
                    $id=$this->genereaza(10);
                    $idanunt=$this->genereaza(10);
                    $confirm=$this->genereaza(50);
                    $user = new User();
                    $user->email=$data['email'];
                    $user->id=$id;
                    $user->cartier=$data['cartier'];
                    $user->oras=$data['oras'];
                    $user->telefon=$data['telefon'];
                    $user->skype=$data['skype'];
                    $user->yahoo=$data['yahoo'];
                    $user->nume=$data['nume'];
                    $user->persoana=$data['persoana'];
                    $user->showemail=$data['showemail'];
                    $user->confirm_code=$confirm;
                    $user->save();
                    $anunt = new Anunt();
                    $anunt->id = $idanunt;
                    $anunt->titlu = $data['titlu'];
                    $anunt->categorie = $data['categorie'];
                    $anunt->subcategorie = $data['subcategorie'];
                    $anunt->continut = $data['anunt'];
                    $anunt->pret = $data['pret'];
                    $anunt->moneda = $data['moneda'];
                    $anunt->negociabil = $data['negociabil'];
                    $anunt->confirm = 1;
                    $anunt->confirm_code = $this->genereaza(20);
                    $anunt->user = $id;
                    $anunt->expired_at = Carbon::today()->addWeekdays(4);
                    $first = true;
                    if (Session::has('imagini'))
                    {
                        $imagini = Session::get('imagini');
                        foreach ($imagini as $imagine)
                        {
                            if (file_exists(public_path($imagine))) {
                                $session = $this->CreateImg(public_path($imagine));
                                $img = new Imagine();
                                $img->id = $session['big'];
                                $img->link_big = $session['big'];
                                $img->link_mini = $session['mini'];
                                $img->orientare = $session['orientare'];
                                $img->user = $id;
                                $img->anunt = $idanunt;
                                if ($first===true) { $img->first = 1; $first = false; }
                                $img->save();
                            }
                        }
                    }
                    $anunt->save();
                    Session::forget('imagini');
                    $this->SendConfirmMessage($data['nume'], $confirm, $data['email'], 'mail.welcome', 'Bun venit pe eRapid.ro - Anunturi gratuite pentru Galati si Braila');
                    $rezultat['titlu']='Felicitari ! Anuntul tau a fost trimis cu succes !';
                    $rezultat['mesaj']='Pentru ca e primul tau anunt, vei primi un email de confirmare in cel mai scurt timp. Urmeaza instructiunile din email pentru a finaliza procesul de postare a anuntului. <br /> Cu respect, Echipa eRapid.ro';
                    return View::make('anunt.afteraddmesaj')->with('mesaj', $rezultat);
                }
                else { $messages = $validator->messages(); foreach ($messages->all() as $message) { $rezultat['mesaj'].='<br />'.$message; } $rezultat['titlu']='Oops ! Ceva nu a mers bine !'; return View::make('anunt.afteraddmesaj')->with('mesaj', $rezultat); }
            }
            return View::make('anunt.afteraddmesaj')->with('mesaj', $rezultat);
        }
        else { return Redirect::to('/'); }
    }
    public function AddAnuntWithLogin() {
        $password = Input::get('password');
        $data = Session::get('anunt');
        if (Hash::check($password, User::where('email', $data['email'])->pluck('password'))) {
            Auth::loginUsingId(User::where('email', $data['email'])->pluck('id'));
            return $this->AdaugaAnunt();
        }
        else {
            $rezultat['titlu']='Parola nu este corecta !';
            $rezultat['mesaj'] = 'Acest email apartine deja unui utilizator. Daca tu esti acela te rugam sa iti scri parola<br /> <input class="reqpass" type="password" /><div class="reqpasstrim">Trimite</div>';
            return View::make('anunt.afteraddmesaj')->with('mesaj', $rezultat);
        }

    }
    public function ConfirmUser($confirm_code) {
        if ($confirm_code!="") {
            $id = DB::table('users')->where('confirm_code', '=', $confirm_code)->pluck('id');
            if (isset($id)) {
                Auth::loginUsingId($id);
                $this->getVarForTemplate();
                return View::make('anunt.callconfirm')->with('data', $this->data);
            }
            else return Redirect::to('/');
        }
        else { return Redirect::to('/'); }
    }
    public function ConfirmUserWithoutSetPassword($confirm_code) {
        if ($confirm_code!="") {
            $id = DB::table('users')->where('confirm_code', '=', $confirm_code)->pluck('id');
            if (isset($id)) {
                Auth::loginUsingId($id);
                $this->getVarForTemplate();
                return View::make('anunt.callconfirmwithout')->with('data', $this->data);
            }
            else return Redirect::to('/');
        }
        else { return Redirect::to('/'); }
    }
    public function SeteazaParola() {
        if (Request::ajax()) {
            $values = Input::get('setparola');
            $rules = array('parola'=>'required|min:6', 'repetaparola'=>'required|same:parola');
            $validator = Validator::make($values, $rules);
            if (!$validator->fails())
                Auth::user()->password = Hash::make($values['parola']);
            Auth::user()->confirm = 1;
            Auth::user()->confirm_code=$this->genereaza(40);
            Auth::user()->save();
            return 'Acum totul e gata ! Poti incepe sa administrezi si sa adaugi anunturi mult mai rapid din acest cont!';
        }
        else { return Redirect::to('/'); }
    }
    public function ResetForm()
    {
        if (Request::ajax())
        {
            return View::make('ajax.forgot');
        }
        else Redirect::to('/');
    }
    public function SendResetToken() {
        $values=Input::all();
        if (Request::ajax() && $this->dontAllowXSS($values)) {
            $rules=array('email'=>'exists:users,email|email');
            $validator = Validator::make($values, $rules);
            if (!$validator->fails())
            {
                $confirm_code=DB::table('users')->where('email', $values['email'])->pluck('confirm_code');
                $this->SendConfirmMessage('', $confirm_code, $values['email'], 'mail.reset', 'Cerere de resetare a parolei pe eRapid.ro - Anunturi Gratuite pentru Galati si Braila');
                return View::make('ajax.ok')->with('mesaj', 'Vei primi un email in cel mai scurt timp posibil !');
            }
            else return View::make('ajax.error')->with('mesaj', 'Email-ul nu exista in baza de date!');
        }
        else Redirect::to('/');
    }
    public function ReseteazaParola($confirm_code) {
        if ($confirm_code!="") {
            $id = DB::table('users')->where('confirm_code', '=', $confirm_code)->pluck('id');
            if (isset($id)) {
                Auth::loginUsingId($id);
                $this->getVarForTemplate();
                return View::make('anunt.callresetpass')->with('data', $this->data);
            }
            else return Redirect::to('/');
        }
        else { return Redirect::to('/'); }
    }
    private function ShowFirst($categorie, $pagina, $path) {
        $values = array('categorie'=>$categorie, 'pagina'=>$pagina, 'path'=>$path);
        if ($values['path']==0) $rules = array('categorie'=>'exists:categoriis,codunic', 'pagina'=>'numeric');
        else $rules = array('categorie'=>'exists:subcategoriis,codunic', 'pagina'=>'numeric');
        $validator = Validator::make($values, $rules);
        if (!$validator->fails()) {
            Paginator::setCurrentPage($values['pagina']);
            $categorie='';
            if ($values['path']==0) {
                $categorie = Categorii::where('codunic', '=', $values['categorie'])->pluck('nume');
                $anunturi = Anunt::where('categorie', '=', $categorie)->where('confirm', '=', '1');
                $promo = Anunt::where('categorie', '=', $categorie)->where('confirm', '=', '1');
            }
            else if ($values['path']==1) {
                $categorie = Subcategorii::where('codunic', '=', $values['categorie'])->pluck('nume');
                $anunturi = Anunt::where('subcategorie', '=', $categorie)->where('confirm', '=', '1');
                $promo = Anunt::where('subcategorie', '=', $categorie)->where('confirm', '=', '1');
            }
            $anunturi = $anunturi->orderBy('created_at', 'desc')->paginate(10);
            $promo = $promo->where('promovat', '1')->orderByRaw('RAND()')->take(3)->get();
            $data['anunturi'] = $this->AdsCompliment($anunturi);
            $data['promo'] = $this->AdsCompliment($promo);
            if ($values['pagina']==1) $data['first']=0;
            else $data['first']=1;
            return View::make('ajax.anunt')->with('anunturi', $data);
        }
    }
    public function ShowFirstAds() {
        if (Request::ajax()) {
            $values = array('categorie'=>Input::get('categorie'), 'pagina'=>Input::get('pagina'), 'path'=>Input::get('path'));
            if ($values['path']==0) $rules = array('categorie'=>'exists:categoriis,codunic', 'pagina'=>'numeric');
            else $rules = array('categorie'=>'exists:subcategoriis,codunic', 'pagina'=>'numeric');
            $validator = Validator::make($values, $rules);
            if (!$validator->fails()) {
                Paginator::setCurrentPage($values['pagina']);
                $categorie='';
                if ($values['path']==0) {
                    $categorie = Categorii::where('codunic', '=', $values['categorie'])->pluck('nume');
                    $anunturi = Anunt::where('categorie', '=', $categorie)->where('confirm', '=', '1');
                    $promo = Anunt::where('categorie', '=', $categorie)->where('confirm', '=', '1');
                }
                else if ($values['path']==1) {
                    $categorie = Subcategorii::where('codunic', '=', $values['categorie'])->pluck('nume');
                    $anunturi = Anunt::where('subcategorie', '=', $categorie)->where('confirm', '=', '1');
                    $promo = Anunt::where('subcategorie', '=', $categorie)->where('confirm', '=', '1');
                }
                $anunturi = $anunturi->orderBy('created_at', 'desc')->paginate(10);
                $promo = $promo->where('promovat', '1')->orderByRaw('RAND()')->take(3)->get();
                $data['anunturi'] = $this->AdsCompliment($anunturi);
                $data['promo'] = $this->AdsCompliment($promo);
                if ($values['pagina']==1) $data['first']=0;
                else $data['first']=1;
                return View::make('ajax.anunt')->with('anunturi', $data);
            }
        }
        else Redirect::to('/');
    }
    public function AjutorPage() {
        $this->getVarForTemplate();
        return View::make('page.callajutor')->with('data', $this->data);
    }
    public function ContactPage() {
        $this->getVarForTemplate();
        return View::make('page.callcontact')->with('data', $this->data);
    }
    public function TermeniSiConditiiPage() {
        $this->getVarForTemplate();
        return View::make('page.calltermeni')->with('data', $this->data);
    }
    public function trimiteContact() {
        $data = Input::get('data');
        if ($data['capcha']==Session::pull('capcha')) {
            $rules = array('subiect'=>'required', 'mesaj'=>'required', 'email'=>'required|email');
            $validator = Validator::make($data, $rules);
            if (!$validator->fails()) {
                $this->SendConfirmMessage($data['mesaj'], '', $data['email'], 'mail.contact', 'Tichet inregistrat.');
                $this->SendConfirmMessage($data, '', 'suport@erapid.ro', 'mail.mycontact', $data['subiect']);
                return 'Mesajul tau a fost inregistrat. Multumim ca folosesti eRapid.ro!';
            }
            else {
                $mesaj = $validator->messages()->all();
                return $mesaj[0];
            }
        }
        else return 'Codul capcha nu este corect!';
    }
    public function ShowAnunt($anunt_code){
        $this->getVarForTemplate();
        $code_array=explode('-', $anunt_code);
        $code = end($code_array);
        $anunt = Anunt::find($code);
        $this->data['titlu'] = $anunt['titlu'].' - ';
        $this->data['descriere'] = $anunt['continut'];
        if (isset($anunt) && ($anunt->confirm==1 || (Auth::check() && Auth::user()->admin==1))) {
            $today = date('20y-m-d');
            $yesterday = date('20y-m-d', strtotime( '-1 days' ));
            $date = new DateTime($anunt['created_at']);
            if ($date->format('20y-m-d')==$today) $alias="Azi";
            else if ($date->format('20y-m-d')==$yesterday) $alias="Ieri";
            else $alias = $today;
            $anunt['alias']=$alias;
            $anunt['ora']=$date->format('H:i:s');
            $anunt->increment('vizualizari');
            $this->data['anunt'] = $anunt;
            $this->data['user'] = User::find($anunt['user']);
            $this->data['galerie'] = Imagine::where('anunt', '=', $anunt['id'])->get();
            if (count($this->data['galerie'])>0) $this->data['img']= $this->data['galerie'][0]['link_big'];
            $this->data['nr'] = 0;
            $this->data['anunt_recomand'] = Anunt::where('categorie', $anunt->categorie)->where('id', '!=', $anunt->id)->where('confirm', 1)->orderByRaw('RAND()')->take(4)->get();

            return View::make('showanunt.callshowanunt')->with('data', $this->data);
        }
        else return Redirect::to('/');
    }
    public function LoginFacebook() {
        if (Request::ajax() && !Auth::check()) {
            $data = Input::get('data');
            $secret = Input::get('secret_key');
            $user = User::where('email', $data['email'])->first();
            if (isset($user) && Crypt::decrypt($secret)==$user->secret_key) {
                $user->secret_key = $this->genereaza(99);
                $user->save();
                Auth::loginUsingId($user->id);
            }
            else {
                $user = new User();
                $id = $this->genereaza(20);
                $user->id = $id;
                $user->secret_key = $this->genereaza(99);
                $user->email = $data['email'];
                $user->nume = $data['name'];
                $user->persoana = "Persoana Fizica";
                $user->confirm = 1;
                $user->save();
                Auth::loginUsingId($id);
            }
        }
    }
    public function ModificaAnuntWithoutSave($anunt) {
        $modanunt = ModAnunt::find($anunt->id);
        if (isset($modanunt) && Auth::check() && Auth::user()->admin==1) {
            $anunt->titlu= $modanunt->titlu;
            $anunt->categorie = $modanunt->categorie;
            $anunt->subcategorie = $modanunt->subcategorie;
            $anunt->continut = $modanunt->continut;
            $anunt->pret = $modanunt->pret;
            $anunt->negociabil = $modanunt->negociabil;
            $anunt->modificare = 1;
            return $anunt;
        }
    }
    public function ShowModAnunt($anunt_code){
        $this->getVarForTemplate();
        $code_array=explode('-', $anunt_code);
        $code = end($code_array);
        $anunt = Anunt::find($code);
        if (isset($anunt) && ($anunt->confirm==1 || (Auth::check() && Auth::user()->admin==1))) {
            $today = date('20y-m-d');
            $yesterday = date('20y-m-d', strtotime( '-1 days' ));
            $date = new DateTime($anunt['created_at']);
            if ($date->format('20y-m-d')==$today) $alias="Azi";
            else if ($date->format('20y-m-d')==$yesterday) $alias="Ieri";
            else $alias = $today;
            $anunt['alias']=$alias;
            $anunt['ora']=$date->format('H:i:s');
            $this->data['anunt'] = $this->ModificaAnuntWithoutSave($anunt);
            $this->data['user'] = User::find($anunt['user']);
            $this->data['galerie'] = Imagine::where('anunt', '=', $anunt['id'])->get();
            return View::make('showanunt.callshowanunt')->with('data', $this->data);
        }
        else return Redirect::to('/');
    }
    private function StabilesteTermeniCautare($data)
    {
        $anunturi = Anunt::where('anunts.confirm', '=', '1')->where('titlu', 'LIKE', '%'.$data['keyword'].'%');
        $anunturi->select('anunts.*')->join('users', 'anunts.user', '=', 'users.id');
        if ($data['categorie'] && $data['isCat']==1) $anunturi->where('categorie', $data['categorie']);
        else if ($data['categorie'] && $data['isCat']==0) $anunturi->where('subcategorie', $data['categorie']);
        if ($data['cartier']) $anunturi->where('users.cartier', '=', $data['cartier']);
        if ($data['oras']) $anunturi->where('users.oras', '=', $data['oras']);
        if ($data['pretdela']) $anunturi->where('pret', '>', $data['pretdela']);
        if ($data['pretpanala']) $anunturi->where('pret', '<', $data['pretpanala']);
        return $anunturi;
    }
    public function CautaFirst() {
        if (Request::ajax()) {
            $data = Input::get('data');
            $data = $this->changeXSS($data);
            $rules = array('pagina'=>'numeric',
                'pretdela'=>'numeric',
                'pretpanala'=>'numeric');
            if ($data['categorie'] && $data['isCat']==1) { $rules['categorie']='exists:categoriis,nume'; }
            else if ($data['categorie'] && $data['isCat']==0) { $rules['categorie']='exists:subcategoriis,nume'; }
            if ($data['cartier']) { $rules['cartier']='exists:cartieres,nume'; }
            if ($data['oras']) { $rules['oras']='exists:orases,nume'; }
            $validator = Validator::make($data, $rules);
            $anunturi=array('anunturi'=>array(), 'promo'=>array());
            if (!$validator->fails()) {
                $anunturi = $this->StabilesteTermeniCautare($data);
                $promo = $this->StabilesteTermeniCautare($data);
                Paginator::setCurrentPage($data['pagina']);
                $ads['anunturi'] = $anunturi->orderBy('created_at', 'desc')->paginate(10);
                $ads['promo'] = $promo->where('promovat', '1')->orderByRaw('RAND()')->take(3)->get();
                $ads['anunturi'] = $this->AdsCompliment($ads['anunturi']);
                $ads['promo'] = $this->AdsCompliment($ads['promo']);
                if ($data['pagina']==1) $ads['first']=0;
                else $ads['first']=1;
                if ($data['pagina']==1) return View::make('ajax.cauta')->with('anunturi', $ads);
                else return View::make('ajax.anunt')->with('anunturi', $ads);
            }
            else return View::make('ajax.cauta')->with('anunturi', $anunturi);
        }
    }
    public function CreateImg($path) {
        $destinationPath = public_path('anunturi/');
        $filename = str_random(40).".jpg";
        $img = Image::make($path);
        if ($img->height()>$img->width()) {
            $img->resize(430, 600);
            $img->insert($destinationPath.'logo.png');
            $img->save($destinationPath.$filename);
            $img->resize(60, 100);
            $img->save($destinationPath.'mini_'.$filename);
            $session = array('orientare'=>'1', 'mini'=>'/public/anunturi/'.'mini_'.$filename, 'big'=>'/public/anunturi/'.$filename);
            return $session;
        }
        else {
            $img->resize(650, 380);
            $img->insert($destinationPath.'logo.png');
            $img->save($destinationPath.$filename);
            $img->resize(120, 80);
            $img->save($destinationPath.'mini_'.$filename);
            $session = array('orientare'=>'0', 'mini'=>'/public/anunturi/'.'mini_'.$filename, 'big'=>'/public/anunturi/'.$filename);
            return $session;
        }
    }
    public function CreateThumbTemporary($path, $location, $nume) {
        $img = Image::make($path);
        if ($img->height()>$img->width()) {
            $img->resize(60, 100);
            $img->response();
            $img->save($location);
            return '/tmp/'.$nume;
        }
        else {
            $img->resize(120, 80);
            $img->response();
            $img->save($location);
            return '/tmp/'.$nume;
        }
    }
    public function UploadImg() {
        if (Input::hasFile('img1')) {
            $imagini = array('img1'=>Input::file('img1'));
            $rules = array('img1'=>'image');
            $validator = Validator::make($imagini, $rules);
            if (!$validator->fails()) {
                $imagine = array_shift($imagini);
                if ($imagine->isValid()) {
                    $destinationPath = public_path('tmp/');
                    $filename = str_random(40).".jpg";
                    $path = $imagine->getRealPath();
                    $img = Image::make($path);
                    $img->save(public_path('tmp/'.$filename));
                    Session::push('imagini', 'tmp/'.$filename);
                    return $this->CreateThumbTemporary($path, $destinationPath.'thumb_'.$filename, 'thumb_'.$filename);
                }
                else return 2;
            }
            else return 3;
        }
        else return 4;
    }
    public function Blank() {}
    public function DeleteImg() {
        if (Session::has('imagini'))
        {
            $imagini = Session::get('imagini');
            $img = Input::get('img');
            $img = str_replace('thumb_', '', substr($img, 1));
            foreach ($imagini as $imagine)
            {
                if ($imagine==$img)
                    unlink(public_path($imagine));
            }
        }
        return $img;
    }
    public function DeleteImgFromDB() {
        $img = Input::get('img');
        $img = str_replace('mini_', '', $img);
        $imag = Imagine::find($img);
        if (isset($imag)) $imag->delete();
    }
    public function ExtrageImg() {
        $id = Input::get('link');
        $imagine = Imagine::where('anunt', '=', $id)->select('link_big', 'orientare')->get();
        if (isset($imagine)) {
            $i=0;
            foreach ($imagine as $img) {
                $rezultat[$i++] = array('img'=>$img->link_big, 'orientare'=>$img->orientare);
            }
            $rezultat['fir'] = Input::get('first');
            $rezultat['length'] = $i;
            return json_encode($rezultat);
        }
    }
    public function ExtrageInfo() {
        $rules = array('type'=>'alpha', 'code'=>'alpha_num');
        $values = array('type'=>Input::get('type'), 'code'=>Input::get('code'));
        $validator = Validator::make($values, $rules);
        if (!$validator->fails()) {
            $telefon = User::find(Anunt::find($values['code'])->user)->$values['type'];
            return $telefon;
        }
    }
    public function TrimiteMesaj() {
        if (Cookie::get('mesajWait')!='1') {
            $values = Input::get('data');
            $values['mesaj']=$this->BrToNewLine($values['mesaj'], 0);
            $values = $this->changeXSS($values);
            $values['mesaj']=$this->BrToNewLine($values['mesaj'], 1);
            $rules = array('telefon'=>'numeric', 'mesaj'=>'required', 'code'=>'alpha_num|exists:anunts,id', 'nume'=>'alpha_spaces');
            if ($values['email']!="") $rules['email']='email';
            if ($values['telefon']!="") $rules['telefon']='numeric';
            $validator = Validator::make($values, $rules);
            if (!$validator->fails()) {
                $mesaj = new Mesaj();
                $mesaj->id = $this->genereaza(30);
                $mesaj->anunt = $values['code'];
                $mesaj->mesaj = $values['mesaj'];
                $mesaj->stare = 1;
                if (Auth::check())  { $mesaj->user = Auth::user()->id; $mesaj->telefon = Auth::user()->telefon; $mesaj->email = Auth::user()->email; $mesaj->nume= Auth::user()->nume; }
                else { $mesaj->telefon = $values['telefon']; $mesaj->email = $values['email']; $mesaj->nume = $values['nume']; }
                $user_id = Anunt::find($values['code'])->user;
                $mesaj->user2 = User::find($user_id)->id;
                Cookie::queue('mesajWait', '1', 5);
                $mesaj->save();
                return 'Mesaj trimis cu succes !';
            }
            else {
                $rezultat='';
                $messages = $validator->messages(); foreach ($messages->all() as $message) $rezultat.='<br />'.$message;
                return $rezultat; }
        }
        else return 'Nu poti trimite mesaje intr-un interval atat de scurt !';
    }
    public function MyAccount($tab) {
        if (Auth::check()) {
            $this->getVarForTemplate();
            $this->data['tab']=$tab;
            $this->data['nrads']=Anunt::where('user', '=', Auth::user()->id)->count();
            $this->data['nrmsg']=Mesaj::where('user2', '=', Auth::user()->id)->orWhere('user', '=', Auth::user()->id)->count();
            $this->data['usermsg']=Mesaj::where('user2', '=', Auth::user()->id)->orWhere('user', '=', Auth::user()->id)->get();
            $this->data['userads']=Anunt::where('user', '=', Auth::user()->id)->where('confirm', '1')->get();
            return View::make('cont.callcont')->with('data', $this->data);
        }
        else return Redirect::to('/');
    }
    public function GetMyAdsActive() {
        if (Request::ajax()) {
            $anunturi = Anunt::where('user', Auth::user()->id)->where('confirm', '1')->orderBy('created_at', 'desc')->get();
            $anunturi = $this->AdsCompliment($anunturi);
            return View::make('ajax.sample-anunt')->with('anunturi', $anunturi);
        }
    }
    public function GetMyAdsInactive() {
        if (Request::ajax()) {
            $anunturi = Anunt::where('user', Auth::user()->id)->where('confirm', '0')->orderBy('created_at', 'desc')->get();
            $anunturi = $this->AdsCompliment($anunturi);
            $anunturi['work']=1;
            return View::make('ajax.sample-anunt')->with('anunturi', $anunturi);
        }
    }
    public function SearchInMyAds() {
        if (Request::ajax()) {
            $value = $this->changeXSS(Input::get('data'));
            $anunturi = Anunt::where('user', '=', Auth::user()->id)->where('confirm', '1')->where('titlu', 'LIKE', '%'.$value.'%')->get();
            $anunturi = $this->AdsCompliment($anunturi);
            return View::make('ajax.sample-anunt')->with('anunturi', $anunturi);
        }
    }
    public function getMesajeNew() {
        if (Request::ajax()) {
            $mesaje = Mesaj::where('user2', Auth::user()->id)->where('stare', '=', '1')->get();
            foreach ($mesaje as $mesaj) { if ($mesaj->vazut==0) { $mesaj->vazut = 1; $mesaj->save(); } $mesaj['anunt']=Anunt::where('id', $mesaj['anunt'])->first(); }
            $datas['mesaje']=$mesaje;
            $datas['locatie']='New';
            return View::make('ajax.mesaj')->with('datas', $datas);
        }
    }
    public function RaspundeMesaj() {
        $mesaj = Input::get('mesaj');
        $id = Input::get('id');
        $mesajex = Mesaj::find($id);
        $user = User::find($mesajex->user);
        if (isset($user)) {
            $message = new Mesaj();
            $message->id = $this->genereaza(30);
            $message->mesaj = $mesaj;
            $message->nume = Auth::user()->nume;
            $message->telefon = Auth::user()->telefon;
            $message->email = Auth::user()->email;
            $message->anunt = $mesajex->anunt;
            $message->user = Auth::user()->id;
            $message->user2 = $mesajex->user;
            $message->save();
        }
        else {
            $anunt = Anunt::find($mesajex->anunt);
            $confirm['link'] = '/anunt/'.preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $anunt->titlu)).'-'.$anunt->id;
            $confirm['nume'] = $anunt->titlu;
            $this->SendConfirmMessage($mesajex->nume, $confirm, $mesajex->email, 'mail.NotificareRaspMesaj', 'Mesaj nou pe eRapid.ro');
        }
    }
    public function getMesajeSterse() {
        if (Request::ajax()) {
            $mesaje = Mesaj::where('user2', Auth::user()->id)->where('stare', '=', '0')->get();
            foreach ($mesaje as $mesaj) { $mesaj['anunt']=Anunt::where('id', $mesaj['anunt'])->first(); }
            $datas['mesaje']=$mesaje;
            $datas['locatie']='Sterse';
            return View::make('ajax.mesaj')->with('datas', $datas);
        }
    }
    public function getMesajeTrimise() {
        if (Request::ajax()) {
            $mesaje = Mesaj::where('user', Auth::user()->id)->get();
            foreach ($mesaje as $mesaj) { $mesaj['anunt']=Anunt::where('id', $mesaj['anunt'])->first(); }
            $datas['mesaje']=$mesaje;
            $datas['locatie']='Trimise';
            return View::make('ajax.mesaj')->with('datas', $datas);
        }
    }
    public function MesajDeletePreventiv() {
        if (Request::ajax()) {
            $mesaj = Mesaj::find(Input::get('id'));
            if (($mesaj->user==Auth::user()->id || $mesaj->user2==Auth::user()->id) && $mesaj->stare==1) {
                $mesaj->stare = 0;
                $mesaj->save();
                return 1;
            }
            else if (($mesaj->user==Auth::user()->id || $mesaj->user2==Auth::user()->id) && $mesaj->stare==0) { $mesaj->delete(); return 2; }
        }
    }
    public function MesajRepune() {
        if (Request::ajax()) {
            $mesaj = Mesaj::find(Input::get('id'));
            if ($mesaj->user2==Auth::user()->id) {
                $mesaj->stare = 1;
                $mesaj->save();
            }
            return 1;
        }
    }
    public function saveAds() {
        if (Request::ajax()) {
            $code = Input::get('anunt');
            $saveads = Savead::where('anunt', $code)->where('user', Auth::user()->id)->count();
            if ($saveads==0) {
                $save = new Savead();
                $save->id = $this->genereaza(39);
                $save->anunt = $code;
                $save->user = Auth::user()->id;
                $save->save();
                return 1;
            }
        }
    }
    public function getAddTicketForm() {
        if (Request::ajax()) {
            return View::make('ajax.ticketadd');
        }
    }
    public function Capcha() {
        $capcha = Image::make(public_path().'/img/capcha.png');
        $text = $this->genereaza(7);
        $capcha->text($text, 20, 20, function($font) {
            $font->file(public_path('font/opensans.ttf'));
            $font->size(13);
            $font->color('#fff');
        });
        Session::put('capcha', $text);
        $img = $capcha->response();
        $capcha->destroy();
        return $img;
    }
    public function trimiteTicket() {
        if (Cookie::get('ticketWait')!='1') {
            $data = Input::get('data');
            $data = $this->changeXSS($data);
            $data['mesaj']=$this->BrToNewLine($data['mesaj'], 0);
            $data = $this->changeXSS($data);
            $data['mesaj']=$this->BrToNewLine($data['mesaj'], 1);
            $capcha = Session::get('capcha');
            if ($data['capcha']==$capcha) {
                $ticket = new Ticket();
                $ticket->id=$this->genereaza(10);
                $ticket->user=Auth::user()->id;
                $ticket->subiect=$data['subiect'];
                $ticket->mesaj=$data['mesaj'];
                $ticket->save();
                Cookie::queue('ticketWait', '1', 5);
                return 1;
            }
            else { return 2; }
        }
    }
    public function getTickete() {
        if (Request::ajax()) {
            if (Auth::check()) {
                $tickete = Ticket::where('user', Auth::user()->id)->get();
                foreach ($tickete as $ticket)
                {
                    $ticket['user']=User::where('id', $ticket['user'])->first();
                }
                return View::make('ajax.ticket')->with('tickete', $tickete);
            }
        }
    }
    public function openTicket() {
        if (Request::ajax()) {
            $code = array('code'=>Input::get('code'));
            $rules = array('code'=>'alpha_num');
            $validator = Validator::make($code, $rules);
            if (!$validator->fails()) {
                $ticket = Ticket::where('id', $code['code'])->first();
                $replys = Reply::where('ticket', $code['code'])->get();
                $last = Reply::where('ticket', $code)->orderBy('created_at', 'desc')->first();
                if (isset($last['send']) && $last['send']==1 && ($ticket['stare']==1 || $ticket['stare']==0)) $work = '';
                else $work = 'inactiv';
                $data=array('ticket'=>$ticket, 'replys'=>$replys, 'work'=>$work);
                Session::put('openticket', $code['code']);
                return View::make('ajax.viewticket')->with('data', $data);
            }
        }
    }
    public function replyTicket() {
        if (Request::ajax()) {
            $data['mesaj']=Input::get('mesaj');
            $data['mesaj']=$this->BrToNewLine($data['mesaj'], 0);
            $data = $this->changeXSS($data);
            $data['mesaj']=$this->BrToNewLine($data['mesaj'], 1);
            $code = Session::get('openticket');
            if (isset($code)) {
                $last = Reply::where('ticket', $code)->orderBy('created_at', 'desc')->first();
                $ticket = Ticket::where('id', $code)->first();
                if (isset($last['send']) && $last['send']==1 && ($ticket['stare']==1 || $ticket['stare']==0)) {
                    $reply = new Reply();
                    $reply->ticket=$code;
                    $reply->mesaj=$data['mesaj'];
                    $reply->send=0;
                    $reply->save();
                    $replys = Reply::where('ticket', $code)->get();
                    $data=array('ticket'=>$ticket, 'replys'=>$replys, 'work'=>'inactiv');
                    return View::make('ajax.viewticket')->with('data', $data);
                }
                else {
                    $ticket = Ticket::where('id', $code)->first();
                    $replys = Reply::where('ticket', $code)->get();
                    $data=array('ticket'=>$ticket, 'replys'=>$replys, 'work'=>'inactiv');
                    return View::make('ajax.viewticket')->with('data', $data);
                }
            }
        }
    }
    public function deleteTicket() {
        if (Request::ajax()) {
            $code = Input::get('ticket');
            $ticket = Ticket::where('id', $code)->first();
            if ($ticket->user==Auth::user()->id) {
                $ticket->delete();
            }
        }
    }
    public function getTicketMesajMod() {
        $code = Input::get('ticket');
        $ticket = Ticket::where('id', $code)->first();
        if ($ticket->user==Auth::user()->id) {
            return View::make('ajax.modticket')->with('ticket', $ticket);
        }
    }
    public function modificaTicket() {
        if (Request::ajax()) {
            $data = Input::get('data');
            $data['mesaj']=$this->BrToNewLine($data['mesaj'], 0);
            $data = $this->changeXSS($data);
            $data['mesaj']=$this->BrToNewLine($data['mesaj'], 1);
            $ticket = Ticket::where('id', $data['code'])->first();
            if ($ticket->user==Auth::user()->id) {
                $ticket->subiect = $data['subiect'];
                $ticket->mesaj= $data['mesaj'];
                $ticket->save();
            }
        }
    }
    public function modificaUser() {
        if (Request::ajax()) {
            $data = Input::get('data');
            $data = $this->changeXSS($data);
            $rules = array(
                'persoana'=>'persoana|required|no_emtpy',
                'nume'=>'alpha_spaces|required|no_emtpy',
                'email'=>'email',
                'showemail'=>'boolean',
                'telefon'=>'numeric|min:10',
                'cartier'=>'exists:cartieres,nume|required',
                'oras'=>'exists:orases,nume',
                'parola'=>'min:6'
            );
            if ($data['telefon']!="") $rules['telefon']='numeric|min:10';
            if ($data['parola']!="") $rules['parola']='min:6';
            $validator = Validator::make($data, $rules);
            if (!$validator->fails()) {
                Auth::user()->persoana = $data['persoana'];
                Auth::user()->nume = $data['nume'];
                Auth::user()->email = $data['email'];
                Auth::user()->showemail = $data['showemail'];
                Auth::user()->oras = $data['oras'];
                Auth::user()->cartier = $data['cartier'];
                Auth::user()->telefon = $data['telefon'];
                Auth::user()->skype = $data['skype'];
                Auth::user()->yahoo = $data['yahoo'];
                if ($data['parola']!="") Auth::user()->password = Hash::make($data['parola']);
                Auth::user()->save();
                return 1;
            }
            else {
                $mesaj = $validator->messages()->all();
                return $mesaj[0]; }
        }
    }
    public function getSubcategorie() {
        if (Request::ajax()) {
            $categorie = Input::get('categorie');
            $subcategorii = Subcategorii::where('parent', $categorie)->get();
            $rezultat = '';
            foreach ($subcategorii as $subcategorie) {
                $rezultat.='<li>'.ucfirst($subcategorie['nume']).'</li>';
            }
            return $rezultat;
        }
    }
    public function codeToName() {
        if (Request::ajax()) {
            $code = Input::get('code');
            $nume = Categorii::where('codunic', $code)->pluck('nume');
            $cat = 1;
            if (empty($nume)) { $nume = Subcategorii::where('codunic', $code)->pluck('nume'); $cat = 0; }
            return $cat."***".ucfirst($nume);
        }
    }
    public function ModificaAnuntForm($anunt_id) {
        $anunt = Anunt::where('id', $anunt_id)->first();
        if (isset($anunt) && Auth::check() && $anunt->user==Auth::user()->id) {
            $this->getVarForTemplate();
            $anunt['continut']=$this->BrToNewLine($anunt['continut'], 0);
            $this->data['anunt']=$anunt;
            $this->data['imagini'] = Imagine::where('anunt', $anunt_id)->get();
            return View::make('cont.callmodificaanunt')->with('data', $this->data);
        }
        else return Redirect::to('contul-meu/anunturile-mele');
    }
    private function makeModificareAnunt($data) {
        $modificare = ModAnunt::find($data['code']);
        if (isset($modificare)) {
            $modificare->titlu = $data['titlu'];
            $modificare->categorie = $data['categorie'];
            $modificare->subcategorie = $data['subcategorie'];
            $modificare->continut = $data['anunt'];
            $modificare->pret = $data['pret'];
            $modificare->negociabil = $data['negociabil'];
            $modificare->save();
            $first = true;
            $first = true;
            if (Session::has('imagini'))
            {
                $imagini = Session::get('imagini');
                foreach ($imagini as $imagine)
                {
                    if (file_exists(public_path($imagine))) {
                        $session = $this->CreateImg(public_path($imagine));
                        $img = new Imagine();
                        $img->id = $session['big'];
                        $img->link_big = $session['big'];
                        $img->link_mini = $session['mini'];
                        $img->orientare = $session['orientare'];
                        $img->user = Auth::user()->id;
                        $img->anunt = $data['code'];
                        if ($first===true) { $img->first = 1; $first = false; }
                        $img->save();
                    }
                }
            }
            Session::forget('imagini');
        }
        else {
            $modificare = new ModAnunt();
            $modificare->id = $data['code'];
            $modificare->titlu = $data['titlu'];
            $modificare->categorie = $data['categorie'];
            $modificare->subcategorie = $data['subcategorie'];
            $modificare->continut = $data['anunt'];
            $modificare->pret = $data['pret'];
            $modificare->negociabil = $data['negociabil'];
            $modificare->save();
            $first = true;
            if (Session::has('imagini'))
            {
                $imagini = Session::get('imagini');
                foreach ($imagini as $imagine)
                {
                    if (file_exists(public_path($imagine))) {
                        $session = $this->CreateImg(public_path($imagine));
                        $img = new Imagine();
                        $img->id = $session['big'];
                        $img->link_big = $session['big'];
                        $img->link_mini = $session['mini'];
                        $img->orientare = $session['orientare'];
                        $img->user = Auth::user()->id;
                        $img->anunt = $data['code'];
                        if ($first===true) { $img->first = 1; $first = false; }
                        $img->save();
                    }
                }
            }
            Session::forget('imagini');
        }
        return 1;
    }
    public function modificaAnunt() {
        if (Request::ajax()) {
            $data = Input::get('data');
            $data['anunt']=$this->BrToNewLine($data['anunt'], 0);
            $data = $this->changeXSS($data);
            $data['anunt']=$this->BrToNewLine($data['anunt'], 1);
            $rules = array(
                'code'=>'exists:anunts,id',
                'titlu'=>'required|max:100',
                'categorie'=>'exists:categoriis,nume|required',
                'subcategorie'=>'exists:subcategoriis,nume|required',
                'anunt'=>'max:1000|required',
                'pret'=>'required|numeric',
                'moneda'=>'required|boolean',
                'negociabil'=>'required|boolean',
            );
            $validator = Validator::make($data, $rules);
            if (!$validator->fails()) {
                $anunt = Anunt::where('id', $data['code'])->first();
                $anunt->moneda = $data['moneda'];
                $anunt->save();
                $this->makeModificareAnunt($data);
                $this->AcceptModAnunt2($data['code']);
                return 1;
            }
            else {
                $mesaj = $validator->messages()->all();
                return $mesaj[0];
            }
        }
    }
    public function stergeAnunt() {
        if (Request::ajax()) {
            $value['code'] = Input::get('code');
            $value['parola'] = Input::get('parola');
            $rules = array('code'=>'exists:anunts,id', 'parola'=>'min:6|passcheck');
            $validator = Validator::make($value, $rules);
            if (!empty($value['parola']) && !$validator->fails()) {
                $anunt = Anunt::find($value['code']);
                $imagini = Imagine::where('anunt', $value['code'])->get();
                foreach ($imagini as $imagine) {
                    unlink('..'.$imagine['link_mini']);
                    unlink('..'.$imagine['link_big']);
                }
                if (count($imagini)>0) DB::table('imagines')->where('anunt', '=', $value['code'])->delete();
                $anunt->delete();
                return 1;
            }
            else {
                $mesaj = $validator->messages()->all();
                if (empty($mesaj)) $mesaj=array('');
                return $mesaj[0];
            }
        }
    }
    public function dezactiveazaAnunt() {
        if (Request::ajax()) {
            $value['code'] = Input::get('code');
            $value['parola'] = Input::get('parola');
            $rules = array('code'=>'exists:anunts,id', 'parola'=>'min:6|passcheck');
            $validator = Validator::make($value, $rules);
            if (!empty($value['parola']) && !$validator->fails()) {
                $anunt = Anunt::find($value['code']);
                $anunt->confirm = 0;
                $anunt->save();
                return 1;
            }
            else {
                $mesaj = $validator->messages()->all();
                if (empty($mesaj)) $mesaj=array('');
                return $mesaj[0];
            }
        }
    }
    public function activeazaAnunt() {
        if (Request::ajax() && Auth::check() && Auth::user()->admin==1) {
            $code = Input::get('code');
            $anunt = Anunt::find($code);
            if (isset($anunt)) {
                $anunt->created_at = Carbon::now();
                $anunt->expired_at = Carbon::today()->addDays(30);
                $anunt->confirm = 1;
                $anunt->confirm_code = $this->genereaza(30);
                $anunt->save();
                return 1;
            }
        }
        else return Redirect::to('/');
    }
    public function AcceptModAnunt() {
        if (Request::ajax() && Auth::check() && Auth::user()->admin==1) {
            $code = Input::get('code');
            $anunt = Anunt::find($code);
            $modanunt = ModAnunt::find($code);
            if (isset($modanunt) && isset($anunt)) {
                $anunt->titlu= $modanunt->titlu;
                $anunt->categorie = $modanunt->categorie;
                $anunt->subcategorie = $modanunt->subcategorie;
                $anunt->continut = $modanunt->continut;
                $anunt->pret = $modanunt->pret;
                $anunt->negociabil = $modanunt->negociabil;
                $anunt->save();
                $modanunt->delete();
                return preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $anunt['titlu'])).'-'.$anunt['id'];
            }
        }
        else return Redirect::to('/');
    }
    public function AcceptModAnunt2($data) {
            $code = $data;
            $anunt = Anunt::find($code);
            $modanunt = ModAnunt::find($code);
            if (isset($modanunt) && isset($anunt)) {
                $anunt->titlu= $modanunt->titlu;
                $anunt->categorie = $modanunt->categorie;
                $anunt->subcategorie = $modanunt->subcategorie;
                $anunt->continut = $modanunt->continut;
                $anunt->pret = $modanunt->pret;
                $anunt->negociabil = $modanunt->negociabil;
                $anunt->save();
                $modanunt->delete();
                return preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $anunt['titlu'])).'-'.$anunt['id'];
            }
    }
    public function getAnunturiSalvate() {
        $ads = Savead::where('user', Auth::user()->id)->get();
        $anunturi = array();
        $i=0;
        foreach ($ads as $anunt)
        {
            $annouce = Anunt::where('id', $anunt->anunt)->first();
            $anunturi[$i] = $annouce;
            $i++;
        }
        $anunturi = $this->AdsCompliment($anunturi);
        return View::make('ajax.anunt-save')->with('anunturi', $anunturi);
    }
    public function StergeAdssave() {
        $code = Input::get('code');
        Savead::where('anunt', $code)->where('user', Auth::user()->id)->delete();
    }
    public function AlegePachetForm($anunt_code) {
        if (Auth::check()) {
            $this->getVarForTemplate();
            return View::make('promovare.calladauga-pachet')->with("data", $this->data);
        }
        else return Redirect::to('/');
    }
    public function getPlatiForm() {
        $plati = Pay::where('user', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return View::make('ajax.plati')->with('plati', $plati);
    }
    public function reactualizeazaAnunt() {
        $code = Input::get('code');
        $anunt = Anunt::find($code);
        if (isset($anunt)) {
            if (!empty($anunt->confirm_code)) {
                $anunt->confirm = 1;
                $anunt->confirm_code = $this->genereaza(30);
                $anunt->created_at = Carbon::now();
                $anunt->expired_at = Carbon::today()->addWeeks(4);
                $anunt->save();
            }
        }
    }
    public function ReactiveazaAnunt($confirm_code) {
        $anunt = Anunt::where('reinoieste', $confirm_code)->first();
        if (isset($anunt)) {
            $anunt->confirm = 1;
            $anunt->confirm_code = $this->genereaza(30);
            $anunt->created_at = Carbon::now();
            $anunt->expired_at = Carbon::today()->addWeeks(4);
            $anunt->save();
            return Redirect::to('/anunt/'.preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $anunt['titlu'])).'-'.$anunt['id']);
        }
        else return Redirect::to('/');
    }
}