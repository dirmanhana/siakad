<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of bayarmhsw
 *
 * @author indra
 */
session_start();
include_once "../sisfokampus1.php";
include_once "../$_SESSION[mnux].lib.php";

HeaderSisfoKampus("Edit Pembayaran Mahasiswa");

$md = $_REQUEST['md'] + 0;
$bayarid = $_REQUEST['BayarID'];
// *** Main ***
$gos = (empty($_REQUEST['gos'])) ? 'Edit' : $_REQUEST['gos'];
$gos($bayarid, $md);

// *** Functions ***
function Edit($bayarid, $md) {
    if ($md == 0) {
        $jdl = "Edit Tanggal Pembayaran Mahasiswa";
        //$w = GetFields('bipotmhsw', 'BIPOTMhswID', $id, '*');
        $ro = "readonly=true disabled=true";
    } 
    else
        die(ErrorMsg('Error', "Mode edit <b>$md</b> tidak ditemukan.<br />
    Hubungi Sysadmin untuk informasi lebih detail.
    <hr size=1 color=silver />
    Opsi: <input type=button name='Tutup' value='Tutup'
      onClick=\"window.close()\" />"));
    
    $bayar = GetFields("bayarmhsw", "BayarMhswID", $bayarid,"*");
    $optTanggal = GetDateOption($bayar["Tanggal"], 'Tanggal');
    
    echo "<p><table class=box cellspacing=1 width=100%>
  <form action='../$_SESSION[mnux].bayaredit.php' method=POST>
  <input type=hidden name='gos' value='Simpan' />
  <input type=hidden name='md' value='$md' />  
  <input type=hidden name='BayarID' value='$bayarid' />
  <tr><th class=ttl colspan=2>$jdl</th></tr>
  <tr><td class=inp>Nomor Bukti:</td><td class=ul1>$bayar[BayarMhswID]</td></tr>
  <tr><td class=inp>Tanggal Bayar:</td><td class=ul1>$optTanggal</td></tr>  
  <tr><td class=inp>Nominal Rp:</td><td class=ul1>".number_format($bayar[Jumlah],0)."</td></tr>  
  <tr><td class=inp>Keterangan:</td><td class=ul1><textarea name='Keterangan'>$bayar[Keterangan]</textarea></td></tr>
  <tr><td class=ul1 colspan=2 align=center><input type=submit name='Simpan' value='Simpan' /><input type=button name='Batal' value='Batal' onClick=\"window.close()\" /></td></tr>  
  </form></table></p>";
}

function Simpan($bayarid, $md) {
        
    $Tanggal = "$_REQUEST[Tanggal_y]-$_REQUEST[Tanggal_m]-$_REQUEST[Tanggal_d]";
    $Keterangan = $_REQUEST['Keterangan'];

    $s = "update bayarmhsw set Tanggal = '$Tanggal', Keterangan='$Keterangan' where BayarMhswID = '$bayarid'";
    $r = _query($s);
    
    TutupScript();
}

function TutupScript() {
    echo <<<SCR
<SCRIPT>
  function ttutup() {
    opener.location='../index.php?mnux=$_SESSION[mnux]&gos=&MhswID=$_SESSION[MhswID]&TahunID=$_SESSION[TahunID]';
    self.close();
    return false;
  }
  ttutup();
</SCRIPT>
SCR;
}
?>
