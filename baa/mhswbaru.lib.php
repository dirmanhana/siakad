<?php
// Author : Emanuel Setio Dewo
// Email  : setio.dewo@gmail.com
// Start  : 20 Agustus 2008
// Desc   : library for Cama

function HitungUlangBIPOTPMB($PMBID) {
  $pmb = GetFields('pmb', "KodeID='".KodeID."' and PMBID", $PMBID, '*');
  // Hitung Total BIPOT & Pembayaran
  $TotalBiaya = GetaField("bipotmhsw bm
      left outer join bipot2 b2 on bm.BIPOT2ID = b2.BIPOT2ID",
      "bm.PMBMhswID = 0 and bm.KodeID = '".KodeID."'
      and bm.NA = 'N'
      and bm.TahunID = '$pmb[PMBPeriodID]' and bm.PMBID", $PMBID,
      "sum(bm.TrxID * bm.Jumlah * bm.Besar)")+0;
  $TotalBayar = GetaField('bayarmhsw',
      "PMBMhswID = 0 and KodeID = '".KodeID."'
      and NA = 'N'
      and TahunID = '$pmb[PMBPeriodID]' and PMBID", $PMBID,
      "sum(Jumlah)")+0;
  // Update data PMB
  $s = "update pmb
    set TotalBiaya = $TotalBiaya,
        TotalBayar = $TotalBayar
    where KodeID = '".KodeID."'
      and PMBID = '$PMBID' 
    limit 1";
  $r = _query($s);
  //echo "<pre>$s</pre>";
}
function SetBIPOTID($pmb) {
  $bipot = GetFields('bipot', "KodeID='".KodeID."' and NA='N' and `Def`='Y' 
    and ProgramID='$pmb[ProgramID]' and ProdiID",
    $pmb['ProdiID'], '*');
  $bipot['BIPOTID'] += 0;

  if ($bipot['BIPOTID'] == 0) {
    echo "
    <table class=box width=100%>
    <tr><th class=wrn>Data master BIPOT tidak ditemukan. Hubungi Ka BAA/BAK</th></tr>
    </table>";
  }
  else {
    $s = "update pmb set BIPOTID = '$bipot[BIPOTID]' where KodeID='".KodeID."' and PMBID='$pmb[PMBID]' ";
    $r = _query($s);
    echo "
    <table class=box width=100%>
    <tr><th class=ttl>Data bipot telah diupdate secara otomatis.</th></tr>
    </table>";
  }
}

function ProsesBIPOT2($PMBID) {
  $pmb = GetFields('pmb', "KodeID='".KodeID."' and PMBID", $PMBID, '*');
  // Ambil BIPOT-nya
  $s = "select * 
    from bipot2 
    where BIPOTID = '$pmb[BIPOTID]'
      and Otomatis = 'Y'
      and NA = 'N'
    order by TrxID, Prioritas";
  $r = _query($s);
  while ($w = _fetch_array($r)) {
    $oke = true;
    // Apakah sesuai dengan status awalnya?
    $pos = strpos($w['StatusAwalID'], ".".$pmb['StatusAwalID'].".");
    $oke = $oke && !($pos === false);

    // Apakah grade-nya?
    if ($oke) {
      if ($w['GunakanGradeNilai'] == 'Y') {
        $pos = strpos($w['GradeNilai'], ".".$pmb['GradeNilai'].".");
        $oke = $oke && !($pos === false);
      }
    }
    
    // Simpan data
    if ($oke) {
      // Cek, sudah ada atau belum? Kalau sudah, ambil ID-nya
      $ada = GetaField('bipotmhsw',
        "KodeID='".KodeID."' and PMBID = '$pmb[PMBID]'
        and TahunID='$pmb[PMBPeriodID]' and BIPOT2ID",
        $w['BIPOT2ID'], "BIPOTMhswID") +0;
      // Cek apakah memakai script atau tidak?
      if ($w['GunakanScript'] == 'Y') BipotGunakanScript($pmb, '', $w, $ada, 0);
      // Jika tidak perlu pakai script
      else {
        // Jika tidak ada duplikasi, maka akan di-insert. Tapi jika sudah ada, maka dicuekin aja.
        if ($ada == 0) { 
          // Simpan
          $Nama = GetaField('bipotnama', 'BIPOTNamaID', $w['BIPOTNamaID'], 'Nama');
          $s1 = "insert into bipotmhsw
            (KodeID, COAID, PMBMhswID, PMBID, TahunID,
            BIPOT2ID, BIPOTNamaID, Nama, TrxID,
            Jumlah, Besar, Dibayar,
            Catatan, NA,
            LoginBuat, TanggalBuat)
            values
            ('".KodeID."', '$w[COAID]', 0, '$pmb[PMBID]', '$pmb[PMBPeriodID]',
            '$w[BIPOT2ID]', '$w[BIPOTNamaID]', '$Nama', '$w[TrxID]',
            1, '$w[Jumlah]', 0,
            'Auto', 'N',
            '$_SESSION[_Login]', now())";
          $r1 = _query($s1);
        }// end $ada=0
      } // end if $ada
    }   // end if $oke
  }     // end while
}
function BipotGunakanScript($mhsw, $khs, $bipot, $ada, $pmbmhswid) {
  if (file_exists("script/$bipot[NamaScript].php")) {
    include_once "script/$bipot[NamaScript].php";
    $exec = $bipot['NamaScript'];
    $exec($mhsw, $khs, $bipot, $ada, $pmbmhswid);
  }
  elseif (file_exists("../script/$bipot[NamaScript].php")) {
    include_once "../script/$bipot[NamaScript].php";
    $exec = $bipot['NamaScript'];
    $exec($mhsw, $khs, $bipot, $ada, $pmbmhswid);
  }
}
?>
