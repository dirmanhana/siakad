<?php

error_reporting(E_ALL);

include_once "../dwo.lib.php";
include_once "../db.mysql.php";
include_once "../connectdb.php";
//include file PHPExcel dan konfigurasi database
require_once '../include/PHPExcel.php';
// Buat object PHPExcel
$objPHPExcel = new PHPExcel();


// Set properties, isi teks ini bisa anda lihat
//di file excel yang dihasilkan, klik kanan file tersebut
//dan pilih properties.
/*
  $objPHPExcel->getProperties()->setCreator("Candra Adi Putra")
  ->setLastModifiedBy("Candra Adi Putra")
  ->setTitle("Office 2007 XLSX Test Document")
  ->setSubject("Office 2007 XLSX Test Document")
  ->setDescription("Laporan transaksi .")
  ->setKeywords("office 2007 openxml php")
  ->setCategory("UMR 2013");
 */
// Header dari tabel , data akan di simpan di kolom A, B dan C
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'No')
        ->setCellValue('B1', 'Nama Pelanggan')
        ->setCellValue('C1', 'Alamat Baris 1')
        ->setCellValue('D1', 'Alamat Baris 2')
        ->setCellValue('E1', 'Kota')
        ->setCellValue('F1', 'Propinsi')
        ->setCellValue('G1', 'Kode Pos')
        ->setCellValue('H1', 'Negara')
        ->setCellValue('I1', 'No Telepon')
        ->setCellValue('J1', 'Kontak')
        ->setCellValue('K1', 'Email')
        ->setCellValue('L1', 'invoice date')
        ->setCellValue('M1', 'invoice no')
        ->setCellValue('N1', 'Saldo Awal')
        ->setCellValue('O1', 'Mata Uang')
        ->setCellValue('P1', 'Termin')
        ->setCellValue('Q1', 'Tipe Pelanggan');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);


$s = "SELECT * FROM mhsw WHERE StatusMhswID='A' ORDER BY TahunID, ProdiID, MhswID";
$r = _query($s);

$i = 2;
while ($w = _fetch_array($r)) {
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A' . $i, $w['MhswID'], PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('B' . $i, $w['Nama'], PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('C' . $i, $w['Alamat'], PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('D' . $i, '', PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('E' . $i, $w['Kota'], PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('F' . $i, $w['Propinsi'], PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('G' . $i, $w['KodePos'], PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('H' . $i, $w['Negara'], PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('I' . $i, $w['Telepon'], PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('J' . $i, $w['Handphone'], PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('K' . $i, $w['Email'], PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('L' . $i, '', PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('M' . $i, '', PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('N' . $i, '', PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('O' . $i, 'IDR', PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('P' . $i, '', PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('Q' . $i, 'UMUM', PHPExcel_Cell_DataType::TYPE_STRING);
    $i++;
}


// nama dari sheet yang aktif
$objPHPExcel->getActiveSheet()->setTitle('Data Mahasiswa');

$objPHPExcel->setActiveSheetIndex(0);

// simpan file excel dengan nama umr2013.xls
//saat file berhasil di buat, otomatis pop up download akan muncul
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="DataMahasiswa.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;
?>
