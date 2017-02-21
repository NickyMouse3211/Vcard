<?php
	$phpExcel = new PHPExcel();
	$objPHPExcel = $phpExcel->setActiveSheetIndex(0);
	$objPHPExcel->setTitle($pagetitle);

	//$date = date('d', strtotime($date)).' '.bulan(date('m', strtotime($date))).' '.date('Y', strtotime($date));
	$namaFile = @$namaFile;

	$data = @$header;

	$topStyle =[
		'font'  => [
		    'bold'  => true,
		    'size'  => 10
		],
		'alignment' => [
		    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		]
	];

	$headerStyle = array(
		'font'  => array(
		    'bold'  => true,
		    'size'  => 12
		),
		'alignment' => array(
		    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
		    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
		),
		'borders' => array(
			'allborders' => array(
			  	'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		),
		'fill' => array(
		    'type' => PHPExcel_Style_Fill::FILL_SOLID,
		    'color' => array('rgb' => 'EEEEEE')
		)
	);

	$fillStyle = array(
		'borders' => array(
			'allborders' => array(
			  	'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		)
	);

    $objPHPExcel->setCellValue('A1', @$title);
    $objPHPExcel->mergeCells('A1:L1');
    $objPHPExcel->setCellValue('A2', @$title_2);
    $objPHPExcel->mergeCells('A2:L2');

    $objPHPExcel->getStyle('A1:A2')->applyFromArray($topStyle);
    $objPHPExcel->getStyle('A1:A3')->getFont()->setBold(true)->setSize(12);;


    $startColumn 	= 'A';
    $startRow 		= 4;

	$start = $startRow;
	$i = $startColumn;
	$j = chr(ord($i)+(count($data)-1));
    $objPHPExcel->getStyle($i.$start.':'.$j.($start+1))->applyFromArray($headerStyle);
	foreach ($data as $key => $value) {
		
    		$objPHPExcel->mergeCells($i.$start.':'.$i.($start+1));
	    	$objPHPExcel->setCellValue($i.$start, $value[0]);
		
	    $objPHPExcel->getColumnDimension($i)->setWidth($value[1]);
	    $i++;
	}

	$objPHPExcel->getRowDimension($start)->setRowHeight(20);

	$i = $startColumn;
	$start = $startRow+2;
	$no = 1;
	foreach ($report as $rows) {
		$j = chr(ord($i)+1);
    	$objPHPExcel->setCellValue($i.$start, $no);
		foreach ($rows as $key => $value) {
			
			
	    	$objPHPExcel->setCellValue($j.$start, $value);
	    	$j++;
		}
		$start++;
		$no++;
	}

	$i = $startColumn;
	$start = $startRow+2;

    $objPHPExcel->getStyle($i.$start.':'.chr(ord($j)-1).($start+count($report)-1))->applyFromArray($fillStyle);

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$namaFile.'.xls"');
	header('Cache-Control: max-age=0');
	header('Cache-Control: max-age=1');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header('Pragma: public'); // HTTP/1.0

	$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
?>

