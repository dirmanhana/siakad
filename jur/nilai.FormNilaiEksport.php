<?php

error_reporting(E_ALL);

include_once "../dwo.lib.php";
include_once "../db.mysql.php";
include_once "../connectdb.php";
include_once "../parameter.php";
include_once "../cekparam.php";
require_once '../include/PHPExcel.php';
$objPHPExcel = new PHPExcel();

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Universitas Pembangunan Jaya')
        ->setCellValue('A2', 'Program Studi')
        ->setCellValue('A3', 'Matakuliah')
        ->setCellValue('A4', 'SKS')
        ->setCellValue('A5', 'Dosen Pengampu');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:M1');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:B2');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:B3');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A4:B4');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A5:B5');

$jadwal = GetFields('jadwal', "KodeID='" . KodeID . "' and JadwalID", $_REQUEST[JadwalID], '*');
$prodiNama = GetaField('prodi', "KodeID='" . KodeID . "' and ProdiID", $jadwal[ProdiID], 'Nama');
$dosenNama = GetaField('dosen', "KodeID='" . KodeID . "' and Login", $jadwal[DosenID], 'Nama');

$grade_sql = "SELECT NilaiMin, NilaiMax, Nama FROM nilai WHERE KodeID='" . KodeID . "' and ProdiID='" . $jadwal[ProdiID] . "' ORDER BY NilaiMax ASC ";
$grade_r = _query($grade_sql);



$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('C2', ' : ' . $prodiNama)
        ->setCellValue('C3', ' : ' . $jadwal["Nama"] . ' (' . $jadwal["MKKode"] . ')')
        ->setCellValue('C4', ' : ' . $jadwal["SKS"] . ' SKS')
        ->setCellValue('C5', ' : ' . $dosenNama);

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C2:M2');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C3:M3');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C4:M4');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C5:M5');

$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1:A5')->getFont()->setBold(true);

$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(16);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth('10');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth('10');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth('10');
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth('10');
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth('10');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth('10');
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth('10');
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth('10');
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth('10');
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth('10');

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A7', 'No')
        ->setCellValue('B7', 'NIM')
        ->setCellValue('C7', 'Nama')
        ->setCellValue('D7', 'Kehadiran')
        ->setCellValue('E7', 'Tugas 1')
        ->setCellValue('F7', 'Tugas 2')
        ->setCellValue('G7', 'Tugas 3')
        ->setCellValue('H7', 'Presentasi')
        ->setCellValue('I7', 'Lab')
        ->setCellValue('J7', 'UTS')
        ->setCellValue('K7', 'UAS')
        ->setCellValue('L7', 'Nilai Akhir')
        ->setCellValue('M7', 'Grade');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:A8');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B7:B8');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C7:C8');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('L7:L8');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('M7:M8');

$bobot = GetFields("jadwal", "KodeID = '" . KodeID . "' and JadwalID ", $_REQUEST["JadwalID"], "Tugas1,Tugas2,Tugas3,Tugas4,Tugas5,Presensi,UTS,UAS");

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueExplicit('D8', $bobot["Presensi"] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC)
        ->setCellValueExplicit('E8', $bobot["Tugas1"] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC)
        ->setCellValueExplicit('F8', $bobot["Tugas2"] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC)
        ->setCellValueExplicit('G8', $bobot["Tugas3"] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC)
        ->setCellValueExplicit('H8', $bobot["Tugas4"] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC)
        ->setCellValueExplicit('I8', $bobot["Tugas5"] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC)
        ->setCellValueExplicit('J8', $bobot["UTS"] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC)
        ->setCellValueExplicit('K8', $bobot["UAS"] / 100, PHPExcel_Cell_DataType::TYPE_NUMERIC);

$objPHPExcel->setActiveSheetIndex(0)->getStyle('D8:K8')->getNumberFormat()->setFormatCode('0%');

$objPHPExcel->setActiveSheetIndex(0)->getStyle('A7:M7')->getFont()->setBold(true);

$s = "select k.*, m.MhswID as NIM, m.Nama as NamaMhsw
    from krs k
      left outer join mhsw m on k.MhswID = m.MhswID and m.KodeID = '" . KodeID . "'
    where k.JadwalID = '$_REQUEST[JadwalID]'
    order by m.MhswID";

$r = _query($s);

$countPresensi = GetaField('presensi', 'JadwalID', $_REQUEST['JadwalID'], 'count(PresensiID)');

