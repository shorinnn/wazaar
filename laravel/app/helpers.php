<?php

function alphanum($string){
    return preg_replace("/[^a-zA-Z0-9]+/", "", $string);
}