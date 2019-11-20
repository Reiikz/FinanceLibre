<?php

class LocaleLoader {
    function __construct(Lang $lc){
        $this->lc = $lc;
    }

    function loadText($template, $in){
        $out = $in;
        foreach($this->lc->keys[$template] as $key){
            $out = str_replace("$key", $this->lc->lc[$key], $out);
        }
        return $out;
    }

    private $lc;
}