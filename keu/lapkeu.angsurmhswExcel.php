<?php

// Author : Irvandy Goutama
// Email  : irvandygoutama@gmail.com
// Start  : 05 Juni 2008

session_start();

include_once "../dwo.lib.php";
include_once "../db.mysql.php";
include_once "../connectdb.php";
include_once "../parameter.php";
include_once "../cekparam.php";
//include file PHPExcel dan konfigurasi database
require_once '../include/PHPExcel.php';
// Buat object PHPExcel
$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Laporan Tunggakan Mahasiswa');
$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true)->setSize(16);

$objPHPExcel->setActiveSheetIndex(0)->mergeCells("A1:E1");
$objPHPExcel->setActiveSheetIndex(0)->getStyle("A1:E1")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A3', 'No')
        ->setCellValue('B3', 'NIM')
        ->setCellValue('C3', 'Nama Mahasiswa')
        ->setCellValue('D3', 'Tahun')
        ->setCellValue('E3', 'Tunggakan');

$objPHPExcel->getActiveSheet()->getStyle("A1:E3")->getFont()->setBold(true)->setSize(11);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

// *** Parameters ***
$TahunID = GetSetVar('TahunID');
$ProdiID = GetSetVar('ProdiID');

$whr_prodi = (empty($ProdiID)) ? '' : "and k.ProdiID = '$ProdiID' ";
$whr_tahun = (empty($TahunID)) ? '' : "and k.TahunID = '$TahunID'";
$s = "select k.MhswID, m.Nama, k.ProdiID, k.IP, k.SKS, k.TahunID,  
      (k.Biaya - k.Potongan) as Tagihan,
	  k.Bayar
    from khs k 
      left outer join mhsw m on m.MhswID = k.MhswID and m.KodeID = '" . KodeID . "'
    where k.KodeID='" . KodeID . "'
	   $whr_tahun
      $whr_prodi
	  and ((k.Biaya-k.Potongan)-k.Bayar) > 0
    order by k.MhswID";
$r = _query($s);
$n = 0;
$t = 5;
$ttlselisih = 0;
$i = 4;

if (_num_rows($r) > 0) {
//
    while ($w = _fetch_array($r)) {
        $n++;
        $selisih = $w['Tagihan'] - $w['Bayar'];
        $ttlselisih += $selisih;

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValueExplicit('A' . $i, $n, PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('B' . $i, $w['MhswID'], PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('C' . $i, ucwords(strtolower($w['Nama'])), PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('D' . $i, $w['TahunID'], PHPExcel_Cell_DataType::TYPE_STRING)
                ->setCellValueExplicit('E' . $i, $selisih, PHPExcel_Cell_DataType::TYPE_NUMERIC);

        $i++;
    }
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("E4:E" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle("E4:E" . $i)->getNumberFormat()->setFormatCode("Rp #,##0");

    $_ttl = $ttlselisih + 0;
    $i = $i + 1;
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A' . $i, 'Total');
    $objPHPExcel->getActiveSheet()->getStyle("A" . $i . ":E" . $i)->getFont()->setBold(true)->setSize(11);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A" . $i . ":D" . $i);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("A" . $i . ":D" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueExplicit('E' . $i, $_ttl, PHPExcel_Cell_DataType::TYPE_NUMERIC);
    $objPHPExcel->setActiveSheetIndex(0)->getStyle("E" . $i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    $objPHPExcel->getActiveSheet()->getStyle("E" . $i)->getNumberFormat()->setFormatCode("Rp #,##0");
    
    }
//
// nama dari sheet yang aktif
$objPHPExcel->getActiveSheet()->setTitle('Laporan Tunggakan Mahasiswa');

$objPHPExcel->setActiveSheetIndex(0);

// simpan file excel dengan nama umr2013.xls
//saat file berhasil di buat, otomatis pop up download akan muncul
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="LaporanTunggakanMahasiswa.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;
?>
