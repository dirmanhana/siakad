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
TampilkanJudul("Form EDOM");
$gos = 'frameEdom';
CekBolehAksesModul();
$gos();

// *** Functions ***
function frameEdom() {
  echo '<script type="text/javascript">
        function iframeLoaded() {
            var iFrameID = document.getElementById(\'idIframe\');
            if(iFrameID) {
                  // here you can make the height, I delete it first, then I make it again
                  iFrameID.height = "";
                  iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + 20 + "px";
            }   
        }
        </script>
        <iframe onLoad="iframeLoaded()" id="idIframe" src="http://localhost/kuesioner/index.php/kuesioner/edom" seamless="seamless" frameborder="0" width="100%">Your browser does not support inline frames.</iframe>';
}

function CekBolehAksesModul() {
    $arrAkses = array(1, //superuser
        20, //admin 
        41, //TU
        40, //BAA
        50, //ka BAA
        100, //dosen
        140, //rektor
        120); //mahasiswa
    $key = array_search($_SESSION['_LevelID'], $arrAkses);
    if ($key === false)
        die(ErrorMsg('Error', "Anda tidak berhak mengakses modul ini.<br />
      Hubungi Sysadmin untuk informasi lebih lanjut."));
}
?>
