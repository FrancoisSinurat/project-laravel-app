<?php

if(!function_exists('replaceComma')) {

    function replaceComma($amount) {
        return str_replace(',','',$amount);
    }
}
