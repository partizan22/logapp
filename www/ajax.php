<?php

include "init.php";

if (!empty($_REQUEST['c']))
{    
    $c = $_REQUEST['c'];
    $classname =  "Controller\\" . ucfirst($c) . 'Controller';
    
    if (class_exists($classname))
    {
        $c = new $classname();
        return $c->_run_ajax();
    }
}