<?php

if(!function_exists('replaceComma')) {

    function replaceComma($amount) {
        return str_replace(',','',$amount);
    }
}

if(!function_exists('numberFormat')) {

    function numberFormat($amount) {
        return number_format($amount,0,",",".");
    }
}
