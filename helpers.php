<?php

function dump($value)
{
    print_r($value);
    echo "\n";
}

function dd($value)
{
    dump($value);
    die();
}
