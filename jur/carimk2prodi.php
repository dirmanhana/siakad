<?php
// Author : Emanuel Setio Dewo
// Email  : setio.dewo@gmail.com
// Start  : 21 Agustus 2008

session_start();
include_once "../sisfokampus1.php";

HeaderSisfoKampus("Cari Matakuliah");

// *** Parameters ***
$ProdiID = GetSetVar('ProdiID');
$frm = GetSetVar('frm');
$div = GetSetVar('div');
$Nama = GetSetVar('Nama');

// cek Nama Dosen dulu
if (empty($Nama))
  die(ErrorMsg('Error', 
    "Masukkan terlebih dahulu Nama Matakuliah sebagai kata kunci pencarian.<br />
    Hubungi Sysadmin untuk informasi lebih lanjut.
    <hr size=1 color=silver />
    Opsi: <a href='#' onClick=\"javascript:toggleBox('$div', 0)\">Tutup</a>"));


$prd = GetaField('prodi', "KodeID='".KodeID."' and ProdiID", $ProdiID, 'Nama');

// *** Main ***
TampilkanJudul("Cari Matakuliah - $prd <sup>($ProdiID)</sup><br /><font size=-1><a href='#' onClick=\"toggleBox('$div', 0)\">(&times; Close &times;)</a></font>");
TampilkanDaftar();

// *** Functions ***
function TampilkanDaftar() {
  $s = "select mk.MKID, mk.MKKode, mk.Nama, mk.SKS, k.KurikulumKode as KUR, mk.Sesi, hs.DefKehadiran as RencanaKehadiran, hs.DefMaxAbsen as MaxAbsen, mk.Responsi
    from mk mk
      left outer join kurikulum k on mk.KurikulumID = k.KurikulumID
	  left outer join hadirsks hs on mk.SKS = hs.SKS and mk.ProdiID = hs.ProdiID and hs.KodeID='".KodeID."'
    where mk.KodeID = '".KodeID."'
      and mk.Nama like '%$_SESSION[Nama]%'
      and mk.NA = 'N'
      and mk.ProdiID = '$_SESSION[ProdiID]'
      and k.NA = 'N'
    order by mk.MKKode, mk.Nama";
  $r = _query($s); $i = 0;
  //echo "<pre>$s</pre>";
  $jml = _num_rows($r);
  if ($jml == 0) {
    echo "<p style='background-color: red; color: white; text-align:center'>
      <b>Tidak ada data matakuliah.<br />
      Mungkin tidak ada kurikulum yang aktif.<br />
      Hubungi BAA atau Sysadmin untuk informasi lebih detail.
      </b></p>";
  }
  
  echo "<table class=bsc cellspacing=1 width=100%>";
  echo "<tr>
    <th class=ttl>#</th>
    <th class=ttl>Kode MK</th>
    <th class=ttl>Nama MK</th>
    <th class=ttl>SKS</th>
    <th class=ttl>Sesi</th>
	<th class=ttl>Lab?</th>
    <th class=ttl>Kurikulum</th>
    </tr>";
  while ($w = _fetch_array($r)) {
    $i++;
	$RencanaKehadiranDariProdi = GetaField('prodi', "KodeID='".KodeID."' and ProdiID", $_SESSION['ProdiID'], 'DefKehadiran');
	$RencanaKehadiran = (empty($w[RencanaKehadiran]))? "$RencanaKehadiranDariProdi" : "$w[RencanaKehadiran]";
	$MaxAbsenDariProdi = GetaField('prodi', "KodeID='".KodeID."' and ProdiID", $_SESSION['ProdiID'], 'DefMaxAbsen');
	$MaxAbsen = (empty($w[MaxAbsen]))? "$MaxAbsenDariProdi" : "$w[MaxAbsen]";
    echo <<<SCR
      <tr>
      <td class=inp width=20>$i</td>
      <td class=ul1 width=100>$w[MKKode]</td>
      <td class=ul1>
        <a href="javascript:
				$_SESSION[frm].MKID.value='$w[MKID]';
				$_SESSION[frm].MKKode.value='$w[MKKode]';
				$_SESSION[frm].MKNama.value='$w[Nama]';
				$_SESSION[frm].SKS.value='$w[SKS]';

/* fungsi ini dihilangkan
			if('$w[Responsi]'=='Y') $_SESSION[frm].AdaResponsi.checked=true; 
				$_SESSION[frm].RencanaKehadiran.value='$RencanaKehadiran'; 
				$_SESSION[frm].MaxAbsen.value='$MaxAbsen'; 
*/

				toggleBox('$_SESSION[div]', 0)">
					$w[Nama]
		</a>
      </td>
      <td class=ul1 width=10 align=right>$w[SKS]</td>
      <td class=ul1 width=10 align=right>$w[Sesi]</td>
	  <td class=ul1 width=10 align=right>$w[Responsi]</td>
      <td class=ul1>$w[KUR]</td>
      </tr>
SCR;
  }
  echo "</table></p>";
}

?>


</BODY>
</HTML>
