<?php

include "init.php";

if (empty($_REQUEST['c']))
{
	$e = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
	$_REQUEST['c'] = $e[0];
}

if (empty($_REQUEST['c']))
{
	$_REQUEST['c'] = 'book';
}

if (!empty($_REQUEST['c']))
{    
    $c = $_REQUEST['c'];
    $classname =  "Controller\\" . ucfirst($c) . 'Controller';
	$cname = strtolower($c);
    
    if (class_exists($classname))
    {
        $c = new $classname();
        $c->_run();
		
		$include_js = $c->_include_js;
		foreach ($include_js as &$js)
		{
			if (strpos($js, '/') !== 0)
			{
				$js = "/js/{$cname}/$js";
			}
		}
		unset($js);
		
		$view = 'views/' . ($cname) . '/' . $c->_view_name  . '.php';
		extract($c->_view_data);
		$_js_data = $c->_js_data;
		
		ob_start();
		include $view;
		$contents = ob_get_contents();
		ob_end_clean();
		
		include 'layout.php';
    }
}
