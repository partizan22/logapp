<?php

include '../f2/init.php';

spl_autoload_register(function ($class) {
    
    foreach (['classes', 'models', 'controllers', 'helpers'] as $dir)
    {
        $file = $dir . '/' . preg_replace('/(.+\\\\)+/', '', $class) . '.class.php';
        
        if (file_exists($file))
        {
            include $file;
            break;
        }
    }
});

AppGlobal::i();

include 'vendor/autoload.php';

$_SESSION['account_id'] = 1;