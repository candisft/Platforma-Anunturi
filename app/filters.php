<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
Route::filter('xss', function()
{

});
Route::filter('existCategorie', function($route) {
    $rules = array('codunic'=>'exists:categoriis');
    $val['codunic']=$route->getParameter('categorie');
    $validator = Validator::make($val, $rules);
    if ($validator->fails()) { return Redirect::intended('/'); }
});
Route::filter('ApartineAnunt', function($route) {
    $rules = array('anunt_id'=>'exists:anunts,id');
    $val['anunt_id']=$route->getParameter('anunt_id');
    $validator = Validator::make($val, $rules);
    $anunt = Anunt::find($val['anunt_id']);
    if (!Auth::check() || $validator->fails() || $anunt->user != Auth::user()->id) { return Redirect::intended('/'); }
});
Route::filter('existSubcategorie', function($route) {
    $rules = array('codunic'=>'exists:subcategoriis');
    $val['codunic']=$route->getParameter('subcategorie');
    $val['categorie']=$route->getParameter('categorie');
    $validator = Validator::make($val, $rules);
    if ($validator->fails()) { return Redirect::intended('/'); }
    else if (Subcategorii::where('codunic', $val['codunic'])->first()->parent!=str_replace('-', ' ', $val['categorie'])) return Redirect::intended('/');
});
Route::filter('isAdmin', function() {
   if (Auth::check() && Auth::user()->admin==1) {  }
   else return Redirect::to('/');
});
