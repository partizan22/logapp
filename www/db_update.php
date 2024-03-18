<?php

//chdir(dirname(__FILE__));
//
//include "init.php";

$res = \AppGlobal::db()->query(BTF\DB\SQL\SQLQuery::SELECT()->from('migrations'));
$existing = [];

if (!empty($res))
{
	foreach ($res as $row)
	{
		$existing[] = $row['name'];
	}
}

$dir = opendir('../migrations');
$new = [];
while ($file = readdir($dir))
{
	if (substr($file, -4) === '.sql')
	{
		if (!in_array($file, $existing))
		{
			$new[] = $file;
		}
	}
}

sort($new);
$mysqli = \AppGlobal::db()->_connection();

foreach ($new as $name)
{
	$q = file_get_contents("../migrations/{$name}");
	mysqli_multi_query($mysqli, $q );
	
	do {		
		if ($mysqli->more_results()) {
			
		}
	} while ($mysqli->next_result());
	
	$name = \AppGlobal::db()->escapeValue($name);
	$q = "INSERT INTO migrations SET `name`={$name};";
	
	mysqli_query($mysqli, $q );
	
}




