@extends(((!Auth::check()) ? 'index.platforma' : 'index.logat' ))
@extends('section')