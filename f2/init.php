<?php

define('BTF_DIR', dirname(__FILE__));

spl_autoload_register(function ($class) {
    
        $class = str_replace('BTF', 'classes', $class);
    
        $file =  BTF_DIR . '/' . str_replace('\\', '/',  $class) .  '.class.php';
        
        if (file_exists($file))
        {
            include $file;
        }
    
});
