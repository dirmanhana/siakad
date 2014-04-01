<?php
// *** Parameters ***
/*if ($_SESSION['_LevelID'] == 1) {
  $_MhswID = GetSetVar('_MhswID');
}
else if ($_SESSION['_LevelID'] == 120) {
  $_MhswID = $_SESSION['_Login'];
}
else die(ErrorMsg('Error',
  "Anda tidak berhak menjalankan modul ini."));*/

// *** Main ***
TampilkanJudul(".: Laporan EDOM :.");
$gos = 'frameEdomLaporan1';
CekBolehAksesModul();
$gos();

// *** Functions ***
function frameEdomLaporan1() {
  echo '<iframe src="http://localhost/kuesioner/index.php/laporan/edom_1" seamless="seamless" frameborder="0" width="100%" height="100%"></iframe>';
}

function CekBolehAksesModul() {
    $arrAkses = array(1, //superuser
        20, //admin 
        41, //TU
        40, //BAA
        50, //ka BAA
        100, //dosen
        140 //rektor
        ); //mahasiswa 120
    $key = array_search($_SESSION['_LevelID'], $arrAkses);
    if ($key === false)
        die(ErrorMsg('Error', "Anda tidak berhak mengakses modul ini.<br />
      Hubungi Sysadmin untuk informasi lebih lanjut."));
}
?>
