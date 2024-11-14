<?php

	use PhpOffice\PhpWord\TemplateProcessor;
	
	$deps = [];
	foreach ($data_by_dep as $d => $r)
	{
		$deps[] = ['department' => $d];
	}
		
	
	$processor = new TemplateProcessor('doctpl/inv-title.docx');
	$processor->cloneBlock('cont', count($deps), true, false, $deps);