<?php

function autoload($className){
    $className = str_replace("\\","/",$className);
    require_once __DIR__."/../../".$className.".php";

}

spl_autoload_register('autoload');