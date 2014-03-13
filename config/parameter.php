<?php
// Parameter
$_ProductName = "Sisfo Kampus";
$_Institution = 'STMIK BINA INSANI';
$_Identitas = "SISFO";
$_Version = "Semarang";
$_Author = "Emanuel Setio Dewo";
$_AuthorEmail = "setio.dewo@gmail.com";

$_Themes = "default";

// System
$_lf = "\r\n";
$_defmnux = 'login';
$_maxbaris = 30;
$_tmpdir = "C:\\apachefriends\\xampp\\htdocs\\tmp";
$_templatedir = "C:\\apachefriends\\xampp\\htdocs\\template";
//$_kwitansipmb = "$_tmpdir\\kwitansipmb.dwoprn";
$_kwitansipmb = "tmp/kwitansipmb.dwoprn";
$_FKartuUSM = "tmp/kartuusm.dwoprn";
$divider = str_pad("=", 79, '=').$_lf;
$divider1 = str_pad("-", 79, '-').$_lf;

// PMB
$_PMBDigit = 4;
$_PMBMaxPilihan = 3;
$_PMBKapasitasRuang = 25;
$_PMBMinimalFields = "Nama,ProgramID,Pilihan1,TempatLahir";
$_PMBPemberitahuanDef = "template/Pemberitahuan.USM.DEF.doc";
$_PMBAdminJalurKhusus = ".31.";

// depan variabel session
$_ses = '_sfk2';
// max row
$_defmaxrow = 20;
// BUlan
$arrBulan = array('', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
  'Agustus', 'September', 'Oktober', 'November', 'Desember');
$arrHari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
$arrJam = array('07:00', '07:30', '08:00', '08:30', '09:00', '09:30',
  '10:00', '10:30', '11:00', '11:30', '12:00', '12:30',
  '13:00', '13:30', '14:00', '14:30', '15:00', '15:30',
  '16:00', '16:30', '17:00', '17:30', '18:00', '18:30',
  '19:00', '19:30', '20:00', '20:30', '21:00', '21:30');

// Init variable
if (empty($_SESSION['_KodeID'])) {
    $KodeID = GetSetVar('KodeID', $_Identitas);
    $arrID = GetFields('identitas', 'Kode', $KodeID, '*');
} else {
    $arrID = GetFields('identitas', 'Kode', $_SESSION['_KodeID'], '*');
}
$_BPMDigit = 5;

// Akademik
$arrUjian = array(0=>"", 1=>"UTS", 2=>"UAS");

// Keuangan
$accHutangSemesterLalu = 30;

// Ijazah
$FormatNoIjazah = "M~PRD~-~NOINDUKFAK~/SIS-~NOINDUKKOP~/~DATE~";

// Printer
//$_HeaderPrn = chr(27).chr(64).chr(27).'C' . chr(33) . chr(27) . chr(15);
$_InitPrn = chr(27).chr(64);
//                       Lines: 33            Font: Courier            10cpi                   Left margin: 0            Right margin: 0
$_HeaderPrn = $_InitPrn. chr(27).'C'.chr(33). chr(27).chr(107).chr(2). chr(27).chr(33).chr(2). chr(27).chr(108).chr(0) . chr(27).chr(81).chr(0);
$_HeaderPrn .= chr(27).'M';
$_HeaderPrn .= chr(27).'p'.chr(0);
$_HeaderPrn .= chr(27).'x'.chr(1);
$_TestColumnPrn = '1234567890123456789012345678901234567890123456789012345678901234567890123456789'.$_lf;
//$_EjectPrn = chr(27).chr(25).'R';
$_EjectPrn = chr(12);
?>