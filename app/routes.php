<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Index Route
Route::get('/', 'Core@getIndex');

// Ajax Route
Route::post('ajax/LoginFacebook', 'Core@LoginFacebook');
Route::post('ajax/getSecretKey', 'Core@getSecretKey');
Route::post('ajax/request-login-form', 'Core@getLoginForm');
Route::post('ajax/request-register-form', 'Core@getRegisterForm');
Route::post('adauga-credit/getFormRedirect', 'Core@getFormRedirect');
Route::post('adauga-credit/SMSconfirm', 'Core@confirmPlataSMS');
Route::post('adauga-credit/CardConfirm', 'Core@confirmPlataCard');
Route::post('ajax/inregistreazama', 'Core@RegisterMe');
Route::post('ajax/logheazama', 'Core@LoginMe');
Route::post('ajax/logout', function() { Auth::logout(); });
Route::post('ajax/chosetown', 'Core@GetCartOfTown');
Route::post('ajax/adauga-anunt', 'Core@AdaugaAnunt');
Route::post('ajax/setparola', 'Core@SeteazaParola');
Route::post('ajax/request-reset-form', 'Core@ResetForm');
Route::post('ajax/trimite-reset-parola', 'Core@SendResetToken');
Route::post('ajax/first-ads', 'Core@ShowFirstAds');
Route::post('ajax/cauta', 'Core@CautaFirst');
Route::post('ajax/uploadimage', 'Core@UploadImg');
Route::post('ajax/deleteimg', 'Core@DeleteImg');
Route::post('ajax/extractimg', 'Core@ExtrageImg');
Route::post('ajax/extrageinfo', 'Core@ExtrageInfo');
Route::post('ajax/trimitemesaj', 'Core@TrimiteMesaj');
Route::post('ajax/getMyAdsActive', 'Core@GetMyAdsActive');
Route::post('ajax/getMyAdsInactive', 'Core@GetMyAdsInactive');
Route::post('ajax/SearchInMyAds', 'Core@SearchInMyAds');
Route::post('ajax/getMesajeNew', 'Core@getMesajeNew');
Route::post('ajax/getMesajeSterse', 'Core@getMesajeSterse');
Route::post('ajax/getMesajeTrimise', 'Core@getMesajeTrimise');
Route::post('ajax/MesajDeletePreventiv', 'Core@MesajDeletePreventiv');
Route::post('ajax/MesajRepune', 'Core@MesajRepune');
Route::post('ajax/seveAds', 'Core@saveAds');
Route::post('ajax/getAddTicketForm', 'Core@getAddTicketForm');
Route::post('ajax/trimiteTicket', 'Core@trimiteTicket');
Route::post('ajax/getTickete', 'Core@getTickete');
Route::post('ajax/openTicket', 'Core@openTicket');
Route::post('ajax/replyTicket', 'Core@replyTicket');
Route::post('ajax/deleteTicket', 'Core@deleteTicket');
Route::post('ajax/getTicketMesajMod', 'Core@getTicketMesajMod');
Route::post('ajax/modificaTicket', 'Core@modificaTicket');
Route::post('ajax/modficaUser', 'Core@modificaUser');
Route::post('ajax/chosecategorie', 'Core@getSubcategorie');
Route::post('ajax/code-to-name', 'Core@codeToName');
Route::post('ajax/modificaAnunt', 'Core@modificaAnunt');
Route::post('ajax/trimiteContact', 'Core@trimiteContact');
Route::post('ajax/stergeAnunt', 'Core@stergeAnunt');
Route::post('ajax/dezactiveazaAnunt', 'Core@dezactiveazaAnunt');
Route::post('ajax/getAnunturiSalvate', 'Core@getAnunturiSalvate');
Route::post('ajax/StergeAdssave', 'Core@StergeAdssave');
Route::post('pachete/bronze', 'Planuri@BronzeCheckForUser');
Route::post('pachete/silver', 'Planuri@SilverCheckForUser');
Route::post('pachete/gold', 'Planuri@GoldCheckForUser');
Route::post('pachete/cumpara', 'Planuri@CumparaPachet');
Route::post('ajax/getPlati', 'Core@getPlatiForm');
Route::post('ajax/addAnuntWithLogin', 'Core@AddAnuntWithLogin');
Route::post('ajax/reactualizeazaAnunt', 'Core@reactualizeazaAnunt');
Route::post('ajax/activezaanunt', 'Core@activeazaAnunt');
Route::post('ajax/deleteimgFromDB', 'Core@DeleteImgFromDB');
Route::post('ajax/AcceptModAnunt', 'Core@AcceptModAnunt');
Route::post('admin/acceptaAnunt', array('before' => 'isAdmin', 'uses' => 'Admin@acceptaAnunt'));
Route::post('ajax/RefuzaModAnunt', array('before' => 'isAdmin', 'uses' => 'Admin@RefuzaAnunt'));
Route::post('admin/getUtilizatori', array('before' => 'isAdmin', 'uses' => 'Admin@getUtilizatori'));
Route::post('admin/FormeditUser', array('before' => 'isAdmin', 'uses' => 'Admin@FormEditUser'));
Route::post('admin/editUser', array('before' => 'isAdmin', 'uses' => 'Admin@EditUser'));
Route::post('admin/stergeUser', array('before' => 'isAdmin', 'uses' => 'Admin@stergeUser'));
Route::post('admin/stergeAnunt', array('before' => 'isAdmin', 'uses' => 'Admin@stergeAnunt'));
Route::post('admin/stergePay', array('before' => 'isAdmin', 'uses' => 'Admin@stergePay'));
Route::post('admin/getAnunturi', array('before' => 'isAdmin', 'uses' => 'Admin@getAnunturi'));
Route::post('admin/getPays', array('before' => 'isAdmin', 'uses' => 'Admin@getPays'));
Route::post('admin/getTickets', array('before' => 'isAdmin', 'uses' => 'Admin@getTickets'));
Route::post('admin/stergeTicket', array('before' => 'isAdmin', 'uses' => 'Admin@stergeTickets'));
Route::post('admin/RaspTicket', array('before' => 'isAdmin', 'uses' => 'Admin@RaspTicket'));
Route::post('admin/IntretineAplicatie', array('before' => 'isAdmin', 'uses' => 'Admin@ActiuneForApp'));
Route::post('admin/raspundeTicket', array('before' => 'isAdmin', 'uses' => 'Admin@RaspundeTicket'));
Route::post('ajax/RapundeMesaj', 'Core@RaspundeMesaj');
Route::post('ajax/MesajDelete', 'Core@MesajDelete');
Route::post('/ajax/checkLogin', function() { if (Auth::check())  return 1; else return 0; });
Route::post('ajax/checkLoginForPromo', function() {

    if (Auth::check()) {
        $code = Input::get('anunt');
        $user = Anunt::find($code)->user;
        if ($user != Auth::user()->id) {
            return 2;
        }
        else return 1;
    }
    else return 0;
});

