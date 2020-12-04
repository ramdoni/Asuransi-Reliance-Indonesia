<?php

namespace App\Http\Livewire\CashFlow;

use Livewire\Component;

class InternalReport extends Component
{
    public $year,$month;
    public function render()
    {
        return view('livewire.cash-flow.internal-report');
    }

    public function mount()
    {
        $this->year = date('Y');
    }

    public function downloadExcel()
    {
        // Create new PHPExcel object
        $objPHPExcel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Stalavista System")
                                     ->setLastModifiedBy("Stalavista System")
                                     ->setTitle("Office 2007 XLSX Product Database")
                                     ->setSubject("Journal Database")
                                     ->setDescription("Journal Database.")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("Journal");

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'JOURNAL '.$this->year?$this->year:date('Y'));
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setWrapText(false);
        
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A3', 'COA')
                    ->setCellValue('B3', 'No Voucher')
                    ->setCellValue('C3', 'Date')
                    ->setCellValue('D3', 'Account')
                    ->setCellValue('E3', 'Description')
                    ->setCellValue('F3', 'Debit')
                    ->setCellValue('G3', 'Kredit')
                    ->setCellValue('H3', 'Saldo');

        $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        //$objPHPExcel->getActiveSheet()->getStyle('A3:I3')->getFill()
                            //->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            //->getStartColor()->setRGB('e2efd9')
                           // ;
        $objPHPExcel->getActiveSheet()->getRowDimension('3')->setRowHeight(34);
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->freezePane('A4');

        $objPHPExcel->getActiveSheet()->setAutoFilter('A3:H3');
        
        $data = \App\Models\Journal::orderBy('id','DESC');
        
        if($this->keyword) $data = $data->where('no_voucher','LIKE',"%{$this->keyword}%");
        if($this->year) $data = $data->whereYear('date_journal',$this->year);
        if($this->month) $data = $data->whereMonth('date_journal',$this->month);
        if($this->coa_id) $data = $data->where('coa_id',$this->coa_id);
        
        $param = $data->get();
        $num=4;
        $br='';
        foreach($param as $k => $i){
            if($i->no_voucher!=$br and $br!=""){
                $num++;
                $objPHPExcel->setActiveSheetIndex(0)
                  ->setCellValue('A'.$num,'')
                  ->setCellValue('B'.$num,'')
                  ->setCellValue('C'.$num,'')
                  ->setCellValue('D'.$num,'')
                  ->setCellValue('E'.$num,'')
                  ->setCellValue('F'.$num,'')
                  ->setCellValue('G'.$num,'')
                  ->setCellValue('H'.$num,'');
            }
            
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.$num,(isset($i->coa->code)?$i->coa->code:''))
                ->setCellValue('B'.$num,$i->no_voucher)
                ->setCellValue('C'.$num,$i->date_journal)
                ->setCellValue('D'.$num,(isset($i->coa->name)?$i->coa->name:''))
                ->setCellValue('E'.$num,$i->description)
                ->setCellValue('F'.$num,$i->debit)
                ->setCellValue('G'.$num,$i->kredit)
                ->setCellValue('H'.$num,$i->saldo);

            $objPHPExcel->getActiveSheet()->getStyle('F'.$num)->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('G'.$num)->getNumberFormat()->setFormatCode('#,##0');
            $objPHPExcel->getActiveSheet()->getStyle('H'.$num)->getNumberFormat()->setFormatCode('#,##0');
            
            $br = $i->no_voucher;
            $num++;
        }

        // Rename worksheet
        //$objPHPExcel->getActiveSheet()->setTitle('Iuran-'. date('d-M-Y'));

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($objPHPExcel, "Xlsx");

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Journal-' .date('d-M-Y') .'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        //header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        return response()->streamDownload(function() use($writer){
            $writer->save('php://output');
        },'Journal-' .date('d-M-Y') .'.xlsx');
        //return response()->download($writer->save('php://output'));
    }

    
}
