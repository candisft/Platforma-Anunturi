<?php
class Cartiere extends Eloquent {

    public static function getCartiere($oras) {
        if ($oras) {
            $cartiere = Cartiere::where('oras', '=', $oras)->orderBy('nume', 'asc')->get();
        }
        else {
            $cartiere = Cartiere::orderBy('nume', 'asc')->get();
        }
        foreach($cartiere as $cartier) {
            $cartier->nume = ucfirst($cartier->nume);
        }
        return $cartiere;
    }
}