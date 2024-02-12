<?php



class ExcelHelper
{
    public $sheet;
    public $xls;

    public function __construct($template=false)
    {
        require_once( dirname(__FILE__) . '/PHPExcel/PHPExcel.php');
        
        if ($template)
        {
            require_once( dirname(__FILE__) . '/PHPExcel/PHPExcel/Writer/Excel2007.php');        
            $objReader = PHPExcel_IOFactory::createReader('Excel2007');
            $this->xls = $objReader->load($template);
        }
        else
        {
            $this->xls = new PHPExcel();
        }
        
        $this->xls->setActiveSheetIndex(0);
        $this->sheet = $this->xls->getActiveSheet();
    }
    
    public function updateSheet($idx)
    {
        $this->xls->setActiveSheetIndex($idx);
        $this->sheet = $this->xls->getActiveSheet();
    }

    public function setColWidth($c, $w)
    {
        $this->sheet->getColumnDimension( self::CellLabbel($c) )->setWidth($w);
    }
    
    static function CellLabbel($c, $r = false)
    {
        $A = ord('A');

        $cell = '';
        while ($c > 0) {
            $c--;

            $cell = chr($A + ($c % 26)) . $cell;
            $c = (int)($c / 26);
        }

        if ($r) {
            $cell .= $r;
        }

        return $cell;
    }

    static function CellRange($c1, $r1, $c2, $r2)
    {
        return self::CellLabbel($c1, $r1) . ':' . self::CellLabbel($c2, $r2);
    }


    public function copyStyles($r_from, $c_from, $r_to, $c_to, $r_count, $c_count)
    {
        for ($r = 0; $r < $r_count; $r++) {
            for ($c = 0; $c < $c_count; $c++) {
                $this->sheet->duplicateStyle($this->sheet->getStyle(ExcelHelper::CellLabbel($c + $c_from, $r + $r_from)), ExcelHelper::CellLabbel($c + $c_to, $r + $r_to));
            }
        }
    }

    public function copyCells($r_from, $c_from, $r_to, $c_to, $r_count, $c_count)
    {
        for ($r = 0; $r < $r_count; $r++) {
            for ($c = 0; $c < $c_count; $c++) {
                $this->sheet->duplicateStyle($this->sheet->getStyle(ExcelHelper::CellLabbel($c + $c_from, $r + $r_from)), ExcelHelper::CellLabbel($c + $c_to, $r + $r_to));
                $this->sheet->setCellValue(ExcelHelper::CellLabbel($c + $c_to, $r + $r_to), $this->sheet->getCellByColumnAndRow($c + $c_from - 1, $r + $r_from)->getValue());
            }
        }
    }
    
    public function newSheet($index)
    {
        // Add new sheet
        $objWorkSheet = $this->xls->createSheet();

        //  Attach the newly-cloned sheet to the $objPHPExcel workbook
        //$this->xls->addSheet($objWorkSheet);

        // Add some data
        $this->xls->setActiveSheetIndex($index);

        $this->sheet = $this->xls->getActiveSheet();
    }

    /**
     * @param $filename
     */
    public  function output($filename)
    {
        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=" . $filename);

        $objWriter = new PHPExcel_Writer_Excel2007($this->xls);
		//$objWriter->setPreCalculateFormulas(); 

        $objWriter->save('php://output');
        exit();
    }

}