$i = 9;
$i_awal = $i;
$j = 1;
while ($w = _fetch_array($r)) {

    $jmlPresensi = GetaField("krs", "MhswID='" . $w['NIM'] . "' and KodeID = '" . KodeID . "' and JadwalID", $_REQUEST['JadwalID'], "_Presensi");    
    $Presensi = ($countPresensi == 0)? 0 : number_format($jmlPresensi/$countPresensi*100, 0);
    
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('A' . $i, $j++, PHPExcel_Cell_DataType::TYPE_NUMERIC)
            ->setCellValueExplicit('B' . $i, $w['NIM'], PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('C' . $i, ucwords(strtolower($w['NamaMhsw'])), PHPExcel_Cell_DataType::TYPE_STRING)
            ->setCellValueExplicit('D' . $i, $Presensi, PHPExcel_Cell_DataType::TYPE_NUMERIC)
            ->setCellValueExplicit('L' . $i, '=(D8*D' . $i . ')+(E8*E' . $i . ')+(F8*F' . $i . ')+(G8*G' . $i . ')+(H8*H' . $i . ')+(I8*I' . $i . ')+(J8*J' . $i . ')+(K8*K' . $i . ')', PHPExcel_Cell_DataType::TYPE_FORMULA)
            ->setCellValueExplicit('M' . $i, '=LOOKUP(L' . $i . ',O9:O18,Q9:Q18)', PHPExcel_Cell_DataType::TYPE_FORMULA);

    $i++;
}

$i_akhir = $i - 1;

$styleBorderArray = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => '000000'),
        ),
    ),
);

$objPHPExcel->setActiveSheetIndex(0)->getStyle('A7:M8')->applyFromArray($styleBorderArray);

$styleBorderArray = array(
    'borders' => array(
        'outline' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => '000000'),
        ),
    ),
);

$objPHPExcel->setActiveSheetIndex(0)->getStyle('A' . $i_awal . ':A' . $i_akhir)->applyFromArray($styleBorderArray);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B' . $i_awal . ':B' . $i_akhir)->applyFromArray($styleBorderArray);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('C' . $i_awal . ':C' . $i_akhir)->applyFromArray($styleBorderArray);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D' . $i_awal . ':D' . $i_akhir)->applyFromArray($styleBorderArray);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('E' . $i_awal . ':E' . $i_akhir)->applyFromArray($styleBorderArray);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('F' . $i_awal . ':F' . $i_akhir)->applyFromArray($styleBorderArray);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('G' . $i_awal . ':G' . $i_akhir)->applyFromArray($styleBorderArray);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('H' . $i_awal . ':H' . $i_akhir)->applyFromArray($styleBorderArray);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('I' . $i_awal . ':I' . $i_akhir)->applyFromArray($styleBorderArray);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('J' . $i_awal . ':J' . $i_akhir)->applyFromArray($styleBorderArray);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('K' . $i_awal . ':K' . $i_akhir)->applyFromArray($styleBorderArray);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('L' . $i_awal . ':L' . $i_akhir)->applyFromArray($styleBorderArray);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('M' . $i_awal . ':M' . $i_akhir)->applyFromArray($styleBorderArray);

$objPHPExcel->setActiveSheetIndex(0)->getStyle('A7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('B7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('C7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('L7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('M7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);


$i = 9;
$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueExplicit('O8', "Nilai Min", PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicit('P8', "Nilai Max", PHPExcel_Cell_DataType::TYPE_STRING)
        ->setCellValueExplicit('Q8', "Grade", PHPExcel_Cell_DataType::TYPE_STRING);

while ($grade_w = _fetch_array($grade_r)) {

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueExplicit('O' . $i, $grade_w["NilaiMin"], PHPExcel_Cell_DataType::TYPE_NUMERIC)
            ->setCellValueExplicit('P' . $i, $grade_w["NilaiMax"], PHPExcel_Cell_DataType::TYPE_NUMERIC)
            ->setCellValueExplicit('Q' . $i, $grade_w["Nama"], PHPExcel_Cell_DataType::TYPE_STRING);
    $i++;
}

$objPHPExcel->setActiveSheetIndex(0)->getStyle('O8:Q8')->getFont()->setBold(true);

$i = $i - 1;

$styleBorderArray = array(
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('argb' => '000000'),
        ),
    ),
);

$objPHPExcel->setActiveSheetIndex(0)->getStyle('O8:Q' . $i)->applyFromArray($styleBorderArray);

// nama dari sheet yang aktif
$objPHPExcel->getActiveSheet()->setTitle('Form Nilai Mahasiswa');

$objPHPExcel->setActiveSheetIndex(0);

// simpan file excel dengan nama umr2013.xls
//saat file berhasil di buat, otomatis pop up download akan muncul
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="FormNilaiMahasiswa.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

exit;
?>
