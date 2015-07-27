<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "Campul :attribute trebuie sa fie acceptat.",
	"active_url"           => "In campul :attribute nu este un URL valid.",
	"after"                => "Campul :attribute trebuie sa contina o data dupa data :date.",
	"alpha"                => "Campul :attribute poate contine numai litere.",
	"alpha_dash"           => "Campul :attribute poate contine numai litere, numere si '_', '-'",
	"alpha_num"            => "Campul :attribute poate contine numai litere sau numere.",
	"array"                => "Campul :attribute trebuie sa fie o matrice.",
	"before"               => "Campul :attribute trebuie sa fie inaintea datei de :date.",
	"between"              => array(
		"numeric" => "Campul :attribute trebuie sa fie intre :min si :max.",
		"file"    => "Fisierul :attribute trebuie sa fie intre :min si :max kilobytes.",
		"string"  => "Campul :attribute trebuie sa contina intre :min si :max caractere.",
		"array"   => "Array-ul :attribute trebuie sa contina intre :min si :max iteme.",
	),
	"confirmed"            => "Campul :attribute nu este confirmat.",
	"date"                 => "Campul :attribute nu este o data valida.",
	"date_format"          => "Campul :attribute nu are formatul :format.",
	"different"            => "Campurile :attribute si :other trebuie sa fie diferite.",
	"digits"               => "Campul :attribute trebuie sa aiba :digits digitale.",
	"digits_between"       => "Campul :attribute trebuie sa contina intre :min si :max digitale.",
	"email"                => "Campul :attribute trebuie sa fie o adresa valida.",
	"exists"               => "Campul selectat :attribute nu exista in baza de date.",
	"image"                => "Campul :attribute trebuie sa fie o imagine.",
	"in"                   => "Campul selectat :attribute este invalid.",
	"integer"              => "Campul :attribute trebuie sa fie un numar natural.",
	"ip"                   => "Campul :attribute trebuie sa contina un IP valid.",
	"max"                  => array(
		"numeric" => "Campul :attribute nu poate fi mai mare de :max.",
		"file"    => "Campul :attribute nu poate avea mai mult de :max kilobytes.",
		"string"  => "Campul :attribute nu poate avea mai mult de :max caractere.",
		"array"   => "Campul :attribute nu poate avea mai mult de :max iteme.",
	),
	"mimes"                => "Campul :attribute trebuie sa fie un fisier cu extensia: :values.",
	"min"                  => array(
		"numeric" => "Campul :attribute trebuie sa fie mai mare de :min.",
		"file"    => "Campul :attribute trebuie sa aiba cel putin :min kilobytes.",
		"string"  => "Campul :attribute trebuie sa aiba cel putin :min caractere.",
		"array"   => "Campul :attribute trebuie sa aiba cel putin :min iteme.",
	),
	"not_in"               => "Campul selectat :attribute este invalid.",
	"numeric"              => "Campul :attribute trebuie sa fie un numar.",
	"regex"                => "Formatul campului :attribute este invalid.",
	"required"             => "Campul :attribute este obligatoriu.",
	"required_if"          => "Campul :attribute este obligatoriu cand :other este :value.",
	"required_with"        => "Campul :attribute este obligatoriu cand :values este prezent.",
	"required_with_all"    => "Campul :attribute este obligatoriu cand :values este prezent.",
	"required_without"     => "Campul :attribute este obligatoriu cand :values is not present.",
	"required_without_all" => "Campul :attribute este obligatoriu cand :values nu este prezent.",
	"same"                 => "Campurile :attribute si :other trebuie sa fie la fel.",
	"size"                 => array(
		"numeric" => "Campul :attribute trebuie sa aiba :size.",
		"file"    => "Campul :attribute trebuie sa aiba :size kilobytes.",
		"string"  => "Campul :attribute trebuie sa aiba :size caractere.",
		"array"   => "Campul :attribute trebuie sa contina :size iteme.",
	),
	"unique"               => "Campul :attribute exista deja in baza de date.",
	"url"                  => "Campul :attribute nu are un URL valid.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(),
    "alpha_spaces"     => "Campul :attribute poate contine numai litera, spatii si '-'.",
    "passcheck"     => "Parola introdusa nu este corecta !",

);
