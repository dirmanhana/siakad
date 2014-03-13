<?php
// *** Parameters ***
if ($_SESSION['_LevelID'] == 1) {
  $_MhswID = GetSetVar('_MhswID');
}
else if ($_SESSION['_LevelID'] == 120) {
  $_MhswID = $_SESSION['_Login'];
}
else die(ErrorMsg('Error',
  "Anda tidak berhak menjalankan modul ini."));

// *** Main ***
TampilkanJudul("Survey");
$gos = 'frameKuesioner';
$gos();

// *** Functions ***
function frameKuesioner() {
  echo '<iframe src="http://localhost/kuesioner" seamless="seamless" frameborder="0" width="100%" height="62%"></iframe>';
}
?>
