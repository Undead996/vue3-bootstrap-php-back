<?php
namespace App\SRC\ADV;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CabinetOffice
{
    public function __construct($data)
    {   
        $this->names = $data['colnames'];
        $this->values = $data['colvalues'];
    }
    public function excelExport()
    {   
        $spreadsheet = new Spreadsheet();
        ob_end_clean();
        $this->writer = new Xlsx($spreadsheet);
        $this->sheet = $spreadsheet->getActiveSheet();
        $this->setDoc();     
    }
    private function setDoc()
    {   
        $head = [];
        foreach($this->names as $name) {
            if ($name['display'] == 'show') {
                array_push($head, $name['name']);
            }
        };
        // шапка
        $this->sheet->fromArray($head, NULL, 'A1'); 
        // тело
        foreach($this->values as $row => $vals) {
            $coll = 1;
            foreach($vals as $key => $val) {
                $this->sheet->setCellValueByColumnAndRow($coll, $row + 2, $val);
                if ($this->names[$key]['type'] == 'str'){
                    // $this->sheet->getStyleByColumnAndRow($cell, $row + 2)->getNumberFormat()->setFormatCode('0');
                    $this->sheet->setCellValueExplicit($this->getCell($coll, $row + 2), $val, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                }
                $coll = $coll + 1;
            }
        }
        // автоширина
        foreach (range('A', $this->sheet->getHighestDataColumn()) as $coll) {
            $this->sheet->getColumnDimension($coll)->setAutoSize(true);
        } 
        // $this->sheet->getStyleByColumnAndRow('J2')->getNumberFormat()->setFormatCode('#');    
        // $this->sheet->setCellValueExplicit('J2', '9876654334567890', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
    }
    private function getCell($coll, $row){
        $colls = [
            '1' => 'A', '2' => 'B', '3' => 'C', '4' => 'D', '5' => 'E', '6' => 'F', '7' => 'G', '8' => 'H', '9' => 'I', '10' => 'J',
            '11' => 'K', '12' => 'L', '13' => 'M', '14' => 'N', '15' => 'O', '16' => 'P', '17' => 'Q', '18' => 'R', '19' => 'S', '20' => 'T',
            '21' => 'U', '22' => 'V', '23' => 'W', '24' => 'X', '25' => 'Y', '26' => 'Z'
        ];
        return $colls[$coll].(string)$row;
    }
    private function getFileName($filename) {
        return date("d.m.Y").'_'.$filename;
    }
    public function toBrowser($filename) {
        $name = $this->getFileName($filename);
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");;
        header("Content-Disposition: attachment;filename=$name.xlsx");
        header("Content-Transfer-Encoding: binary ");
        ob_end_clean();
        flush();
        $this->writer->save('php://output');   
    }
}