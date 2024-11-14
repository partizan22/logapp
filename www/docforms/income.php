<?php

	use PhpOffice\PhpWord\TemplateProcessor;
	
	$processor = new TemplateProcessor('doctpl/internal.docx');
	$processor->setValues([
		'doc_number' => $data['document']['number'],
		'doc_date'=> $data['document']['date'],
		'reg_number'=> $data['document']['reg_number'],
		'reg_date'=> $data['document']['reg_date'],
		'subject_name'=> $data['subject']['name'],
		'total_items'=> $data['total_items']
	]);
	
	$rows = [];
	$n = 0;
	foreach ($data['items'] as $i)
	{
		$rows[] = [
			'itemNo' => ++$n,
			'itemName' => $i['name'],
			'itemCode' => $i['number'],
			'itemUnit' => $i['unit'],
			'itemCat' => $i['category'],
			'itemCnt' => $i['count'],
			'itemPrice' => "Ціна {$i['price']} грн",
		];
	}
	$processor->cloneRowAndSetValues('itemNo', $rows);
	
	$name = 'internal';