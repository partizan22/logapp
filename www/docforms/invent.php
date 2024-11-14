<?php

	$xls = new ExcelHelper('doctpl/invent.xlsx');
	$xls->updateSheet(0);
	
	$cnt = 0;
	$sum = 0.0;
	
	foreach ($data as $row)
	{
		$cnt += $row['cnt'];
		$sum += $row['cnt'] * $row['price'];
	}
	
	$xls->sheet->setCellValue('R30', Helpers\NumbersLangHelper::lang_number(count($data)));
	$xls->sheet->setCellValue('R32', Helpers\NumbersLangHelper::lang_number($cnt, 'female'));
	$xls->sheet->setCellValue('R34', Helpers\NumbersLangHelper::lang_price($sum));
	$xls->sheet->setCellValue('R36', Helpers\NumbersLangHelper::lang_number($cnt, 'female'));
	$xls->sheet->setCellValue('R38', Helpers\NumbersLangHelper::lang_price($sum));
	
	if (count($data) < 21)
	{
		for ($i=0; $i<21-count($data); $i++)
		{
			$xls->sheet->removeRow(7, 1);
		}
	}
	
	$r = 7;
	$n = 0;
	foreach ($data as $row){
		$xls->sheet->setCellValue("B{$r}", ++$n);
		$xls->sheet->setCellValue("C{$r}", $row['name']);
		$xls->sheet->setCellValue("K{$r}", $row['number']);
		$xls->sheet->setCellValue("S{$r}", $row['unit']);
		$xls->sheet->setCellValue("T{$r}", $row['cnt']);
		$xls->sheet->setCellValue("U{$r}", $row['price']);
		$xls->sheet->setCellValue("W{$r}", $row['price']*$row['cnt']);
		$xls->sheet->setCellValue("X{$r}", $row['cnt']);
		$xls->sheet->setCellValue("Y{$r}", $row['price']);
		$xls->sheet->setCellValue("Z{$r}", $row['price']*$row['cnt']);
		
		$r ++;
	}
	
	$xls->save($filename);
	