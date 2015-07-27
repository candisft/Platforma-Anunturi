<?php

class Categorii extends Eloquent {

    public static function getCategori() {
        $categorii = Categorii::all();
        foreach ($categorii as $categorie) {
            $categorie->nume=ucfirst($categorie->nume);
        }
        return $categorii;
    }
}