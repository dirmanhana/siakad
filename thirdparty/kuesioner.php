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
TampilkanJudul("EDOM");
$gos = 'frameEdomLaporan';
CekBolehAksesModul();
$gos();

// *** Functions ***
function frameEdomLaporan() {
  echo '<iframe src="http://localhost/kuesioner/index.php/laporan/edom_0" seamless="seamless" frameborder="0" width="100%" height="60%"></iframe>';
}

function CekBolehAksesModul() {
    $arrAkses = array(1, 20, 41, 120);
    $key = array_search($_SESSION['_LevelID'], $arrAkses);
    if ($key === false)
        die(ErrorMsg('Error', "Anda tidak berhak mengakses modul ini.<br />
      Hubungi Sysadmin untuk informasi lebih lanjut."));
}
?>