// App Route
Route::get('ajax/getCpachaImg', 'Core@Capcha');
Route::get('ajax/uploadimage', 'Core@Blank');
Route::get('adauga-anunt', 'Core@AdaugaAnuntView');
Route::get('ajutor', 'Core@AjutorPage');
Route::get('contact', 'Core@ContactPage');
Route::get('termeni-si-conditii', 'Core@TermeniSiConditiiPage');
Route::get('adauga-credit', 'Core@AdaugaCreditPage');
Route::get('administrator', array('before' => 'isAdmin', 'uses' => 'Admin@GetAdminPanelIndex'));
Route::get('/adauga-credit/SMSsucces', 'Core@getConfirmPlataReturn');
Route::get('administrator/{ramura}', array('before' => 'isAdmin', 'uses' => 'Admin@GetAdminPanel'));
Route::get('contul-meu/{tab}', 'Core@MyAccount');
Route::get('anunt/{anunt_code}', 'Core@ShowAnunt');
Route::geT('anunt/reactiveaza/{confirm_code}', 'Core@ReactiveazaAnunt');
Route::get('modanunt/{anunt_code}', array('before' => 'isAdmin', 'uses' => 'Core@ShowModAnunt'));
Route::get('confirm/{confirm_code}', 'Core@ConfirmUser');
Route::get('confirma/{confirm_code}', 'Core@ConfirmUserWithoutSetPassword');
Route::get('reseteaza/{confirm_code}', 'Core@ReseteazaParola');
Route::get('cronjobs/empty_tmp', 'Admin@DeleteImgNorecord');
Route::get('cronjobs/set_reinoire_anunt_promo', 'Admin@ReinoiesteAnunturiPromovate');
Route::get('cronjobs/setReinoire', 'Admin@SetReinoire');
Route::get('modifica/anunt/{anunt_id}', 'Core@ModificaAnuntForm');
Route::get('promoveaza/alege-pachet/{anunt_id}', array('before' => 'ApartineAnunt', 'uses' => 'Core@AlegePachetForm'));
Route::get('{categorie}', array('before' => 'existCategorie', 'uses' => 'Core@ShowCategorie'));
Route::get('{categorie}/{subcategorie}', array('before' => 'existSubcategorie', 'uses' => 'Core@ShowSubcategorie'));
Route::get('cauta/{categorie}/{oras}/{cartier}/{keywords}/{pretdela}-{pretpanala}', 'Core@CautaFirstForm');
//Valiators

Event::listen('auth.login', function($user)
{
    $user->last_login = new DateTime;

    $user->save();
});

Validator::extend('alpha_spaces', function($attribute, $value)
{
    return preg_match('/^[0-9A-Za-z -]+$/', $value);
});
Validator::extend('no_emtpy', function($attribute, $value)
{
    if (empty($value)) return false;
    else return true;
});
Validator::extend('persoana', function($attribute, $value)
{
    if ($value=="Persoana Fizica") return true;
    else if ($value=="Persoana Juridica") return true;
    else return false;
});
Validator::extend('gol', function($attribute, $value)
{
    if (Auth::user()->$value!="") return true;
    else return false;
});
Validator::extend('passcheck', function ($attribute, $value)
{
   return Hash::check($value, Auth::user()->getAuthPassword());
});