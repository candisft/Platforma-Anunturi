<?php

class Subcategorii extends Eloquent {

    public static function getSubcategori() {
        $subcategorii = Subcategorii::all();
        foreach ($subcategorii as $subcategorie) {
            $subcategorie->nume=ucfirst($subcategorie->nume);
        }
        return $subcategorii;
    }
    public static function getSubcategoriWithParent($parent) {
        $subcategorii = Subcategorii::where('parent', $parent)->get();
        foreach ($subcategorii as $subcategorie) {
            $subcategorie->nume=ucfirst($subcategorie->nume);
        }
        return $subcategorii;
    }
}