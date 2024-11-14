<?php


	$xls = new ExcelHelper('doctpl/handout.xlsx');
	$xls->updateSheet(0);
	
	$xls->sheet->setCellValue('E1', $document->number);
	$xls->sheet->setCellValue('H1', $document->date);
	
	
	
	$c = 4;
	foreach ($items as $i)
	{
		$xls->sheet->setCellValue(ExcelHelper::CellLabbel($c, 3), $i['book_item_id']);
		$name = $i['name'];
		if (!empty($i['category']))
		{
			$name .= " {$i['category']}к";
		}
		$name .= " {$i['price']} грн";
		$xls->sheet->setCellValue(ExcelHelper::CellLabbel($c, 4), $name);
		
//		$xls->sheet->getStyle(ExcelHelper::CellRange($c, 3, $c, 4))->applyFromArray(array(
//            'borders' => array(
//                'allborders' => array(
//                    'style' => PHPExcel_Style_Border::BORDER_THIN
//                )
//            )
//        ));
		
		$c ++;
	}
	
	$c --;
	
	$r = 5;
	$n = 0;
	foreach ($members as $m){
		
		
		$xls->sheet->setCellValue(ExcelHelper::CellLabbel(1, $r), $m['member_id']);
		$xls->sheet->setCellValue(ExcelHelper::CellLabbel(2, $r), ++$n);
		$xls->sheet->setCellValue(ExcelHelper::CellLabbel(3, $r), $m['name']);
		
		$r ++;
	}
	$r --;
	
	$xls->sheet->getStyle(ExcelHelper::CellRange(1, 3, $c, $r))->applyFromArray(array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        ));
	
	$xls->sheet->getStyle(ExcelHelper::CellRange(1, 4, $c, 4))->applyFromArray(array(
            'borders' => array(
                'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));
	
	$xls->sheet->getStyle(ExcelHelper::CellRange(3, 3, 3, $r))->applyFromArray(array(
            'borders' => array(
                'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_MEDIUM
                )
            )
        ));
	
	
	$xls->output($filename);
	