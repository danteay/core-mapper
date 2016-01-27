<?php

function autoload($className){

    require_once __DIR__."/../../$className.php";

}

spl_autoload_register('autoload');