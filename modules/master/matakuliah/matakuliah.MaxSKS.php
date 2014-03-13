<?php

function DefMaxSKS() {
  global $mnux, $pref, $token;
  TampilkanPilihanProdi($mnux, '', $pref, "MaxSKS");
  if (!empty($_SESSION['prodi'])) {
    TampilkanMenuMaxSKS();
    TampilkanMaxSKS();
  }
}
function TampilkanmenuMaxSKS() {
  global $mnux, $pref, $token;
  echo "<p><a href='?mnux=$mnux&$pref=$token&sub=MaxSKSEdt&md=1'>Tambah Batas SKS</a> |
  <a href='?mnux=$mnux&$pref=$token&sub=CetakMaxSKS'>Cetak</a></p>";
}
function TampilkanMaxSKS() {
  global $mnux, $pref, $token;
  $s = "select *
    from maxsks
	where ProdiID='$_SESSION[prodi]'
	order by DariIP desc";
  $r = _query($s); $n = 0;
  echo "<p><table class=box cellspacing=1>
    <tr><th class=ttl colspan=2>#</th>
	<th class=ttl>Dari IPS</th>
	<th class=ttl>Sampai IPS</th>
	<th class=ttl>Max SKS</th>
	</tr>";
  while ($w = _fetch_array($r)) {
    $n++;
    echo "<tr><td class=inp>$n</td>
	  <td class=ul align=center><a href='?mnux=$mnux&$pref=$token&sub=MaxSKSEdt&md=0&MaxSKSID=$w[MaxSKSID]'><img src='img/edit.png'></a></td>
	  <td class=ul align=right>$w[DariIP]</td>
	  <td class=ul align=right>$w[SampaiIP]</td>
	  <td class=ul align=right>$w[SKS]</td>
	</tr>";
  }
  echo "</table></p>";
}
function MaxSKSEdt() {
  global $mnux, $pref, $token;
  $md = $_REQUEST['md']+0;
  if ($md == 0) {
    $MaxSKSID = $_REQUEST['MaxSKSID'];
	$w = GetFields('maxsks', 'MaxSKSID', $MaxSKSID, '*');
	$jdl = "Edit Max SKS";
  }
  else {
    $w['MaxSKSID'] = 0;
	$w['DariIP'] = 0;
	$w['SampaiIP'] = 0;
	$w['SKS'] = 0;
	$jdl = "Tambah Max SKS";
  }
  $optprd = GetOption2('prodi', "concat(ProdiID, ' - ', Nama)", 'ProdiID', $_SESSION['prodi'], '', 'ProdiID');
  // Tampilkan
  CheckFormScript("prodi,DariIP,SampaiIP,SKS");
  echo "<p><table class=box cellspacing=1 cellpadding=4>
  <form action='?' name='MaxSKS' method=POST onSubmit=\"return CheckForm(this)\">
  <input type=hidden name='mnux' value='$mnux'>
  <input type=hidden name='$pref' value='$token'>
  <input type=hidden name='sub' value='MaxSKSSav'>
  <input type=hidden name='md' value='$md'>
  <input type=hidden name='MaxSKSID' value='$w[MaxSKSID]'>
  
  <tr><th class=ttl colspan=2>$jdl</th></tr>
  <tr><td class=inp>Program Studi</td>
      <td class=ul><select name='prodi'>$optprd</select></td></tr>
  <tr><td class=inp>Dari IPS</td>
      <td class=ul><input type=text name='DariIP' value='$w[DariIP]' size=5 maxlength=5></td></tr>
  <tr><td class=inp>Sampai IPS</td<br>
      <td class=ul><input type=text name='SampaiIP' value='$w[SampaiIP]' size=5 maxlength=5></td></tr<br>
  <tr><td class=inp>Max SKS</td>
      <td class=ul><input type=text name='SKS' value='$w[SKS]' size=3 maxlength=3></td></tr>
  <tr><td class=ul colspan=2><input type=submit name='Simpan' value='Simpan'>
      <input type=reset name='Reset' value='Reset'>
	  <input type=button name='Batal' value='Batal' onClick=\"location='?mnux=$mnux&$pref=$token'\"></td></tr>
  </form></table></p>";
}
function MaxSKSSav() {
  $md = $_REQUEST['md']+0;
  $MaxSKSID = $_REQUEST['MaxSKSID']+0;
  $DariIP = $_REQUEST['DariIP']+0;
  $SampaiIP = $_REQUEST['SampaiIP']+0;
  $SKS = $_REQUEST['SKS']+0;
  $ProdiID = $_REQUEST['prodi'];
  if ($md == 0) {
    $s = "update maxsks set ProdiID='$ProdiID', DariIP='$DariIP', SampaiIP='$SampaiIP', SKS='$SKS'
	  where MaxSKSID=$MaxSKSID ";
	$r = _query($s);
  }
  else {
    $s = "insert into (ProdiID, DariIP, SampaiIP, SKS)
	  values ('$ProdiID', '$DariIP', '$SampaiIP', '$SKS')";
	$r = _query($s);
  }
  DefMaxSKS();
}
function CetakMaxSKS() {
  if (!empty($_SESSION['prodi'])) CetakMaxSKS1();
  else echo ErrorMsg("Tidak Dapat Mencetak",
    "Tidak dapat mencetak karena Program Studi belum diset");
}
function CetakMaxSKS1() {
  global $_lf;
  $mxc = 80;
  $nmf = HOME_FOLDER  .  DS . "tmp/$_SESSION[_Login].dwoprn";
  $grs = str_pad('-', $mxc, '-').$_lf;
  $prd = GetaField('prodi', 'ProdiID', $_SESSION['prodi'], 'Nama');
  $f = fopen($nmf, 'w');
  $hdr = "Master Maximal SKS \r\nProgram Studi: $prd ($_SESSION[prodi])\r\n\r\n$grs".
    "No.   ".
    str_pad('Dari IP', 10, ' ', STR_PAD_LEFT).
    str_pad("Smp IP", 10, ' ', STR_PAD_LEFT).
    str_pad("MaxSKS", 10, ' ', STR_PAD_LEFT).
    $_lf.$grs;
  fwrite($f, $hdr);
  $s = "select *
    from maxsks
    where ProdiID='$_SESSION[prodi]' and NA='N'
    order by DariIP desc";
  $r = _query($s); $n = 0;
  while ($w = _fetch_array($r)) {
    $n++;
    fwrite($f, str_pad($n, 6). 
      str_pad($w['DariIP'], 10, ' ', STR_PAD_LEFT).
      str_pad($w['SampaiIP'], 10, ' ', STR_PAD_LEFT).
      str_pad($w['SKS'], 10, ' ', STR_PAD_LEFT).
      $_lf);
  }
  fwrite($f, $grs);
  fclose($f);
  TampilkanFileDWOPRN($nmf, "matakuliah");
}

?>
