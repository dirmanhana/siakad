<?php
// Author: Emanuel Setio Dewo
// 27 Jan 2006
// www.sisfokampus.net

// *** Functions ***
// function for Mata Kuliah
function Def() {
  global $mnux, $pref, $token;
  include_once "$mnux.$_SESSION[$pref].php";
  $sub = (!empty($_REQUEST['sub']))? $_REQUEST['sub'] : "Def$_SESSION[$pref]";
  $sub();
}

// *** Parameters ***
$pref = 'mk';
$mnux = 'matakuliah';
$arrMK = array('Mata Kuliah->MK',
  'MK Setara->MKSet', 
  'Kurikulum->Kur', 
  'Konsentrasi->Kons',
  'Jenis Mata Kuliah->Jen', 
  'Pilihan Wajib->Pil',
  'Jenis Kurikulum->JenKur',
  'Nilai->Nil',
  'MaxSKS->MaxSKS',
  'Paket Matakuliah->Pkt',
  "Predikat->pred");
$tokendef = 'MK';
$token = GetSetVar($pref, $tokendef);
$prodi = GetSetVar('prodi');
$kurid = GetSetVar("kurid_$prodi");
$mkkode = GetSetVar("mkkode_$prodi");
if (empty($kurid) && !empty($prodi)) {
  $_kurid = GetaField("kurikulum", "NA='N' and ProdiID", $prodi, "KurikulumID");
  $_SESSION["kurid_$prodi"] = $_kurid;
  $kurid = $_kurid;
}

// *** Main ***
TampilkanJudul("Administrasi Mata Kuliah");
if (empty($_SESSION['_ProdiID'])) echo ErrorMsg('Tidak Ada Hak Akses',
  "Anda tidak memiliki hak akses terhadap modul ini.<br>
  Hubungi Superuser/Administrator untuk memberikan hak akses terhadap program studi.");
else {
  TampilkanSubMenu($mnux, $arrMK, $pref, $token);
  if (!empty($token)) Def();
}
?>
